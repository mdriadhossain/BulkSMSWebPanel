<?php
ob_start();
error_reporting(0);
set_time_limit(0);
require_once "Config/config.php";
require_once "Lib/lib.php";
$IsSubcribed = $_GET['IsSubcribed'];
$userPass = $_GET['userPass'];

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
                    <p align="center"><h3 align="center" >Password Confirmation</h3></p>
                    <p align="center"><b>A Password has been sent to your mobile phone, Please type this password to the bellow box </b></p>

<?php echo $mgs; ?>

                    <form action="" class="form-horizontal" enctype="multipart/form-data" method="post" style="margin-bottom: 0px !important;">

                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="text" name="userPass" class="form-control" id="password" placeholder="Type the Password You have received Your Mobile">
                                </div>
                            </div>
                        </div>
                        <div class="clearfix">

                        </div>


                </div>

                <div class="panel" align="center">




                   <button type="submit" name="submit" value="Login" class="btn btn-primary btn-block">Update Profile </button>



                </div>
                </form>
            </div>
        </div>

    </body>
</html>
<?php
$cn = ConnectDB();
$userPass = $_POST['userPass'];

if ($_POST['submit'] == "Login") {


    $showUser = "select UserID,UserName,Password,MobileNo from UserInfo where Password='$userPass'";
    $result_showUser_exec = odbc_exec($cn, $showUser);

    $result_showUser_result = odbc_fetch_array($result_showUser_exec);
    $Password = $result_showUser_result['Password'];
    $UserID = $result_showUser_result['UserID'];

    if ($userPass == $Password) {
        ReDirect("NewUserProfileUpdate.php?id=$UserID&IsSubcribed=$IsSubcribed");

        //ReDirect("NewUserProfileUpdate.php?parent=home");
    } else {
        // echo "<font color='#FF0000'><p align='center'>Wrong  Password.</p></font>";
        ?>
        <script type="text/javascript">



            alert("Wrong  Password.");



        </script>
        <?php
        ReDirect("PasswordConfirmation.php?parent=home");
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
