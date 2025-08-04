<?php
require_once "Config/config.php";
require_once "Lib/lib.php";
$cn = ConnectDB();
?>

<script type="text/JavaScript">
    function confirmDelete(){
    var agree=confirm("Are you sure you want to delete this entry?");
    if (agree)
    {
    return true ;
    }
    else
    {
    return false ;
    }
    }
</script>

<?php
 $userDetail = "SELECT UserID, UserName FROM BULKSMSPanel.dbo.UserInfo where Username<>'admin' Order By UserName ASC";
$result_userDetail = odbc_exec($cn, $userDetail);
?>

<link rel="stylesheet" href="bootstrap-select/dist/css/bootstrap-select.css">
<script type="text/javascript" src="bootstrap-select/dist/js/bootstrap-select.js"></script>

<div id="page-content">
    <div id='wrap'>



        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>Show User Info</h4>
                </div>
                <div class="panel-body">


                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->

                        <form class="form-horizontal"id="role" name="role" method="post" action="" onSubmit="return validateRoleInfo();">


                             <?php
                            if ($User == 'Admin' || $User == 'admin') {
                                ?>

                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label">User Name</label>
                                    <div class="col-sm-6">

                                        <select class="form-control selectpicker"  data-live-search="true" name="UserName" id="UserName">
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

                                <?php
                            } else {
                                ?>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label">User Name</label>
                                    <div class="col-sm-6">

                                        <select class="form-control selectpicker"  data-live-search="true" name="UserName" id="UserName">
                                            <option value=''>Select User</option>
                                            <option value='<?php echo $User; ?>'><?php echo $User; ?></option>

                                        </select>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>  
                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label"></label>
                                <div class="col-sm-6">
                                    <input name="Save" class="btn btn-primary" type="submit" id="Save" value="Show">
                                </div>
                            </div>
                        </form>
                    </div>
                    <script language="JavaScript" type="text/javascript">
                        var frmvalidator = new Validator("role");
                        frmvalidator.addValidation("RoleId", "req", "Please Select RoleId.");
                        frmvalidator.addValidation("RoleName", "req", "Please select RoleName.");
                    </script>

                </div>

                <div class="panel-body">


                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->


                        <?PHP
                        if ($_REQUEST['Save'] == 'Show') {
                            $UserId = $_REQUEST['UserId'];
                            $check = $_REQUEST['chkAll'];
							$UserName = $_REQUEST['UserName'];
							
                           if ($User == 'Admin' and $UserName =="" and $UserName ==null) { 
						    $showUser = "select UserID,IsSubscribed,UserName,Password,MobileNo,CompanyName,CreateDate,HeaderText,Email from UserInfo where UserName<>'admin' Order By UserName ASC";

                                //$showUser1 = "select MaskingID from MaskingDetail where UserName<>'admin'";
                            } 
							
							else {

							$showUser = "select UserID,IsSubscribed,UserName,Password,MobileNo,CompanyName,CreateDate,HeaderText,Email from UserInfo where UserName='$UserName' Order By UserName ASC";

                                //$showUser1 = "select MaskingID from MaskingDetail where UserName<>'admin'";
                            }

                            $InMsgID = $MobileNo . date('YmdHis') . rand(1, 99);
                            $Message = "This+is+a+Test+Message+from+Sender";
                            $result_showUser = odbc_exec($cn, $showUser);
                            ?>

                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables">
                                <thead>
                                    <tr role="row">
                                        <th>UserID</th>
                                        <th>UserName</th>
                                        <th>Password</th>
										
										<?php 
                                         if (($User == 'Admin')){
                                             ?>
										
                                        <th>Base 64 Encoded String</th>
										
										<?php  } ?> 
										
                                        <th>CompanyName</th>
                                        <th>MobileNo</th>
                                        <th>Email</th>
                                        <th>CreateDate</th>
										<?php 
                                         if (($User == 'Admin')){
                                             ?>
                                        <th>Header Text</th>
										<?php  } ?> 
										
										<?php 
                                         if (($User == 'Admin' || $User == 'admin')){
                                             ?>
                                        <th>API Link</th>
											<?php  } ?> 
										                                       
 
										
                                        <th>EDIT</th>
										 <?php if (($User == 'Admin'))
                {
                                                ?>
                                        <th>DELETE</th>
										<?php  } ?> 

                                    </tr>
                                </thead>

                                <?php
                                while ($row = odbc_fetch_row($result_showUser)) {
                                    ?>
                                    <tr>
                                        <td><?php echo odbc_result($result_showUser, "UserID"); ?> </td>
                                        <td><?php echo $SMSUserName = odbc_result($result_showUser, "UserName"); ?></td>
                                        <td><?php echo $SMSUserPassword = odbc_result($result_showUser, "Password"); ?></td>
                                                               
																		 <?php if (($User == 'Admin'))
                {
                                                ?>
										
										<td><?php $userString = $SMSUserName . '|' . $SMSUserPassword;
                            echo $AuthToken = base64_encode($userString); ?></td>
							
							 <?php    } ?>
							
                                        <td><?php echo odbc_result($result_showUser, "CompanyName"); ?></td>
                                        <td><?php echo odbc_result($result_showUser, "MobileNo"); ?></td>
                                          <td><?php echo odbc_result($result_showUser, "Email"); ?></td>
                                        <td><?php echo odbc_result($result_showUser, "CreateDate"); ?></td>
										 <?php if (($User == 'Admin'))
                {
                                                ?>
                                        <td><?php echo odbc_result($result_showUser, "HeaderText"); ?></td>
											<?php  } ?> 
                                         <?php        if (($User == 'Admin' || $User == 'admin')){
                                                ?>
                                        <td><a href="#" onClick='NewWindow("UserRole/BulkSMSAPILink.php?UserID=<?php echo odbc_result($result_showUser, "UserID"); ?>", "name", "800", "200", "no");
                                                            return false;'><button type="button" class="btn btn-success btn-sm">Show API Link</button></a></td>
                                       
                
																		
                                       <?php  } ?> 
									   
									   <td><a href="UserRole/edit_UserInfo.php?id=<?php echo odbc_result($result_showUser, "UserID") ?>&user=<?php echo odbc_result($result_showUser, "UserName"); ?>&pass=<?php echo odbc_result($result_showUser, "Password"); ?>&company=<?php echo odbc_result($result_showUser, "CompanyName"); ?>&mobile=<?php echo odbc_result($result_showUser, "MobileNo"); ?>&email=<?php echo odbc_result($result_showUser, "Email"); ?>&CreateDate=<?php echo odbc_result($result_showUser, "CreateDate"); ?>&IsSubscribed=<?php echo odbc_result($result_showUser, "IsSubscribed"); ?>&HeaderText=<?php echo odbc_result($result_showUser, "HeaderText"); ?>"><button type="button" class="btn btn-success">Update Profile </button></a></font></b></td>									
                                         <?php if (($User == 'Admin'))
                {
                                                ?>
										<td><a href="UserRole/deleteUser.php?id=<?php echo odbc_result($result_showUser, "UserID") ?>" onClick="return confirmDelete();"><button type="button" class="btn btn-danger">Delete</button></a></td>
                                     <?php    } ?>
									</tr>

                                    <?php
                                }

                                echo "</table>";
                            }
                            ?>

                    </div>

                </div>
            </div>
        </div>
    </div> <!-- row -->
</div> <!-- container -->
</div> <!-- page-content -->

</div> <!-- wrap -->

</div> <!-- page-content -->
