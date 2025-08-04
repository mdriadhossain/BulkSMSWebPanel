<?php session_start(); ?>
<?php
require_once "Config/config.php";
require_once "Lib/lib.php";
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
                    <h4>Date wise Total SMS Sent Report</h4>
                </div>
                <div class="panel-body">


                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->

                        <form class="form-horizontal" name="MTSearch" method='POST' action="" id="RealTimeSMSLogID">


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

                                        <select class="form-control selectpicker"  data-live-search="true"  name="UserName" id="UserName">
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

                        var cal = Calendar.setup({onSelect: function (cal) {
                                cal.hide()
                            }});
                        cal.manageFields("start_button", "start_date", "%Y-%m-%d");
                        cal.manageFields("end_button", "end_date", "%Y-%m-%d");
                        var frmvalidator = new Validator("RealTimeSMSLogID");
                        frmvalidator.addValidation("UserName", "dontselect=0", "Please Select the UserName.");
                    </script>
                </div>

                <div class="panel-body">
                    <div class="panel-body collapse in">
                        <?php
                        if ($_REQUEST['Search'] == 'Search') {
                            $UserNameID = $_REQUEST['UserName'];
                            $stDate = $_REQUEST['start_date'];
                            $etDate = $_REQUEST['end_date'];

                            $stDateTime = $stDate . ' 00:00:00.000';
                            $etDateTime = $etDate . ' 23:59:59.000';

                            $DateWiseSMSCount = "SELECT * FROM [BULKSMSPanel].[dbo].[ExpenceHistory] 
                            WHERE UserName = '$UserNameID' AND
                            Date BETWEEN '$stDateTime' AND '$etDateTime'
                            ORDER BY Date DESC";
                            $resultDateWiseSMSCount = odbc_exec($cn, $DateWiseSMSCount);
                            
                            $TotalSMSCount = "SELECT SUM(NumberOfSMS) TotalCount FROM [BULKSMSPanel].[dbo].[ExpenceHistory] 
                            WHERE UserName = '$UserNameID' AND
                            Date BETWEEN '$stDateTime' AND '$etDateTime'";
                            $resultTotalSMSCount = odbc_exec($cn, $TotalSMSCount);
                            while ($row = odbc_fetch_array($resultTotalSMSCount)) {
                                $totalSMSUsage = $row['TotalCount'];
                            }
                            ?>

                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables">
                                <h4> User Name: <?php echo $UserNameID; ?></h4>
                                <h5> Date Range: <?php echo date("d-m-Y", strtotime($stDate)); ?> <b style="color: blue;">to</b> <?php echo date("d-m-Y", strtotime($etDate)); ?></h5>
                                <h5> Total SMS Usage: <b style="color: red;"><?php echo $totalSMSUsage; ?></b></h5>
                                <thead>
                                    <tr role="row">
                                        <th>Date </th>                                        
                                        <th>Number of SMS Usage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                while ($rsc = odbc_fetch_array($resultDateWiseSMSCount)) {
                                    $SendDate = $rsc['Date'];
                                    $NumberOfSMS = $rsc['NumberOfSMS'];
                                    echo '<tr>
                                        <td>' . $SendDate . '</td>
                                        <td>' . $NumberOfSMS . '</td>
                                        </tr>';
                                 }
                               
                                    }
                                
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
