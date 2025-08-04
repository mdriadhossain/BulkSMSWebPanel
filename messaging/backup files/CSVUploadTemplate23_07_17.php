<?php
set_time_limit(0);
$cn = ConnectDB();
?>
<?php
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
<div id="page-content">
    <div id='wrap'>
        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>Send SMS (Number and Message List in CSV)</h4>
                </div>
                <div class="panel-body">
                    <div class="panel-body collapse in">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="SchedulePromotionID" id="user" >

                            <?php
                            if ($User == "Admin" || $User == "admin") {
                                ?>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label">Select User Name :</label>
                                    <div class="col-sm-6">
                                        <select name="opt" id="opt" type="text" class="form-control" onchange="ShowDropDown('opt', 'ShortCodeDiv', 'ShowMaskingId', 'ShowService')">
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

                                        <select name="opt" id="opt" type="text" class="form-control" onchange="ShowDropDown('opt', 'ShortCodeDiv', 'ShowMaskingId',
                                                        'ShowService')">
                                            <option selected=''>please select user name</option>
                                            <option value='<?php echo $User; ?>'><?php echo $User; ?></option>
                                            <?php
//                                        while ($n = odbc_fetch_row($result_userDetail)) {
//                                            $UserID = odbc_result($result_userDetail, "UserID");
//                                            $UserName = odbc_result($result_userDetail, "UserName");
//                                            echo "<option value='$UserID'>$UserName</option>";
//                                        }
                                            ?>
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

                                    <input class="form-control" name="uploadcsv"  type="file" id="uploadcsv"><br/>
                                    Please download sample csv here . <a href="messaging/SampleCSVMsgNumber.csv">Download</a>
                                     <br/>Please Don't Send Bangla SMS here<br/>
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
                        frmvalidator.addValidation("SMSTextID", "req", "SMS Text Can not be null.");
                    </script>
                    <?php
                    if ($_REQUEST['submit'] == "send") {

                        function getContents($str, $startDelimiter, $endDelimiter) {
                            $contents = array();
                            $startDelimiterLength = strlen($startDelimiter);
                            $endDelimiterLength = strlen($endDelimiter);
                            $startFrom = $contentStart = $contentEnd = 0;
                            while (false !== ($contentStart = strpos($str, $startDelimiter, $startFrom))) {
                                $contentStart += $startDelimiterLength;
                                $contentEnd = strpos($str, $endDelimiter, $contentStart);
                                if (false === $contentEnd) {
                                    break;
                                }
                                $contents[] = substr($str, $contentStart, $contentEnd - $contentStart);
                                $startFrom = $contentEnd + $endDelimiterLength;
                            }

                            return $contents;
                        }

                        $cn = ConnectDB();



                        $SendFrom = $_REQUEST['ShortCodeNumber'];
                        $UName = $_REQUEST['opt'];
                        $TemplateText = $_REQUEST['TemplateText'];
                        $string = $_REQUEST['SMSText'];
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

                            $sql_UserAccountStatus = "select NumberOfSMS from BULKSMSPanel.[dbo].[CurrentStatus] where UserName='$UName'";
                            $result_UserAccountStatus = odbc_exec($cn, $sql_UserAccountStatus);
                            $row_UserAccount = odbc_fetch_array($result_UserAccountStatus);
                            $row_UserAccount = $row_UserAccount['NumberOfSMS'];

                            //echo  "number of sms" . $row_UserAccount."</br>";

                            $ScheduleTime = date('Y-m-d H:i:s');

                            $ScheduleTime = $ScheduleTime . '.000';

                            $ValidNumCounterArr = array();
                            $InValidNumCounterArr = array();
                            $ValidNumCounter = 0;
                            $InValidNumCounter = 0;
                            $InValidMsisdn = 0;

                            $handleforcsvheader = fopen($filelink, "r");
                            //fgetcsv($handle, 1000, ",");
                            $c = 0;

                            $csvheaderarray = array();
                            $n = '\n';

                            while (($csvheaderresult = fgetcsv($handleforcsvheader)) !== false) {
                                $csvheaderarray[] = $csvheaderresult;
                                $c++;
                            }

                            $c = $c + 1;
                            //fclose($handleforcsvheader);
                            //$templatemgsarr = getContents($string, '[[' , ']');


                            $handle = fopen($filelink, "r");

                            //fgetcsv($fp, 1000, ",");


                            fgetcsv($handle, 1000, ",");
                            $c = 0;

                            $data = array();
                            $csvrowarray = array();
                            $n = '\n';
                            //$row = 2;

                            while (($result = fgetcsv($handle)) !== false) {
                                $data[] = $result[0];

                                $csvrowarray[] = $result;
                                //echo "C: ". $c;
                                $csvarrayvalue = $csvrowarray[$c];
                                //$dataHeader[] = $result;
                                $c++;
                            }

                            $c = $c + 1;
                            //exit;
                            fclose($file);
                            //exit;

                            $NumberString = rtrim(implode(',', $data), ',');

                            if ($c > $row_UserAccount) {


                                $url = base_url() . "index.php?parent=CSVUpload";
                                popup('Your credit limit is over. Please talk to Solvers Team to upgrade your credit limit. ', $url);
                                exit;
                            } else {
                                $Userinfotable = $UserName . 'info';
                                //echo "user name: ";
                                $Usernumbertable = $UserName . 'number';
                                echo "</br>";
                                $sql_createtable = "CREATE TABLE #$Usernumbertable
                                                    (
                                                    MSISDN VARCHAR(40),
                                                    textmgs VARCHAR(1000)
                                                    )";

                                //exit;
                                //echo $sql_createtable = "CREATE TABLE #$Usernumbertable(". $t3. ")";
                                odbc_exec($cn, $sql_createtable);
                                //exit;
                                //echo $a = odbc_exec($cn, $sql_createtable);    

                                $sql_createusertable = "CREATE TABLE #$Userinfotable(
	
                                [srcMN] [varchar](20) NULL,
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
                            )";
                                odbc_exec($cn, $sql_createusertable);
                                $sql_insertnumbers = "BULK INSERT #$Usernumbertable FROM '$p' WITH (FIELDTERMINATOR = ',', ROWTERMINATOR = '$n')";
                                odbc_exec($cn, $sql_insertnumbers);

                                $msgLenthSql = "SELECT COUNT(*)  as counter From [dbo].[#$Usernumbertable] where LEN(textmgs) > 160";
                                $msgLenthSql = odbc_fetch_array(odbc_exec($cn, $msgLenthSql));
                                $counter = $msgLenthSql['counter'];
                                if($counter > 0){
                                    popup("Maximum characters length is exist.Please send sms within Maximum 160 characters");
                                    return ;
                                    exit;
                                }

                                $sql_insertdata = "Insert into [BULKSMSPanel].[dbo].[#$Userinfotable] 
(srcMN, writeTime, sentTime, msgStatus, retrycount, srcTON, srcNPI, msgType, esm_Class, Data_Coding, smsPart, totalPart, refID,Schedule,srcAccount, destAccount, Remarks,ContentSubCategoryID,ServiceID)
VALUES('$SendFrom', getdate(),'', 'QUE', '3', '1','1', 'TEXT', '64', '1', '1', '1', '','$ScheduleTime','$UserName', '$UserName', '','','' )";

                                odbc_exec($cn, $sql_insertdata);


                                //$c=100000;
                                $sql_BEGINTRANSACTION = "BEGIN TRANSACTION";
                                odbc_exec($cn, $sql_BEGINTRANSACTION);


                                $sql_insertoutbox = "INSERT [BULKSMSGateway_1_0].[dbo].[SMSOutbox]  (srcMN,dstMN, msg, writeTime, sentTime, msgStatus, retrycount, srcTON, srcNPI, msgType, esm_Class, Data_Coding, smsPart, totalPart, refID,Schedule,srcAccount, destAccount, Remarks,ContentSubCategoryID,ServiceID,IN_MSG_ID)
Select srcMN,MSISDN, textmgs, writeTime, sentTime, msgStatus, retrycount, srcTON, srcNPI, msgType, esm_Class, Data_Coding, smsPart, totalPart, refID,Schedule,srcAccount, destAccount, Remarks,ContentSubCategoryID,ServiceID,IN_MSG_ID
 from [dbo].[#$Usernumbertable],[BULKSMSPanel].[dbo].[#$Userinfotable] ";
                                $result = odbc_exec($cn, $sql_insertoutbox);

                                $val = odbc_num_rows($result);

                                echo "</br>";

                                /* if($c==$val)
                                  {
                                  $sql_COMMITTRANSACTION = "COMMIT TRANSACTION";
                                  odbc_exec($cn, $sql_COMMITTRANSACTION );
                                  } */

                                //sleep(5);
                                //$val=100000;	 
                                if ($c == $val) {

                                    $sql_COMMITTRANSACTION = "COMMIT TRANSACTION";
                                    odbc_exec($cn, $sql_COMMITTRANSACTION);

                                    $AccountValSql = "Select NumberOfSMS from [dbo].[CurrentStatus] WHERE UserName='$UserName' and IsActive=1";
                                    $AccountValResult = odbc_exec($cn, $AccountValSql);
                                    $AccountValue = odbc_fetch_array($AccountValResult);
                                    $UserCurrentSmsVal = $AccountValue[NumberOfSMS];
                                    $TotalNumberOfSmsVal = $UserCurrentSmsVal - $c;
                                    $UpdateMainAccountQuery = "UPDATE [dbo].[CurrentStatus] set NumberOfSMS = $TotalNumberOfSmsVal WHERE UserName='$UserName' and IsActive=1";
                                    odbc_exec($cn, $UpdateMainAccountQuery);

                                    if ($TotalNumberOfSmsVal < 101) {

                                        $SelectEmailSql = "Select Email from [dbo].[UserInfo] WHERE UserName='$UserName' ";
                                        $SelectEmailResult = odbc_exec($cn, $SelectEmailSql);
                                        $UserEmailValue = odbc_fetch_array($SelectEmailResult);
                                        $UserEmail = $UserEmailValue[Email];


                                        $file = file_get_contents("http://solversbd.com/email/PHPMailer/examples/test_smtp_basic_rem.php?email=$UserEmail&mgs=welcome", FILE_USE_INCLUDE_PATH);
                                    }



                                    $ExpenseValSql = "Select NumberOfSMS from [dbo].[ExpenceHistory] WHERE UserName='$UserName' and  Date= convert(date, getdate())	";

                                    //echo "</br>";

                                    $ExpenseValResult = odbc_exec($cn, $ExpenseValSql);
                                    $ExpenseValue = odbc_fetch_array($ExpenseValResult);
                                    $UserCurrentExpenseSmsVal = $ExpenseValue[NumberOfSMS];
                                    if ($UserCurrentExpenseSmsVal > 0) {
                                        $TotalNumberOfExpenseSmsVal = $UserCurrentExpenseSmsVal + $c;

                                        $UpdateExpenseQuery = "UPDATE [dbo].[ExpenceHistory] set NumberOfSMS = $TotalNumberOfExpenseSmsVal WHERE UserName='$UserName' and Date= convert(date, getdate())";
                                        odbc_exec($cn, $UpdateExpenseQuery);
                                    } else {
                                        $sql_insertExpenseHistory = "INSERT INTO [dbo].[ExpenceHistory] (UserName,[NumberOfSMS],[Date]) VALUES ('$UserName','$c',convert(date, getdate()))";
                                        odbc_exec($cn, $sql_insertExpenseHistory);
                                    }
                                    echo "<script>alert('SMS Posted Successfully');</script>";
                                } else {
                                    $sql_ROLLBACKTRANSACTION = " ROLLBACK TRANSACTION";
                                    odbc_exec($cn, $sql_ROLLBACKTRANSACTION);
                                    echo "<script>alert('Your Data is not uploaded properly,please try again.');</script>";
                                }


                                $sql_droptable = "DROP Table #$Usernumbertable ";
                                //odbc_exec($cn, $sql_droptable);

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

