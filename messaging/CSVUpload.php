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
                    <h4>Send SMS (Number List in CSV)</h4>
                </div>
               <div class="panel-body" id="recipient">
                    <div class="panel-body collapse in">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="SchedulePromotionID" id="user" >

                            <?php
                            if ($User == "Admin" || $User == "admin") {
                                ?>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label">Select User Name :</label>
                                    <div class="col-sm-6">
                                        <select name="opt" id="opt" type="text" class="form-control selectpicker"  data-live-search="true" onchange="ShowDropDown('opt', 'ShortCodeDiv', 'ShowMaskingId', 'ShowService')">
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
                                <div class = "form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label">User Name</label>
                                    <div class="col-sm-6">

                                        <select name="opt" id="opt" type="text" class="form-control selectpicker"  data-live-search="true" onchange="ShowDropDown('opt', 'ShortCodeDiv', 'ShowMaskingId',
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
                                    <label for="focusedinput" class="col-sm-3 control-label">Select Template Text</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="TemplateText" id="TemplateText">
                                            <option value=''>please select template text</option>
                                            <?php
                                            //echo $User;

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
                                <label for="focusedinput" class="col-sm-3 control-label">Upload CSV File:</label>
                                <div class="col-sm-6">

                                    <input class="form-control" name="uploadcsv"  type="file" id="uploadcsv">

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
                        $UserName = $_REQUEST['opt'];
                        $TemplateText = $_REQUEST['TemplateText'];
                        $Msg = $_REQUEST['message'];
                        $MsgCount = $_REQUEST['NumberOfSms'];
                        if ($TemplateText != '') {
                            $Msg = $TemplateText;
                        }
                        $txtitemcode = $_POST['Recipients'];
                        $date = date("Y-m-d");
                        $_POST['date'] = $date;


                        $filename = $_FILES['uploadcsv']['name'];
                        $filename = str_replace(' ', '_', $filename);
                        $filepath = "./CSV/";

                        $tmp_name = $_FILES['uploadcsv']['tmp_name'];
                        $ext = getFileextension($filename);
                        $header = substr($filename, 0, -5) . date("YmdHis") . '.' . $ext;


                        $filelink = "./CSV/" . $header;
                        $p = "D:/wwwroot/bulksmswebpanel/CSV/" . $header; //localhost
//$p= base_url()."CSV/".$header;		//server	

                        if (move_uploaded_file($tmp_name, $filelink)) {

                            //echo "test";

                            $sql_UserAccountStatus = "select NumberOfSMS from BULKSMSPanel.[dbo].[CurrentStatus] where UserName='$UserName'";
                            $result_UserAccountStatus = odbc_exec($cn, $sql_UserAccountStatus);
                            $row_UserAccount = odbc_fetch_array($result_UserAccountStatus);
                            $row_UserAccount = $row_UserAccount['NumberOfSMS'];

                            $ScheduleTime = date('Y-m-d H:i:s');

                            $ScheduleTime = $ScheduleTime . '.000';
                            $handle = fopen($filelink, "r");
                            fgetcsv($handle, 1000, ",");
                            $c = 1;

                            $data = array();
                            $n = '\n';
                            while (($result = fgetcsv($handle)) !== false) {
                                if (!empty($result[0])) {
                                    $c++;
                                  //  continue;
                                } //else {  $c++; }
                            }
                          
                             $TotalMsgCount=$MsgCount*$c;
                            
                            if ($TotalMsgCount > $row_UserAccount) {
                                $url = base_url() . "index.php?parent=CSVUpload";
                                popup('Your credit limit is over. Please talk to Solvers Team to upgrade your credit limit. ', $url);
                                exit;
                            } else {
                                $conn = PDOConnectDB();
                                                          
                                //echo $cn = ConnectDB();

                                $Userinfotable = $UserName . 'info';
                                $Usernumbertable = $UserName . 'number';

                                $conn->beginTransaction();
                                $sql = "CREATE TABLE #$Userinfotable(
	
                                [srcMN] [varchar](20) NULL,
                                [msg] [nvarchar](1000) NULL,
                                [writeTime] [datetime] NULL,
                                [sentTime] [datetime] NULL,
                                [msgStatus] [varchar](50) NULL,
                                [retrycount] [int] NULL,
                                [msgID] [uniqueidentifier] NULL,
                                [srcTON] [int] NULL,
                                [srcNPI] [int] NULL,
                                [msgType] [varchar](50) NULL,
                                [esm_Class] [int] NULL,
                                [Data_Coding] [int] NULL,
                                [smsPart] [int] NULL,
                                [totalPart] [int] NULL,
                                [refID] [bigint] NULL,
                                [Schedule] [datetime] NULL,
                                [srcAccount] [varchar](50) NULL,
                                [destAccount] [varchar](50) NULL,
                                [Remarks] [varchar](1000) NULL,
                                [ContentSubCategoryID] [varchar](100) NULL,
                                [ServiceID] [varchar](100) NULL,
                                [LastRetryTime] [datetime] NULL,
                                [Priority] [int] NULL,
                                [IN_MSG_ID] [varchar](30) NULL	
                            )
                            Insert into [BULKSMSPanel].[dbo].[#$Userinfotable] 
(srcMN, msg, writeTime, sentTime, msgStatus, retrycount, srcTON, srcNPI, msgType, esm_Class, Data_Coding, smsPart, totalPart, refID,Schedule,srcAccount, destAccount, Remarks,ContentSubCategoryID,ServiceID)
VALUES('$SendFrom',N'" . $Msg . "', getdate(),'', 'QUE', '5', '1','1', 'TEXT', '64', '1', '1', '1', '','$ScheduleTime','$UserName', '$UserName', '','','' )
                            CREATE TABLE #$Usernumbertable
                            (
                            MSISDN VARCHAR(40)
                            )
                            BULK INSERT #$Usernumbertable FROM '$p' WITH ( FIELDTERMINATOR = ',', ROWTERMINATOR = '$n' )
                            INSERT [BULKSMSGateway_1_0].[dbo].[SMSOutbox]  (srcMN,dstMN, msg, writeTime, sentTime, msgStatus, retrycount, srcTON, srcNPI, msgType, esm_Class, Data_Coding, smsPart, totalPart, refID,Schedule,srcAccount, destAccount, Remarks,ContentSubCategoryID,ServiceID,IN_MSG_ID)
Select srcMN,MSISDN, msg, writeTime, sentTime, msgStatus, retrycount, srcTON, srcNPI, msgType, esm_Class, Data_Coding, smsPart, totalPart, refID,Schedule,srcAccount, destAccount, Remarks,ContentSubCategoryID,ServiceID,IN_MSG_ID
 from [dbo].[#$Usernumbertable],[BULKSMSPanel].[dbo].[#$Userinfotable] ";
//  odbc_exec($cn, $sql_createusertable);
                                $stmt = $conn->query($sql);
                                if ($stmt != NULL) {
                                    $conn->commit();
//                                    $sql_COMMITTRANSACTION = "COMMIT TRANSACTION";
//                                    odbc_exec($cn, $sql_COMMITTRANSACTION);

                                    $AccountValSql = "Select NumberOfSMS from [dbo].[CurrentStatus] WHERE UserName='$UserName' and IsActive=1";
                                    $AccountValResult = odbc_exec($cn, $AccountValSql);
                                    $AccountValue = odbc_fetch_array($AccountValResult);
                                    $UserCurrentSmsVal = $AccountValue[NumberOfSMS];
                                    $TotalNumberOfSmsVal = $UserCurrentSmsVal - $TotalMsgCount;
                                  $UpdateMainAccountQuery = "UPDATE [dbo].[CurrentStatus] set NumberOfSMS = $TotalNumberOfSmsVal WHERE UserName='$UserName' and IsActive=1";
                                    odbc_exec($cn, $UpdateMainAccountQuery);

                                    if (($TotalNumberOfSmsVal == 100)||($TotalNumberOfSmsVal == 50)) {
                                 //if ($TotalNumberOfSmsVal < 101) {

                                        $SelectEmailSql = "Select Email from [dbo].[UserInfo] WHERE UserName='$UserName' ";
                                        $SelectEmailResult = odbc_exec($cn, $SelectEmailSql);
                                        $UserEmailValue = odbc_fetch_array($SelectEmailResult);
                                        $UserEmail = $UserEmailValue[Email];


                                        $file = file_get_contents("http://solversbd.com/email/PHPMailer/examples/test_smtp_basic_rem.php?email=$UserEmail&mgs=welcome", FILE_USE_INCLUDE_PATH);
                                    }



                                    $ExpenseValSql = "Select NumberOfSMS from [dbo].[ExpenceHistory] WHERE UserName='$UserName' and  Date= convert(date, getdate())	";

                                    $ExpenseValResult = odbc_exec($cn, $ExpenseValSql);
                                    $ExpenseValue = odbc_fetch_array($ExpenseValResult);
                                    $UserCurrentExpenseSmsVal = $ExpenseValue[NumberOfSMS];
                                    if ($UserCurrentExpenseSmsVal > 0) {
                                        $TotalNumberOfExpenseSmsVal = $UserCurrentExpenseSmsVal + $TotalMsgCount;

                                        $UpdateExpenseQuery = "UPDATE [dbo].[ExpenceHistory] set NumberOfSMS = $TotalNumberOfExpenseSmsVal WHERE UserName='$UserName' and Date= convert(date, getdate())";
                                        odbc_exec($cn, $UpdateExpenseQuery);
                                    } else {
                                        $sql_insertExpenseHistory = "INSERT INTO [dbo].[ExpenceHistory] (UserName,[NumberOfSMS],[Date]) VALUES ('$UserName','$TotalMsgCount',convert(date, getdate()))";
                                        odbc_exec($cn, $sql_insertExpenseHistory);
                                    }



                                    echo "<script>
               alert('SMS Posted Successfully');
        </script>";
                                } else {
                                    $conn->rollBack();
//                                    $sql_ROLLBACKTRANSACTION = " ROLLBACK TRANSACTION";
//                                    odbc_exec($cn, $sql_ROLLBACKTRANSACTION);
                                    echo "<script>
				alert('Your Data is not uploaded properly,please try again.');
			    </script>";
                                }


                                $sql_droptable = "DROP Table #$Usernumbertable ";
                                odbc_exec($cn, $sql_droptable);


                                $sql_dropusertable = "DROP Table #$Userinfotable ";
                                odbc_exec($cn, $sql_dropusertable);

                                odbc_close($cn);
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div> <!-- row -->
</div> <!-- container -->

