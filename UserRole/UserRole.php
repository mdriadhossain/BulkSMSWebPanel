

<?php
$cn = ConnectDB();
$user = $_SESSION['User'];
$userNameSelect = "SELECT UserID, UserName FROM UserInfo where UserName <>'Admin' Order By UserName ASC";
$result_userNameSelect = odbc_exec($cn, $userNameSelect);

$userRoleSelect = "SELECT RoleID, RoleName FROM BULKSMSPanel.dbo.RoleInfo where RoleName <>'Admin'";
$result_userRoleSelect = odbc_exec($cn, $userRoleSelect);
?>

<link rel="stylesheet" href="bootstrap-select/dist/css/bootstrap-select.css">
<script type="text/javascript" src="bootstrap-select/dist/js/bootstrap-select.js"></script>

<div id="page-content">
    <div id='wrap'>



        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>User Assign In Role</h4>
                </div>
                <div class="panel-body">


                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->




                        <form class="form-horizontal" id="role" name="role" method="post" action="" >


                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">User Name:</label>
                                <div class="col-sm-6">



                                    <select class="form-control selectpicker"  data-live-search="true" name="UserId" id="UserId">
                                        <?php
                                        while ($n = odbc_fetch_row($result_userNameSelect)) {
                                            $UserID = odbc_result($result_userNameSelect, "UserID");
                                            $UserName = odbc_result($result_userNameSelect, "UserName");
                                            echo "<option value=$UserID>$UserName</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Role Name</label>
                                <div class="col-sm-6">



                                    <select class="form-control" name="RoleId" id="RoleId">
                                        <?php
                                        while ($n = odbc_fetch_row($result_userRoleSelect)) {
                                            $RoleID = odbc_result($result_userRoleSelect, "RoleID");
                                            $RoleName = odbc_result($result_userRoleSelect, "RoleName");
                                            echo "<option value=$RoleID>$RoleName</option>";
                                        }
                                        ?>
                                    </select>
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

                </div>

              
                <?PHP
                $userName = $_REQUEST['UserId'];
                $roleName = $_REQUEST['RoleId'];

                if ($_REQUEST['Save'] == 'Save') {
                    $ckUserID = checkUserID($userName, $cn);

                    $insertUserRole = "Insert into UserRole (UserID, RoleID, CreatedBy, CreateDate) Values ('$userName','$roleName','Admin',getdate())";
                    //exit;

                    if ((Save) && ($ckUserID == '0')) {
                        odbc_exec($cn, $insertUserRole);
                        MsgBox('Saved Successfully');
                    } else
                        $ckUserID;
                }

                function checkUserID($userName, $cn) {
                    $user = $userName;
                    $isexistUser = "select count(*) as count from UserRole where UserID = '$userName'";
                    $result_isexistUser = odbc_exec($cn, $isexistUser);
                    while ($rs = odbc_fetch_row($result_isexistUser)) {
                        $isExistUser = odbc_result($result_isexistUser, "count");
                    }
                    If ($isExistUser == '1') {
                        $url = base_url() . "index.php?parent=AddUserRole";
                        popup('Sorry!! Role for this User already Defined.', $url);
                    } else {
                        return $isExistUser;
                    }
                }
                ?>
                <div class="panel-body">


                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->


                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables">
                            <thead>
                                <tr class="row">

                                    <th>User Id</th>
                                    <th>User Name</th>
                                    <th>Role Name</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <?PHP
                            $qry = "select UserRole.UserId,UserInfo.UserName,UserRole.RoleId from UserRole left outer join UserInfo on UserRole.UserId=UserInfo.UserID where UserRole.RoleId<>'Admin'";
                            $rs = odbc_exec($cn, $qry);
                            while ($row = odbc_fetch_row($rs)) {
                                $UserId = odbc_result($rs, "UserId");
                                $UserName = odbc_result($rs, "UserName");
                                $RoleId = odbc_result($rs, "RoleId");
                                ?>
                                <tr class="row">
                                    <td><?php echo $UserId; ?></td>
                                    <td><?php echo $UserName; ?></td>
                                    <td><?php echo $RoleId; ?></td>
                                    <td><a href="#" <?php echo "onclick=\"deleteUserRole('$UserId','$RoleId');\"" ?>><button type="button" class="btn btn-danger">Delete</button></a></td>
                                </tr>
                                <?PHP
                            }
                            ?>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div> <!-- row -->
</div> <!-- container -->


