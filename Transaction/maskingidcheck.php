<?php

error_reporting(0);
require_once "../Config/config.php";
require_once "../Lib/lib.php";
$cn = ConnectDB();


if ($_POST) {
    $name = strip_tags($_POST['MaskingName']);

    $maskingIDSql = "CREATE VIEW $name as (SELECT MaskingID FROM MaskingDetail where MaskingID = '$name')";
    odbc_exec($cn, $maskingIDSql);
    $newSQL = "SELECT * FROM $name";
    $result_maskingIDSql = odbc_exec($cn, $newSQL);
    $countArray = odbc_fetch_array($result_maskingIDSql);
    if (!empty($countArray)) {

        echo "<span style='color:brown;'>Sorry $name already taken !!! please select another.</span>";
    } else {

        echo "<span style='color:green;'>$name available for User Name.</span>";
    }
}
?>