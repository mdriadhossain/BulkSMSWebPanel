<?php
session_start();
error_reporting(0);
set_time_limit(0);
//echo "From Header.php";
require_once "Config/config.php";
require_once "Lib/lib.php";
?>
<?php

  $cn = ConnectDB();
  $CurrentSMSQuery = "SELECT  NumberOfSMS FROM CurrentStatus WHERE  UserName='$User'";									   
  $result_CurrentSMS = odbc_fetch_array(odbc_exec($cn, $CurrentSMSQuery));
  $CurrentSMS=$result_CurrentSMS['NumberOfSMS'];

  $_SESSION['CurrentSMSBalance']=$CurrentSMS;
  
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>SMS Panel</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Avant">
        <meta name="author" content="The Red Team">

        <!-- <link href="assets/less/styles.less" rel="stylesheet/less" media="all">  -->
        <link rel="stylesheet" href="assets/css/styles.css?=121">
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>


        <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='styleswitcher'>

        <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='headerswitcher'>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries. Placeholdr.js enables the placeholder attribute -->
        <!--[if lt IE 9]>
        <link rel="stylesheet" href="assets/css/ie8.css">
                <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
                <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
        <script type="text/javascript" src="assets/plugins/charts-flot/excanvas.min.js"></script>
        <![endif]-->

        <!-- The following CSS are included as plugins and can be removed if unused-->

        <link rel='stylesheet' type='text/css' href='assets/plugins/datatables/dataTables.css' />
        <link rel='stylesheet' type='text/css' href='assets/plugins/codeprettifier/prettify.css' />
        <link rel='stylesheet' type='text/css' href='assets/plugins/form-toggle/toggles.css' />

<!-- <script type="text/javascript" src="assets/js/less.js"></script> -->
        <script type='text/javascript' src='assets/js/jquery-1.10.2.min.js'></script>
        <script type='text/javascript' src='assets/js/jqueryui-1.10.3.min.js'></script>
        <script type='text/javascript' src='assets/js/bootstrap.min.js'></script>
        <script type='text/javascript' src='assets/js/enquire.js'></script>
        <script type='text/javascript' src='assets/js/jquery.cookie.js'></script>
        <script type='text/javascript' src='assets/js/jquery.nicescroll.min.js'></script>
        <script type='text/javascript' src='assets/plugins/codeprettifier/prettify.js'></script>
        <script type='text/javascript' src='assets/plugins/easypiechart/jquery.easypiechart.min.js'></script>
        <script type='text/javascript' src='assets/plugins/sparklines/jquery.sparklines.min.js'></script>
        <script type='text/javascript' src='assets/plugins/form-toggle/toggle.min.js'></script>

        <script type='text/javascript' src='assets/plugins/jqueryui-timepicker/jquery.ui.timepicker.min.js'></script>
        <script type='text/javascript' src='assets/plugins/form-daterangepicker/daterangepicker.min.js'></script>
        <script type='text/javascript' src='assets/plugins/form-datepicker/js/bootstrap-datepicker.js'></script>
        <script type='text/javascript' src='assets/plugins/form-daterangepicker/moment.min.js'></script>

        <script type='text/javascript' src='assets/plugins/form-datetimepicker/bootstrap-datetimepicker.js'></script>


        <script type='text/javascript' src='assets/plugins/datatables/jquery.dataTables.min.js'></script>
        <script type='text/javascript' src='assets/plugins/datatables/dataTables.bootstrap.js'></script>
        <script type='text/javascript' src='assets/demo/demo-datatables.js'></script>
        <script type='text/javascript' src='assets/js/placeholdr.js'></script>
        <script type='text/javascript' src='assets/js/application.js'></script>
        <script type='text/javascript' src='assets/demo/demo.js'></script>
        <script language="JavaScript" src="js/form_validatorv31.js" type="text/javascript"></script>
        <script language="JavaScript" src="js/global.js" type="text/javascript"></script>

        <script language="JavaScript" src="js/AjaxFunctionHandler.js" type="text/javascript"></script>
        <script language="JavaScript" src="js/jquerysession.js" type="text/javascript"></script>
<!--        <script language="JavaScript" src="js/jquery1.js" type="text/javascript"></script>
        <script language="JavaScript" src="js/validator.js" type="text/javascript"></script>
        <script language="JavaScript" src="js/jquery_004.js" type="text/javascript"></script>-->

    </head>

    <body class="">
        <header class="navbar navbar-inverse navbar-fixed-top" role="banner">
		
		        <a id="leftmenu-trigger" class="tooltips" data-toggle="tooltip" data-placement="right" title="Toggle Sidebar"></a>
        <a id="rightmenu-trigger" class="tooltips" data-toggle="tooltip" data-placement="left" title="Toggle Infobar"></a>

            <div class="navbar-header pull-left">
                <!--  <a class="navbar-brand" href="index.htm">Avant</a>-->
				<h align="center" style="color:#FFF;"><b>Available SMS Balance:  </b><span class="badge"><?php echo $CurrentSMS;?></span></h>
            </div>

            <?php
            if (isset($_SESSION['Login']) && $_SESSION['Login'] == "True") {
                ?>

                <ul class="nav navbar-nav pull-right toolbar">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle username" data-toggle="dropdown"><span class="hidden-xs">   <?php
                                if ($_SESSION['User']) {
								
                                    $cn = ConnectDB();
                                    $UserName = $_SESSION['User'];
                                    $showUser = "select HeaderText from UserInfo where UserName='$UserName'";
                                    $result_showUser = odbc_exec($cn, $showUser);
                                    echo $HeaderTextValue = odbc_result($result_showUser, "HeaderText");
                                } else {
                                    echo "SMS Panel";
                                }
                                ?><i class="fa fa-caret-down"></i></span><img src="assets/demo/avatar/dangerfield.png" alt="Dangerfield" /></a>

                        <ul class="dropdown-menu userinfo arrow">

                            <li class="username">
                                <a href="#">
                                    <div class="pull-left"><img src="assets/demo/avatar/dangerfield.png" alt="Jeff Dangerfield"/></div>
                                    <div class="pull-right"><h5>Hello, <?php echo $UserName; ?></h5></div>
                                </a>
                            </li>



                            <li class="userlinks">
                                <ul class="dropdown-menu">
                                     <li><a href="index.php?parent=ChangePassword" class="text-right">Change Password</a></li>
                                     <li><a href="index.php?parent=Logout" class="text-right">Sign Out</a></li>

  									 
                                </ul>
                            </li>
                        </ul>
                    </li>

                <?php }
                ?>
            </ul>
        </header>