<?php
require_once "../header.php";
$cn = ConnectDB();

$UserId = $_REQUEST["id"];
$UName = $_REQUEST["user"];
$Password = $_REQUEST["pass"];
$mn = $_REQUEST["mobile"];
$email = $_REQUEST["email"];
$comp = $_REQUEST["company"];
$createDate = $_REQUEST["CreateDate"];
$HeaderText = $_REQUEST["HeaderText"];
$IsSubscribed = $_REQUEST["IsSubscribed"];
if($IsSubscribed == 1){
    $IsSubcribed = "yes";
}else{
     $IsSubcribed = "No";
}
?>

<?php
//session_start();
error_reporting(0);
set_time_limit(0);
//echo "From Header.php";
require_once "../Config/config.php";
require_once "../Lib/lib.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Avant</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <script type='text/javascript' src='../assets/js/jquery-1.10.2.min.js'></script>
        <script type='text/javascript' src='../assets/js/jqueryui-1.10.3.min.js'></script>
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
    </head>

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
                                    $showUser = "select HeaderText from UserInfo where UserName='$UserName'";
                                    $result_showUser = odbc_exec($cn, $showUser);
                                    echo $HeaderTextValue = odbc_result($result_showUser, "HeaderText");
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
        <div id="page-content">
            <div id='wrap'>



                <div class="container">
                    <div class="panel panel-sky">

                        <div class="panel-heading">
                            <h4>Update Profile</h4>
                        </div>
                        <div class="panel-body">


                            <div class="panel-body collapse in">
                                <table  class="table table-bordered table-condensed">

                                    <form id="role" name="role" method="post" action="<?php echo $PHP_SELF; ?>" enctype="multipart/form-data">

                                        <tr>
                                            <td >UserID: </td>
                                            <td>
                                              <?PHP echo $UserId; ?>  <input name="UserID" type="hidden" id="UserID" readonly="readonly"  value="<?PHP echo $UserId; ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td >User Name: </td>
                                            <td>
                                               <?PHP echo $UName; ?>  <input name="UserName" type="hidden" id="UserName"  value="<?PHP echo $UName; ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td >Password: </td>
                                            <td>
                                                <input name="Password" type="text" id="Password"  value="<?PHP echo $Password; ?>" maxlength="15">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td >MobileNo: </td>
                                            <td>
                                                <input name="MobileNo" type="text" id="MobileNo"  value="<?PHP echo $mn; ?>" >
                                            </td>
                                        </tr>
										
										<tr>
                                            <td >Email: </td>
                                            <td>
                                                <input name="Email" type="text" id="Email"  value="<?PHP echo $email; ?>" >
                                            </td>
                                        </tr>
                                        <tr>
                                            <td >Company Name: </td>
                                            <td>
                                                <input name="CompanyName" type="text" id="CompanyName"  value="<?PHP echo $comp; ?>" >
                                            </td>
                                        </tr>

                                        <tr>
                                            <td >Header Text: </td>
                                            <td>
                                                <input name="HeaderText" type="text" id="HeaderText"  value="<?PHP echo $HeaderText; ?>" >
                                            </td>
                                        </tr>
                                        <tr>
                                            <td >Create Date: </td>
                                            <td>
                                               <?PHP echo $createDate; ?><!-- <input name="CreateDate" type="text" id="CreateDate" readonly="readonly"  value="<?PHP echo $createDate; ?>" >-->
                                            </td>
                                        </tr>
                                        <tr>
                                            <td >Subscription Status: </td>
                                            <td>
                                                <?PHP echo $IsSubcribed; ?>
                                                <input name="" type="hidden" id=""  value="<?PHP echo $IsSubcribed; ?>" readonly="readonly"   >
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>
                                                <input name="Save" class="btn btn-sm btn-primary" type="submit" id="Save" value="Update">
                                            </td>
                                        </tr>

                                    </form>
                                </table>

                                </td>
                                </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?PHP
        if ($_REQUEST['Save'] == 'Update') {
            $UserID = $_REQUEST['UserID'];
            $UserName = $_REQUEST['UserName'];
            $Password = $_REQUEST['Password'];
            $MobileNo = $_REQUEST['MobileNo'];
			$Email = $_REQUEST['Email'];
            $CompanyName = $_REQUEST['CompanyName'];
            $HeaderText = $_REQUEST["HeaderText"];

            if ((empty($UserName)) || (empty($Password))) {
                $url = base_url() . "index.php?parent=ShowUserInfo";
                popup('Sorry !! The User / Password Field is Null.', $url);
            } else {
                $update = "update UserInfo set UserName='$UserName', Password = '$Password', MobileNo = '$MobileNo',Email = '$Email', CompanyName = '$CompanyName', CreateDate=getdate(),HeaderText = '$HeaderText' where UserID='$UserID'";
                $result_update = odbc_exec($cn, $update);

                $url = base_url() . "index.php?parent=ShowUserInfo";
                popup('Succesfully Updated.', $url);
            }
        }
        ?>
        <?php require_once "../footer.php" ?>
    </body>
