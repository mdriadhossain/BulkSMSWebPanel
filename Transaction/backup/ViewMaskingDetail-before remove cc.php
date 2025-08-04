<?php  session_start(); 

require_once "Config/config.php";
require_once "Lib/lib.php";
$cn = ConnectDB();
$userDetail = "SELECT UserID, UserName FROM BULKSMSPanel.dbo.UserInfo Order By UserName ASC";
$result_userDetail = odbc_exec($cn, $userDetail);
$User=strtoupper($User);

?>

<link rel="stylesheet" href="bootstrap-select/dist/css/bootstrap-select.css">
<script type="text/javascript" src="bootstrap-select/dist/js/bootstrap-select.js"></script>

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
                            <?php
                            if (strtoupper($User) == 'ADMIN') {
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
                            }
                            ?>  

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


                </div>
                <div class="panel-body">
                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->
                        <?php
                        if ($_REQUEST['Search'] == 'GETReport') {

                           $UserName = strtoupper($_REQUEST['UserName']);                                                      
                           
                           // echo "UserName=".$UserName."|User=". $User;
                            
                            if (($User == 'ADMIN') and $UserName != null) {
                                $ViewMaskingDetailQuery = "SELECT  ID,UserName,MaskingID,RequestingIP,[MaskingForGP],[MaskingForRO],[MaskingForBL],[MaskingForAT],[MaskingForTT],[MaskingForCC]  FROM MaskingDetail WHERE  UserName='$UserName'";
                            } elseif (($User == 'ADMIN')and $UserName == null) {
                                $ViewMaskingDetailQuery = "SELECT  ID,UserName,MaskingID,RequestingIP,[MaskingForGP],[MaskingForRO],[MaskingForBL],[MaskingForAT],[MaskingForTT],[MaskingForCC]  FROM MaskingDetail ";
                            } else {
                                $ViewMaskingDetailQuery = "SELECT  ID,UserName,MaskingID,RequestingIP,[MaskingForGP],[MaskingForRO],[MaskingForBL],[MaskingForAT],[MaskingForTT],[MaskingForCC]  FROM MaskingDetail WHERE  UserName='$User'";
                            }
                            //echo $ViewMaskingDetailQuery;
                            // $_SESSION['xls_query'] = $ViewMaskingDetailQuery;
                            ?>

                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables">

                                <thead>

                                    <tr role="row">
                                        <th>UserName</th>
                                        <th>Masking ID</th>
                                        <th>Requesting IP</th>
                                        <th>Masking For GP</th>
                                        <th>Masking For RO</th>
                                        <th>Masking For BL</th>
                                        <th>Masking For AT</th>
                                         <th>Masking For TT</th>
                                        <th>Masking For CC</th>
                                        
                                        <?php
                                        if (($User == 'ADMIN')) {
                                            ?>
                                            <th>EDIT</th>
                                            <th>DELETE</th>
                                        <?php } ?> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?PHP
                                    $rs = odbc_exec($cn, $ViewMaskingDetailQuery);


                                    while ($row = odbc_fetch_array($rs)) {
                                        //print_r($row);
                                        $UserName = $row['UserName'];
                                        //$Keyword=$row['Keyword'];
                                        $MaskingID = $row['MaskingID'];
                                        $RequestingIP = $row['RequestingIP'];                                                                                                                     
                                        
                                        ?>
                                        <tr>
                                            <td><?php echo $UserName; ?></td>
                                            <td><?php echo $MaskingID; ?></td>
                                            <td><?php echo $RequestingIP; ?></td>
                                            
                                            <td><?php echo $row['MaskingForGP']; ?></td>
                                            <td><?php echo $row['MaskingForRO']; ?></td>
                                            <td><?php echo $row['MaskingForBL']; ?></td>
                                            <td><?php echo $row['MaskingForAT']; ?></td>
                                            <td><?php echo $row['MaskingForTT']; ?></td>
                                            <td><?php echo $row['MaskingForCC']; ?></td>
                                                                                                                                                                                
                                            <?php
                                            if ($User == 'ADMIN') {
                                                ?>
                                                <td><a href="Transaction/edit.php?id=<?php echo $row['ID']; ?>" onClick="return confirmDelete();"><button type="button" class="btn btn-primary">Edit</button></a></td>
                                                <td><a href="Transaction/delete.php?id=<?php echo $row['ID']; ?>&tbl=MaskingDetail" onClick="return confirmDelete();"><button type="button" class="btn btn-danger">Delete</button></a></td>
                                            <?php } ?>
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


