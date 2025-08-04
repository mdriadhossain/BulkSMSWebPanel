<?php

require_once "../Config/config.php";
require_once "../Lib/lib.php";

$cn = ConnectDB();

$id = $_GET['id'];
$tbl = $_GET['tbl'];
if ($tbl == "TemplateText") {
    $redirect_page = "ViewTemplate";
}

$deletesql = "DELETE FROM $tbl WHERE ID='$id'";

$result_delete = odbc_exec($cn, $deletesql);

$url = base_url() . "index.php?parent=$redirect_page";

popup('Succesfully Deleted.', $url);
?>