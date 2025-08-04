<style> div.ViewPanel{width:100%;height:600px;overflow:auto !important;}</style>
<div class="ViewPanel">
    <?php
    require_once "../header.php";
    require_once "../Lib/lib.php";

    $UserNameID = $_REQUEST["UserName"];
    $TransactionId = $_REQUEST["TransactionId"];
//    $etTime = $_REQUEST["etTime"];
//    $status = $_REQUEST["status"];
//    $TransmobileNo = $_REQUEST["TransmobileNo"];
    ?>

    <!DOCTYPE html>
    <html lang="bn">
        <head>
            <meta charset="UTF-8">
            <title>Avant</title>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <meta name="description" content="Avant">
            <meta name="author" content="The Red Team">

            <!-- <link href="assets/less/styles.less" rel="stylesheet/less" media="all">  -->
            <link rel="stylesheet" href="../assets/css/styles.css?=121">
            <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>


            <link href='../assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='styleswitcher'>

            <link href='../assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='headerswitcher'>

            <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries. Placeholdr.js enables the placeholder attribute -->
            <!--[if lt IE 9]>
            <link rel="stylesheet" href="assets/css/ie8.css">
                    <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
                    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
            <script type="text/javascript" src="assets/plugins/charts-flot/excanvas.min.js"></script>
            <![endif]-->

            <!-- The following CSS are included as plugins and can be removed if unused-->

            <link rel='stylesheet' type='text/css' href='../assets/plugins/datatables/dataTables.css' />
            <link rel='stylesheet' type='text/css' href='../assets/plugins/codeprettifier/prettify.css' />
            <link rel='stylesheet' type='text/css' href='../assets/plugins/form-toggle/toggles.css' />

<!-- <script type="text/javascript" src="assets/js/less.js"></script> -->
            <script type='text/javascript' src='../js/jquery-1.12.4.js'></script>
            <!--<script type='text/javascript' src='../assets/js/jqueryui-1.10.3.min.js'></script>-->
            <script type='text/javascript' src='../assets/js/bootstrap.min.js'></script>
            <script type='text/javascript' src='../assets/js/enquire.js'></script>
            <script type='text/javascript' src='../assets/js/jquery.cookie.js'></script>
            <script type='text/javascript' src='../assets/js/jquery.nicescroll.min.js'></script>
            <script type='text/javascript' src='../assets/plugins/codeprettifier/prettify.js'></script>
            <script type='text/javascript' src='../assets/plugins/easypiechart/jquery.easypiechart.min.js'></script>
            <script type='text/javascript' src='../assets/plugins/sparklines/jquery.sparklines.min.js'></script>
            <script type='text/javascript' src='../assets/plugins/form-toggle/toggle.min.js'></script>
            <script type='text/javascript' src='../assets/plugins/datatables/jquery.dataTables.min.js'></script>
            <script type='text/javascript' src='../assets/plugins/datatables/dataTables.bootstrap.js'></script>
            <script type='text/javascript' src='../assets/demo/demo-datatables.js'></script>
            <script type='text/javascript' src='../assets/js/placeholdr.js'></script>
            <script type='text/javascript' src='../assets/js/application.js'></script>
            <script type='text/javascript' src='../assets/demo/demo.js'></script>
            <script language="JavaScript" src="../js/form_validatorv31.js" type="text/javascript"></script>
            <script language="JavaScript" src="../js/global.js" type="text/javascript"></script>
            <script language="JavaScript" src="../js/tablee.js" type="text/javascript"></script>
            <script language="JavaScript" src="../js/AjaxFunctionHandler.js" type="text/javascript"></script>
            <script language="JavaScript" src="../js/AjaxFunctionHandler.js" type="text/javascript"></script>
            <script language="JavaScript" src="../js/tablescroll.js" type="text/javascript"></script>
        </head>
        <script>
            $(function () {
                $('#paymentDetails').DataTable({
                    "scrollY": 200,
                    "scrollX": true
                });
            });
        </script>
        <body class="">

            <header class="navbar navbar-inverse navbar-fixed-top" role="banner">

                <div class="navbar-header pull-left">
                    <a class="navbar-brand" href="index.htm">Avant</a>
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
                                        $showUser = "select HeaderText,RoleID from UserInfo, UserRole where UserInfo.UserID = UserRole.UserID and UserName='$UserName'";
                                        $result_showUser = odbc_exec($cn, $showUser);
                                        echo $HeaderTextValue = odbc_result($result_showUser, "HeaderText");
                                        $userRole = odbc_result($result_showUser, "RoleID");
                                    } else {
                                        echo "SMS Panel";
                                    }
                                    ?><i class="fa fa-caret-down"></i></span><img src="../assets/demo/avatar/dangerfield.png" alt="Dangerfield" /></a>

                            <ul class="dropdown-menu userinfo arrow">

                                <li class="username">

                                    <a href="#">
                                        <div class="pull-left"><img src="../assets/demo/avatar/dangerfield.png" alt="Jeff Dangerfield"/></div>
                                        <div class="pull-right"><h5>Hello, <?php echo $UserName; ?></h5></div>
                                    </a>
                                </li>

                                <li class="userlinks">
                                    <ul class="dropdown-menu">

                                        <li><a href="index.php?parent=Logout" class="text-right">Sign Out</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

<?php }
?>
                </ul>
            </header>
            <div id="">
                <div id='wrap'>

                    <div class="container">
                        <div class="panel panel-sky">

                            <div class="panel-heading">
                                <h4>Payment Details of <?php echo $UserNameID;
?> </h4>
                            </div>
                            <div class="panel-body" align="right">
                                    <?php
                                    $TotalQueQuery = " select OnlinePaymentHistory.[UserName] ,OnlinePaymentHistory.[TransactionId] ,[MobileNo] ,[GatewayName] ,[ProceAmount] ,OnlinePaymentHistory.[Amount] ,OnlinePaymentHistory.[DataEntryDate] ,[Response] ,[Status] ,[PaymentValStatus] ,[HashValStatus], TransactionHistory.NumberOfSMS,TransactionHistory.PerSMSRate from [dbo].[OnlinePaymentHistory], [dbo].[TransactionHistory] where OnlinePaymentHistory.UserName='$UserNameID' and OnlinePaymentHistory.TransactionId='$TransactionId'  and OnlinePaymentHistory.TransactionId = TransactionHistory.TransactionId";
                                    $rs = odbc_exec($cn, $TotalQueQuery);
                                    $transactionInfo = odbc_fetch_array($rs);
                                    ?>

                                <div class="row form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label" >Transaction ID</label>
                                    <div class="col-sm-6">
<?php echo $transactionInfo[TransactionId]; ?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label">Number of SMS </label>
                                    <div class="col-sm-6">
<?php echo $transactionInfo[NumberOfSMS]; ?>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label">Amount</label>
                                    <div class="col-sm-6">
<?php echo $transactionInfo[Amount]; ?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label">Processing  Amount</label>
                                    <div class="col-sm-6">
<?php echo $transactionInfo[ProceAmount]; ?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label">Per SMS Rate</label>
                                    <div class="col-sm-6">
<?php echo $transactionInfo[PerSMSRate]; ?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label">Gateway Name </label>
                                    <div class="col-sm-6">
<?php echo $transactionInfo[GatewayName]; ?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label">Mobile No</label>
                                    <div class="col-sm-6">
<?php echo $transactionInfo[MobileNo]; ?>
                                    </div>
                                </div>



                                <div class="row form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label">Status</label>
                                    <div class="col-sm-6">
<?php echo $transactionInfo[Status]; ?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label">Payment Validation Status</label>
                                    <div class="col-sm-6">
<?php echo $transactionInfo[PaymentValStatus]; ?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label">Hash Validation Status</label>
                                    <div class="col-sm-6">
<?php echo $transactionInfo[HashValStatus]; ?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label">Data Entry Date</label>
                                    <div class="col-sm-6">
<?php echo $transactionInfo[DataEntryDate]; ?>
                                    </div>
                                </div>
                                        <?php if ($userRole != "reseller") { 
                                            ?>
                                    <div class="row form-group">
                                        <label for="focusedinput" class="col-sm-3 control-label">Response</label>
                                        <div class="col-sm-6">
                                    <?php echo $transactionInfo[Response]; ?>
                                        </div>
                                    </div>
                                        <?php } ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
</div>
<?php require_once "../footer.php" ?>
