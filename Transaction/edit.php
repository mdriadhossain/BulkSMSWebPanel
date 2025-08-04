<?php
require_once "../Config/config.php";
require_once "../Lib/lib.php";
$cn = ConnectDB();
$id = $_GET['id'];
$EditSql = "SELECT  MaskingID,RequestingIP  FROM MaskingDetail where ID='$id'";

$EditQuery = odbc_exec($cn, $EditSql);
$result = odbc_fetch_array($EditQuery);

$MaskingID = $result['MaskingID'];
$RequestingIP = $result['RequestingIP'];
//exit;
?>
<link rel="stylesheet" href="../assets/css/styles.css?=121">
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>

<link href='../assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='styleswitcher'>
<link href='../assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='headerswitcher'>

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries. Placeholdr.js enables the placeholder attribute -->
<!--[if lt IE 9]>
<link rel="stylesheet" href="../assets/css/ie8.css">
        <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
<script type="text/javascript" src="../assets/plugins/charts-flot/excanvas.min.js"></script>
<![endif]-->

<!-- The following CSS are included as plugins and can be removed if unused-->

<link rel='stylesheet' type='text/css' href='../assets/plugins/form-daterangepicker/daterangepicker-bs3.css' />
<link rel='stylesheet' type='text/css' href='../assets/plugins/fullcalendar/fullcalendar.css' />
<link rel='stylesheet' type='text/css' href='../assets/plugins/form-markdown/css/bootstrap-markdown.min.css' />
<link rel='stylesheet' type='text/css' href='../assets/plugins/codeprettifier/prettify.css' />
<link rel='stylesheet' type='text/css' href='../assets/plugins/form-toggle/toggles.css' />
<div id="page-content">
    <div id='wrap'>

        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>Edit Masking Detail</h4>
                </div>
                <div class="panel-body">


                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->


                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" id="UserInfoID" name="CreateMaskingDetail">

                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">MaskingID:</label>
                                <div class="col-sm-6">
                                    
                                    <input class="form-control" name="MaskingID" type="text" id="MaskingID" value=<?php echo $MaskingID; ?>>
                                
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">RequestingIP:</label>
                                <div class="col-sm-6">
                                    
                                    <input class="form-control" name="RequestingIP" type="text" id="RequestingIP" value=<?php echo $RequestingIP; ?>>
                                
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label"></label>
                                <div class="col-sm-6">
                                    
                                    <input class="btn btn-primary" name="Save"  type="submit" id="Save"  value="Update">

                                </div>
                            </div>
                        </form>
                        <script language="JavaScript" type="text/javascript">
                            var frmvalidator = new Validator("CreateMaskingDetail");

                            
                            frmvalidator.addValidation("MaskingID", "req", "Please Type MaskingID.");
                            frmvalidator.addValidation("RequestingIP", "req", "Please Type RequestingIP.");
                            
                    </div>

                    <?php
                    if ($_REQUEST['Save'] == 'Update') {

                        $MaskingID = $_REQUEST['MaskingID'];
                        $RequestingIP = $_REQUEST['RequestingIP'];

                        echo $UpdateMaskingDetailquery = "UPDATE MaskingDetail SET MaskingID ='$MaskingID', RequestingIP ='$RequestingIP' where ID='$id'";

                        $rs = odbc_exec($cn, $UpdateMaskingDetailquery);

                        $url = base_url() . "index.php?parent=ViewMaskingDetail";

                        popup('Succesfully Edited.', $url);
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
  <script type='text/javascript' src='../assets/js/jquery-1.10.2.min.js'></script>
    <script type='text/javascript' src='../assets/js/jqueryui-1.10.3.min.js'></script>
    <script type='text/javascript' src='../assets/js/bootstrap.min.js'></script>
    <script type='text/javascript' src='../assets/js/enquire.js'></script>
    <script type='text/javascript' src='../assets/js/jquery.cookie.js'></script>
    <script type='text/javascript' src='../assets/js/jquery.nicescroll.min.js'></script>
    <script type='text/javascript' src='../assets/plugins/codeprettifier/prettify.js'></script>
    <script type='text/javascript' src='../assets/plugins/easypiechart/jquery.easypiechart.min.js'></script>
    <script type='text/javascript' src=../'assets/plugins/sparklines/jquery.sparklines.min.js'></script>
    <script type='text/javascript' src='../assets/plugins/form-toggle/toggle.min.js'></script>
    <script type='text/javascript' src='../assets/js/tablee.js'></script>
    <script type='text/javascript' src='../assets/js/placeholdr.js'></script>
    <script type='text/javascript' src='../assets/js/application.js'></script>
    <script type='text/javascript' src='../assets/demo/demo.js'></script>