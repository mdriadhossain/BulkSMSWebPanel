<?php

require_once "../Config/config.php";
require_once "../Lib/lib.php";

$cn = ConnectDB();

$RoleId = $_REQUEST["RoleId"];

$deleterole = "DELETE FROM [BULKSMSPanel].[dbo].[RoleInfo] WHERE RoleID='$RoleId'";
//echo $deleterole;exit;
$result_deleterole = odbc_exec($cn, $deleterole);

$url = base_url() . "index.php?parent=AddRole";

popup('Succesfully Deleted.', $url);
?>
