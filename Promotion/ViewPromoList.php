<?php
require_once "Config/config.php";
require_once "Lib/lib.php";
$cn = ConnectDB();
?>

<script type="text/JavaScript">
    function confirmDelete(){
    var agree=confirm("Are you sure you want to delete this entry?");
    if (agree)
    {
    return true ;
    }
    else
    {
    return false ;
    }
    }
	
	
	    function confirmDetail(){
    var agree=confirm("Are you sure you want to view detail?");
    if (agree)
    {
    return true ;
    }
    else
    {
    return false ;
    }
    }
</script>

<?php
//echo $User;
if ($User == 'admin') {
    $userDetail = "select distinct(PromoListName) as 'PromoListName' from [BULKSMSPanel].dbo.PromoList order by PromoListName asc";
} else {

    $userDetail = "select distinct(PromoListName) as 'PromoListName' from [BULKSMSPanel].dbo.PromoList where UpdateBy='$User'";
}
$result_userDetail = odbc_exec($cn, $userDetail);
?>

<link rel="stylesheet" href="bootstrap-select/dist/css/bootstrap-select.css">
<script type="text/javascript" src="bootstrap-select/dist/js/bootstrap-select.js"></script>

<div id="page-content">
    <div id='wrap'>



        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>View Scheduled SMS List</h4>
                </div>
                <div class="panel-body">


                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->




                        <form class="form-horizontal" id="role" name="role" method="post" action="" >


                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Scheduled SMS List Name:</label>
                                <div class="col-sm-6">


                                    <select name="PromoListName" class="form-control selectpicker"  data-live-search="true" id="PromoListName">
                                        <option value=''>Select List</option>
                                        <?php
                                        while ($n = odbc_fetch_row($result_userDetail)) {
                                            $PromoListName = odbc_result($result_userDetail, "PromoListName");
                                            echo "<option value='$PromoListName'>$PromoListName</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

							
							 <?php 
                                         if (($User == 'Admin')){
                                             ?>
                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">All:</label>
                                <div class="col-sm-6">

                                    

                                    <input  name="chkAll" type="checkbox" id="chkAll" value="chk">
                                  
                                </div>
                            </div>
 <?php  } ?> 



                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label"></label>
                                <div class="col-sm-6">





                                    <input name="Save" class="btn btn-primary" type="submit" id="Save" value="Show">


                                </div>
                            </div>
                        </form>
                    </div>


                </div>

                <div class="panel-body">


                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->
                        <?PHP
                        if ($_REQUEST['Save'] == 'Show') {
                            $PromoListName = $_REQUEST['PromoListName'];
                            $check = $_REQUEST['chkAll'];
                            if ($check == "chk") {
							if($User =='admin'){
							
							$showUser = "select PromoListName,UserName,COUNT(MSISDN) as 'NumberOfList' from [BULKSMSPanel].dbo.PromoList group by PromoListName,UserName";
							}else{
							exit;
							
							}
                                
    } else {
                                $showUser = "select PromoListName,UserName,COUNT(MSISDN) as 'NumberOfList' from [BULKSMSPanel].dbo.PromoList where PromoListName='$PromoListName' group by PromoListName,UserName";
    }
                            $result_showUser = odbc_exec($cn, $showUser);
                            ?>

                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables">


                                <thead>
                                    <tr role="row">
                                        <th>Scheduled SMS List Name</th>
                                                <th>User Name</th>
                                                <th>Number of MSISDN</th>
                                                    <th>Detail</th>
                                                    <th>DELETE</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?PHP
                                    while ($row = odbc_fetch_array($result_showUser)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $row[PromoListName]; ?></td>
                                                            <td><?php echo $row[UserName]; ?></td>
                                                            <td><?php echo $row[NumberOfList]; ?></td>
                                                            
															<td><a href="#" onClick='NewWindow("Promotion/ViewPromoListDetail.php?PromoListName=<?php echo $row[PromoListName]; ?>&UserName=<?php echo $row[UserName]; ?>", "name", "1080", "800", "no");
                                                                    return false;'><button type="button" class="btn btn-success btn-sm">Detail</button></a></td>


                                                    <td><a href="Promotion/deletePromoList.php?PromoListName=<?php echo $row[PromoListName]; ?>&UserName=<?php echo $row[UserName]; ?>" onClick="return confirmDelete();"><button type="button" class="btn btn-danger">Delete</button></a></td>
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
