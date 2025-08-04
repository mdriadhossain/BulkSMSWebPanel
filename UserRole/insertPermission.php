<?php

require_once "../Config/config.php";
require_once "../Lib/lib.php";
$cn = ConnectDB();

session_start();
$sessionvalue = $_SESSION["roleId"];

if (isset($_POST['delstaff']) && is_array($_POST['delstaff'])) {
    $DeleteQuery = "delete from rolemenu where RoleId='$sessionvalue'";
    odbc_exec($cn, $DeleteQuery);
    $array = $_POST["delstaff"];
    foreach ($array as $value) {
        $insertPermission = "Insert into RoleMenu (MenuID, RoleID,Permission, CreatedBy, CreateDate) Values ('$value', '$sessionvalue', 1, 'Admin', getdate())";
        odbc_exec($cn, $insertPermission);
    }
} else {
    echo 'Failed !';
}
$url = base_url() . "index.php?parent=MenuPermission";
popup('Permission Successfully Defined.', $url);
?>