<?php
$cn = ConnectDB();
$user = $_SESSION['User'];
$roleNameSelect = "SELECT RoleID, RoleName FROM RoleInfo";
$result_roleNameSelect = odbc_exec($cn, $roleNameSelect);
?>

<script language="javascript">
    function resubmit()
    {
        document.menu.action = "index.php?parent=menuPrs";
        document.menu.submit();
    }

    function checkAllMP(field) {
        isall = document.getElementById('MPAll').checked;
        for (i = 0; i < field.length; i++) {
            if (isall == true)
                field[i].checked = true;
            else
                field[i].checked = false;
        }
    }
</script>
<div id="page-content">
    <div id='wrap'>



        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>Menu Permission</h4>
                </div>
                <div class="panel-body">


                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->



                        <form class="form-horizontal" id="menu" name="menu" method="post" action="" >

                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Select Role</label>
                                <div class="col-sm-6">


                                    <select class="form-control" name="roleId" id="roleId">
                                        <?PHP
                                        while ($n = odbc_fetch_row($result_roleNameSelect)) {
                                            $RoleID = odbc_result($result_roleNameSelect, "RoleID");
                                            $RoleName = odbc_result($result_roleNameSelect, "RoleName");
                                            echo "<option value=$RoleID>$RoleName</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label"></label>
                                <div class="col-sm-6">
                                    <input class="btn btn-primary" name="Show" type="submit"  id="Show" value="Show Menu" />
                                </div>
                            </div>
                        </form>
                    </div>
                    <?PHP
                    if ($_REQUEST['Show'] == "Show Menu") {

                        require_once "Config/config.php";
                        require_once "Lib/lib.php";
                        $cn = ConnectDB();
                        $rolId = $_REQUEST["roleId"];
                        $_SESSION["roleId"] = $rolId;
                        $sessionvalue = $_SESSION["roleId"];
                        $roleId = $_REQUEST["roleId"];
                        //$SQL = "select MenuId,MenuLevel from MenuDefine order by MenuOrder asc";

                        $SQL = "select MenuId,MenuLevel,MenuOrder,Parent from MenuDefine where MenuId<>'home' order by MenuOrder asc";
                        $rs = odbc_exec($cn, $SQL);
                        if (odbc_num_rows($rs) != 0) {
                            ?>

                        </div>

                        <div class="panel-body">


                            <div class="panel-body collapse in">
                                <!--//onSubmit="return validateUserInfo();-->
                                <form action="UserRole/insertPermission.php" method="POST">

                                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="example">


                                        <thead>
                                            <tr role="row">
                                                <td>Set Menu permission for : <?php echo $rolId; ?></td>
                                            </tr>
                                            <tr role="row">
                                                <th>MenuID</th>
                                                <th>MenuLevel</th>
                                                <th>Parent</th>
                                                <th>Permission</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                        <input name="delstaffform" type="hidden">
                                        <?php
                                        while ($row = odbc_fetch_array($rs)) {
                                            $MenuId = $row['MenuId'];
                                            $MenuLevel = $row['MenuLevel'];
                                            $parent = $row['Parent'];
                                            $SQL = "select Permission from RoleMenu where RoleId='$roleId' and MenuId='$MenuId'";
                                            $permissionVal = odbc_fetch_array(odbc_exec($cn, $SQL));
                                            $permission = $permissionVal['Permission'];
                                            ?>
                                            <tr>
                                                <td><?php echo $MenuId; ?></td>
                                                <td><?php echo $MenuLevel; ?></td>
                                                <?php
                                                if ($parent == 0) {
                                                    $color = '#000';
                                                    ?>
                                                    <td style="background-color: <?php echo $color; ?>"><?php echo "Main Menu"; ?></td>
                                                    <?php
                                                } else {
                                                    $color = '';
                                                    ?>
                                                    <td style="background-color: <?php echo $color; ?>"><?php echo "Sub Menu"; //echo $parent;   ?></td>
                                                <?php }
                                                ?>

                                                <td><input class="checkbox" type="checkbox" name="delstaff[]" id="MP" value="<?PHP echo $MenuId; ?>" <?php if ($permission == 1) echo "checked='checked'"; ?>  /></td>
                                            </tr>
                                            </tbody>
                                            <?PHP
                                        }
//db_close($cn);
                                        ?>

                                    </table>
                                    <table>
                                        <tr role="row"><td><input name="Save"  class="btn btn-sm btn-primary" type="submit" id="Save"  value="Save"></td></tr></table>
                                </form>

                                <?php
                            }
                        }
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div> <!-- row -->
</div> <!-- container -->






