<?php session_start(); ?>
<?php
$serverName = $_SERVER['SERVER_NAME'];
if ($serverName == "116.212.108.50"){
header("Location: http://smsreport.solversbd.com/"); 
exit();
};


//require_once "header.php";
error_reporting(0);
set_time_limit(0);
$parent = $_GET['parent'];

if ($parent == "Logout") {
    $_SESSION["Login"] = "False";
    $_SESSION['User'] = "False";
}
$User = $_SESSION['User'];
?>
<?PHP

if (isset($_SESSION['Login']) && $_SESSION['Login'] == "True") {
    include_once "header.php";
} else {
//include_once "UserRole/headermain.php";
    echo "&nbsp;";
}
?>

<?PHP

if (isset($_SESSION['Login']) && $_SESSION['Login'] == "True") {
    ?>
    <?PHP

    if ($_SESSION["Login"] == "True")
        include "leftmenu.php";
    else
        echo "&nbsp;";
    ?>
    <?PHP

    if ($_SESSION["Login"] == "True") {
        $cn = ConnectDB();
        $SQL = "select MenuURL from MenuDefine where MenuId='$parent'";
        $rs = odbc_exec($cn, $SQL);
        while ($row = odbc_fetch_row($rs)) {
            $mUrl = odbc_result($rs, "MenuURL");
            //echo $mUrl;
            include $mUrl;
        }
    } else {
        include "UserRole/login.php";
    }
    ?>





    <?php

} else {

    include_once "UserRole/login.php";
}
?>

<?PHP

if ($_SESSION["Login"] == "True")
    include "footer.php";
else
    echo "&nbsp;";
?>
<?php

//include_once "footer.php"; ?>