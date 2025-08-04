<?php
ob_start();
require_once "Config/config.php";
require_once "Lib/lib.php";


$cn = ConnectDB();
?>

<?php
$userDetail = "SELECT UserID, UserName FROM BULKSMSPanel.dbo.UserInfo where Username<>'admin'";
$result_userDetail = odbc_exec($cn, $userDetail);
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
                                <label for="focusedinput" class="col-sm-3 control-label">Number of SMS:</label>
                                <div class="col-sm-6">

                                    <input class="form-control" name="NumberOfSMS" type="text" id="NumberOfSMS" >
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
                                <label for="focusedinput" class="col-sm-3 control-label">Per SMS Rate:</label>
                                <div class="col-sm-6">

                                   <select name="PerSMSRate" id="PerSMSRate">
                                        
                                        <option selected="selected">please select price</option>
                                         <option value=".35">.35</option>
                                        <option value=".38">.38</option>
                                        <option value=".40">.40</option>
                                        
                                    </select>
                                </div>
                            </div>
                            
                            
                            
                            
                            
                            

                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Total Amount:</label>
                                <div class="col-sm-6">
                                    <input type="text" name="Amount" id="Amount" onClick="checkPrice()" readonly>
                                    <script type="text/JavaScript">
<!--                                     $("#PerSMSRate,#NumberOfSMS").keyup(function () {

                                        $('#Amount').val($('#NumberOfSMS').val() * $('#PerSMSRate').val());

                                        });-->
                                                
                                       var select = document.getElementById('PerSMSRate');
                                       var input = document.getElementById('Amount');
                                       select.onchange = function() {
                                       input.value = select.value;
                                       }

                                    </script>


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

                                    <input onClick="return confirm('Do you really want Transaction?')" class="btn btn-primary" name="Save"  type="submit" id="Save"  value="Save">

                                </div>
                            </div>
                        </form>
                        
                        
                        <script language="JavaScript" type="text/javascript">
                            
                            
                            var select = document.getElementById('PerSMSRate');
                            var sms = document.getElementById('NumberOfSMS');
                            var input = document.getElementById('Amount');
                            select.onchange = function() {
                            input.value = select.value * sms.value;
                            }
                            var frmvalidator = new Validator("TransactionHistory");

                            frmvalidator.addValidation("NumberOfSMS", "req", "Please Type Number of SMS.");
                            //frmvalidator.addValidation("Status", "dontselect=0", "Please Select Status.");
                            frmvalidator.addValidation("PerSMSRate", "req", "Please Type Per SMS Rate.");
                            frmvalidator.addValidation("validitydate", "req", "Please Type validitydate.");
                            //frmvalidator.addValidation("end_date", "req", "Select The End Date.");</script>
                    </div>

                    <?php
                    if ($_REQUEST['Save'] == 'Save') {
                        $UserName = $_REQUEST['UserName'];
                        $NumberOfSMS = $_REQUEST['NumberOfSMS'];
                        $TransactionType = $_REQUEST['TransactionType'];
                        $PerSMSRate = $_REQUEST['PerSMSRate'];
                        $Amount = $_REQUEST['Amount'];
                        $validitydate = $_REQUEST['validitydate'];
						
						
							
                        $insertquery = "INSERT INTO TransactionHistory (UserName, NumberOfSMS,TransactionType, PerSMSRate, Amount) VALUES ('$UserName', '$NumberOfSMS', '$TransactionType', '$PerSMSRate','$Amount')";

                        $rs = odbc_exec($cn, $insertquery);

                        $insertqueryadmin = "INSERT INTO TransactionHistory (UserName, NumberOfSMS,TransactionType, PerSMSRate, Amount) VALUES ('admin', '$NumberOfSMS', 'Debit', 'NULL','NULL')";

                        $rs = odbc_exec($cn, $insertqueryadmin);

                        $AccountValSql = "Select CurrentNoOfSMS from MainAccount";
                        $AccountValResult = odbc_exec($cn, $AccountValSql);
                        $AccountValue = odbc_fetch_array($AccountValResult);
                        $UserCurrentSmsVal = $AccountValue[CurrentNoOfSMS];
                        $TotalNumberOfSmsVal = $UserCurrentSmsVal - $NumberOfSMS;

                        $UpdateMainAccountQuery = "UPDATE MainAccount set CurrentNoOfSMS = $TotalNumberOfSmsVal";
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
						
						
						if (($UsersCurrentSmsVal== "")||($UsersCurrentSmsVal== "NULL")) 
						{
						    $InsertCurrentStatusQuery = "Insert INTO CurrentStatus (UserName,NumberOfSMS,IsActive,ValidityDate) VALUES ('$UserName',$NumberOfSMS,1,DATEADD(day, $validitydate, convert(date,getdate())))";
                            $rsval=odbc_exec($cn, $InsertCurrentStatusQuery);						
						}
						else {
                            $TestTotalNumberOfSmsVal = $UsersCurrentSmsVal + $NumberOfSMS;
                            $UpdateCurrentStatusQuery = "UPDATE CurrentStatus set NumberOfSMS = $TestTotalNumberOfSmsVal,ValidityDate = '$CurrentValidityDate' WHERE UserName = '$UserName'";
                            $rsval=odbc_exec($cn, $UpdateCurrentStatusQuery);
                        }
						$r = odbc_num_rows($rsval);
						if($r>0){
						   MsgBox('Transaction Completed Successfully.');
						   
						   $m = "Dear%20Sir,%0A%20$NumberOfSMS%20SMS%0Asuccessfully%0D%0Aadded\nto\nyour%20\naccount\ntest1\ntest2\n\n\n\ntest3";
						    $m = str_replace("\n","%0D", $m);
						
						  /* $m=urlencode('Welcome, 
						   Transaction 
						   Completed Successfully
						   %0AThanks');*/
						  // $m=urlencode('$m');
						
						  // echo $UserEmail;
						 // echo $a = "http://solversbd.com/email/PHPMailer/examples/test_smtp_basic.php?email=$UserEmail&mgs=$m";
						  //exit;
                        //$UserEmail
						//$m = str_replace("\n","%0A",$m);
				     //  $file = file_get_contents('http://solversbd.com/email/PHPMailer/examples/test_smtp_basic.php?email=$UserEmail&mgs=welcome', FILE_USE_INCLUDE_PATH);
					   $file = file_get_contents("http://solversbd.com/email/PHPMailer/examples/test_smtp_basic.php?email=$UserEmail&mgs=$m&NumberOfSMS=$NumberOfSMS", FILE_USE_INCLUDE_PATH);
						   //header("Location: index.php?parent=TransactionHistory");
						}else{
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
