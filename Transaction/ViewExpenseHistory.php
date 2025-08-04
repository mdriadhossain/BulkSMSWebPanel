<?php session_start(); ?>
<?php
require_once "Config/config.php";
require_once "Lib/lib.php";
$cn = ConnectDB();


$userDetail = "SELECT UserID, UserName FROM BULKSMSPanel.dbo.UserInfo  Order By UserName ASC";
$result_userDetail = odbc_exec($cn, $userDetail);
?>

<link rel="stylesheet" href="bootstrap-select/dist/css/bootstrap-select.css">
<script type="text/javascript" src="bootstrap-select/dist/js/bootstrap-select.js"></script>

<div id="page-content">
    <div id='wrap'>
        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>View Expense History</h4>
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

                </div>
                <div class="panel-body">
                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->
                        <?php
                        if ($_REQUEST['Search'] == 'GETReport') {

                            $UserName = $_REQUEST['UserName'];
                                                                                 
                           // $start_date = $_REQUEST['start_date'] . ' 00:00:00.000';
                           // $end_date = $_REQUEST['end_date'] . ' 23:59:59.000';
                            
                             $start_date = $_REQUEST['start_date'] ;
                            $end_date = $_REQUEST['end_date'] ;
                            

                            if (($User == 'Admin') and $UserName != null) {
                                $ExpenseHistoryQuery = "SELECT  UserName,sum(cast(NumberOfSMS as int)) AS TotalSMS   FROM ExpenceHistory WHERE  UserName='$UserName' and  Date BETWEEN '$start_date' and '$end_date' group by UserName";
                            } elseif (($User == 'Admin')) {
                                $ExpenseHistoryQuery = "SELECT  UserName,sum(cast(NumberOfSMS as int)) AS TotalSMS   FROM ExpenceHistory WHERE   Date BETWEEN '$start_date' and '$end_date' group by UserName ";
                            } else {
                                $ExpenseHistoryQuery = "SELECT  UserName,sum(cast(NumberOfSMS as int)) AS TotalSMS   FROM ExpenceHistory WHERE  UserName='$UserName'  and Date BETWEEN '$start_date' and '$end_date' group by UserName";
                            }
                                                     
                            $_SESSION['xls_query'] = $ExpenseHistoryQuery;
                            ?>

                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables">
    
                                <thead>
                                      <tr>
                                         <th colspan="1"> Detail Expense History Report</th>
                                        <th><a href="<?php echo base_url().'Lib/ExportToExcel.php';?>"/><button type="button" class="btn btn-primary btn-block">Export To Excel</button></a></th>
                                    </tr>
                                    <tr>
                                        <th>UserName</th>
                                        
                                        <th>Total Number of SMS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?PHP
                                    $rs = odbc_exec($cn, $ExpenseHistoryQuery);


                                    while ($row = odbc_fetch_array($rs)) {

                                        $UserName = $row['UserName'];                                     
                                    
                                        $NumberOfSMS = $row['TotalSMS'];
                                        ?>
                                        <tr>
                                            <td><?php echo $UserName;?></td>                                              
                                                                                                                                          
                                           <td><?php echo $NumberOfSMS; ?></td>
                                            
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


