<?php
require_once "../header.php";
$cn = ConnectDB();

$Id = $_REQUEST["id"];
//$Keyword = $_REQUEST["Keyword"];
//$ContentCode = $_REQUEST["ContentCode"];
//$ContentURL = $_REQUEST["ContentURL"];
//$IsActive = $_REQUEST["IsActive"];
//$SelectCode='select';
$ServiceIDQuery = "select [ID],[Keyword],[ContentCode],[ContentURL],[IsActive] from [SpecialServices].[dbo].[WapCode] where [id]='$Id'";

$ServiceIDResult = odbc_exec($cn, $ServiceIDQuery);
$n = odbc_fetch_array($ServiceIDResult);
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
                            <h4>Edit WAP Code </h4>
                        </div>
                        <div class="panel-body">


                            <div class="panel-body collapse in">
                                <table  class="table table-bordered table-condensed">
                                    <form id="role" name="role" method="post" action="<?php echo $PHP_SELF; ?>" enctype="multipart/form-data">
                                        <input name="IDVal" type="hidden"  value="<?PHP echo $n['ID']; ?>" >
                                        <tr>
                                            <td> Select Content Type : </td>
                                            <td>
                                                <select name="ContentType" type="text" class="form-control" >
                                                    <option value='<?php echo $n['Keyword']; ?>'><?php echo $n['Keyword']; ?></option>
                                                    <option value="WP">WALLPAPER</option>
                                                    <option value="AN">ANIMATION</option>
                                                    <option value="VD">VIDEO</option>
                                                    <option value="MP3">MP3</option>
                                                    <option value="FT">FULLTRACK</option>
                                                    <option value="TT">TRUETONE</option>
                                                    <option value="PT">POLYTONE</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td >Content Code: </td>
                                            <td>
                                                <input name="ContentCode" type="text" size="60" id="ContentCode"  value="<?PHP echo $n['ContentCode']; ?>" >
                                            </td>
                                        </tr>

                                        <tr>
                                            <td >Content URL: </td>
                                            <td>
                                                <input name="ContentURL" type="text" size="100" id="ContentURL"  value="<?PHP echo $n['ContentURL']; ?>" >
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> Active/ InActive : </td>
                                            <td>
                                                <select name="IsActive" >

                                                    <option value="<?php echo $n['IsActive']; ?>" selected="selected"><?php echo $n['IsActive']; ?></option>
                                                    <option value="1">Active</option>
                                                    <option value="0">InActive</option>
                                                </select>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>
                                                <input name="Save" class="btn btn-sm btn-primary" type="submit" id="Save" value="Update">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" colspan="2"><input type="button" class="btn btn-sm btn-primary" name="back" value="Back" onClick="history.go(-1);"/>
                                            </td>
                                        </tr>
                                    </form>
                                </table>

                                </td>
                                </tr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?PHP
        if ($_REQUEST['Save'] == 'Update') {
            print_r($_REQUEST);
            $IDVal = $_REQUEST['IDVal'];
            $Keyword = $_REQUEST['ContentType'];
            $ContentURL = $_REQUEST['ContentURL'];
            $ContentCode = $_REQUEST['ContentCode'];
            $IsActive = $_REQUEST['IsActive'];

            $update = "UPDATE [SpecialServices].[dbo].[WapCode] set [Keyword]='$Keyword',[ContentCode]='$ContentCode',[ContentURL]='$ContentURL',[IsActive]='$IsActive' where [ID]=$IDVal";
            //echo $update;exit;
            $result_update = odbc_exec($cn, $update);

            $url = base_url() . "index.php?parent=ShowWapCode";
            popup('Succesfully Updated.', $url);
        }
        ?>
        <?php require_once "../footer.php" ?>
    </body>
