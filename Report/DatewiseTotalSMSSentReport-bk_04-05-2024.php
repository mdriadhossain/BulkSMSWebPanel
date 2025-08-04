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
                        <!--//onSubmit="return validateUserInfo();-->
                        <?php
                        if ($_REQUEST['Search'] == 'Search') {
                            $UserNameID = $_REQUEST['UserName'];
                            $DayType = $_REQUEST['DayType'];

                            $cn = ConnectDB();


                            if ($DayType == "Today") {
                                $CurrentDate = date('Y-m-d');
                                $stTime = $CurrentDate . " 00:00:00";
                                $etTime = $CurrentDate . " 23:59:59";
                                $db = "BULKSMSGateway_1_0.[dbo].[SMSOutbox_Back]";
                                //$status = 'QUE';
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
                                $db = "BULK_DWH_1_0.[dbo].[SMSOutbox_back]";
                                //$status = 'DELIVERED';
                            }



                            //$TotalQueQuery = "select count(ID) as TotalQueCount from $db where srcAccount='$UserNameID' and writeTime between '$stTime' and '$etTime'";

                            //$result_TotalQueQuery = odbc_exec($cn, $TotalQueQuery);
                            ?>

                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables">
                                <h4> User Name: <?php echo $UserNameID; ?></h4>

                                <thead>

                                    <tr role="row">
                                        <th>Date </th>                                        
                                        <th>Number of SMS uses</th>                                      
                                        <!--<th>Sent Detail</th>-->

                                    </tr>
                                </thead>
                                <tbody>



                                    <tr>
                                        <?php
                                          $fromDateTS = strtotime($stTime);
                                    $toDateTS = strtotime($etTime);

                                    for ($currentDateTS = $fromDateTS; $currentDateTS <= $toDateTS; $currentDateTS += (60 * 60 * 24)) {
                                        $currentDateStr = date("m-d-Y", $currentDateTS);
                                        $StartDateTime = $currentDateStr . " 00:00:00 AM";
                                        $EndDateTime = $currentDateStr . " 11:59:59 PM";





                                        //echo "Service ID:".$row[ServiceID]."|Description:".$row[Description]."<br/>";



                                        //$ActiveSubscriberQuery = "select count(SubscriptionGroupID) as 'ActiveUser' from [$OperatorDB].[dbo].[SubscriberServices] where SubscriptionGroupID like '%_$ShortCodeNumber' and Status<>'Deregistered' and RegistrationDate BETWEEN '$StartDateTime' and '$EndDateTime'";
                           $TotalQueQuery = "select count(ID) as TotalQueCount from $db where srcAccount='$UserNameID' and writeTime between '$StartDateTime' and '$EndDateTime'";

                            //$result_TotalQueQuery = odbc_exec($cn, $TotalQueQuery);
							$ActiveUserResult = odbc_fetch_array(odbc_exec($cn, $TotalQueQuery));


                                        //echo $ActiveSubscriberQuery."<br/>";
                                        //echo $DeActiveSubscriberQuery."<br/>";

                                            ?>
                                            <td><?php echo $currentDateStr; ?></td>

                                            <td><?php echo $ActiveUserResult[TotalQueCount]; ?></td>

<!--                                            /*<td><a href="#" onClick='NewWindow("Report/DatewiseTotalSMSSentDetailReport.php?MaskingID=<?php // echo $row[srcMN]; ?>&UserName=<?php // echo $UserNameID; ?>&db=<?php // echo $db; ?>&stTime=<?php // echo $stTime; ?>&etTime=<?php // echo $etTime; ?>&status=<?php // echo $status;?>", "name", "1080", "800", "no");
                                                           return false;'><button type="button" class="btn btn-success btn-sm">Detail</button></a></td> */-->


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
