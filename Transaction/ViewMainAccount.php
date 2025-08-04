<?php session_start(); ?>
<?php
require_once "Config/config.php";
require_once "Lib/lib.php";
$cn = ConnectDB();
$userDetail = "SELECT UserID, UserName FROM BULKSMSPanel.dbo.UserInfo where Username<>'admin' Order By UserName ASC";
$result_userDetail = odbc_exec($cn, $userDetail);
?>

<div id="page-content">
    <div id='wrap'>
        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>View Main Account</h4>
                </div>
                <div class="panel-body">

                </div>
                <div class="panel-body">
                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->
                        <?php
                        $UserName = $_REQUEST['UserName'];

                        if (($User = 'admin') || ($User == 'ADMIN'))
                            $MainAccountQuery = "SELECT  UserName,CurrentNoOfSMS  FROM MainAccount ";
                        ?>

                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables">

                            <thead>

                                <tr role="row">
                                    <th>User Name</th>
                                    <th>Current No Of SMS</th>
                                </tr>

                            </thead>
                            <tbody>
                                <?PHP
                                $rs = odbc_exec($cn, $MainAccountQuery);

                                while ($row = odbc_fetch_array($rs)) {

                                    $UserName = $row['UserName'];

                                    $CurrentNoOfSMS = $row['CurrentNoOfSMS'];
                                    ?>
                                    <tr>
                                        <td><?php echo $UserName; ?></td>
                                        <td><?php echo $CurrentNoOfSMS; ?></td>

                                    </tr>
                                    <?PHP
                                }
//  }
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


