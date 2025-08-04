<?php
$conn = PDOConnectDB();
$userDetail = "SELECT UserID, UserName FROM BULKSMSPanel.dbo.UserInfo Order By UserName ASC";
$result_userDetail = odbc_exec($cn, $userDetail);
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
                    <h4>Messaging</h4>
                </div>
                <div class="panel-body" id="recipient">
                    <div class="panel-body collapse in">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data"
                              name="SchedulePromotionID" id="user">

                            <?php
                            if ($User == "Admin" || $User == "admin") {
                                ?>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label">Select User Name :</label>
                                    <div class="col-sm-6">
                                        <select name="opt" id="opt" type="text" class="form-control selectpicker"  data-live-search="true"
                                                onchange="ShowDropDown('opt', 'ShortCodeDiv', 'ShowMaskingId', 'ShowService')">
                                            <option selected=''>please select user name</option>
                                            <?php
                                            while ($n = odbc_fetch_row($result_userDetail)) {

                                                $UserID = odbc_result($result_userDetail, "UserID");
                                                $UserName = odbc_result($result_userDetail, "UserName");
                                                echo "<option value='$UserName'>$UserName</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label">User Name</label>
                                    <div class="col-sm-6">
                                        <select name="opt" id="opt" type="text" class="form-control selectpicker" data-live-search="true" onchange="ShowDropDown('opt', 'ShortCodeDiv', 'ShowMaskingId',
                                                            'ShowService')">
                                            <option selected=''>please select user name</option>
                                            <option value='<?php echo $User; ?>'><?php echo $User; ?></option>
                                            
                                        </select>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Masking ID:</label>
                                <div class="col-sm-6" id="ShortCodeDiv">
                                </div>
                            </div>
                            <div>
                                <label for="chkPassport">
                                    Click on checkbox for Template Text SMS .
                                    <input type="checkbox" id="chkPassport"/>
                                </label>
                            </div>
                            <div id="autoUpdate" class="autoUpdate">
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label">SMS Text</label>
                                    <div class="col-sm-6">                                  
                                        <div class="form-group">                                     
                                            <div class="mt-radio-inline">
                                                <label class="mt-radio">
                                                    <input name="recipientsmsRadios" id="recipientsmsRadiosText"
                                                           value="text" checked="checked" type="radio"> Text
                                                    <span></span>
                                                </label>
                                                <label class="mt-radio">
                                                    <input name="recipientsmsRadios" id="recipientsmsRadiosUnicode"
                                                           value="unicode" type="radio"> Unicode
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <textarea class="count_me form-control" name="message" rows="3" id="message" placeholder="write your text" required=""> </textarea>
                                        <div class="row">
                                                <div style="float: right">
                                                    <span class="charleft contacts-count">0 Characters | 235 Characters Left</span>
                                                    <span class="parts-count">| 1 SMS (160 Char./SMS)</span>
                                                </div>
                                              
                                                <input type="hidden" class="NumberOfSms" id="NumberOfSms" name="NumberOfSms">
<!--                                            </div>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="dvPassport" style="display: none">
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label">Select Template
                                        Text</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="TemplateText" id="TemplateText">
                                            <option value=''>please select template text</option>
                                            <?php
                                            echo $User;

                                            if ($User == 'Admin') {
                                                echo $TemplateText = "SELECT TemplateSMS FROM BULKSMSPanel.dbo.TemplateText ";
                                            } else {
                                                echo $TemplateText = "SELECT TemplateSMS FROM BULKSMSPanel.dbo.TemplateText where UserName='$User' ";
                                            }

                                            //echo $TemplateText = "SELECT TemplateSMS FROM BULKSMSPanel.dbo.TemplateText ";
                                            //exit;
                                            $result_userDetail = odbc_exec($cn, $TemplateText);
                                            while ($n = odbc_fetch_row($result_userDetail)) {
                                                echo $TemplateSMS = odbc_result($result_userDetail, "TemplateSMS");
                                                //$UserName = odbc_result($result_userDetail, "UserName");
                                                echo "<option value='$TemplateSMS'>$TemplateSMS</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Recipients</label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" name="Recipients" id="Recipients" cols="100" rows="3"
                                              placeholder="Numbers should be  comma-separated values e.g.: 880191XXXXXXX, 880171XXXXXXX,880181XXXXXXX,880161XXXXXXX"></textarea>


                                    <span>Valid :</span> <span id="mnValidMobile">0</span>
                                    <span>&nbsp;&nbsp;|&nbsp;&nbsp;Invalid : </span><span id="mnInvalidMobile">0</span>
                                    <span id="mnInvalidLocation"></span>

                                    <script type="text/javascript">

                                        $('#Recipients').on("input propertychange", function () {
                                            var data = $('#Recipients').val();
                                            data = data.replace(/\n/g, ',');
                                            var numbers = data.split(",");
                                            var invalid = 0;
                                            var total = 0;
                                            for (var i = 0; i < numbers.length; i++) {
                                                if (numbers[i].trim() != "") {
                                                    total++;
                                                    if (window.mobileCheck(numbers[i]) == null) {
                                                        invalid++;
                                                    }
                                                }
                                            }
                                            var valid = total - invalid;

                                            $('#mnValidMobile').html(valid);
                                            $('#mnInvalidMobile').html(invalid);
                                        });

                                        function mobileCheck(mobileNumber) {
                                            mobileNumber = mobileNumber.replace(/\W+/g, "")
                                            var chkVal = mobileNumber.match(/(^(\+8801|8801|01|008801))[1|3-9]{1}(\d){8}$/);
                                            // var chkVal = mobileNumber.match(/^(?:\+?88)?0?1[15-9]\d{8}$/);
                                            //alert(chkVal);
                                            return chkVal;
                                        }

                                    </script>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label"></label>
                                <div class="col-sm-6">
                                    <input onClick="return confirm('Do you Really want to SEND this information?')"
                                           class="btn btn-primary" name="submit" type="submit" value="send">
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
                            <!-- End Recipient-->

                            <!-- Sart Group SMS-->

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
                            <!-- End Group SMS-->

                            <!-- Sart Upload SMS-->

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

                            <!-- End Upload SMS-->
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
                    if ($_REQUEST['submit'] == "send") {

                        $SendFrom = $_REQUEST['ShortCodeNumber'];
                        
                      if ($SendFrom == "") {
                            $url = base_url() . "index.php?parent=RechargeBalance";
                            popup('Please Purchase SMS first. ', $url);
                            return false;
                            exit;
                       }




                        $UName = $_REQUEST['opt'];
                        $TemplateText = $_REQUEST['TemplateText'];
                      echo  $Msg = $_REQUEST['message'];
                        $MsgCount = $_REQUEST['NumberOfSms'];
                        if ($TemplateText != '') {
                            $Msg = $TemplateText;
                        }
                        $txtitemcode = $_POST['Recipients'];
                        $date = date("Y-m-d");
                        $_POST['date'] = $date;
                        //$RequestedIP = "127.0.0.1";
                        $sql_userInfo = "select UserName,Password from BULKSMSPanel.[dbo].[UserInfo] where UserName='$UName'";
                        $result_userInfo = odbc_exec($cn, $sql_userInfo);
                        $row = odbc_fetch_array($result_userInfo);
                        $UserName = $row['UserName'];
                        $Password = $row['Password'];
                        $string = $username . "|" . $password;
                        $AuthToken = base64_encode($string);

                        $ScheduleTime = date('Y-m-d H:i:s');

                        $ScheduleTime = $ScheduleTime . '.000';

                        //echo $string = $username|$password;
                        $sql_requestingip = "select RequestingIP from BULKSMSPanel.[dbo].[MaskingDetail] where MaskingID='$SendFrom'";
                        $result_requestingip = odbc_exec($cn, $sql_requestingip);
                        $row = odbc_fetch_array($result_requestingip);

                        $RequestedIP = $row['RequestingIP'];
                        $dataexplode = explode(",", $txtitemcode);
                        //print_r($dataexplode);
                        $dataexplodecount = count($dataexplode);
                        $sql_UserAccountStatus = "select NumberOfSMS from BULKSMSPanel.[dbo].[CurrentStatus] where UserName='$UName'";
                        $result_UserAccountStatus = odbc_exec($cn, $sql_UserAccountStatus);
                        $row_UserAccount = odbc_fetch_array($result_UserAccountStatus);
                        $row_UserAccount = $row_UserAccount['NumberOfSMS'];

                        if ($dataexplodecount > $row_UserAccount) {

                            //echo "Your Limit is Over.";

                            $url = base_url() . "index.php?parent=SmsInSent";
                            popup('Your credit limit is over. Please Purchase SMS. ', $url);
                            exit;
                        }


                        //$arr = array();
                        $ValidNumCounterArr = array();
                        $InValidNumCounterArr = array();
                        $ValidNumCounter = 0;
                        $InValidNumCounter = 0;
                        $InValidMsisdn = 0;
                        foreach ($dataexplode as $SendTo) {

                            $MSISDNCHK = strlen($SendTo);
                            if ($MSISDNCHK > 10 && is_numeric($SendTo)) {
                                $InitialMSISDN = substr($SendTo, -10);
                                $SendTo = "880" . $InitialMSISDN;
                                $MSISDN = $SendTo;
                                $InMSgID = $MSISDN . date('YmdHis') . rand(1, 99);

                                //echo $URL = "BulkSMSAPI/BulkSMSExtAPI.php?SendFrom=$MaskingID&SendTo=$Recipients&InMSgID=$InMgsID&AuthToken=$AuthToken&Msg=$SMSText";

                                $SMSPermitQuery = 'SET NOCOUNT ON ;';
                                $SMSPermitQuery .= 'DECLARE @returnValue INT;';
                                $SMSPermitQuery .= 'EXEC @returnValue=[BULKSMSPanel].[dbo].[PermitSMSProcBangla]';
                                $SMSPermitQuery .= "@UserName ='$UserName',";
                                $SMSPermitQuery .= "@Password ='$Password',";
                                $SMSPermitQuery .= "@RequestedIP='$RequestedIP',";
                                $SMSPermitQuery .= "@SendFrom ='$SendFrom',";
                                $SMSPermitQuery .= "@SendTo ='$SendTo',";
                                $SMSPermitQuery .= "@InMSgID ='$InMSgID',";
                                $SMSPermitQuery .= "@ScheduleTime ='$ScheduleTime',";
                                $SMSPermitQuery .= "@NumberOfPerSMS ='$MsgCount',";                                
                                $SMSPermitQuery .= "@msg =N'$Msg';";
                                $SMSPermitQuery .= "select @returnValue as ReturnVal; ";

                                //echo $SMSPermitQuery;  // exit;

                                $stmt = $conn->query($SMSPermitQuery);


                                //$result = odbc_exec($cn, $SMSPermitQuery);
                                //$PermitReturnValArray = odbc_fetch_array($result);                     
                                // $PermitReturnVal = $PermitReturnValArray['ReturnVal'];


                                while ($ReturnRow = $stmt->fetch()) {
                                    $PermitReturnVal = $ReturnRow['ReturnVal'];
                                }

                                //exit;

                                if ($PermitReturnVal == '200') {
                                    //$StatusCode = '200';
                                    $ValidNumCounter++;
                                    ?>

                                    <?php
                                } else {
                                    $StatusCode = $PermitReturnVal;
                                    $sql_error = "select ErrorCode,ErrorDescription,ActionTaken from [BULKSMSPanel].[dbo].[ErrorCode] where ErrorCode='$StatusCode'";
                                    $result_error = odbc_exec($cn, $sql_error);
                                    $row_error = odbc_fetch_array($result_error);
                                    $ErrorDescription = $row_error['ErrorDescription'];
                                    //"INSERT into [CMS_1_0].[dbo].[PromotionalDetail](PromoName,PromoText,PromoID,SendingTime,SendBy)values('$PromoName','$SMSText','$ServiceID','$ContentSendingTime','$User')";
                                    $sql_erroeinsert = "INSERT INTO [BULKSMSGateway_1_0].[dbo].[ErrorNumbers]  (MobileNo,ErrorCode,ErrorDescription,UserName)values('$SendTo','$StatusCode','$ErrorDescription','$UserName')";
                                    odbc_exec($cn, $sql_erroeinsert);
                                    $InValidNumCounter++;
                                }
                            } else {
                                $sql_erroeinsert = "INSERT INTO [BULKSMSGateway_1_0].[dbo].[ErrorNumbers]  (MobileNo,ErrorCode,ErrorDescription,UserName)values('$SendTo','204','Invalid Recipient MSISDN number','$UserName')";
                                odbc_exec($cn, $sql_erroeinsert);
                                $InValidMsisdn++;
                            }


                            $AccountValSql = "Select NumberOfSMS from [dbo].[CurrentStatus] WHERE UserName='$UserName' and IsActive=1";
                            $AccountValResult = odbc_exec($cn, $AccountValSql);
                            $AccountValue = odbc_fetch_array($AccountValResult);
                            $UserCurrentSmsVal = $AccountValue[NumberOfSMS];


                            if (($UserCurrentSmsVal == 100)||($UserCurrentSmsVal == 50)) {

                                $SelectEmailSql = "Select Email from [dbo].[UserInfo] WHERE UserName='$UserName' ";
                                $SelectEmailResult = odbc_exec($cn, $SelectEmailSql);
                                $UserEmailValue = odbc_fetch_array($SelectEmailResult);
                                $UserEmail = $UserEmailValue[Email];

                                //$file = file_get_contents("http://solversbd.com/email/PHPMailer/examples/test_smtp_basic.php?email=$UserEmail&mgs=welcome", FILE_USE_INCLUDE_PATH);
                                //$file = file_get_contents("http://45.64.135.90/PHPMailer/examples/test_smtp_basic_low_balance.php?sub=SMS credit below 100&uname=$UserName&Email=$UserEmail", FILE_USE_INCLUDE_PATH);

                                $MailURL = get_mail_server_url() . "test_smtp_basic_low_balance.php?sub=SMS credit below 100&uname=$UserName&Email=$UserEmail";
                                $MainMailURL = str_replace(" ", "+", $MailURL);
                                //echo $ChargingInterfaceURL;exit;
                                $ChargingURLResponce = file_get_contents($MainMailURL);
                                // echo $file = file_get_contents("http://solversbd.com/email/PHPMailer/examples/test_smtp_basic.php?email=$UserEmail&mgs=$m&NumberOfSMS=$NumberOfSMS", FILE_USE_INCLUDE_PATH);
                            }
                        }
                        //end of foreach
                        //print_r($ValidNumCounterArr);
                        ?>
                        <div class="alert alert-success" role="alert">
                            <p>Successfully Posted SMS: <span class="badge"><?php echo $ValidNumCounter; ?></span></p>
                            <br/>
                            <?php if ($ValidNumCounter > 0) {
                                ?>
                                <a class="btn btn-success btn-sm"
                                   href="<?php echo base_url() . 'index.php?parent=RealTimeSMSLogReport'; ?>">click here  for detail</a>
                            <?php }
                            ?>
                        </div>
                        <?php if ($InValidNumCounter > 0) {
                            ?>
                            <div class="alert alert-warning" role="alert">
                                <p>Total Error Found: <span class="badge"><?php echo $InValidNumCounter; ?></span></p>
                                <br/>
                                <a class="btn btn-danger btn-sm"
                                   href="<?php echo base_url() . 'index.php?parent=ViewError'; ?>">click here for error  detail</a>
                            </div>
                        <?php }
                        ?>
                        <?php if ($InValidMsisdn > 0) {
                            ?>
                            <div class="alert alert-danger" role="alert">
                                <p>Total Invalid Number Found: <span class="badge"><?php echo $InValidMsisdn; ?></span>
                                </p><br/>
                                <a class="btn btn-danger btn-sm"  href="<?php echo base_url() . 'index.php?parent=ViewError'; ?>">click here for error  detail</a>
                            </div>
                        <?php }
                        ?>
                        <?php
                    }
                    ?>
                </div>

            </div>
        </div>
    </div> <!-- row -->
</div> <!-- container -->

