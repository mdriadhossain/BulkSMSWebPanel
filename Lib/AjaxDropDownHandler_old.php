<?php

session_start();
require_once "../Config/config.php";
require_once "lib.php";



$ShowFunction = $_GET['ShowFunction'];
$RequestingValue = $_GET['RequestingValue'];
$NextCallFunction = $_GET['NextCallFunction'];

$cn = ConnectDB();

if ($ShowFunction == "ShowShortCode")
    ShowShortCode($cn, $RequestingValue, $NextCallFunction);
if ($ShowFunction == "ShowService")
    ShowService($cn, $RequestingValue, $NextCallFunction);

if ($ShowFunction == "ShowServiceID")
    ShowServiceID($cn, $RequestingValue, $NextCallFunction);

function ShowShortCode($cn, $RequestingValue, $NextCallFunction) {
    $OperatorName = $RequestingValue;
    $query = "select distinct(ShortCode) as ShortCode  from CMS_1_0.dbo.Keyword where Operator='$OperatorName'";
//echo $query;
    if ($rs = odbc_exec($cn, $query)) {
        if ($NextCallFunction == "ShowService") {
            $NextCallFunction = "ShowDropDown('ShortCodeID','ServiceDiv','ShowService','NO')";
        }
        echo "<select class=\"form-control\" name=\"ShortCodeNumber\" id=\"ShortCodeID\" style=\"width: 200px;\" onchange=\"$NextCallFunction\">";

        echo "<option value=\"\">Select ShortCode</option>";
        while ($row = odbc_fetch_array($rs)) {
            echo "<option value=\"" . $row[ShortCode] . "|" . $OperatorName . "\">" . $row[ShortCode] . "</option>";
        }
        echo "</select>";
    }
}

function ShowService($cn, $RequestingValue, $NextCallFunction) {

    $val = explode("|", $RequestingValue);
    $ShortCode = $val[0];
    $OperatorName = $val[1];

    $RequestSourceID = $OperatorName . "SMS";

    $UserName = strtoupper($_SESSION['User']);

    if (($UserName != 'ADMIN') || ($UserName <> 'ADMIN'))
        $query = "SELECT  distinct ServiceID,Description  FROM CMS_1_0.dbo.service WHERE  RequestSourceID='$RequestSourceID' and ServiceID not like '%ALL%' and  ServiceID not like '%REG' and  ServiceID not like '%DEREG' and Status='Active' and UserID='$UserName'";
    else
        $query = "SELECT  distinct ServiceID,Description  FROM CMS_1_0.dbo.service WHERE  RequestSourceID='$RequestSourceID' and ServiceID not like '%ALL%' and  ServiceID not like '%REG' and  ServiceID not like '%DEREG' and Status='Active'";


//$query = "select LEFT(ServiceID, LEN(ServiceID)-4) as 'ServiceID',Description from CMS_1_0.dbo.Service where RequestSourceID='$RequestSourceID' and ShortCode='$ShortCode' and ServiceID not like '%__DEREG' and ServiceID like '%_REG'  and LTRIM(RTRIM(ServiceID))<>'ALL' group by ServiceId,Description order by Description ASC ";
// echo $query;
    if ($rs = odbc_exec($cn, $query)) {
        if ($NextCallFunction == "NO") {
            echo "<select class=\"form-control\" name=\"ServiceName\" id=\"ServiceID\"  style=\"width: 200px;\" >";
        }
        echo "<option value=\"\">Select Service Name</option>";
        echo "<option value=\"ALL|ALL\">ALL</option>";
        while ($row = odbc_fetch_array($rs)) {
            echo "<option value=\"" . $row[ServiceID] . "|" . $row[Description] . "\">" . $row[Description] . "</option>";
        }
        echo "</select>";
    }
}

function ShowServiceID($cn, $RequestingValue, $NextCallFunction) {
    $OperatorName = $RequestingValue;
    global $CPName;
    $UserName = $_SESSION['User'];
    if (($UserName != 'admin') || ($UserName <> 'admin')) {

        $query = "select distinct(ServiceID) as ServiceID,Description  from CMS_1_0.dbo.Service where UserID='$UserName' and ServiceID like '" . "$CPName" . "_" . "$OperatorName%" . "' Group by ServiceID,Description";
    } else {

        $query = "select distinct(ServiceID) as ServiceID,Description  from CMS_1_0.dbo.Service where ServiceID like '" . "$CPName" . "_" . "$OperatorName%" . "' Group by ServiceID,Description";
    }
    // echo $query;
    $rs = odbc_exec($cn, $query);
    echo "<select class=\"form-control\" name=\"ShortCodeNumber\" id=\"ShortCodeID\" style=\"width: 200px;\">";

    echo "<option value=\"\">Select Subscription Group ID</option>";
    echo "<option value=\"ALL\">ALL</option>";
    while ($row = odbc_fetch_array($rs)) {
        echo "<option value=\"" . $row[ServiceID] . "\">" . $row[Description] . "</option>";
    }
    echo "</select>";
}

?>