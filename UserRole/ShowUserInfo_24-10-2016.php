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
$userDetail = "SELECT UserID, UserName FROM BULKSMSPanel.dbo.UserInfo where Username<>'admin'";
$result_userDetail = odbc_exec($cn, $userDetail);
?>
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


                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">User Name</label>
                                <div class="col-sm-6">



                                    <select class="form-control" name="UserId" id="UserId">
                                        <option value=''>Select User</option>
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

                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">All</label>
                                <div class="col-sm-6">



                                    <input class="form-control" name="chkAll" type="checkbox" id="chkAll" value="chk">
                                </div>
                            </div>




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
                            if ($check == "chk") {
                                $showUser = "select UserID,UserName,Password,MobileNo,CompanyName,CreateDate,HeaderText from UserInfo where UserName<>'admin'";
                            } else {
                                $showUser = "select UserID,UserName,Password,MobileNo,CompanyName,CreateDate,HeaderText from UserInfo where UserID='$UserId'";
                            }
                            $result_showUser = odbc_exec($cn, $showUser);
                            ?>

                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables">
                                <thead>
                                    <tr role="row">
                                        <th>UserID</th>
                                        <th>UserName</th>
                                        <th>Password</th>
                                        <th>Base 64 Encoded String</th>
                                        <th>CompanyName</th>
                                        <th>MobileNo</th>
                                        <th>CreateDate</th>
                                        <th>Header Text</th>
                                        <th>EDIT</th>
                                        <th>DELETE</th>

                                    </tr>
                                </thead>

                                <?php
                                while ($row = odbc_fetch_row($result_showUser)) {
                                    ?>
                                    <tr>
                                        <td><?php echo odbc_result($result_showUser, "UserID"); ?> </td>
                                        <td><?php echo $SMSUserName=odbc_result($result_showUser, "UserName"); ?></td>
                                        <td><?php echo $SMSUserPassword=odbc_result($result_showUser, "Password"); ?></td>
                                        <td><?php $userString=$SMSUserName.'|'.$SMSUserPassword;echo base64_encode($userString); ?></td>
                                        <td><?php echo odbc_result($result_showUser, "CompanyName"); ?></td>
                                        <td><?php echo odbc_result($result_showUser, "MobileNo"); ?></td>
                                        <td><?php echo odbc_result($result_showUser, "CreateDate"); ?></td>
                                        <td><?php echo odbc_result($result_showUser, "HeaderText"); ?></td>
                                        <td><a href="UserRole/edit_UserInfo.php?id=<?php echo odbc_result($result_showUser, "UserID") ?>&user=<?php echo odbc_result($result_showUser, "UserName"); ?>&pass=<?php echo odbc_result($result_showUser, "Password"); ?>&company=<?php echo odbc_result($result_showUser, "CompanyName"); ?>&mobile=<?php echo odbc_result($result_showUser, "MobileNo"); ?>&CreateDate=<?php echo odbc_result($result_showUser, "CreateDate"); ?>&HeaderText=<?php echo odbc_result($result_showUser, "HeaderText"); ?>"><button type="button" class="btn btn-success">Edit</button></a></font></b></td>
                                        <td><a href="UserRole/deleteUser.php?id=<?php echo odbc_result($result_showUser, "UserID") ?>" onClick="return confirmDelete();"><button type="button" class="btn btn-danger">Delete</button></a></td>
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
