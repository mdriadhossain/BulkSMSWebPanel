<?php
ob_start();
require_once "Config/config.php";
require_once "Lib/lib.php";


$cn = ConnectDB();
?>

<?php
$userDetail = "SELECT UserID, UserName FROM BULKSMSPanel.dbo.UserInfo where Username<>'admin' Order By UserName ASC";
$result_userDetail = odbc_exec($cn, $userDetail);

$PurchaseFromAccountQuery = "select Username as AccName,CurrentNoOfSMS,Description from [BULKSMSPanel].[dbo].[MainAccount]";
$result_PurchaseFromAccount = odbc_exec($cn, $PurchaseFromAccountQuery);
?>

<div id="page-content">
    <div id='wrap'>

        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>Transaction History</h4>
                </div>
                <div class="panel-body">


                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->

                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" id="UserInfoID" name="TransactionHistory">

                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">User Name</label>
                                <div class="col-sm-6">

                                    <select class="form-control" name="UserName" id="UserName">
                                        <option value=''>Select User</option>
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

                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Purchase From</label>
                                <div class="col-sm-6">

                                    <select class="form-control" name="PurchaseFromAccount" id="PurchaseFromAccount">
                                        <option value=''>Select Purchase From Account</option>
                                        <?php
                                        while ($n = odbc_fetch_row($result_PurchaseFromAccount)) {
                                            $AccName = odbc_result($result_PurchaseFromAccount, "AccName");
                                            $CurrentNoOfSMSAvailable = odbc_result($result_PurchaseFromAccount, "CurrentNoOfSMS");
                                            $MaskDescription = odbc_result($result_PurchaseFromAccount, "Description");
                                            echo "<option value='$AccName'>" . $AccName . "|" . $CurrentNoOfSMSAvailable . "|".$MaskDescription."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Per SMS Rate:</label>
                                <div class="col-sm-6">                                    
                                    <select name="PerSMSRate" id="PerSMSRate" onselect="calculate()" >
                                    <option value="">Please Select Price</option>
                                        <option value=".30">0.30</option>
                                        <option value=".32">0.32</option>
                                        <option value=".35">0.35</option>
                                        <option value=".40">0.40</option>
                                        <option value=".45">0.45</option>
                                        <option value=".55">0.55</option>
                                        <option value=".60">0.60</option>
                                    </select>
                                    
<!--                                   <input class="form-control" name="PerSMSRate" type="text" id="PerSMSRate" oninput="calculate()" >                                    -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Number of SMS:</label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="NumberOfSMS" type="text" id="NumberOfSMS" oninput="calculate()" >
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Total Amount:</label>
                                <div class="col-sm-6">                                                                                                                                                                         
                                     <input type="text" name="Amount" id="Amount" readonly />
                                </div>
                            </div>               
                            
                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Transaction Type</label>
                                <div class="col-sm-6">

                                    <select class="form-control" name="TransactionType" >

                                        <option value="Credit" selected="selected">Credit</option>
                                        <option value="Debit">Debit</option>
                                    </select>
                                </div>
                            </div>                           


                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Add Validity Days (like:365):</label>
                                <div class="col-sm-6">

                                    <input class="form-control" name="validitydate" type="text" id="validitydate" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label"></label>
                                <div class="col-sm-6">

                                    <input onClick="return confirm('Do You Really Want To Do The Transaction?')" class="btn btn-primary" name="Save"  type="submit" id="Save"  value="Save">

                                </div>
                            </div>
                        </form>


                        <script language="JavaScript" type="text/javascript">

                                        function calculate() {
                                                var myBox1 = document.getElementById('PerSMSRate').value;	
                                                var myBox2 = document.getElementById('NumberOfSMS').value;
                                                var result = document.getElementById('result');	
                                                var myResult = myBox1 * myBox2;
                                                Amount.value = myResult;      		
                                            }
                           
                            
                            var frmvalidator = new Validator("TransactionHistory");
                            frmvalidator.addValidation("UserName", "dontselect=0", "Please Select the user name.");                        
                            frmvalidator.addValidation("PurchaseFromAccount", "dontselect=0", "Please Select Purchage Form Account.");
                            frmvalidator.addValidation("NumberOfSMS", "req", "Please Type Number of SMS.");                            
                            frmvalidator.addValidation("PerSMSRate", "req", "Please Type Per SMS Rate.");
                            frmvalidator.addValidation("validitydate", "req", "Please Type validitydate.");
                            //frmvalidator.addValidation("end_date", "req", "Select The End Date.");</script>
                    </div>

                    <?php
                    if ($_REQUEST['Save'] == 'Save') {
                        $UserName = $_REQUEST['UserName'];                        
                        $PurchaseFromAccount = $_REQUEST['PurchaseFromAccount'];                        
                        $NumberOfSMS = $_REQUEST['NumberOfSMS'];
                        $TransactionType = $_REQUEST['TransactionType'];
                        $PerSMSRate = $_REQUEST['PerSMSRate'];
                        $Amount = $_REQUEST['Amount'];
                        $validitydate = $_REQUEST['validitydate'];



                        $insertquery = "INSERT INTO TransactionHistory (UserName, NumberOfSMS,TransactionType, PerSMSRate, Amount,FromMainAccount) VALUES ('$UserName', '$NumberOfSMS', '$TransactionType', '$PerSMSRate','$Amount','$PurchaseFromAccount')";

                        $rs = odbc_exec($cn, $insertquery);

                        $insertqueryadmin = "INSERT INTO TransactionHistory (UserName, NumberOfSMS,TransactionType, PerSMSRate, Amount,FromMainAccount) VALUES ('admin', '$NumberOfSMS', 'Debit', 'NULL','NULL','$PurchaseFromAccount')";

                        $rs = odbc_exec($cn, $insertqueryadmin);

                        $AccountValSql = "Select CurrentNoOfSMS from MainAccount where username='$PurchaseFromAccount'";
                        $AccountValResult = odbc_exec($cn, $AccountValSql);
                        $AccountValue = odbc_fetch_array($AccountValResult);
                        $UserCurrentSmsVal = $AccountValue[CurrentNoOfSMS];
                        $TotalNumberOfSmsVal = $UserCurrentSmsVal - $NumberOfSMS;

                        $UpdateMainAccountQuery = "UPDATE MainAccount set CurrentNoOfSMS = $TotalNumberOfSmsVal  where username='$PurchaseFromAccount' ";
                        odbc_exec($cn, $UpdateMainAccountQuery);

                        $UserAccountValSql = "Select NumberOfSMS,ValidityDate from CurrentStatus where UserName = '$UserName'";
                        $ValidityDateSql = "SELECT DATEADD(day, $validitydate, ValidityDate) AS ValidityDate FROM CurrentStatus where UserName = '$UserName'";
                        $ValidityDateResult = odbc_exec($cn, $ValidityDateSql);
                        $ValidityDateAccountValue = odbc_fetch_array($ValidityDateResult);
                        $CurrentValidityDate = $ValidityDateAccountValue[ValidityDate];
                        $UserAccountValResult = odbc_exec($cn, $UserAccountValSql);
                        $UserAccountValue = odbc_fetch_array($UserAccountValResult);
                        $UsersCurrentSmsVal = $UserAccountValue[NumberOfSMS];

                        $SelectEmailSql = "Select Email from [dbo].[UserInfo] WHERE UserName='$UserName' ";
                        $SelectEmailResult = odbc_exec($cn, $SelectEmailSql);
                        $UserEmailValue = odbc_fetch_array($SelectEmailResult);
                        $UserEmail = $UserEmailValue[Email];


                        if (($UsersCurrentSmsVal == "") || ($UsersCurrentSmsVal == "NULL")) {
                            $InsertCurrentStatusQuery = "Insert INTO CurrentStatus (UserName,NumberOfSMS,IsActive,ValidityDate) VALUES ('$UserName',$NumberOfSMS,1,DATEADD(day, $validitydate, convert(date,getdate())))";
                            $rsval = odbc_exec($cn, $InsertCurrentStatusQuery);
                        } else {
                            $TestTotalNumberOfSmsVal = $UsersCurrentSmsVal + $NumberOfSMS;
                            $UpdateCurrentStatusQuery = "UPDATE CurrentStatus set NumberOfSMS = $TestTotalNumberOfSmsVal,ValidityDate = '$CurrentValidityDate' WHERE UserName = '$UserName'";
                            $rsval = odbc_exec($cn, $UpdateCurrentStatusQuery);
                        }
                        $r = odbc_num_rows($rsval);
                        if ($r > 0) {
                            MsgBox('Transaction Completed Successfully.');

                            //$m = "Dear%20Sir,%0A%20$NumberOfSMS%20SMS%0Asuccessfully%0D%0Aadded\nto\nyour%20\naccount\ntest1\ntest2\n\n\n\ntest3";
                            //$m = str_replace("\n", "%0D", $m);

                            /* $m=urlencode('Welcome, 
                              Transaction
                              Completed Successfully
                              %0AThanks'); */
                            // $m=urlencode('$m');
                            // echo $UserEmail;
                            // echo $a = "http://solversbd.com/email/PHPMailer/examples/test_smtp_basic.php?email=$UserEmail&mgs=$m";
                            //exit;
                            //$UserEmail
                            //echo $m = "http://45.64.135.90/PHPMailer/examples/test_smtp_basic_th.php?email=$UserEmail&NumberOfSMS=$NumberOfSMS";
                            //  $file = file_get_contents('http://solversbd.com/email/PHPMailer/examples/test_smtp_basic.php?email=$UserEmail&mgs=welcome', FILE_USE_INCLUDE_PATH);
                           //$file = file_get_contents("http://45.64.135.90/PHPMailer/examples/test_smtp_basic_th.php?sub=transaction history&email=$UserEmail&NumberOfSMS=$NumberOfSMS", FILE_USE_INCLUDE_PATH);
							
							   $MailURL = "http://45.64.135.90/PHPMailer/examples/test_smtp_basic_th.php?sub=transaction history&email=$UserEmail&NumberOfSMS=$NumberOfSMS";
	

    $MainMailURL = str_replace(" ", "+", $MailURL);
    
	//echo $ChargingInterfaceURL;exit;
	
	$ChargingURLResponce = file_get_contents($MainMailURL);
	
	
                            //header("Location: index.php?parent=TransactionHistory");
                        } else {
                            MsgBox('Sorry!!! Transaction Not Completed Properly.Please Try again.');
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div> <!-- row -->
</div> <!-- container -->
</div> <!-- page-content -->

</div> <!-- wrap -->

</div> <!-- page-content -->
