<?php session_start(); ?>
<?php
require_once "Config/config.php";
require_once "Lib/lib.php";
$cn = ConnectDB();

$userDetail = "SELECT UserID, UserName FROM BULKSMSPanel.dbo.UserInfo";
$result_userDetail = odbc_exec($cn, $userDetail);
?>
<div id="page-content">
    <div id='wrap'>

        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>Real Time SMS Sent Report</h4>
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

                                        <select class="form-control" name="UserName" id="UserName">
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

                                        <select class="form-control" name="UserName" id="UserName">
                                            <option value=''>Select User</option>
                                            <option value='<?php echo $User; ?>'><?php echo $User; ?></option>

                                        </select>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>  


                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label"></label>
                                <div class="col-sm-6">

                                    <input name="Search"  class="btn btn-primary" type="submit" id="Save"  value="Search">

                                </div>
                            </div>
                        </form>
                    </div>
                    <script language="JavaScript" type="text/javascript">
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
                            $cn = ConnectDB();
                            
                            $TotalQueQuery = "select count(ID) as TotalQueCount from BULKSMSGateway_1_0.[dbo].[SMSOutbox] where msgStatus='QUE' and srcAccount='$UserNameID'";
                            
                            $result_TotalPostedQuery = odbc_exec($cn, $TotalQueQuery);
                            $rowQue = odbc_fetch_array($result_TotalPostedQuery);
                            
                            $TotalNumberOfQue=$rowQue['TotalQueCount'];
                            
                            
                            $TotalPostedQuery = "select count(ID) as TotalPostedCount from BULKSMSGateway_1_0.[dbo].[SMSOutbox_Back] where srcAccount='$UserNameID' ";
                           
                            $result_TotalPostedQuery = odbc_fetch_array(odbc_exec($cn, $TotalPostedQuery));
                            
                            $TotalNumberOfPost=$result_TotalPostedQuery['TotalPostedCount'];
                            
                            ?>

                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables">


                                <thead>

                                    <tr role="row">
                                        <th>User Name</th>                                        
                                        <th>Number of QUE</th>
                                        <th>Number of Delivered</th>
                                        <th>QUE Detail</th>
                                        <th>Delivered Detail</th>

                                    </tr>
                                </thead>
                                <tbody>


                                    <tr>
                                        <?php
                                      
                                            ?>
                                            <td><?php echo $UserNameID; ?></td>
                                            <td><?php echo $TotalNumberOfQue; ?></td>
                                            <td><?php echo $TotalNumberOfPost ?></td>
                                            
                                            <td><a href="#" onClick='NewWindow("Report/RealTimeSMSLogDetailReport.php?Param=QUE&UserName=<?php echo $UserNameID; ?>", "name", "1080", "800", "no");
                                                            return false;'><button type="button" class="btn btn-success btn-sm">Detail</button></a></td>
                                            <td><a href="#" onClick='NewWindow("Report/RealTimeSMSLogDetailReport.php?Param=POSTED&UserName=<?php echo $UserNameID; ?>", "name", "1080", "800", "no");
                                                            return false;'><button type="button" class="btn btn-success btn-sm">Detail</button></a></td>


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
