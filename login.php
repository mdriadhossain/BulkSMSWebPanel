<?php
error_reporting(0);
set_time_limit(0);
require_once "Config/config.php";
require_once "Lib/lib.php";
?>


<?php
$cn = ConnectDB();

$userName = $_POST['userName'];
$userPass = $_POST['userPass'];

if ($_POST['submit'] == "Login") {
    $arr = isExit3($cn, $userName, $userPass);
    if ($arr > '0') {
        $_SESSION['User'] = $userName;
        $_SESSION["Login"] = "True";
        ReDirect("index.php?parent=home");
    } else {
        echo "<font color='#FF0000'><p align='center'>Wrong User ID and/or Password.</p></font>";
    }
}

function isExit3($cn, $userName, $userPass) {
    $userName = $userName;
    $userPass = $userPass;
    $query = "select count(*) as Total from [BULKSMSPanel].[dbo].[UserInfo] where UserName='$userName' and [Password]='$userPass'";
    $result = odbc_exec($cn, $query);
    $arr = odbc_fetch_array($result);
    $arr = $arr['Total'];
    return $arr;
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>.:SMS Panel:.</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Avant">
        <meta name="author" content="The Red Team">

        <!-- <link href="assets/less/styles.less" rel="stylesheet/less" media="all"> -->
        <link rel="stylesheet" href="assets/css/styles.css">
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>

<!-- <script type="text/javascript" src="assets/js/less.js"></script> -->
    </head>
    <body class="focusedform">

        <div class="verticalcenter">

            <div class="panel panel-primary">
                <div class="panel-body">
                    <p align="center"><h1>Bulk SMS Admin Panel</h1></p>

                    <?php echo $mgs; ?>

                    <form action="" class="form-horizontal" enctype="multipart/form-data" method="post" style="margin-bottom: 0px !important;">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" name="userName" id="username" placeholder="userName">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" name="userPass" class="form-control" id="password" placeholder="Password">
                                </div>
                            </div>
                        </div>
                        <div class="clearfix">

                        </div>


                </div>
				
                <div class="panel" align="center">
                    <input class="btn btn-primary btn-block" type="submit" name="submit" value="Login">
					  <div class="panel-body">
                    <div class="panel-body collapse in">
					<br/>
					<input class="btn btn-success" type="button" onclick="location.href='UserRegistration.php';" value="New Account Signup" /><br>
					<font color="blue">Support Contact No:+88 01973390330</font><br>
					<font color="blue">Commercial Contact No:+88 01953561249</font><br>
					<a href="TermsConditions.php">Terms & Conditions</a> | <a href="PrivacyPolicy.php">Privacy Policy</a><br>
					
					
					</div>
					</div>
                </div>
                </form>
            </div>
        </div>

    </body>
</html>
