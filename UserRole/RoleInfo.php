<?PHP
//include "Config/config.php";
//include "Lib/lib.php";
$user = $_SESSION['User'];
?>
<div id="page-content">
    <div id='wrap'>



        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>Create Role</h4>
                </div>
                <div class="panel-body">


                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->



                        <form class="form-horizontal" id="role" name="role" method="post" action="" onSubmit="return validateRoleInfo();">


                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Role Id</label>
                                <div class="col-sm-6">


                                    <input class="form-control" name="RoleId" type="text" id="RoleId">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Role Name</label>
                                <div class="col-sm-6">


                                    <input class="form-control" name="RoleName" type="text" id="RoleName">
                                </div>
                            </div>




                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label"></label>
                                <div class="col-sm-6">




                                    <input class="btn btn-primary" name="Save" type="submit" id="Save" value="Save">


                                </div>
                            </div>
                        </form>
                    </div>
                    <script language="JavaScript" type="text/javascript">
                        var frmvalidator = new Validator("role");
                        frmvalidator.addValidation("RoleId", "req", "Please Select RoleId.");
                        frmvalidator.addValidation("RoleName", "req", "Please select RoleName.");


                    </script>
                    <?PHP
                    $cn = ConnectDB();
                    $RoleId = $_REQUEST['RoleId'];
                    $RoleName = $_REQUEST['RoleName'];
                    $ckRoleID = ckRoleIDExist($RoleId, $cn);
                    $ckRoleName = ckRoleNameExist($RoleName, $cn);

                    if (($_REQUEST['Save'] == 'Save') && ($ckRoleID == '0') && ($ckRoleName == '0')) {
                        $insertRole = "INSERT INTO RoleInfo (RoleID, RoleName, CreatedBy, CreateDate) VALUES ('$RoleId', '$RoleName', 'Admin', getdate())";
                        if (Save) {
                            odbc_exec($cn, $insertRole);
                            $url = base_url() . "index.php?parent=AddRole";
                            popup('Succesfully Created User Role.', $url);
                        } else
                            MsgBox('failed');
                    }

                    function ckRoleIDExist($RoleId, $cn) {
                        $roleid = $RoleId;
                        $isexistRoleID = "select count(*) as count from RoleInfo where RoleID = '$roleid'";
                        $result_isexistRoleID = odbc_exec($cn, $isexistRoleID);
                        while ($rs = odbc_fetch_row($result_isexistRoleID)) {
                            $existRoleID = odbc_result($result_isexistRoleID, "count");
                        }
                        If ($existRoleID == '1') {
                            $url = base_url() . "index.php?parent=AddRole";
                            popup('Sorry!! Role ID Already Exist.', $url);
                        } else {
                            return $existRoleID;
                        }
                    }

                    function ckRoleNameExist($RoleName, $cn) {
                        $rolename = $RoleName;
                        $isexistRoleName = "select count(*) as count from RoleInfo where RoleName = '$rolename'";
                        $result_isexistRoleName = odbc_exec($cn, $isexistRoleName);
                        while ($rs = odbc_fetch_row($result_isexistRoleName)) {
                            $existRoleName = odbc_result($result_isexistRoleName, "count");
                        }
                        If ($existRoleName == '1') {
                            $url = base_url() . "index.php?parent=AddRole";
                            popup('Sorry!! Role Name Already Exist.', $url);
                        } else {
                            return $existRoleName;
                        }
                    }
                    ?>
                </div>

                <div class="panel-body">


                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->


                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables">


                            <thead>
                                <tr role="row">
                                    <th>Role Id</th>
                                    <th>Role Name</th>
                                    <th>Delete</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?PHP
                                $qry = "select RoleId,RoleName from RoleInfo where RoleId<>'admin'";
                                $rs = odbc_exec($cn, $qry);
                                while ($row = odbc_fetch_row($rs)) {
                                    $Roleid = odbc_result($rs, "RoleId");
                                    $RoleName = odbc_result($rs, "RoleName");
                                    ?>
                                    <tr>
                                        <td><?php echo $Roleid; ?></td>
                                        <td><?php echo $RoleName; ?></td>
                                        <td><a href="#" <?php echo "onclick=\"deleteRole('$Roleid');\"" ?>><button type="button" class="btn btn-danger">Delete</button></a></td>
                                    </tr>
                                    <?PHP
                                }
//db_close($cn);
                                ?>
                            </tbody>

                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div> <!-- row -->
</div> <!-- container -->
</div> <!-- page-content -->

</div> <!-- wrap -->

</div> <!-- page-content -->
