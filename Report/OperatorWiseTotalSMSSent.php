<?php
$cn = ConnectDB();

$userDetail = "SELECT UserID, UserName FROM BULKSMSPanel.dbo.UserInfo Order By UserName ASC";
$result_userDetail = odbc_exec($cn, $userDetail);
?>

<link rel="stylesheet" href="bootstrap-select/dist/css/bootstrap-select.css">
<script type="text/javascript" src="bootstrap-select/dist/js/bootstrap-select.js"></script>

<div id="page-content">
    <div id='wrap'>

        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>Operatorwise Total SMS Sent Report</h4>
                </div>
                <div class="panel-body">

                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->

                        <form class="form-horizontal" name="MTSearch" method='POST' action="" id="TotalSMSSentReportID">


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
                                <label for="focusedinput" class="col-sm-3 control-label">Day:</label>
                                <div class="col-sm-6">
                                    <select name="DayType" id="DayTypeID" type="text" class="form-control" />
                                    <option value='Today' selected="selected">Today</option>
                                    <option value="Whole">Whole</option>
                                    </select>


                                </div>
                            </div>

                            <div class="panel-body collapse in">
                                <div class="row">

                                    <div class='col-sm-5'>
                                        <div class="form-group">
                                            <div class='input-group date' id='start_date'>
                                                <input type='text' class="form-control" name="start_date" placeholder="Start Date"/>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"><i class="fa fa-calendar"></i></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <script type="text/javascript">
                                        $(function () {
                                            $('#start_date').datepicker({
                                                format: 'yyyy-mm-dd',
                                                stDate: '-3d'

                                            });
                                        });</script><!-- /.col-lg-6 -->
                                    <div class='col-sm-5'>
                                        <div class="form-group">
                                            <div class='input-group date' id='end_date'>
                                                <input type='text' class="form-control" name="end_date" placeholder="End Date"/>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"><i class="fa fa-calendar"></i></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <script type="text/javascript">
                                        $(function () {
                                            $('#end_date').datepicker({
                                                format: 'yyyy-mm-dd',
                                                stDate: '-3d'

                                            });
                                        });</script><!-- /.col-lg-6 -->
                                    <div class="col-lg-2">

                                        <input name="Search"  class="btn btn-primary" type="submit" id="Save"  value="Search">

                                    </div><!-- /.col-lg-6 -->
                                </div><!-- /.row -->
                            </div>

                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label"></label>
                                <div class="col-sm-6">

                                </div>
                            </div>
                        </form>
                    </div>
                    <script language="JavaScript" type="text/javascript">
                        var frmvalidator = new Validator("TotalSMSSentReportID");
                        frmvalidator.addValidation("UserName", "dontselect=0", "Please Select the UserName.");
                    </script>
                </div>

                <div class="panel-body">


                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->
                        <?php
                        if ($_REQUEST['Search'] == 'Search') {
                            $UserName = $_REQUEST['UserName'];
                            $DayType = $_REQUEST['DayType'];

                            if ($DayType == "Today") {
                                $CurrentDate = date('Y-m-d');
                                $stTime = $CurrentDate . " 00:00:00";
                                $etTime = $CurrentDate . " 23:59:59";
                            } else {
                                if (($_REQUEST['start_date'] == NULL)or ( $_REQUEST['start_date'] == "")) {
                                    $stTime = "2001-01-01 00:00:00";
                                } else {
                                    $stTime = $_REQUEST['start_date'] . ' 00:00:00.000';
                                }
                                if (($_REQUEST['end_date'] == NULL)or ( $_REQUEST['end_date'] == "")) {
                                    $etTime = date('Y-m-d') . ' 23:59:59.000';
                                } else {
                                    $etTime = $_REQUEST['end_date'] . ' 23:59:59.000';
                                }
                            }
                            ?>


                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables">


                                <thead>
                                    <tr role="row">
                                        <th>Total SMS Sent Report.Reporting Date: <?php echo $stTime; ?> to <?php echo $etTime; ?></th>


                                    </tr>
                                    <tr role="row">
                                        <th>UserName</th>
                                        <th>GP</th>
                                        <th>Robi</th>
                                        <th>BL</th>
                                        <th>Airtel</th>
                                        <th>CC</th>
                                        <th>TT</th>


                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td><?php echo $UserName; ?></td>

                                        <?php
                                        if ($DayType == "Today") {

                                            $GpCountQuery = "select count(id) as gp  from BULKSMSGateway_1_0.[dbo].[SMSOutbox_back] where srcAccount='$UserName' and sentTime between '$stTime' and '$etTime' and LEFT(dstMN , 5) ='88017'";

                                            $result_GpCountQuery = odbc_exec($cn, $GpCountQuery);
                                            $row = odbc_fetch_array($result_GpCountQuery);
                                            $gp = $row['gp'];


                                            $RoCountQuery = "select count(id) as ro  from BULKSMSGateway_1_0.[dbo].[SMSOutbox_back] where srcAccount='$UserName' and sentTime between '$stTime' and '$etTime' and LEFT(dstMN , 5) ='88018'";

                                            $result_RoCountQuery = odbc_exec($cn, $RoCountQuery);
                                            $row = odbc_fetch_array($result_RoCountQuery);
                                            $ro = $row['ro'];

                                            $BlCountQuery = "select count(id) as bl  from BULKSMSGateway_1_0.[dbo].[SMSOutbox_back] where srcAccount='$UserName' and sentTime between '$stTime' and '$etTime' and LEFT(dstMN , 5) ='88019'";

                                            $result_BlCountQuery = odbc_exec($cn, $BlCountQuery);
                                            $row = odbc_fetch_array($result_BlCountQuery);
                                            $bl = $row['bl'];


                                            $AtCountQuery = "select count(id) as at  from BULKSMSGateway_1_0.[dbo].[SMSOutbox_back] where srcAccount='$UserName' and sentTime between '$stTime' and '$etTime' and LEFT(dstMN , 5) ='88016'";

                                            $result_AtCountQuery = odbc_exec($cn, $AtCountQuery);
                                            $row = odbc_fetch_array($result_AtCountQuery);
                                            $at = $row['at'];

                                            $CcCountQuery = "select count(id) as cc  from BULKSMSGateway_1_0.[dbo].[SMSOutbox_back] where srcAccount='$UserName' and sentTime between '$stTime' and '$etTime' and LEFT(dstMN , 5) ='88011'";

                                            $result_CcCountQuery = odbc_exec($cn, $CcCountQuery);
                                            $row = odbc_fetch_array($result_CcCountQuery);
                                            $cc = $row['cc'];


                                            $TtCountQuery = "select count(id) as tt  from BULKSMSGateway_1_0.[dbo].[SMSOutbox_back] where srcAccount='$UserName' and sentTime between '$stTime' and '$etTime' and LEFT(dstMN , 5) ='88015'";

                                            $result_TtCountQuery = odbc_exec($cn, $TtCountQuery);
                                            $row = odbc_fetch_array($result_TtCountQuery);
                                            $tt = $row['tt'];
                                        } else {

                                            $GpCountQuery = "select count(id) as gp  from BULK_DWH_1_0.[dbo].[SMSOutbox_back] where srcAccount='$UserName' and sentTime between '$stTime' and '$etTime' and LEFT(dstMN , 5) ='88017'";

                                            $result_GpCountQuery = odbc_exec($cn, $GpCountQuery);
                                            $row = odbc_fetch_array($result_GpCountQuery);
                                            $gp = $row['gp'];


                                            $RoCountQuery = "select count(id) as ro  from BULK_DWH_1_0.[dbo].[SMSOutbox_back] where srcAccount='$UserName' and sentTime between '$stTime' and '$etTime' and LEFT(dstMN , 5) ='88018'";

                                            $result_RoCountQuery = odbc_exec($cn, $RoCountQuery);
                                            $row = odbc_fetch_array($result_RoCountQuery);
                                            $ro = $row['ro'];

                                            $BlCountQuery = "select count(id) as bl  from BULK_DWH_1_0.[dbo].[SMSOutbox_back] where srcAccount='$UserName' and sentTime between '$stTime' and '$etTime' and LEFT(dstMN , 5) ='88019'";

                                            $result_BlCountQuery = odbc_exec($cn, $BlCountQuery);
                                            $row = odbc_fetch_array($result_BlCountQuery);
                                            $bl = $row['bl'];


                                            $AtCountQuery = "select count(id) as at  from BULK_DWH_1_0.[dbo].[SMSOutbox_back] where srcAccount='$UserName' and sentTime between '$stTime' and '$etTime' and LEFT(dstMN , 5) ='88016'";

                                            $result_AtCountQuery = odbc_exec($cn, $AtCountQuery);
                                            $row = odbc_fetch_array($result_AtCountQuery);
                                            $at = $row['at'];

                                            $CcCountQuery = "select count(id) as cc  from BULK_DWH_1_0.[dbo].[SMSOutbox_back] where srcAccount='$UserName' and sentTime between '$stTime' and '$etTime' and LEFT(dstMN , 5) ='88011'";

                                            $result_CcCountQuery = odbc_exec($cn, $CcCountQuery);
                                            $row = odbc_fetch_array($result_CcCountQuery);
                                            $cc = $row['cc'];


                                            $TtCountQuery = "select count(id) as tt  from BULK_DWH_1_0.[dbo].[SMSOutbox_back] where srcAccount='$UserName' and sentTime between '$stTime' and '$etTime' and LEFT(dstMN , 5) ='88015'";

                                            $result_TtCountQuery = odbc_exec($cn, $TtCountQuery);
                                            $row = odbc_fetch_array($result_TtCountQuery);
                                            $tt = $row['tt'];
                                        }
                                        ?>

                                        <td><?php echo $gp; ?></td>
                                        <td><?php echo $ro; ?></td>
                                        <td><?php echo $bl; ?></td>
                                        <td><?php echo $at; ?></td>
                                        <td><?php echo $cc; ?></td>
                                        <td><?php echo $tt; ?></td>


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
