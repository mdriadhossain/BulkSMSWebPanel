<?php
require_once "../Config/config.php";
require_once "../Lib/lib.php";
$cn = ConnectDB();
$id = $_GET['id'];
 $EditSql = "SELECT  TemplateSMS  FROM TemplateText where id='$id'";

$EditQuery = odbc_exec($cn, $EditSql);
$result = odbc_fetch_array($EditQuery);

 $TemplateSMS = $result['TemplateSMS'];

//exit;
?>
<link rel="stylesheet" href="../assets/css/styles.css?=121">
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>

<link href='../assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='styleswitcher'>
<link href='../assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='headerswitcher'>

<script language="JavaScript" src="../js/jscal2.js" type="text/javascript"></script>


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
                    <h4>Edit Template Text</h4>
                </div>
                <div class="panel-body">


                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->


                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" id="UserInfoID" name="CreateMaskingDetail">

                          
							
							<div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Template SMS Text</label>
                                <div class="col-sm-6">



                                    <textarea class="form-control" name="TemplateSMS" id="TemplateSMS"  cols="100" rows="3" onKeyDown="limitText(this.form.SMSText,
                                                    this.form.countdown, 160);"onKeyUp="limitText(this.form.SMSText, this.form.countdown, 160);"><?php echo $TemplateSMS; ?></textarea>
                                    <font size="1">(Maximum characters: 160)</font>
                                </div>
                            </div>
							
							
							

                            


                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label"></label>
                                <div class="col-sm-6">
                                    
                                    <input class="btn btn-primary" name="Submit"  type="submit" id="Save"  value="Update">

                                </div>
                            </div>
                        </form>
                        <script language="JavaScript" type="text/javascript">
                            var frmvalidator = new Validator("CreateMaskingDetail");

                            
                            frmvalidator.addValidation("MaskingID", "req", "Please Type MaskingID.");
                            
                    </div>

                    <?php
                    if ($_REQUEST['Submit'] == 'Update') {
    //echo "okayyy";
    //exit;

     $TemplateSMS = $_REQUEST['TemplateSMS'];
   


    $UpdateSMSTextquery = "UPDATE TemplateText SET TemplateSMS ='$TemplateSMS' where id='$id'";
                        //exit;
    $rs = odbc_exec($cn, $UpdateSMSTextquery);

   echo "<script>
alert('Succesfully Edited.');

</script>";
    $url = base_url() . "index.php?parent=ViewTemplate";

   
	popup('Succesfully Edited.', $url);
	//popup('Succesfully Edited.');
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
