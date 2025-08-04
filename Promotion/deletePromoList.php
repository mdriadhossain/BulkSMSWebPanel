<?php

require_once "../Config/config.php";
require_once "../Lib/lib.php";

$cn = ConnectDB();

$PromoListName = $_GET['PromoListName'];
$UserName = $_GET['UserName'];


$deleteuser = "DELETE FROM [BULKSMSPanel].dbo.PromoList WHERE PromoListName='$PromoListName' and UserName='$UserName'";
//echo $deleteuser;exit;
$result_deleteuser = odbc_exec($cn, $deleteuser);

$url = base_url() . "index.php?parent=ViewPromoList";

popup('Succesfully Deleted.', $url);
?>