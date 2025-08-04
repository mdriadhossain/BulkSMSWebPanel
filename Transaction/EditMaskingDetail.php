<?php
require_once "Config/config.php";
require_once "Lib/lib.php";
$cn = ConnectDB();
$id = $_GET['id'];
$TransactionHistoryQuery = "SELECT  MaskingID,RequestingIP  FROM MaskingDetail ";
?>



<div id="page-content">
    <div id='wrap'>



        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>Create Masking Detail</h4>
                </div>
                <div class="panel-body">


                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->




                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" id="UserInfoID" name="CreateMaskingDetail">


                            
                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">MaskingID:</label>
                                <div class="col-sm-6">




                                    <input class="form-control" name="MaskingID" type="text" id="MaskingID" >
                                </div>
                            </div>

    
                            
                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">RequestingIP:</label>
                                <div class="col-sm-6">



                                    <input class="form-control" name="RequestingIP" type="text" id="RequestingIP" >
                                </div>
                            </div>
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                                
                            
                            
                            
                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label"></label>
                                <div class="col-sm-6">




                                    <input class="btn btn-primary" name="Save"  type="submit" id="Save"  value="Save">


                                </div>
                            </div>
                        </form>
						<script language="JavaScript" type="text/javascript">
                        var frmvalidator = new Validator("CreateMaskingDetail");
                       
                        //frmvalidator.addValidation("Status", "dontselect=0", "Please Select Status.");
                        frmvalidator.addValidation("MaskingID", "req", "Please Type MaskingID.");
						frmvalidator.addValidation("RequestingIP", "req", "Please Type RequestingIP.");
                        //frmvalidator.addValidation("end_date", "req", "Select The End Date.");</script>
						
                    </div>
                   
                    <?php
                    if ($_REQUEST['Save'] == 'Save') {
                        $UserName = $_REQUEST['UserName'];
                        $MaskingID = $_REQUEST['MaskingID'];
                        $RequestingIP = $_REQUEST['RequestingIP'];
                        


                        
                        //$lastUserID = getUserID($cn);
                        //$newUserID = $lastUserID + 1;



                        $insertMaskingDetailquery = "INSERT INTO MaskingDetail (UserName, MaskingID,RequestingIP) VALUES ('$UserName', '$MaskingID', '$RequestingIP')";
                        
                       $rs = odbc_exec($cn, $insertMaskingDetailquery);

                        

                           
                       
                       
                       
                            
                    }

            
                    ?>
                </div>


            </div>
        </div>
    </div> <!-- row -->
</div> <!-- container -->
</div> <!-- page-content -->

</div> <!-- wrap -->

</div> <!-- page-content -->
