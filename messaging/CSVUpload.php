<?php
// Full cleaned single-file: CSV bulk upload -> SMSOutbox
// Assumptions:
// - PDOConnectDB() returns a PDO connected to BULKSMSGateway_1_0 (this file uses $conn)
// - PDOConnectDB2() returns a PDO connected to BULKSMSPanel (this file uses $cn)
// - Webserver can write uploaded CSV to __DIR__ . '/CSV/' and SQL Server service can read that file path (or a share)
// - The rest of your application provides $User, base_url(), popup(), getFileextension() and other helpers

// Initialize DB connections
$conn = PDOConnectDB();   // BULKSMSGateway_1_0
$cn   = PDOConnectDB2();  // BULKSMSPanel

// Fetch user list for the select box (using $cn — the panel DB)
try {
    $stmtUsers = $cn->query("SELECT UserID, UserName FROM dbo.UserInfo ORDER BY UserName ASC");
    $users = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error fetching users: " . $e->getMessage());
    $users = [];
}
?>
<script language="javascript" type="text/javascript">
    function limitText(limitField, limitCount, limitNum) {
        if (limitField.value.length > limitNum) {
            limitField.value = limitField.value.substring(0, limitNum);
        } else {
            limitCount.value = limitNum - limitField.value.length;
        }
    }
</script>

<link rel="stylesheet" href="bootstrap-select/dist/css/bootstrap-select.css">
<script type="text/javascript" src="bootstrap-select/dist/js/bootstrap-select.js"></script>

<div id="page-content">
    <div id='wrap'>
        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>Send SMS (Number List in CSV)</h4>
                </div>
               <div class="panel-body" id="recipient">
                    <div class="panel-body collapse in">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="SchedulePromotionID" id="user" >

                            <?php
                            // $User must be defined elsewhere in your app.
                            if (isset($User) && ($User == "Admin" || $User == "admin")) {
                                ?>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label">Select User Name :</label>
                                    <div class="col-sm-6">
                                        <select name="opt" id="opt" class="form-control selectpicker"  data-live-search="true" onchange="ShowDropDown('opt', 'ShortCodeDiv', 'ShowMaskingId', 'ShowService')">
                                            <option value=''>please select user name</option>
                                            <?php
                                            foreach ($users as $u) {
                                                $UserName = htmlspecialchars($u['UserName']);
                                                echo "<option value='{$UserName}'>{$UserName}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class = "form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label">User Name</label>
                                    <div class="col-sm-6">
                                        <select name="opt" id="opt" class="form-control selectpicker"  data-live-search="true" onchange="ShowDropDown('opt', 'ShortCodeDiv', 'ShowMaskingId','ShowService')">
                                            <option value=''>please select user name</option>
                                            <option value='<?php echo htmlspecialchars($User); ?>'><?php echo htmlspecialchars($User); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>

                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Masking ID:</label>
                                <div class="col-sm-6" id="ShortCodeDiv"></div>
                            </div>

                            <div>
                                <label for="chkPassport">
                                    Click on check box for Template Text SMS .
                                    <input type="checkbox" id="chkPassport" />
                                </label>
                            </div>

                             <div id="autoUpdate" class="autoUpdate">
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label">SMS Text</label>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="mt-radio-inline">
                                                <label class="mt-radio">
                                                    <input name="recipientsmsRadios" id="recipientsmsRadiosText" value="text" checked="checked" type="radio"> Text
                                                    <span></span>
                                                </label>
                                                <label class="mt-radio">
                                                    <input name="recipientsmsRadios" id="recipientsmsRadiosUnicode" value="unicode" type="radio"> Unicode
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <textarea class="count_me form-control" name="message" rows="3" id="message" placeholder="write your text" required></textarea>
                                        <div class="row">
                                            <div style="float: right">
                                                <span class="charleft contacts-count">0 Characters | 235 Characters Left</span>
                                                <span class="parts-count">| 1 SMS (160 Char./SMS)</span>
                                            </div>
                                            <input type="hidden" class="NumberOfSms" id="NumberOfSms" name="NumberOfSms">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="dvPassport" style="display: none">
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label">Select Template Text</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="TemplateText" id="TemplateText">
                                            <option value=''>please select template text</option>
                                            <?php
                                            // fetch template texts from panel DB
                                            try {
                                                if (isset($User) && $User == 'Admin') {
                                                    $stmtTemp = $cn->query("SELECT TemplateSMS FROM dbo.TemplateText");
                                                } else {
                                                    $stmtTemp = $cn->prepare("SELECT TemplateSMS FROM dbo.TemplateText WHERE UserName = ?");
                                                    $stmtTemp->execute([$User]);
                                                }
                                                $templates = $stmtTemp->fetchAll(PDO::FETCH_COLUMN, 0);
                                                foreach ($templates as $t) {
                                                    $tEsc = htmlspecialchars($t);
                                                    echo "<option value='{$tEsc}'>{$tEsc}</option>";
                                                }
                                            } catch (PDOException $e) {
                                                error_log("TemplateText fetch error: " . $e->getMessage());
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Upload CSV File:</label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="uploadcsv" type="file" id="uploadcsv" accept=".csv">
                                    Please download sample csv here . <a href="messaging/sample.csv">Download</a>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label"></label>
                                <div class="col-sm-6">
                                    <input onClick="return confirm('Do you Really want to SEND this information?')" class="btn btn-primary" name="submit" type="submit" value="send">
                                </div>
                            </div>
                        </form>

                    </div>

                    <script language="JavaScript" src="js/validator.js" type="text/javascript"></script>
                    <script language="JavaScript" src="js/jquery_004.js" type="text/javascript"></script>

                    <script>
                        $(document).ready(function () {
                            $('#recipient .count_me').textareaCount({
                                'maxCharacterSize': 235,
                                'textAlign': 'right',
                                'warningColor': '#CC3300',
                                'warningNumber': 160,
                                'isCharacterCount': true,
                                'isWordCount': false,
                                'displayFormat': '#input Characters | #left Characters Left',
                                'originalStyle': 'contacts-count',
                                'counterCssClass': '#recipient .charleft',

                            }, function (data) {
                                var parts = 1;
                                var isUnicode = isDoubleByte($('#recipient .count_me').val());
                                var typeRadio = $('input:radio[name=recipientsmsRadios]:checked').val();
                                var charPerSMS = 160;
                                if (isUnicode) {
                                    charPerSMS = 70;
                                    if (data.input > 70) {
                                        parts = Math.ceil(data.input / 67);
                                        charPerSMS = 67;
                                    }
                                    if (typeRadio == "text") {
                                        $("#recipientsmsRadiosUnicode").prop('checked', true);
                                    } else if (typeRadio == "flash") {
                                        $("#recipientsmsRadiosUnicodeFlash").prop('checked', true);
                                    }

                                }
                                else {
                                    var isUnicodeNormal = isDoubleByteNormal($('#recipient .count_me').val());
                                    if (isUnicodeNormal) {
                                        charPerSMS = 140;
                                        if (data.input > 140) {
                                            parts = Math.ceil(data.input / 134);
                                            charPerSMS = 134;
                                        }
                                    } else {
                                        charPerSMS = 160;
                                        if (data.input > 160) {
                                            parts = Math.ceil(data.input / 153);
                                            charPerSMS = 153;
                                        }
                                    }

                                    if (typeRadio == "unicode") {
                                        $("#recipientsmsRadiosText").prop('checked', true);
                                    } else if (typeRadio == "flashunicode") {
                                        $("#recipientsmsRadiosFlash").prop('checked', true);
                                    }
                                }

                                $('#recipient .parts-count').text('| ' + parts + ' SMS (' + charPerSMS + ' Char./SMS)');

                                var SMSNumber = parts;
                                // alert (SMSParts);
                                // $('#SMSPart').val(parts);
                                // $('#recipient .parts-count2').text('| ' + parts + ' SMS (170 Char./SMS)');

                                // $('#recipient .parts-count2').text(parts);
                                $('#recipient .NumberOfSms').val(parts);

                            });
                            // End Recipient

                            // Sart Group SMS

                            $('#group .count_me').textareaCount({
                                'maxCharacterSize': 235,
                                'textAlign': 'right',
                                'warningColor': '#CC3300',
                                'warningNumber': 160,
                                'isCharacterCount': true,
                                'isWordCount': false,
                                'displayFormat': '#input Characters | #left Characters Left',
                                'originalStyle': 'contacts-count',
                                'counterCssClass': '#group .charleft',

                            }, function (data) {
                                var parts = 1;
                                var isUnicode = isDoubleByte($('#group .count_me').val());
                                var typeRadio = $('input:radio[name=groupssmsRadios]:checked').val();
                                var charPerSMS = 160;
                                if (isUnicode) {
                                    charPerSMS = 70;
                                    if (data.input > 70) {
                                        parts = Math.ceil(data.input / 67);
                                        charPerSMS = 67;
                                    }
                                    if (typeRadio == "text") {
                                        $("#groupssmsRadiosUnicode").prop('checked', true);
                                    } else if (typeRadio == "flash") {
                                        $("#groupssmsRadiosUnicodeFlash").prop('checked', true);
                                    }
                                } else {
                                    var isUnicodeNormal = isDoubleByteNormal($('#group .count_me').val());
                                    if (isUnicodeNormal) {
                                        charPerSMS = 140;
                                        if (data.input > 140) {
                                            parts = Math.ceil(data.input / 134);
                                            charPerSMS = 134;
                                        }
                                    } else {
                                        charPerSMS = 160;
                                        if (data.input > 160) {
                                            parts = Math.ceil(data.input / 153);
                                            charPerSMS = 153;
                                        }
                                    }
                                    if (typeRadio == "unicode") {
                                        $("#groupssmsRadiosText").prop('checked', true);
                                    } else if (typeRadio == "flashunicode") {
                                        $("#groupssmsRadiosFlash").prop('checked', true);
                                    }
                                }

                                $('#group .parts-count').text('| ' + parts + ' SMS (' + charPerSMS + ' Char./SMS)');
                            });
                            // End Group SMS

                            // Sart Upload SMS

                            $('#upload .count_me').textareaCount({
                                'maxCharacterSize': 235,
                                'textAlign': 'right',
                                'warningColor': '#CC3300',
                                'warningNumber': 160,
                                'isCharacterCount': true,
                                'isWordCount': false,
                                'displayFormat': '#input Characters | #left Characters Left',
                                'originalStyle': 'contacts-count',
                                'counterCssClass': '#upload .charleft',

                            }, function (data) {
                                var parts = 1;
                                var isUnicode = isDoubleByte($('#upload .count_me').val());
                                var typeRadio = $('input:radio[name=uploadsmsRadios]:checked').val();
                                var charPerSMS = 160;
                                if (isUnicode) {
                                    charPerSMS = 70;
                                    if (data.input > 70) {
                                        parts = Math.ceil(data.input / 67);
                                        charPerSMS = 67;
                                        alert(parts);
                                    }
                                    if (typeRadio == "text") {
                                        $("#uploadsmsRadiosUnicode").prop('checked', true);
                                    } else if (typeRadio == "flash") {
                                        $("#uploadsmsRadiosUnicodeFlash").prop('checked', true);
                                    }
                                } else {
                                    var isUnicodeNormal = isDoubleByteNormal($('#upload .count_me').val());
                                    if (isUnicodeNormal) {
                                        charPerSMS = 140;
                                        if (data.input > 140) {
                                            parts = Math.ceil(data.input / 134);
                                            charPerSMS = 134;
                                        }
                                    } else {
                                        charPerSMS = 160;
                                        if (data.input > 160) {
                                            parts = Math.ceil(data.input / 153);
                                            charPerSMS = 153;
                                            alert(parts);
                                        }
                                    }

                                    if (typeRadio == "unicode") {
                                        $("#uploadsmsRadiosText").prop('checked', true);
                                    } else if (typeRadio == "flashunicode") {
                                        $("#uploadsmsRadiosFlash").prop('checked', true);
                                    }
                                }

                                $('#upload .parts-count').text('| ' + parts + ' SMS (' + charPerSMS + ' Char./SMS)');
                            });

                            // End Upload SMS
                            function isDoubleByte(str) {
                                for (var i = 0, n = str.length; i < n; i++) {
                                    //if (str.charCodeAt( i ) > 255 && str.charCodeAt( i )!== 8364 )
                                    if (str.charCodeAt(i) > 255) {
                                        return true;
                                    }
                                }
                                return false;
                            }

                            function isDoubleByteNormal(str) {
                                for (var i = 0, n = str.length; i < n; i++) {
                                    if (str.charCodeAt(i) == 91
                                        || str.charCodeAt(i) == 92
                                        || str.charCodeAt(i) == 93
                                        || str.charCodeAt(i) == 94
                                        || str.charCodeAt(i) == 123
                                        || str.charCodeAt(i) == 124
                                        || str.charCodeAt(i) == 125
                                        || str.charCodeAt(i) == 126
                                    ) {
                                        return true;
                                    }
                                }
                                return false;
                            }

                        });
                    </script>
                   
                    <script type="text/javascript">
                        $(function () {
                            $("#chkPassport").click(function () {
                                if ($(this).is(":checked")) {
                                    $("#dvPassport").show();
                                } else {
                                    $("#dvPassport").hide();
                                }
                            });
                        });
                    </script>

                    <script language="JavaScript" type="text/javascript">
                        $('#chkPassport').change(function () {
                            if ($(this).is(":checked"))
                                $('#autoUpdate').fadeOut('slow');
                            else
                                $('#autoUpdate').fadeIn('slow');

                        });
                    </script>

                    <script language="JavaScript" type="text/javascript">
                        var frmvalidator = new Validator("SchedulePromotionID");
                        frmvalidator.addValidation("opt", "dontselect=0", "Please Select the User Name.");
                        // frmvalidator.addValidation("ShortCodeID", "dontselect=0", "Please Select the Short Code.");
                        frmvalidator.addValidation("PromoListNameID", "req", "Select The promotional Name.");
                        frmvalidator.addValidation("start_date", "req", "Select The Sending Date.");
                        frmvalidator.addValidation("HourID", "req", "Select The Sending Hour.");
                        frmvalidator.addValidation("MinID", "req", "Write the Min.");
                        frmvalidator.addValidation("message", "req", "SMS Text Can not be null.");
                    </script>

                    <?php
                    // --- FORM SUBMIT PROCESSING ---
                    if (isset($_REQUEST['submit']) && $_REQUEST['submit'] === 'send') {

                        // Collect & sanitize inputs
                        $SendFrom = isset($_REQUEST['ShortCodeNumber']) ? trim($_REQUEST['ShortCodeNumber']) : '';
                        $UserName = isset($_REQUEST['opt']) ? trim($_REQUEST['opt']) : '';
                        $TemplateText = isset($_REQUEST['TemplateText']) ? $_REQUEST['TemplateText'] : '';
                        $Msg = isset($_REQUEST['message']) ? $_REQUEST['message'] : '';
                        $MsgCount = isset($_REQUEST['NumberOfSms']) ? max(1, intval($_REQUEST['NumberOfSms'])) : 1;
                        if (!empty($TemplateText)) {
                            $Msg = $TemplateText;
                        }

                        // Ensure CSV folder exists
                        $csvDir = __DIR__ . '/CSV/';
                        if (!is_dir($csvDir)) {
                            if (!mkdir($csvDir, 0775, true)) {
                                echo "<script>alert('Server cannot create CSV directory.');</script>";
                                exit;
                            }
                        }

                        // Validate upload
                        if (!isset($_FILES['uploadcsv']) || $_FILES['uploadcsv']['error'] !== UPLOAD_ERR_OK) {
                            echo "<script>alert('No CSV uploaded or upload error.');</script>";
                        } else {
                            $uploadedName = $_FILES['uploadcsv']['name'];
                            $tmp_name = $_FILES['uploadcsv']['tmp_name'];
                            $safeName = preg_replace('/[^A-Za-z0-9\-_\.]/', '_', pathinfo($uploadedName, PATHINFO_FILENAME));
                            $ext = pathinfo($uploadedName, PATHINFO_EXTENSION) ?: 'csv';
                            $finalName = $safeName . '_' . date("YmdHis") . '.' . $ext;
                            $filelink = $csvDir . $finalName;

                            if (!move_uploaded_file($tmp_name, $filelink)) {
                                echo "<script>alert('Failed to move uploaded file to CSV folder.');</script>";
                            } else {
                                // Count non-empty recipient rows (skip header)
                                $handle = fopen($filelink, "r");
                                if ($handle === false) {
                                    echo "<script>alert('Cannot open uploaded CSV file.');</script>";
                                } else {
                                    // assume first row is header
                                    fgetcsv($handle, 10000, ",");
                                    $recipientCount = 0;
                                    while (($row = fgetcsv($handle, 10000, ",")) !== false) {
                                        if (isset($row[0]) && trim($row[0]) !== '') {
                                            $recipientCount++;
                                        }
                                    }
                                    fclose($handle);

                                    if ($recipientCount <= 0) {
                                        echo "<script>alert('CSV contains no recipient rows.');</script>";
                                    } else {
                                        $TotalMsgCount = $MsgCount * $recipientCount;

                                        // Check credit from panel DB ($cn)
                                        try {
                                            $stmtCredit = $cn->prepare("SELECT NumberOfSMS FROM dbo.CurrentStatus WHERE UserName = ? AND IsActive = 1");
                                            $stmtCredit->execute([$UserName]);
                                            $row = $stmtCredit->fetch(PDO::FETCH_ASSOC);
                                            $userCredits = ($row && isset($row['NumberOfSMS'])) ? intval($row['NumberOfSMS']) : 0;
                                        } catch (PDOException $e) {
                                            error_log("Credit check error: " . $e->getMessage());
                                            $userCredits = 0;
                                        }

                                        if ($TotalMsgCount > $userCredits) {
                                            $url = base_url() . "index.php?parent=CSVUpload";
                                            popup('Your credit limit is over. Please talk to Solvers Team to upgrade your credit limit. ', $url);
                                            exit;
                                        }

                                        // Prepare server path for BULK INSERT
                                        $serverCsvPath = realpath($filelink);
                                        if ($serverCsvPath === false) {
                                            echo "<script>alert('Failed to resolve absolute path for CSV file.');</script>";
                                        } else {
                                            // For SQL string we escape single quotes and ensure backslashes are doubled
                                            $serverCsvPathForSql = str_replace("'", "''", $serverCsvPath);
                                            $serverCsvPathForSql = str_replace("\\", "\\\\", $serverCsvPathForSql);

                                            // Begin transaction on gateway DB ($conn)
                                            try {
                                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                                $conn->beginTransaction();

                                                // 1) Create temp #Userinfo
                                                $conn->exec("
                                                    CREATE TABLE #Userinfo (
                                                        srcMN varchar(20) NULL,
                                                        msg nvarchar(1000) NULL,
                                                        writeTime datetime NULL,
                                                        sentTime datetime NULL,
                                                        msgStatus varchar(50) NULL,
                                                        retrycount int NULL,
                                                        srcTON int NULL,
                                                        srcNPI int NULL,
                                                        msgType varchar(50) NULL,
                                                        esm_Class int NULL,
                                                        Data_Coding int NULL,
                                                        smsPart int NULL,
                                                        totalPart int NULL,
                                                        refID bigint NULL,
                                                        Schedule datetime NULL,
                                                        srcAccount varchar(50) NULL,
                                                        destAccount varchar(50) NULL,
                                                        Remarks varchar(1000) NULL,
                                                        ContentSubCategoryID varchar(100) NULL,
                                                        ServiceID varchar(100) NULL,
                                                        IN_MSG_ID varchar(30) NULL
                                                    );
                                                ");

                                                // 2) Insert info row
                                                $safeSendFrom = substr($SendFrom, 0, 20);
                                                $safeMsg = mb_substr($Msg, 0, 1000); // keep length reasonable
                                                $safeSchedule = date('Y-m-d H:i:s') . '.000';
                                                $safeUserName = substr($UserName, 0, 50);

                                                // Escape single quotes for literal insertion (temp table insert)
                                                $safeSendFromSql = str_replace("'", "''", $safeSendFrom);
                                                $safeMsgSql = str_replace("'", "''", $safeMsg);
                                                $safeScheduleSql = str_replace("'", "''", $safeSchedule);
                                                $safeUserNameSql = str_replace("'", "''", $safeUserName);

                                                $conn->exec("
                                                    INSERT INTO #Userinfo
                                                    (srcMN, msg, writeTime, sentTime, msgStatus, retrycount, srcTON, srcNPI, msgType, esm_Class, Data_Coding, smsPart, totalPart, refID, Schedule, srcAccount, destAccount, Remarks, ContentSubCategoryID, ServiceID)
                                                    VALUES ('{$safeSendFromSql}', N'{$safeMsgSql}', GETDATE(), NULL, 'QUE', 5, 1, 1, 'TEXT', 64, 1, 1, 1, NULL, '{$safeScheduleSql}', '{$safeUserNameSql}', '{$safeUserNameSql}', NULL, NULL, NULL);
                                                ");

                                                // 3) Create temp #Usernumber
                                                $conn->exec("CREATE TABLE #Usernumber (MSISDN varchar(40) NULL);");

                                                // 4) BULK INSERT into #Usernumber (single exec) -- this runs on DB server
                                                $bulkSql = "BULK INSERT #Usernumber FROM '{$serverCsvPathForSql}' WITH ( FIELDTERMINATOR = ',', ROWTERMINATOR = '\\n' );";
                                                $conn->exec($bulkSql);

                                                // 5) Insert into SMSOutbox from the temp tables
                                                $conn->exec("
                                                    INSERT INTO dbo.SMSOutbox
                                                    (srcMN,dstMN,msg,writeTime,sentTime,msgStatus,retrycount,srcTON,srcNPI,msgType,esm_Class,Data_Coding,smsPart,totalPart,refID,Schedule,srcAccount,destAccount,Remarks,ContentSubCategoryID,ServiceID,IN_MSG_ID)
                                                    SELECT i.srcMN, n.MSISDN, i.msg, i.writeTime, i.sentTime, i.msgStatus, i.retrycount, i.srcTON, i.srcNPI, i.msgType, i.esm_Class, i.Data_Coding, i.smsPart, i.totalPart, i.refID, i.Schedule, i.srcAccount, i.destAccount, i.Remarks, i.ContentSubCategoryID, i.ServiceID, i.IN_MSG_ID
                                                    FROM #Usernumber n CROSS JOIN #Userinfo i;
                                                ");

                                                // 6) Drop temp tables
                                                $conn->exec("DROP TABLE #Usernumber;");
                                                $conn->exec("DROP TABLE #Userinfo;");

                                                // Commit
                                                $conn->commit();

                                                // --- Update panel DB (credits & expense history) using $cn (panel DB) ---
                                                // Deduct credits
                                                $newCredits = $userCredits - $TotalMsgCount;
                                                $stmtUpdate = $cn->prepare("UPDATE dbo.CurrentStatus SET NumberOfSMS = ? WHERE UserName = ? AND IsActive = 1");
                                                $stmtUpdate->execute([$newCredits, $UserName]);

                                                // Trigger low-balance email when 100 or 50 remain
                                                if ($newCredits == 100 || $newCredits == 50) {
                                                    try {
                                                        $stmtEmail = $cn->prepare("SELECT Email FROM dbo.UserInfo WHERE UserName = ?");
                                                        $stmtEmail->execute([$UserName]);
                                                        $emailRow = $stmtEmail->fetch(PDO::FETCH_ASSOC);
                                                        if ($emailRow && !empty($emailRow['Email'])) {
                                                            $UserEmail = urlencode($emailRow['Email']);
                                                            // Fire-and-forget email URL (as before)
                                                            @file_get_contents("http://solversbd.com/email/PHPMailer/examples/test_smtp_basic_rem.php?email={$UserEmail}&mgs=welcome");
                                                        }
                                                    } catch (Exception $e) {
                                                        error_log("Low-balance email error: " . $e->getMessage());
                                                    }
                                                }

                                                // Update expense history
                                                try {
                                                    $stmtExp = $cn->prepare("SELECT NumberOfSMS FROM dbo.ExpenceHistory WHERE UserName = ? AND Date = CONVERT(date, GETDATE())");
                                                    $stmtExp->execute([$UserName]);
                                                    $expRow = $stmtExp->fetch(PDO::FETCH_ASSOC);
                                                    if ($expRow && isset($expRow['NumberOfSMS'])) {
                                                        $updated = intval($expRow['NumberOfSMS']) + $TotalMsgCount;
                                                        $stmtUpdExp = $cn->prepare("UPDATE dbo.ExpenceHistory SET NumberOfSMS = ? WHERE UserName = ? AND Date = CONVERT(date, GETDATE())");
                                                        $stmtUpdExp->execute([$updated, $UserName]);
                                                    } else {
                                                        $stmtInsExp = $cn->prepare("INSERT INTO dbo.ExpenceHistory (UserName, NumberOfSMS, Date) VALUES (?, ?, CONVERT(date, GETDATE()))");
                                                        $stmtInsExp->execute([$UserName, $TotalMsgCount]);
                                                    }
                                                } catch (Exception $e) {
                                                    error_log("ExpenseHistory update error: " . $e->getMessage());
                                                }

                                                echo "<script>alert('SMS Posted Successfully');</script>";

                                            } catch (PDOException $e) {
                                                if ($conn->inTransaction()) {
                                                    $conn->rollBack();
                                                }
                                                error_log("BULK/Temp error (PDO): " . $e->getMessage());
                                                echo "<script>alert('An error occurred while inserting to database. Check server logs.');</script>";
                                            }
                                        } // realpath ok
                                    } // recipients > 0
                                } // fopen ok
                            } // moved file
                        } // upload exists
                    } // form submit
                    ?>
                </div>
            </div>
        </div>
    </div> <!-- row -->
</div> <!-- container -->
