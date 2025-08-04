<?php //session_start();         ?>
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
                    <h4>View Transaction History</h4>
                </div>
                <div class="panel-body">
                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="ViewTransactionHistory" >
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
                                        <input name="Search"  class="btn btn-primary" type="submit" id="Save"  value="GETReport">
                                    </div><!-- /.col-lg-6 -->
                                </div><!-- /.row -->
                                Note: Please select short date rage to get effective result.
                            </div>
                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label"></label>
                                <div class="col-sm-6">  </div>
                            </div>
                        </form>
                    </div>
                    <script language="JavaScript" type="text/javascript">
                        var frmvalidator = new Validator("ViewTransactionHistory");

                        // frmvalidator.addValidation("start_date", "req", "Select The Start Date.");
                        //frmvalidator.addValidation("end_date", "req", "Select The End Date.");</script>

                </div>
                <div class="panel-body">
                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->
                        <?php
                        if ($_REQUEST['Search'] == 'GETReport') {



                            $UserName = $_REQUEST['UserName'];
                            /* $start_date = $_REQUEST['start_date'] . ' 00:00:00.000';
                              $end_date = $_REQUEST['end_date'] . ' 23:59:59.000';
                             */

                            if (($_REQUEST['start_date'] == NULL)or ( $_REQUEST['start_date'] == "")) {
                                $start_date = '1901-01-01 00:00:00.000';
                                // 2016-01-21 22:10:59.000
                            } else {
                                $start_date = $_REQUEST['start_date'] . ' 00:00:00.000';
                            }

                            if (($_REQUEST['end_date'] == NULL)or ( $_REQUEST['end_date'] == "")) {
                                $end_date = date("Y-m-d H:i:s");
                            } else {

                                $end_date = $_REQUEST['end_date'] . ' 23:59:59.000';
                            }



                            /*
                              $start_date = '1901-01-01 00:00:00.000';
                              $date =date("d-m-Y h:i:s");
                              $end_date = $date;
                             */

                            if ((strtoupper($User) == 'ADMIN') and $UserName != null) {
                                $ViewTransactionHistoryQuery = "SELECT  UserName,NumberOfSMS,TransactionType,PerSMSRate,Amount,TransactionDate,FromMainAccount  FROM TransactionHistory WHERE UserName='$UserName' and TransactionDate BETWEEN '$start_date' and '$end_date'";
                            } elseif ((strtoupper($User) == 'Admin')) {
                                $ViewTransactionHistoryQuery = "SELECT  UserName,NumberOfSMS,TransactionType,PerSMSRate,Amount,TransactionDate,FromMainAccount  FROM TransactionHistory WHERE TransactionDate BETWEEN '$start_date' and '$end_date'";
                            } else {
                                $ViewTransactionHistoryQuery = "SELECT  UserName,NumberOfSMS,TransactionType,PerSMSRate,Amount,TransactionDate  FROM TransactionHistory WHERE UserName='$UserName' and TransactionDate BETWEEN '$start_date' and '$end_date'";
                            }
                           // echo $ViewTransactionHistoryQuery;
//                            $_SESSION['xls_query'] = $ViewTransactionHistoryQuery;
                            ?>
                            



                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables">
                                <thead>
                                    <tr><th colspan="6">Reporting Date: <?php echo $start_date; ?> to <?php echo $end_date; ?>  </th></tr>
                                    <tr>

                                        <th colspan="5"> Detail Transaction History Report</th>
<!--                                        <th><a href="<?php echo base_url() . 'Lib/ExportToExcel.php'; ?>"/><button type="button" class="btn btn-primary btn-block">Export To Excel</button></a></th>-->
                                    </tr>

                                    <tr >
                                        <th>UserName</th>
                                        <th>Number Of SMS</th>
                                        <th>Transaction Type</th>                                        
                                        <th>Each SMS Rate</th>  
                                        <th>Amount</th>
                                        <th>Transaction Date</th>
                                <?php if(strtoupper($User) == 'ADMIN') echo "<th>From Main Account</th>"; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?PHP
                                    $rs = odbc_exec($cn, $ViewTransactionHistoryQuery);


                                    while ($row = odbc_fetch_array($rs)) {
                                        //print_r($row);
                                        $UserName = $row['UserName'];
                                        //$Keyword=$row['Keyword'];
                                        $NumberOfSMS = $row['NumberOfSMS'];
                                        $TransactionType = $row['TransactionType'];
                                        $PerSMSRate = $row['PerSMSRate'];
                                        $Amount = $row['Amount'];
                                        $TransactionDate = $row['TransactionDate'];
                                        $FromMainAccount = $row['FromMainAccount'];
                                        
                                        ?>
                                        <tr>
                                            <td><?php echo $UserName; ?></td>
                                            <td><?php echo $NumberOfSMS; ?></td>
                                            <td><?php echo $TransactionType; ?></td>
                                            <td><?php echo $PerSMSRate; ?></td>
                                            <td><?php echo $Amount; ?></td>
                                            <td><?php echo $TransactionDate; ?></td>
                                            
                        <?php if(strtoupper($User) == 'ADMIN') echo "<td> $FromMainAccount </td>"; ?>
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


