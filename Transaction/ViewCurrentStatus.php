<?php session_start(); ?>
<?php
require_once "Config/config.php";
require_once "Lib/lib.php";
$cn = ConnectDB();


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
                    <h4>View Current Status</h4>
                </div>
                <div class="panel-body">
                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="KeywordSearch" >


                            <?php
                            if (strtoupper($User) == 'ADMIN') {
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
                            }
                            ?>  

                            <div class="panel-body collapse in">
                                <div class="row">

                                    <div class="col-lg-2">
                                        <input name="Search"  class="btn btn-primary" type="submit" id="Save"  value="GETReport">
                                    </div><!-- /.col-lg-6 -->
                                </div><!-- /.row -->

                            </div>
                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label"></label>
                                <div class="col-sm-6">  </div>
                            </div>
                        </form>
                    </div>


                </div>
                <div class="panel-body">
                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->
                        <?php
                        if ($_REQUEST['Search'] == 'GETReport') {

                            $UserName = $_REQUEST['UserName'];

                            if ((strtoupper($User) == 'ADMIN') and $UserName != null) {
                                $TransactionHistoryQuery = "SELECT  UserName,NumberOfSMS,IsActive,ValidityDate  FROM CurrentStatus WHERE  UserName='$UserName' ";
                            } elseif ((strtoupper($User) == 'ADMIN')) {
                                $TransactionHistoryQuery = "SELECT  UserName,NumberOfSMS,IsActive,ValidityDate FROM CurrentStatus ";
                            } else {
                                $TransactionHistoryQuery = "SELECT  UserName,NumberOfSMS,IsActive,ValidityDate  FROM CurrentStatus WHERE  UserName='$User' ";
                            }
                            ?>

                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables">

                                <thead>
                                    <tr role="row">
                                        <th>User Name</th>
                                        <th>Number Of SMS</th>
                                        <th>Is Active</th>                                        
                                        <th>Validity Date</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?PHP
                                    $rs = odbc_exec($cn, $TransactionHistoryQuery);
                                    while ($row = odbc_fetch_array($rs)) {

                                        $UserName = $row['UserName'];
                                        $NumberOfSMS = $row['NumberOfSMS'];
                                        $IsActive = $row['IsActive'];
                                        $ValidityDate = $row['ValidityDate'];
                                        ?>
                                        <tr>
                                            <td><?php echo $UserName; ?></td>
                                            <td><?php echo $NumberOfSMS; ?></td>
                                            <td><?php echo $IsActive; ?></td>
                                            <td><?php echo $ValidityDate; ?></td>
                                        </tr>
                                        <?PHP
                                    }
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


