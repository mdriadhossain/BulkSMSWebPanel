<?php

require_once "../Config/config.php";
require_once "../Lib/lib.php";

$cn = ConnectDB();

$userid = $_GET['id'];
$deleteuser = "delete from [SpecialServices].[dbo].[WapCode] where id='$userid'";
//echo $deleteuser;exit;
$result_deleteuser = odbc_exec($cn, $deleteuser);

$url = base_url() . "index.php?parent=ShowWapCode";

popup('Succesfully Deleted.', $url);
?>