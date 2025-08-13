<?php

// Function to detect if the SMS message contains Unicode/Bengali characters
function isUnicodeSMS($text)
{
    return preg_match('/[^\x00-\x7F]/', $text);
}

// Check if the log file is writable
if (!is_writable($logFile)) {
    error_log("DEBUG LOG FILE IS NOT WRITABLE: $logFile");
}

// Fetch users for dropdown (exclude admin)
$userDetail = "SELECT UserID, UserName FROM BULKSMSPanel.dbo.UserInfo WHERE UserName <> 'admin'";
$result_userDetail = odbc_exec($cn, $userDetail);

// Fetch template texts for Template Text dropdown
function getTemplateTexts($cn, $User)
{
    if (strtolower($User) === 'admin') {
        $sql = "SELECT TemplateSMS FROM BULKSMSPanel.dbo.TemplateText";
    } else {
        $sql = "SELECT TemplateSMS FROM BULKSMSPanel.dbo.TemplateText WHERE UserName = ?";
    }
    $stmt = odbc_prepare($cn, $sql);
    if (strtolower($User) === 'admin') {
        $result = odbc_exec($cn, $sql);
    } else {
        $result = odbc_execute($stmt, [$User]);
    }
    $templates = [];
    while ($row = odbc_fetch_array($result)) {
        $templates[] = $row['TemplateSMS'];
    }
    return $templates;
}
$templateTexts = getTemplateTexts($cn, $User);

// Helper function to create dropdown for Hours and Minutes
function createDropdown($name, $id, $range, $selectedValue)
{
    echo '<div class="form-group">';
    echo '<label for="' . $id . '" class="col-sm-3 control-label">' . ucfirst($name) . '</label>';
    echo '<div class="col-sm-6"><select name="' . $name . '" id="' . $id . '" class="form-control">';
    for ($i = 0; $i <= $range; $i++) {
        $value = str_pad($i, 2, "0", STR_PAD_LEFT);
        $selected = ($value === $selectedValue) ? ' selected' : '';
        echo "<option value=\"$value\"$selected>$value</option>";
    }
    echo '</select></div></div>';
}

// Get current hour and minute for default selection
$currentHour = date("H");
$currentMin = date("i");

// Handle form submission for scheduling SMS
if (isset($_REQUEST['Save']) && $_REQUEST['Save'] === 'Save') {
    // Start transaction
    odbc_exec($cn, "BEGIN TRANSACTION");

    try {
        // Collect inputs
        $Uname = $_REQUEST['opt'];
        $SendFrom = $_REQUEST['ShortCodeNumber'] ?? '';
        $PromoName = $_REQUEST['PromoListName'];
        $ServiceID = "promo_" . $PromoName . "_" . $SendFrom;
        $stDate = $_REQUEST['start_date'];
        $Hour = $_REQUEST['Hour'];
        $Min = $_REQUEST['Min'];
        $ScheduleTime = date('Y-m-d H:i:s', strtotime("$stDate $Hour:$Min:00"));

        $TemplateText = $_REQUEST['TemplateText'];
        $Msg = $_REQUEST['SMSText'];
        if ($TemplateText != '') $Msg = $TemplateText;

        $User = strtoupper($_SESSION['User']);

        // Fetch Requesting IP
        $sql_requestingip = "SELECT RequestingIP FROM BULKSMSPanel.dbo.MaskingDetail WHERE MaskingID = ?";
        $stmt_requestingip = odbc_prepare($cn, $sql_requestingip);
        odbc_execute($stmt_requestingip, [$SendFrom]);
        $row = odbc_fetch_array($stmt_requestingip);
        $RequestedIP = $row['RequestingIP'] ?? '';

        // Fetch user credentials
        $sql_userInfo = "SELECT UserName, Password FROM BULKSMSPanel.dbo.UserInfo WHERE UserName = ?";
        $stmt_userInfo = odbc_prepare($cn, $sql_userInfo);
        odbc_execute($stmt_userInfo, [$Uname]);
        $row = odbc_fetch_array($stmt_userInfo);
        $UserName = $row['UserName'] ?? '';
        $Password = $row['Password'] ?? '';

        // Fetch all numbers
        $ScheduleNumbers = [];
        $sql_schedulednumber = "SELECT MSISDN FROM BULKSMSPanel.dbo.PromoList WHERE PromoListName = ?";
        $stmt_schedulednumber = odbc_prepare($cn, $sql_schedulednumber);
        odbc_execute($stmt_schedulednumber, [$PromoName]);
        while ($row = odbc_fetch_array($stmt_schedulednumber)) {
            $ScheduleNumbers[] = $row['MSISDN'];
        }

        // Check if list is empty
        if (empty($ScheduleNumbers)) {
            popup('No numbers found in the selected list.', base_url() . "index.php?parent=SchedulePromotion");
            exit;
        }

        // Insert promotional detail
        $PromoDetail = "INSERT INTO BULKSMSPanel.dbo.PromotionalDetail (PromoName, PromoText, PromoID, SendingTime, SendBy)
                        VALUES (?, ?, ?, ?, ?)";
        $stmtPromoDetail = odbc_prepare($cn, $PromoDetail);
        odbc_execute($stmtPromoDetail, [$PromoName, $Msg, $ServiceID, $ScheduleTime, $User]);

        // Check user credit
        $sql_UserAccountStatus = "SELECT NumberOfSMS FROM BULKSMSPanel.dbo.CurrentStatus WHERE UserName = ?";
        $stmt_UserAccountStatus = odbc_prepare($cn, $sql_UserAccountStatus);
        odbc_execute($stmt_UserAccountStatus, [$Uname]);
        $row_UserAccount = odbc_fetch_array($stmt_UserAccountStatus);
        $userCreditBalance = intval($row_UserAccount['NumberOfSMS'] ?? 0);

        if (count($ScheduleNumbers) > $userCreditBalance) {
            popup('Your credit limit is over. Please talk to Solvers Team to upgrade your credit limit.', base_url() . "index.php?parent=SchedulePromotion");
            exit;
        }

        // Process each MSISDN
        foreach ($ScheduleNumbers as $SendTo) {
            if (strlen($SendTo) > 10 && is_numeric($SendTo)) {
                $SendTo = "880" . substr($SendTo, -10);
                $InMSgID = $SendTo . date('YmdHis') . rand(1, 99);
                $isUnicode = preg_match('/[^\x00-\x7F]/', $Msg);

                $MsgCount = $isUnicode ? ceil(mb_strlen($Msg, 'UTF-8') / 67) : ceil(strlen($Msg) / 153);

                // Choose stored procedure
                $spName = $isUnicode ? "[BULKSMSPanel].[dbo].[PermitSMSProcBangla]" : "[BULKSMSPanel].[dbo].[PermitSMSProc]";

                $SMSPermitQuery = "DECLARE @returnValue INT;
                                   EXEC @returnValue=$spName
                                   @UserName = ?, 
                                   @Password = ?, 
                                   @RequestedIP = ?, 
                                   @SendFrom = ?, 
                                   @SendTo = ?, 
                                   @InMSgID = ?, 
                                   @ScheduleTime = ?, 
                                   @NumberOfPerSMS = ?, 
                                   @msg = ?;
                                   SELECT @returnValue as ReturnVal;";

                $stmtPermit = odbc_prepare($cn, $SMSPermitQuery);
                odbc_execute($stmtPermit, [$UserName, $Password, $RequestedIP, $SendFrom, $SendTo, $InMSgID, $ScheduleTime, $MsgCount, $Msg]);

                $PermitReturnValArray = odbc_fetch_array($stmtPermit);
                $PermitReturnVal = $PermitReturnValArray['ReturnVal'];

                if ($PermitReturnVal != '200') {
                    // Log error (same as your current code)
                    $StatusCode = $PermitReturnVal;
                    $sql_error = "SELECT ErrorCode, ErrorDescription, ActionTaken FROM BULKSMSPanel.dbo.ErrorCode WHERE ErrorCode = ?";
                    $stmt_error = odbc_prepare($cn, $sql_error);
                    odbc_execute($stmt_error, [$StatusCode]);
                    $row_error = odbc_fetch_array($stmt_error);
                    $ErrorDescription = $row_error['ErrorDescription'] ?? 'Unknown error';

                    $sql_error_insert = "INSERT INTO BULKSMSGateway_1_0.dbo.ErrorNumbers (MobileNo, ErrorCode, ErrorDescription, UserName)
                                         VALUES (?, ?, ?, ?)";
                    $stmt_error_insert = odbc_prepare($cn, $sql_error_insert);
                    odbc_execute($stmt_error_insert, [$SendTo, $StatusCode, $ErrorDescription, $UserName]);
                }
            } else {
                // Invalid MSISDN
                $sql_error_insert = "INSERT INTO BULKSMSGateway_1_0.dbo.ErrorNumbers (MobileNo, ErrorCode, ErrorDescription, UserName)
                                     VALUES (?, '204', 'Invalid Recipient MSISDN number', ?)";
                $stmt_error_insert = odbc_prepare($cn, $sql_error_insert);
                odbc_execute($stmt_error_insert, [$SendTo, $UserName]);
            }
        }

        // Commit transaction
        odbc_exec($cn, "COMMIT TRANSACTION");
        popup('Schedule Created Successfully.', base_url() . "index.php?parent=SchedulePromotion");

    } catch (Exception $e) {
        // Rollback on error
        odbc_exec($cn, "ROLLBACK TRANSACTION");
        error_log("Error in scheduling SMS: " . $e->getMessage());
        popup('An error occurred while scheduling. Please try again.', base_url() . "index.php?parent=SchedulePromotion");
    }
}

?>

<div id="page-content">
    <div id="wrap">
        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>Schedule Messaging</h4>
                </div>

                <div class="panel-body">
                    <div class="panel-body collapse in">

                        <!-- Schedule Messaging Form -->
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="SchedulePromotionID" id="user">

                            <!-- User Selection -->
                            <?php if (strtolower($User) === 'admin') : ?>
                                <div class="form-group">
                                    <label for="opt" class="col-sm-3 control-label">Select User Name :</label>
                                    <div class="col-sm-6">
                                        <select name="opt" id="opt" class="form-control selectpicker" data-live-search="true" onchange="ShowDropDown('opt', 'ShortCodeDiv', 'ShowMaskingId', 'ShowService')">
                                            <option value="" selected>please select user name</option>
                                            <?php
                                            while ($n = odbc_fetch_row($result_userDetail)) {
                                                $UserID = odbc_result($result_userDetail, "UserID");
                                                $UserName = odbc_result($result_userDetail, "UserName");
                                                echo "<option value='" . htmlspecialchars($UserName) . "'>" . htmlspecialchars($UserName) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="form-group">
                                    <label for="opt" class="col-sm-3 control-label">User Name</label>
                                    <div class="col-sm-6">
                                        <select name="opt" id="opt" class="form-control selectpicker" data-live-search="true" onchange="ShowDropDown('opt', 'ShortCodeDiv', 'ShowMaskingId', 'ShowService')">
                                            <option value="" selected>please select user name</option>
                                            <option value="<?php echo htmlspecialchars($User); ?>"><?php echo htmlspecialchars($User); ?></option>
                                        </select>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Masking ID placeholder -->
                            <div class="form-group">
                                <label for="ShortCodeDiv" class="col-sm-3 control-label">Masking ID:</label>
                                <div class="col-sm-6" id="ShortCodeDiv"></div>
                            </div>

                            <!-- Schedule SMS List Name -->
                            <div class="form-group">
                                <label for="PromoListNameID" class="col-sm-3 control-label">Schedule SMS List Name:</label>
                                <div class="col-sm-6">
                                    <select name="PromoListName" id="PromoListNameID" class="form-control selectpicker" data-live-search="true">
                                        <option value="">Select List</option>
                                        <?php
                                        if (strtolower($User) == 'admin') {
                                            $userDetailList = "SELECT DISTINCT PromoListName FROM BULKSMSPanel.dbo.PromoList ORDER BY PromoListName ASC";
                                        } else {
                                            $userDetailList = "SELECT DISTINCT PromoListName FROM BULKSMSPanel.dbo.PromoList WHERE UpdateBy = ?";
                                        }
                                        $stmtList = odbc_prepare($cn, $userDetailList);
                                        if (strtolower($User) == 'admin') {
                                            $resultList = odbc_execute($stmtList) ? $stmtList : false;
                                        } else {
                                            $resultList = odbc_execute($stmtList, [$User]) ? $stmtList : false;
                                        }
                                        if ($resultList) {
                                            while ($n = odbc_fetch_array($stmtList)) {
                                                $PromoListName = $n['PromoListName'];
                                                echo '<option value="' . htmlspecialchars($PromoListName) . '">' . htmlspecialchars($PromoListName) . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Schedule Date Picker -->
                            <div class="form-group">
                                <label for="start_date" class="col-sm-3 control-label">Select Date:</label>
                                <div class="col-sm-6">
                                    <div class="input-group date" id="datetimepicker1">
                                        <input type="text" class="form-control" name="start_date" id="start_date" autocomplete="off" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"><i class="fa fa-calendar"></i></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Schedule Time: Hour and Minute Dropdowns -->
                            <?php
                            createDropdown("Hour", "HourID", 23, $currentHour);
                            createDropdown("Min", "MinID", 59, $currentMin);
                            ?>

                            <!-- Checkbox to toggle Template Text SMS -->
                            <div>
                                <label for="chkPassport">
                                    Click on checkbox for Template Text SMS
                                    <input type="checkbox" id="chkPassport" />
                                </label>
                            </div>

                            <!-- SMS Textarea -->
                            <div id="autoUpdate" class="autoUpdate">
                                <div class="form-group">
                                    <label for="SMSTextID" class="col-sm-3 control-label">SMS Text</label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control" name="SMSText" id="SMSTextID" cols="100" rows="3" maxlength="160"></textarea>
                                        <font size="1">(Maximum characters: 160)<br>You have <input readonly type="text" name="countdown" size="3" value="160"> characters left.</font><br>
                                        <!-- <small>Please don't send SMS in Bangla</small> -->
                                    </div>
                                </div>
                            </div>

                            <!-- Template Text Dropdown -->
                            <div id="dvPassport" style="display:none">
                                <div class="form-group">
                                    <label for="TemplateText" class="col-sm-3 control-label">Select Template Text</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="TemplateText" id="TemplateText">
                                            <option value=''>please select template text</option>
                                            <?php
                                            foreach ($templateTexts as $template) {
                                                echo '<option value="' . htmlspecialchars($template) . '">' . htmlspecialchars($template) . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label"></label>
                                <div class="col-sm-6">
                                    <input name="Save" onClick="return confirm('Do you Really want to SEND this information?')" class="btn btn-primary" type="submit" id="Save" value="Save">
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="bootstrap-select/dist/js/bootstrap-select.js"></script>
<link rel="stylesheet" href="bootstrap-select/dist/css/bootstrap-select.css">

<script type="text/javascript" language="javascript">
    // Character limit enforcement for SMS text
    function limitText(limitField, limitCount, limitNum) {
        if (limitField.value.length > limitNum) {
            limitField.value = limitField.value.substring(0, limitNum);
        } else {
            limitCount.value = limitNum - limitField.value.length;
        }
    }

    $(document).ready(function() {
        // Initialize bootstrap-select dropdowns
        $('.selectpicker').selectpicker();

        // Datepicker initialization
        $('#datetimepicker1').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '-3d'
        });

        // Toggle Template Text dropdown visibility
        $('#chkPassport').click(function() {
            if ($(this).is(":checked")) {
                $("#dvPassport").show();
                $('#autoUpdate').fadeOut('slow');
            } else {
                $("#dvPassport").hide();
                $('#autoUpdate').fadeIn('slow');
            }
        });

        // SMS Textarea character count and Unicode handling
        const maxCharsNormal = 160;
        const maxCharsUnicode = 70;

        $('#SMSTextID').on('input keydown keyup', function() {
            let text = $(this).val();
            let isUnicode = hasUnicode(text);
            let maxChars = isUnicode ? maxCharsUnicode : maxCharsNormal;

            if (text.length > maxChars) {
                $(this).val(text.substring(0, maxChars));
                text = $(this).val();
            }

            const charsLeft = maxChars - text.length;
            $('input[name="countdown"]').val(charsLeft);
        });

        // Utility function to detect Unicode characters
        function hasUnicode(str) {
            for (let i = 0; i < str.length; i++) {
                if (str.charCodeAt(i) > 127) {
                    return true;
                }
            }
            return false;
        }

        // Form validation (you can add your Validator code here or keep the existing one)
        var frmvalidator = new Validator("SchedulePromotionID");
        frmvalidator.addValidation("opt", "dontselect=0", "Please Select the Operator Name.");
        frmvalidator.addValidation("ShortCodeID", "dontselect=0", "Please Select the Short Code.");
        frmvalidator.addValidation("PromoListNameID", "req", "Select The promotional Name.");
        frmvalidator.addValidation("start_date", "req", "Select The Sending Date.");
        frmvalidator.addValidation("HourID", "req", "Select The Sending Hour.");
        frmvalidator.addValidation("MinID", "req", "Write the Min.");
        frmvalidator.addValidation("SMSTextID", "req", "SMS Text Can not be null.");
    });
</script>