<?php

session_start(0);
error_reporting(0);
require_once '../Config/config.php';

$query = $_SESSION['xls_query'];
$cn = connectDB();
export_excel($cn, $query);

function export_excel($cn, $query) {
    $sql = $query;
    $rec = odbc_exec($cn, $sql) or die();
    $num_fields = odbc_num_fields($rec);
    for ($i = 1; $i <= $num_fields; $i++) {
        $header .= odbc_field_name($rec, $i) . "\t";
    }
    while ($row = odbc_fetch_array($rec)) {
        $line = '';
        foreach ($row as $value) {
            if ((!isset($value)) || ($value == "")) {
                $value = "\t";
            } else {
                $value = str_replace('"', '""', $value);
                $value = '"' . $value . '"' . "\t";
            }
            $line .= $value;
        }
        $data .= trim($line) . "\n";
    }

    $data = str_replace("\r", "", $data);

    if ($data == "") {
        $data = "\n No Record Found!n";
    }
    $date = date('YmdHis');

    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=" . $date . ".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    print "$header\n$data";
}

?>