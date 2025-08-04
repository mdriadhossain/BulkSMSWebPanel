<?php

    //$cn = ConnectDB();
//$cn = ConnectDB();




$userDetail = "SELECT UserID, UserName FROM BULKSMSPanel.dbo.UserInfo where Username<>'admin'";
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
                    <h4>Schedule Messaging</h4>
                </div>
                <div class="panel-body">


                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->





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


                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Schedule SMS List Name:</label>
                                <div class="col-sm-6">



                                    <select name="PromoListName" id="PromoListNameID"  class="form-control selectpicker"  data-live-search="true">
                                        <option value=''>Select List</option>
                                        <?php
										if($User =='admin'){$userDetail = "select distinct(PromoListName) as 'PromoListName' from [BULKSMSPanel].dbo.PromoList order by PromoListName asc";
										}else{
										$userDetail = "select distinct(PromoListName) as 'PromoListName' from [BULKSMSPanel].dbo.PromoList where UpdateBy='$User'";
										}
                                        
                                        $result_userDetail = odbc_exec($cn, $userDetail);
                                        while ($n = odbc_fetch_row($result_userDetail)) {
                                            $PromoListName = odbc_result($result_userDetail, "PromoListName");
                                            echo "<option value='$PromoListName'>$PromoListName</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Select Date:</label>
                                <div class='col-sm-6'>
                                    <div class="form-group">
                                        <div class='input-group date' id='datetimepicker1'>
                                            <input type='text' class="form-control" name="start_date" id="start_date"/>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"><i class="fa fa-calendar"></i></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <script type="text/javascript">
                                    $(function () {
                                        $('#datetimepicker1').datepicker({
                                            format: 'yyyy-mm-dd',
                                            stDate: '-3d'

                                        });

                                    });
                                </script>
                            </div>


                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Hour</label>
                                <div class="col-sm-6">



                                    <select name="Hour" id="HourID"  class="form-control">
                                        <option value="00">00</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                        <option value="21">21</option>
                                        <option value="22">22</option>
                                        <option value="23">23</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Min</label>
                                <div class="col-sm-6">



                                    <select name="Min" id="MinID"  class="form-control">
                                        <option value="00">00</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                        <option value="21">21</option>
                                        <option value="22">22</option>
                                        <option value="23">23</option>
                                        <option value="24">24</option>
                                        <option value="25">25</option>
                                        <option value="26">26</option>
                                        <option value="27">27</option>
                                        <option value="28">28</option>
                                        <option value="29">29</option>
                                        <option value="30">30</option>
                                        <option value="31">31</option>
                                        <option value="32">32</option>
                                        <option value="33">33</option>
                                        <option value="34">34</option>
                                        <option value="35">35</option>
                                        <option value="36">36</option>
                                        <option value="37">37</option>
                                        <option value="38">38</option>
                                        <option value="39">39</option>
                                        <option value="40">40</option>
                                        <option value="41">41</option>
                                        <option value="42">42</option>
                                        <option value="43">43</option>
                                        <option value="44">44</option>
                                        <option value="45">45</option>
                                        <option value="46">46</option>
                                        <option value="47">47</option>
                                        <option value="48">48</option>
                                        <option value="49">49</option>
                                        <option value="50">50</option>
                                        <option value="40">51</option>
                                        <option value="41">52</option>
                                        <option value="42">53</option>
                                        <option value="43">54</option>
                                        <option value="44">55</option>
                                        <option value="45">56</option>
                                        <option value="46">57</option>
                                        <option value="47">58</option>
                                        <option value="48">59</option>



                                    </select>
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



                                    <textarea class="form-control" name="SMSText" id="SMSTextID" cols="100" rows="3" onKeyDown="limitText(this.form.SMSText, this.form.countdown, 160);"onKeyUp="limitText(this.form.SMSText, this.form.countdown, 160);"></textarea>
                                    <font size="1">(Maximum characters: 160)<br>You have <input readonly type="text" name="countdown" size="3" value="160"> characters left.</font>
                                 <br>Please don't send SMS in Bangla</br>
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
                                <label for="focusedinput" class="col-sm-3 control-label"></label>
                                <div class="col-sm-6">






                                    <input name="Save" onClick="return confirm('Do you Really want to SEND this information?')"  class="btn btn-primary" type="submit" id="Save"  value="Save">


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
                    if ($_REQUEST['Save'] == 'Save') {
                        $Uname = $_REQUEST['opt'];
                        
                         $SendFrom = $_REQUEST['ShortCodeNumber'];
                        $PromoName = $_REQUEST['PromoListName'];
                        $ServiceID = "promo_" . $PromoName . "_" . $SendFrom;

                        $stDate = $_REQUEST['start_date'];
                       $Hour = $_REQUEST['Hour'];
                       $Min = $_REQUEST['Min'];
                       
						 $ScheduleTime = $stDate . " " . $Hour . ":" . $Min . ":000";
						//echo $ContentSendingTime = $stDate . " " . $Hour . ":" . $Min . ":00";

                        $TemplateText = $_REQUEST['TemplateText'];
                        $Msg = $_REQUEST['SMSText'];
						if($TemplateText != '')
					   {
					   $Msg=$TemplateText;
					   }
						//echo "test2";
                        $User = strtoupper($_SESSION['User']);
                        //$ckUser = ckUserExist($PromoName, $Operator, $cn);
						
						$sql_requestingip = "select RequestingIP from BULKSMSPanel.[dbo].[MaskingDetail] where MaskingID='$SendFrom'";
                        $result_requestingip = odbc_exec($cn, $sql_requestingip);
                        $row = odbc_fetch_array($result_requestingip);
                        
                         $RequestedIP = $row['RequestingIP'];
						
						 $sql_userInfo = "select UserName,Password from BULKSMSPanel.[dbo].[UserInfo] where UserName='$Uname'";
                        $result_userInfo = odbc_exec($cn, $sql_userInfo);
                        $row = odbc_fetch_array($result_userInfo);
						
                         $UserName = $row['UserName'];
						
                         $Password = $row['Password'];
						$string = $username . "|" . $password;
                        $AuthToken = base64_encode($string);
						
						
						
						
						
						
						$ScheduleNumbers=array();
						  $sql_schedulednumber = "select MSISDN,PromoListName from BULKSMSPanel.[dbo].[PromoList] where PromoListName='$PromoName' ";
                        $result_schedulednumber = odbc_exec($cn, $sql_schedulednumber);
                        //$row = odbc_fetch_array($result_schedulednumber);
						//echo $a = $row[MSISDN];
						 while ($row = odbc_fetch_array($result_schedulednumber)) {
                                            //echo $a = $row[MSISDN];
											//echo $MSISDN[]=$a;
											 $ScheduleNumbers[]=$row[MSISDN];
											
										   //echo $dataexplodecount =$dataexplodecount+1;
										   
											//print_r($a);
                                        }
										//print_r($ScheduleNumbers);
										//exit;
										 $dataexplodecount = count($ScheduleNumbers);
										
										//print_r($a);
										
						
						                /*$result_userDetail = odbc_exec($cn, $userDetail);
                                        while ($n = odbc_fetch_row($result_userDetail)) {
                                            $PromoListName = odbc_result($result_userDetail, "PromoListName");
                                            echo "<option value='$PromoListName'>$PromoListName</option>";
                                        }
*/
						
						
						 $MSISDN[] = $row['MSISDN'];
						// print_r($MSISDN);
						
                         $PromoListName= $row['PromoListName'];
						
						
						
						
					
						
						
						

                       $PromoDetail = "INSERT into [BULKSMSPanel].[dbo].[PromotionalDetail](PromoName,PromoText,PromoID,SendingTime,SendBy)values('$PromoName', N'".$Msg."','$ServiceID','$ScheduleTime','$User')";
					// echo $PromoDetail = "INSERT into [BULKSMSPanel].[dbo].[PromotionalDetail](PromoName,PromoID,SendBy)values('$PromoName','$ServiceID','$User')";
					 //echo $PromoDetail = "INSERT into [BULKSMSPanel].[dbo].[PromotionalDetail](PromoName,PromoText,PromoID,SendingTime,SendBy)values('$PromoName','$Msg','$ServiceID','$ScheduleTime','$User')";
					          
                        odbc_exec($cn, $PromoDetail);
                            /* $url = base_url() . "index.php?parent=SchedulePromotion";
        popup('Schedule Cretaed Successfully.', $url);*/
	                 // exit;
						 $Uname ;
					
						 $sql_UserAccountStatus = "select NumberOfSMS from BULKSMSPanel.[dbo].[CurrentStatus] where UserName='$Uname'";
                        $result_UserAccountStatus = odbc_exec($cn, $sql_UserAccountStatus);
                      
					    $row_UserAccount = odbc_fetch_array($result_UserAccountStatus);
                       
					    $row_UserAccount = $row_UserAccount['NumberOfSMS'];
					   
//echo $dataexplodecount; 

					  
                        if ($dataexplodecount > $row_UserAccount) {

                            //echo "Your Limit is Over.";

                            $url = base_url() . "index.php?parent=SchedulePromotion";
                            popup('Your credit limit is over. Please talk to Solvers Team to upgrade your credit limit. ', $url);
                            exit;
                        }
                        
						
						
						
						            //$arr = array();
                        $ValidNumCounterArr = array();
                        $InValidNumCounterArr = array();
                        $ValidNumCounter = 0;
                        $InValidNumCounter = 0;
                        $InValidMsisdn = 0;
						
						   foreach ($ScheduleNumbers as $SendTo) {







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
                            $SMSPermitQuery.="@msg ='$Msg';";
                            $SMSPermitQuery.="select @returnValue as ReturnVal; ";
            //echo $SMSPermitQuery="SELECT count(ID) as ReturnVal from BULKSMSPanel.dbo.[ExpenceHistory]"; //exit;
                            //echo $SMSPermitQuery;
                                //exit;

                                $result = odbc_exec($cn, $SMSPermitQuery);
                                $PermitReturnValArray = odbc_fetch_array($result);
                                
								 $PermitReturnVal = $PermitReturnValArray['ReturnVal'];
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
                        }
						
						
						
						
						
						/*
						 echo $PromoDetail = "INSERT into [BULKSMSPanel].[dbo].[PromotionalDetail](PromoName,PromoText,PromoID,SendingTime,SendBy)values('$PromoName','$Msg','$ServiceID','$ScheduleTime','$User')";
					        
                        odbc_exec($cn, $PromoDetail);*/
                             /*$url = base_url() . "index.php?parent=SchedulePromotion";
        popup('Schedule Cretaed Successfully.', $url);*/
						
						
						
						
                        //echo $PromoDetail."<br/>";
                        /*odbc_exec($cn, $PromoDetail);
                             $url = base_url() . "index.php?parent=SchedulePromotion";*/
        popup('Schedule Cretaed Successfully.', $url);

   
   
   
                    }

                    
                    ?>
					
					
					
					
					
					
					
					
					
                </div>


            </div>
        </div>
    </div> <!-- row -->
</div> <!-- container -->

