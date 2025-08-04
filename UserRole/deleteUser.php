<?php

require_once "../Config/config.php";
require_once "../Lib/lib.php";

$cn = ConnectDB();

$userid = $_GET['id'];
$deleteuser = "DELETE FROM [BULKSMSPanel].[dbo].[UserInfo] WHERE UserID='$userid'";
//echo $deleteuser;exit;
$result_deleteuser = odbc_exec($cn, $deleteuser);

$url = base_url() . "index.php?parent=ShowUserInfo";

popup('Succesfully Deleted.', $url);
?>