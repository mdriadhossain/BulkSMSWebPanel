<?php session_start(); ?>
<?php
require_once "Config/config.php";
require_once "Lib/lib.php";
$cn = ConnectDB();


$userDetail = "SELECT UserID, UserName FROM BULKSMSPanel.dbo.UserInfo where Username<>'admin' Order By UserName ASC";
$result_userDetail = odbc_exec($cn, $userDetail);
?>

<link rel="stylesheet" href="bootstrap-select/dist/css/bootstrap-select.css">
<script type="text/javascript" src="bootstrap-select/dist/js/bootstrap-select.js"></script>

<div id="page-content">
    <div id='wrap'>
        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>View Template  Text</h4>
                </div>
                <div class="panel-body">
                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="KeywordSearch" >


                            <?php
                            if ($User == 'Admin') {
                                ?>

                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label">User Name</label>
                                    <div class="col-sm-6">



                                        <select class="form-control selectpicker"  data-live-search="true"  name="UserName" id="UserName">
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

                            $UserName = $_REQUEST['UserName'];

                            if (($User == 'Admin') and $UserName != null) {
                                $ViewTemplateQuery = "SELECT  id,UserName,TemplateSMS,UploadedBy,UploadedDate  FROM TemplateText WHERE  UserName='$UserName' ";
                            } elseif (($User == 'Admin')) {

                                $ViewTemplateQuery = "SELECT  id,UserName,TemplateSMS,UploadedBy,UploadedDate FROM TemplateText ";
                            } else {
                                $ViewTemplateQuery = "SELECT  id,UserName,TemplateSMS,UploadedBy,UploadedDate  FROM TemplateText WHERE  UserName='$User' ";
                            }
                            ?>

                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables">

                                <thead>

                                    <tr role="row">
                                        <th>User Name</th>
                                        <th>TemplateSMS</th>
                                        <th>UploadedBy</th>                                        
                                        <th>UploadedDate</th> 
                                        <th>EDIT</th>
                                        <th>DELETE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?PHP
                                    $serverName = "localhost";
                                    // $serverName = "116.212.108.50";
                                    $database = "BULKSMSPanel";
                                    $uid = 'sa';
                                    $pwd = 'bmWfjg88';
                                    try {
                                        $conn = new PDO(
                                                "sqlsrv:server=$serverName;Database=$database", $uid, $pwd, array(
                                            //PDO::ATTR_PERSISTENT => true,
                                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                                                )
                                        );
                                    } catch (PDOException $e) {
                                        die("Error connecting to SQL Server: " . $e->getMessage());
                                    }




//                                    $rs = odbc_exec($cn, $ViewTemplateQuery);

                                    foreach ($conn->query($ViewTemplateQuery) as $row) {
//                                    while ($row = odbc_fetch_array($rs)) {

                                        $UserName = $row['UserName'];

                                        $TemplateSMS = $row['TemplateSMS'];
                                        $UploadedBy = $row['UploadedBy'];
                                        $UploadedDate = $row['UploadedDate'];
                                        ?>
                                        <tr>
                                            <td><?php echo $UserName; ?></td>

                                            <td><?php echo $TemplateSMS; ?></td>


                                            <td><?php echo $UploadedBy; ?></td>
                                            <td><?php echo $UploadedDate; ?></td>
                                            <td><a href="#" onClick='NewWindow("Promotion/sms_edit.php?id=<?php echo $row['id']; ?>", "name", "600", "600", "no");
                                                            return false;'><input class="btn btn-primary" name="Save" type="submit" id="Save" value="Edit"></a></td>


                                            <td><a href="Promotion/delete.php?id=<?php echo $row['id']; ?>&tbl=TemplateText" onclick="return confirm('Do you really want to delete this record?')"><button type="button" class="btn btn-danger">Delete</button></a></td>







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


