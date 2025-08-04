<?php
require_once "Config/config.php";
require_once "Lib/lib.php";
$cn = ConnectDB();


$userDetail = "SELECT UserID, UserName FROM BULKSMSPanel.dbo.UserInfo where Username<>'admin' Order By UserName ASC";
$result_userDetail = odbc_exec($cn, $userDetail);

?>

<div id="page-content">
    <div id='wrap'>
        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>View Masking Detail</h4>
                </div>
                <div class="panel-body">
                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="KeywordSearch" >
                            

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
                            
                          


                            <!--                            <div class="form-group">
                                                            <label for="focusedinput" class="col-sm-3 control-label">Select Channel Type:</label>
                                                            <div class="col-sm-6">
                            
                            
                                                                <select name="ChannelType" id="channelID" type="text" class="form-control" >
                                                                    <option value=''>Select Channel</option>
                                                                    <option value="WAP">WAP</option>
                                                                    <option value="SMS">SMS</option>
                                                                    <option value="IVR">IVR</option>
                                                                    <option value="WEB">WEB</option>
                            
                                                                </select>
                                                            </div>
                                                        </div>-->

                         
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
                    <script language="JavaScript" type="text/javascript">
                        var frmvalidator = new Validator("KeywordSearch");
                        frmvalidator.addValidation("opt", "dontselect=0", "Please Select the Operator.");
                        frmvalidator.addValidation("Status", "dontselect=0", "Please Select Status.");
                        frmvalidator.addValidation("start_date", "req", "Select The Start Date.");
                        frmvalidator.addValidation("end_date", "req", "Select The End Date.");</script>

                </div>
                <div class="panel-body">
                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->
                        <?php
                        if ($_REQUEST['Search'] == 'GETReport') {
                 
                             $UserName = $_REQUEST['UserName'];
                            
                            
                                //$UserName = strtoupper($_SESSION['User']);

                                        if (($UserName != 'admin') || ($UserName <> 'ADMIN'))
                                            $TransactionHistoryQuery = "SELECT  UserName,MaskingID,RequestingIP  FROM ExpenceHistory ";
                                        else
                                            $TransactionHistoryQuery = "SELECT  UserName,NumberOfSMS,Date  FROM ExpenceHistory WHERE  UserName='$UserName'";

                                        //echo $TransactionHistoryQuery;

                            
                            ?>
                        <?php
//                        $cn = ConnectDB();
//                              $rs = odbc_exec($cn, $TransactionHistoryQuery);
//                             //$AccountValue = odbc_fetch_array($AccountValResult);
//
//                                    while ($row = odbc_fetch_array($rs)) {
//                                        
//                                        print_r($row);
//                                    }
//                                    exit;
                        ?>
                        
                        
                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables">

                                <thead>

                                    <tr role="row">
                                        <th>UserName</th>
                                        <th>Number Of SMS</th>
                                        <th>Date</th
                                    </tr>
                                </thead>
                                <tbody>
                                    <?PHP
                                    //$cn = ConnectDB();
                                    //$SQL = "SELECT writeTime, srcMN,dstMN,msg SMSText FROM smsoutbox where srcMN='$ShortCode' and writeTime >= '$stDate' and  writeTime<='$etDate 23:59:59' $limit";
                                    //$SQL = "Select UserName from TransactionHistory ";
                                   $rs = odbc_exec($cn, $TransactionHistoryQuery);
                             //$AccountValue = odbc_fetch_array($AccountValResult);

                                    while ($row = odbc_fetch_array($rs)) {
                                        //print_r($row);
                                        $UserName = $row['UserName'];
                                        //$Keyword=$row['Keyword'];
                                        $NumberOfSMS = $row['NumberOfSMS'];
                                        $Date = $row['Date'];
                                        
                                        
                                        
                                        ?>
                                        <tr>
                                            <td><?php
                                                echo $UserName;
                                                ;
                                                ?></td>
                                            <td><?php echo $NumberOfSMS; ?></td>
                                            <td><?php echo $Date; ?></td>
                                           
                                           

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


