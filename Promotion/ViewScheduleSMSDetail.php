<?php session_start(); ?>
<?php
require_once "Config/config.php";
require_once "Lib/lib.php";
$cn = ConnectDB();


$userDetail = "SELECT UserID, UserName FROM BULKSMSPanel.dbo.UserInfo Order By UserName ASC ";
$result_userDetail = odbc_exec($cn, $userDetail);
?>

<link rel="stylesheet" href="bootstrap-select/dist/css/bootstrap-select.css">
<script type="text/javascript" src="bootstrap-select/dist/js/bootstrap-select.js"></script>

<div id="page-content">
    <div id='wrap'>
        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>View Scheduled SMS Detail</h4>
                </div>
                <div class="panel-body">
                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="KeywordSearch" >


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

                            if (($User == 'Admin') and $UserName != null) {
                                $ViewScheduleSMSQuery = "SELECT  PromoName,PromoText,PromoID,SendingTime,SendBy  FROM [BULKSMSPanel].[dbo].[PromotionalDetail] WHERE SendBy='$UserName'";
                            } elseif (($User == 'Admin'||$User == 'ADMIN'||$User == 'admin' )) {
                                $ViewScheduleSMSQuery = "SELECT  PromoName,PromoText,PromoID,SendingTime,SendBy  FROM [BULKSMSPanel].[dbo].[PromotionalDetail] ";
                            } else {
                                $ViewScheduleSMSQuery = "SELECT  PromoName,PromoText,PromoID,SendingTime,SendBy  FROM [BULKSMSPanel].[dbo].[PromotionalDetail] WHERE  SendBy='$UserName'";
                            }
                            $_SESSION['xls_query'] = $ViewScheduleSMSQuery;
                            ?>

                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables">
    
                                <thead>
                                     
                                    <tr>
                                        <th>Scheduled SMS List Name</th>
                                        <th>Scheduled Text</th>
                                        <th>Scheduled ID</th>
                                        <th>Sending Time</th>
                                        <th>Send By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?PHP
                                         $conn = PDOConnectDB();
                                    foreach ($conn->query($ViewScheduleSMSQuery) as $row) {
                                        $PromoName = $row['PromoName'];                                     
                                        $PromoText = $row['PromoText'];
                                        $PromoID = $row['PromoID'];
                                        $SendingTime = $row['SendingTime'];
                                        $SendBy = $row['SendBy'];
                                        ?>
                                        <tr>
                                            <td><?php echo $PromoName;?></td>                                                 
                                            <td><?php echo $PromoText; ?></td>
                                            <td><?php echo $PromoID; ?></td>
                                            <td><?php echo $SendingTime; ?></td>
                                            <td><?php echo $SendBy; ?></td>
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







