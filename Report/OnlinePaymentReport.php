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
                    <h4>Online Payment Report</h4>
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
                                <label for="focusedinput" class="col-sm-3 control-label">User MSISDN:</label>
                                <div class="col-sm-6">
                                    <input name="MSISDN" type="text" id="MSISDN" class="form-control" placeholder="MSISDN">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Status Type:</label>
                                <div class="col-sm-6">
                                    <select class="form-control" id="status" name="status" >
                                        <option value="ALL" selected="selected">All</option>
                                        <option value="VALID">Valid</option>
                                        <option value="INVALID_TRANSACTION">Invalid </option>
                                        <option value="FAILED">Failed </option>
                                        <option value="CANCELLED">Cancelled</option>
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
                            if ($UserNameID == NULL || $UserNameID == "") {
                                popup("Please Select User Name");
                                return;
                            }
                            $DayType = $_REQUEST['DayType'];
                            $TransmobileNo = $_REQUEST['MSISDN'];
                            $status = $_REQUEST['status'];

                            $stTime = $_REQUEST['start_date'];
                            $etTime = $_REQUEST['end_date'];
                            $TransactionType = "Credit";


                            $cn = ConnectDB();
                            $TotalQueQuery = " select OnlinePaymentHistory.[UserName] ,OnlinePaymentHistory.[TransactionId] ,[MobileNo] ,[GatewayName] ,[ProceAmount] ,OnlinePaymentHistory.[Amount] ,OnlinePaymentHistory.[DataEntryDate] ,[Response] ,[Status] ,[PaymentValStatus] ,[HashValStatus], TransactionHistory.NumberOfSMS from [dbo].[OnlinePaymentHistory], [dbo].[TransactionHistory] where OnlinePaymentHistory.UserName='$UserNameID'   and OnlinePaymentHistory.TransactionId = TransactionHistory.TransactionId and  TransactionHistory.TransactionType='$TransactionType' ";
                            

//                            $TotalQueQuery = "select [UserName]
//      ,[TransactionId]
//      ,[MobileNo]
//      ,[GatewayName]
//      ,[ProceAmount]
//      ,[Amount]
//      ,[DataEntryDate]
//      ,[Response]
//      ,[Status]
//      ,[PaymentValStatus]
//      ,[HashValStatus]
//      ,[TransValStatus]
//      ,[CreatedBy]
//      ,[UpdatedDate]from [dbo].[OnlinePaymentHistory] where UserName='$UserNameID'";
                            if ($TransmobileNo != NULL && $TransmobileNo != "") {
                                $mobile_number_2 = substr($TransmobileNo, -10);
                                $mobile = "880" . $mobile_number_2;
                                $TotalQueQuery = $TotalQueQuery . "and OnlinePaymentHistory.MobileNo='$mobile'";
                            }
                            if ($status != "ALL") {
                                $TotalQueQuery = $TotalQueQuery . "and OnlinePaymentHistory.PaymentValStatus='$status'";
                            }
                            if ($stTime != NULL && $stTime != "" && $etTime != NULL && $etTime != "") {
                                $stTime = $stTime . ' 00:00:00.000';
                                $etTime = $etTime . ' 23:59:59.000';
                                $TotalQueQuery = $TotalQueQuery . "and OnlinePaymentHistory.DataEntryDate between '$stTime' and '$etTime'";
                            }

                            echo $result_TotalQueQuery = odbc_exec($cn, $TotalQueQuery);
                            ?>

                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" style="overflow:auto">


                                <thead>
                                    <tr class="TableTopHeader"><td colspan="7"><b>Online Payment Details of <?php echo $UserNameID; ?></b></td>
                                    </tr>

                                    <tr role="row">
                                        <td>Details </td>
                                        <td>Mobile</td>
                                        <td>Number of SMS</td>
                                        <td>Gateway</td>
                                        <td>Amount</td>
                                        <td>Payment Successful Status</td>
                                        <td>Transaction Date</td>
                                        

                                    </tr>
                                </thead>
                                <tbody>



                                    <tr>
                                        <?php
                                        while ($row = odbc_fetch_array($result_TotalQueQuery)) {
                                            ?>
                                          <td><a href="#" onClick='NewWindow("Report/OnlinePaymentDetails.php?&UserName=<?php echo $UserNameID; ?>&TransactionId=<?php echo $row[TransactionId]; ?>", "name", "1080", "800", "no");
                                                    return false;'><button type="button" class="btn btn-success btn-sm">Detail</button></a></td>
                                            <td><?php echo $row[MobileNo]; ?></td>
                                            <td><?php echo $row[NumberOfSMS]; ?></td>
                                            <td><?php echo $row[GatewayName]; ?></td>
                                            <td><?php echo $row[Amount]; ?></td>
                                            <td><?php echo $row[PaymentValStatus]; ?></td>
                                            <td><?php echo $row[DataEntryDate]; ?></td>

                                          


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
