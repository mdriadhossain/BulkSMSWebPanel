<?php
$cn = ConnectDB();
?>

<div id="page-content">
    <div id='wrap'>



        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>Total SMS Sent Report</h4>
                </div>
                <div class="panel-body">


                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->




                        <form class="form-horizontal" name="MTSearch" method='POST' action="" id="TotalSMSSentReportID">


                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Select Operator :</label>
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

                        var frmvalidator = new Validator("TotalSMSSentReportID");
                        frmvalidator.addValidation("opt", "dontselect=0", "Please Select the Operator Name.");
                        /* frmvalidator.addValidation("start_date","req","Select The Start Date.");
                         frmvalidator.addValidation("end_date","req","Select The End Date.");*/
                    </script>
                </div>

                <div class="panel-body">


                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->
                        <?php
                        if ($_REQUEST['Search'] == 'Search') {
                            $operator = $_REQUEST['opt'];
                            $DayType = $_REQUEST['DayType'];

                            /* $st=$_REQUEST['start_date'];
                              $et=$_REQUEST['end_date'];
                              $stTime = $st.' 00:00:00.000';
                              $etTime = $et.' 23:59:59.000'; */

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


                            $OperatorDB = FindOperatorDB($operator, 'SMS');
                            ?>


                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables">


                                <thead>
                                    <tr role="row">
                                        <th>Total SMS Sent Report.Reporting Date: <?php echo $stTime; ?> to <?php echo $etTime; ?></th>


                                    </tr>
                                    <tr role="row">
                                        <th>Operator</th>
                                        <th>Short Code</th>
                                        <th>Two TK MT</th>


                                        <th>One TK MT</th>
                                        <th>Free MT</th>
                                        <th>Total</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?PHP
                                    $OperatorQuery = "select distinct(ShortCode) as ShortCode  from dbo.Keyword where Operator='$operator'";
                                    if ($rs = odbc_exec($cn, $OperatorQuery)) {
                                        $NumberOfShortcode = odbc_num_rows($rs) + 1;
                                        //echo '<tr>';
                                        //echo '<td rowspan=' . $NumberOfShortcode . ' >' . $operator . '</td>';
                                        //echo '</tr>';
                                        while ($row = odbc_fetch_array($rs)) {

                                            $ShortCode = $row[ShortCode];
                                            ?>
                                            <tr>
                                                <td><?php echo $operator; ?></td>

                                                <?php
                                                if ($DayType == "Today") {
                                                    $TwoTKMTQuery = "SELECT  count([srcMN]) as TwoTkMT FROM [$OperatorDB].[dbo].[SMSOutbox_Back] where srcMN ='02" . "$ShortCode' and sentTime between '$stTime' and '$etTime'";
                                                    $TwoTKResult = odbc_fetch_array(odbc_exec($cn, $TwoTKMTQuery));
                                                    $TwoTKCount = $TwoTKResult['TwoTkMT'];

                                                    $OneTKMTQuery = "SELECT  count([srcMN]) as OneTkMT FROM [$OperatorDB].[dbo].[SMSOutbox_Back] where srcMN ='01" . "$ShortCode' and sentTime between '$stTime' and '$etTime'";
                                                    $OneTKResult = odbc_fetch_array(odbc_exec($cn, $OneTKMTQuery));
                                                    $OneTKCount = $OneTKResult['OneTkMT'];

                                                    $FreeTKMTQuery = "SELECT  count([srcMN]) as FreeTkMT FROM [$OperatorDB].[dbo].[SMSOutbox_Back] where (srcMN ='00" . "$ShortCode' or srcMN ='$ShortCode') and sentTime between '$stTime' and '$etTime'";
                                                    $FreeTKResult = odbc_fetch_array(odbc_exec($cn, $FreeTKMTQuery));
                                                    $FreeTKCount = $FreeTKResult['FreeTkMT'];

                                                    /* echo $TwoTKMTQuery;echo "<br/>";
                                                      echo $OneTKMTQuery;echo "<br/>";
                                                      echo $FreeTKMTQuery;echo "<br/>"; */
                                                } else {

                                                    $TwoTKMTQuery = "SELECT  count([srcMN]) as TwoTkMT FROM [DWH_1_0].[dbo].[SMSOutbox_Back] where srcMN ='02" . "$ShortCode'  and oparetor='$operator' and sentTime between '$stTime' and '$etTime'";
                                                    $TwoTKResult = odbc_fetch_array(odbc_exec($cn, $TwoTKMTQuery));
                                                    $TwoTKCount = $TwoTKResult['TwoTkMT'];

                                                    $OneTKMTQuery = "SELECT  count([srcMN]) as OneTkMT FROM [DWH_1_0].[dbo].[SMSOutbox_Back] where srcMN ='01" . "$ShortCode'  and oparetor='$operator' and sentTime between '$stTime' and '$etTime'";
                                                    $OneTKResult = odbc_fetch_array(odbc_exec($cn, $OneTKMTQuery));
                                                    $OneTKCount = $OneTKResult['OneTkMT'];

                                                    $FreeTKMTQuery = "SELECT  count([srcMN]) as FreeTkMT FROM [DWH_1_0].[dbo].[SMSOutbox_Back] where (srcMN ='00" . "$ShortCode' or srcMN ='$ShortCode')  and oparetor='$operator' and sentTime between '$stTime' and '$etTime'";
                                                    $FreeTKResult = odbc_fetch_array(odbc_exec($cn, $FreeTKMTQuery));
                                                    $FreeTKCount = $FreeTKResult['FreeTkMT'];
                                                }

                                                $TotalMT = $TwoTKCount + $OneTKCount + $FreeTKCount;
                                                ?>

                                                <td><?php echo $ShortCode; ?></td>
                                                <td><?php echo $TwoTKCount; ?></td>

                                                <td><?php echo $OneTKCount; ?></td>
                                                <td><?php echo $FreeTKCount; ?></td>

                                                <td><?php echo $TotalMT; ?></td>


                                            </tr>
                                            <?PHP
                                        }
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
