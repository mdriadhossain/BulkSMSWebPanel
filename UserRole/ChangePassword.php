<?php
require_once 'Config/config.php';
require_once 'Lib/lib.php';

?>

<div id="page-content">
    <div id='wrap'>
        <div class="container">
            <div class="panel panel-sky">
                <div class="panel-heading">
                    <h4>Change Password</h4>
                </div>
                <div class="panel-body">
                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->
                        <form class="form-horizontal" action="" method="post"  enctype="multipart/form-data" name="changepassword" id="changepassword">
                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Previous Password:</label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="PreviousPassword" type="text" id="PreviousPassword">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">New Password:</label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="NewPassword" type="password" id="NewPassword" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Re-Type New Password:</label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="ReNewPassword" type="password" id="ReNewPassword" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label"></label>
                                <div class="col-sm-6">



                                    <input name="Save"  class="btn btn-primary" type="submit" id="Save"  value="Save">
                                </div>
                            </div>
                        </form>
                    </div>

      
   <script language="JavaScript" type="text/javascript">
    var frmvalidator = new Validator("changepassword");
    frmvalidator.addValidation("PreviousPassword", "req", "Write Your Previous Password.");
    frmvalidator.addValidation("NewPassword", "req", "Write the New password.");
    frmvalidator.addValidation("ReNewPassword", "req", "Re Type Your New password.");
</script>                         
                            
        <?PHP
        if ($_REQUEST['Save'] == 'Save') {
            $User = $_SESSION['User'];
            $PreviousPassword = $_REQUEST['PreviousPassword'];
            $NewPassword = $_REQUEST['NewPassword'];
            $ReNewPassword = $_REQUEST['ReNewPassword'];
            if ($NewPassword != $ReNewPassword) {
                MsgBox('Your New Password and Re-Type New Password Are Not Same.');
                exit();
            } else {
                $cn=ConnectDB();
                $param = "Password='$NewPassword'";
                $cond = "UserName='$User' and Password='$PreviousPassword'";
                //echo $cond;exit;
                if (Edit($cn, getDBMain(), '[UserInfo]', $param, $cond)) {
                    //echo $cond;exit;
                    MsgBox('Password Updated Successfully ');
                    echo "<script> window.close();</script>";
                } else
                    MsgBox('Failed to Update Password');
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