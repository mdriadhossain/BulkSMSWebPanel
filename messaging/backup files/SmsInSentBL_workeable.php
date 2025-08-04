<?php

    error_reporting(E_ALL);

    $serverName = "localhost";
    $database = "BULKSMSGateway_1_0";
    $uid = 'sa';
    $pwd = 'bmWfjg88';

    try {
        $conn = new PDO("sqlsrv:server=$serverName;Database=$database",$uid,$pwd,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch(PDOException $e) {
        die("Error connecting to SQL Server: " . $e->getMessage());
    }


    //$query = "SELECT UserID, UserName FROM BULKSMSPanel.dbo.UserInfo";
    //$stmt = $conn->query( $query );

	$userDetail = "SELECT UserID, UserName FROM BULKSMSPanel.dbo.UserInfo";
	$result_userDetail = odbc_exec($cn, $userDetail);

?>
<?php
//$userDetail = "SELECT UserID, UserName FROM BULKSMSPanel.dbo.UserInfo";

//$PDOCN->query("SELECT UserID, UserName FROM BULKSMSPanel.dbo.UserInfo");

//$result_userDetail=$PDOCN->query($userDetail);

//$result_userDetail = odbc_exec($cn, $userDetail);



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
                    <h4>Messaging</h4>
					
					
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
                                          /*  
											while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
													$UserID= $row['UserID'] ;
													$UserName = $row['UserName'] ;
													echo "<option value='$UserName'>$UserName</option>";
												//echo '<br><br>';
											}
											
										*/

                                            ?>    
                                                
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
                                        while ($n = odbc_fetch_row($result_userDetail)) {
                                            $UserID = odbc_result($result_userDetail, "UserID");
                                            $UserName = odbc_result($result_userDetail, "UserName");
                                            echo "<option value='$UserID'>$UserName</option>";
                                        }
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
							
							<div>
   	<label for="chkPassport">
	Click on checkbox for Template Text SMS . 
    <input type="checkbox" id="chkPassport" />
    
   </label> 
   </div>


<div id="autoUpdate" class="autoUpdate">
                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">SMS Text</label>
                                <div class="col-sm-6">



                                    <textarea class="form-control" name="SMSText" id="SMSTextID" cols="100" rows="3" onKeyDown="limitText(this.form.SMSText,
                                                    this.form.countdown, 160);"onKeyUp="limitText(this.form.SMSText, this.form.countdown, 160);"></textarea>
                                    <font size="1">(Maximum characters: 160)<br>You have <input readonly type="text" name="countdown" size="3" value="160"> characters
                                    left.</font>
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
											echo $User;
											
											if($User =='Admin'){echo $TemplateText = "SELECT TemplateSMS FROM BULKSMSPanel.dbo.TemplateText ";
											
										}else{
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



                                    <textarea class="form-control" name="Recipients" id="Recipients" cols="100" rows="3" placeholder="Numbers should be  comma-separated values e.g.: 880191XXXXXXX, 880171XXXXXXX,880181XXXXXXX,880161XXXXXXX" ></textarea>
								
									
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
                var chkVal = mobileNumber.match(/^(?:\+?88)?0?1[15-9]\d{8}$/);
                //alert(chkVal);
                return chkVal;
            }
					
					</script>

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

				$('#chkPassport').change(function(){
    if($(this).is(":checked"))
    $('#autoUpdate').fadeOut('slow');
    else
    $('#autoUpdate').fadeIn('slow');

 });

</script>
					
					
                    <script language="JavaScript" type="text/javascript">


                        var frmvalidator = new Validator("SchedulePromotionID");
                        frmvalidator.addValidation("opt", "dontselect=0", "Please Select the Operator Name.");
                        frmvalidator.addValidation("ShortCodeID", "dontselect=0", "Please Select the Short Code.");
                        frmvalidator.addValidation("PromoListNameID", "req", "Select The promotional Name.");
                        frmvalidator.addValidation("start_date", "req", "Select The Sending Date.");
                        frmvalidator.addValidation("HourID", "req", "Select The Sending Hour.");
                        frmvalidator.addValidation("MinID", "req", "Write the Min.");
                        frmvalidator.addValidation("SMSTextID", "req", "SMS Text Can not be null.");
                    </script>
                    <?php
                    if ($_REQUEST['submit'] == "send") {
					
					 // $PDOCN=PDOConnectDB();
					
					
					
                        $SendFrom = $_REQUEST['ShortCodeNumber'];
                        $UName = $_REQUEST['opt'];
						$TemplateText = $_REQUEST['TemplateText'];
                        $Msg = $_REQUEST['SMSText'];
						if($TemplateText != '')
					   {
					   $Msg=$TemplateText;
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
                            popup('Your credit limit is over. Please talk to Solvers Tem to upgrade your credit limit. ', $url);
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
                            $SMSPermitQuery = 'DECLARE @returnValue INT;';
                            $SMSPermitQuery.='EXEC @returnValue=[BULKSMSPanel].[dbo].[PermitSMSProc]';
                            $SMSPermitQuery.="@UserName ='$UserName',";
                            $SMSPermitQuery.="@Password ='$Password',";
                            $SMSPermitQuery.="@RequestedIP='$RequestedIP',";
                            $SMSPermitQuery.="@SendFrom ='$SendFrom',";
                            $SMSPermitQuery.="@SendTo ='$SendTo',";
                            $SMSPermitQuery.="@InMSgID ='$InMSgID',";
                            $SMSPermitQuery.="@ScheduleTime ='$ScheduleTime',";
                            $SMSPermitQuery.="@msg =N'$Msg';";
                            $SMSPermitQuery.="select @returnValue as ReturnVal; ";
					 //echo $SMSPermitQuery="SELECT count(ID) as ReturnVal from BULKSMSPanel.dbo.[ExpenceHistory]"; //exit;
                            echo $SMSPermitQuery;
                              //  exit;
							  /*
								INSERT INTO [BULKSMSGateway_1_0].[dbo].[SMSOutbox] 
                               (srcMN, dstMN, msg, writeTime, sentTime, msgStatus, retrycount, srcTON, srcNPI, msgType, esm_Class, Data_Coding, smsPart, totalPart, refID, Schedule, srcAccount, destAccount, Remarks,ContentSubCategoryID,ServiceID,IN_MSG_ID)
						 VALUES(@SendFrom, @SendTo, @msg, getdate(),'', 'QUE', '3', '1','1', 'TEXT', '64', '1', '1', '1', '', @ScheduleTime, @UserName, @UserName, '','','',@InMSgID)
					
							   //$queryInsert = "INSERT INTO [tbl_BanglaText]([BanglaText]) VALUES (N'".$banglaText."')";  
							   
							   //echo $queryInsert = "INSERT INTO [BULKSMSGateway_1_0].[dbo].[SMSOutbox] ([msg])VALUES (N'".$Msg."') ";
							   */
							   /*--------------------------
							  echo  $queryInsert = "INSERT INTO [BULKSMSGateway_1_0].[dbo].[SMSOutbox] 
                               (srcMN, dstMN, msg, writeTime, sentTime, msgStatus, retrycount, Schedule, srcAccount, destAccount, Remarks,ContentSubCategoryID,ServiceID,IN_MSG_ID)
						 VALUES('$SendFrom', '$SendTo',N'".$Msg."', getdate(),'', 'QUE', '3', '$ScheduleTime', '$UserName', '$UserName', '','','','$InMSgID')";
							   
							   $stmtInsert = $conn->query( $queryInsert );
							   --------------------------*/
								
								$stmtInsert = $conn->query($SMSPermitQuery);
								
								
								$PermitReturnValArray = $stmtInsert->fetch(PDO::FETCH_ASSOC);		
                                //$result = odbc_exec($cn, $SMSPermitQuery);
                                //$PermitReturnValArray = odbc_fetch_array($result);
                                echo $PermitReturnVal = $PermitReturnValArray['ReturnVal'];
								
		echo "query executed successfully";exit;
								
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
                       
		
		                 if($UserCurrentSmsVal<201)
		                {
		                
			 	         $SelectEmailSql = "Select Email from [dbo].[UserInfo] WHERE UserName='$UserName' ";
                         $SelectEmailResult = odbc_exec($cn, $SelectEmailSql);
                         $UserEmailValue = odbc_fetch_array($SelectEmailResult);
                         $UserEmail = $UserEmailValue[Email];
		
		
		                //$file = file_get_contents("http://solversbd.com/email/PHPMailer/examples/test_smtp_basic.php?email=$UserEmail&mgs=welcome", FILE_USE_INCLUDE_PATH);
						
						//$file = file_get_contents("http://45.64.135.90/PHPMailer/examples/test_smtp_basic_low_balance.php?sub=SMS credit below 100&uname=$UserName&Email=$UserEmail", FILE_USE_INCLUDE_PATH);
						
								
							   $MailURL = get_mail_server_url()."test_smtp_basic_low_balance.php?sub=SMS credit below 100&uname=$UserName&Email=$UserEmail";
	

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
                                        <p>Successfully Posted SMS: <span class="badge"><?php echo $ValidNumCounter; ?></span></p><br/>
                                    <?php if ($ValidNumCounter > 0) {
                                        ?>
                                        <a class="btn btn-success btn-sm"href="<?php echo base_url() . 'index.php?parent=RealTimeSMSLogReport'; ?>">click here for detail</a>
                                            <?php }
                                    ?>
                                </div>
                        <?php if ($InValidNumCounter > 0) {
                            ?>
                            <div class="alert alert-warning" role="alert">
                                            <p>Total Error Found: <span class="badge"><?php echo $InValidNumCounter; ?></span></p><br/>
                                        
                                                            <a class="btn btn-danger btn-sm"href="<?php echo base_url() . 'index.php?parent=ViewError'; ?>">click here for error detail</a>
                                                

                                                </div>
                                    <?php }
                                    ?>
                                    <?php if ($InValidMsisdn > 0) {
                                        ?>
                                        <div class="alert alert-danger" role="alert">
                                    <p>Total Invalid Number Found: <span class="badge"><?php echo $InValidMsisdn; ?></span></p><br/>

                                            <a class="btn btn-danger btn-sm"href="<?php echo base_url() . 'index.php?parent=ViewError'; ?>">click here for error detail</a>
                                        
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

