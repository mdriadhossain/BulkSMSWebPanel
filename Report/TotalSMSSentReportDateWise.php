<?php
$cn = ConnectDB();
?>
<div id="page-content">
    <div id='wrap'>



        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>Total SMS Sent Report [Date Wise]</h4>
                </div>
                <div class="panel-body">


                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->




                        <form class="form-horizontal" name="MTSearch" method='POST' action="" id="TotalSMSSentReportID">


                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Select Operator</label>
                                <div class="col-sm-6">


                                    <select name="opt" id="opt" type="text" class="form-control" />
                                    <option value=''>Select Operator</option>
                                    <option value="GP">GP</option>
                                    <option value="AT">Airtel</option>
                                    <option value="RO">Robi</option>
                                    <option value="BL">Banglalink</option>
                                    <option value="CC">CityCell</option>
                                    <option value="TT">TeleTalk</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Select ShortCode</label>
                                <div class="col-sm-6">


                                    <select name="ShortCodeNumber" id="ShortCodeID" type="text" class="form-control" >
                                        <option value=''>Select ShortCode</option>
                                        <?php
                                        $cn = ConnectDB();
                                        $ScodeQuery = "select distinct(ShortCode) as ShortCode  from CMS_1_0.dbo.Keyword order by ShortCode asc";
                                        $rs = odbc_exec($cn, $ScodeQuery);
                                        while ($row = odbc_fetch_array($rs)) {
                                            echo "<option value=\"" . $row[ShortCode] . "\">" . $row[ShortCode] . "</option>";
                                        }
                                        ?>
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

                                        });
                                    </script><!-- /.col-lg-6 -->
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

                                        });
                                    </script><!-- /.col-lg-6 -->
                                    <div class="col-lg-2">




                                        <input name="Search"  class="btn btn-primary" type="submit" id="Save"  value="Search">
                                    </div><!-- /.col-lg-6 -->
                                </div><!-- /.row -->
                                Note: Please select short date rage to get effective result.
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
                        frmvalidator.addValidation("opt", "dontselect=0", "Please Select the Operator Name.");
                        frmvalidator.addValidation("ShortCodeID", "dontselect=0", "Please Select the Short Code.");
                        frmvalidator.addValidation("start_date", "req", "Select The Start Date.");
                        frmvalidator.addValidation("end_date", "req", "Select The End Date.");
                    </script>

                </div>

                <div class="panel-body">


                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->
                        <?php
                        if ($_REQUEST['Search'] == 'Search') {
                            $operator = $_REQUEST['opt'];
                            $ShortCode = $_REQUEST['ShortCodeNumber'];

                            $st = $_REQUEST['start_date'];
                            $et = $_REQUEST['end_date'];

                            $OperatorDB = FindOperatorDB($operator, 'SMS');
                            ?>


                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables">


                                <thead>
                                    <tr role="row">
                                        <th>Total SMS Sent Report.Operator:$operator . Reporting Date: <?php echo $st; ?> to <?php echo $et; ?></th>


                                    </tr>
                                    <tr role="row">
                                        <th>Short Code</th>
                                        <th>Date</th>
                                        <th>Two TK MT</th>


                                        <th>One TK MT</th>
                                        <th>Free MT</th>
                                        <th>Total</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?PHP
                                    $TotalTwoTKMT = 0;
                                    $TotalOneTKMT = 0;
                                    $TotalFreeTKMT = 0;


                                    $dateMonthYearArr = array();
                                    $fromDateTS = strtotime($st);
                                    $toDateTS = strtotime($et);

                                    for ($currentDateTS = $fromDateTS; $currentDateTS <= $toDateTS; $currentDateTS += (60 * 60 * 24)) {
                                        $currentDateStr = date("m/d/Y", $currentDateTS);
                                        $stTime = $currentDateStr . " 00:00:00 AM";
                                        $etTime = $currentDateStr . " 11:59:59 PM";




                                        $TwoTKMTQuery = "SELECT  count([srcMN]) as TwoTkMT FROM [DWH_1_0].[dbo].[SMSOutbox_Back] where srcMN ='02" . "$ShortCode'  and oparetor='$operator' and sentTime between '$stTime' and '$etTime'";
                                        $TwoTKResult = odbc_fetch_array(odbc_exec($cn, $TwoTKMTQuery));
                                        $TwoTKCount = $TwoTKResult['TwoTkMT'];

                                        echo $TwoTKMTQuery."<br/>";

                                        $OneTKMTQuery = "SELECT  count([srcMN]) as OneTkMT FROM [DWH_1_0].[dbo].[SMSOutbox_Back] where srcMN ='01" . "$ShortCode'  and oparetor='$operator' and sentTime between '$stTime' and '$etTime'";
                                        $OneTKResult = odbc_fetch_array(odbc_exec($cn, $OneTKMTQuery));
                                        $OneTKCount = $OneTKResult['OneTkMT'];

                                        $FreeTKMTQuery = "SELECT  count([srcMN]) as FreeTkMT FROM [DWH_1_0].[dbo].[SMSOutbox_Back] where (srcMN ='00" . "$ShortCode' or srcMN ='$ShortCode')  and oparetor='$operator' and sentTime between '$stTime' and '$etTime'";
                                        $FreeTKResult = odbc_fetch_array(odbc_exec($cn, $FreeTKMTQuery));
                                        $FreeTKCount = $FreeTKResult['FreeTkMT'];


                                        $TotalMT = $TwoTKCount + $OneTKCount + $FreeTKCount;

                                        $TotalTwoTKMT+=$TwoTKCount;
                                        $TotalOneTKMT+=$OneTKCount;
                                        $TotalFreeTKMT+=$FreeTKCount;
                                        ?>
                                        <tr>
                                            <td><?php echo $ShortCode; ?></td>
                                            <td><?php echo $currentDateStr; ?></td>

                                            <td><?php echo $TwoTKCount; ?></td>
                                            <td><?php echo $OneTKCount; ?></td>

                                            <td><?php echo $FreeTKCount; ?></td>
                                            <td><?php echo $TotalMT; ?></td>

                                        </tr>
                                        <?PHP
                                    }
                                }

//db_close($cn);
                                ?>
                            </tbody>

                        </table>
                        <table>
                            <?php $ActualTotalMT = $TotalTwoTKMT + $TotalOneTKMT + $TotalFreeTKMT; ?>
                            <tr>
                                <td>Total :</td><td><?php echo $TotalTwoTKMT; ?></td><td><?php echo $TotalOneTKMT; ?></td><td><?php echo $TotalFreeTKMT; ?></td><td><?php echo $ActualTotalMT; ?></td>

                            </tr>

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
