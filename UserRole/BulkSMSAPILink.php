<?php

require_once '../Config/Config.php';
//require_once "Lib/lib.php";
$cn = ConnectDB();

$UserID = $_GET['UserID'];

$showUser = "select UserID,UserName,Password,MobileNo,CompanyName,CreateDate,HeaderText from UserInfo where UserID='$UserID'";
$result_showUser_exec = odbc_exec($cn, $showUser);
$result_showUser_result = odbc_fetch_array($result_showUser_exec);

$UserName = $result_showUser_result['UserName'];
$Password = $result_showUser_result['Password'];
$MobileNo = $result_showUser_result['MobileNo']; //$MobileNo

$InitialMSISDN = substr($MobileNo, -10);
$MobileNo = "880" . $InitialMSISDN;
$MSISDN = $MobileNo;

$ViewMaskingDetailQuery = "SELECT  MaskingID FROM MaskingDetail WHERE  UserName='$UserName'";
$ViewMaskingDetailQueryresult = odbc_exec($cn, $ViewMaskingDetailQuery);

$result_showUser_result = odbc_fetch_array($ViewMaskingDetailQueryresult);

$MaskingID = $result_showUser_result['MaskingID']; //$MaskingID


$maskingwithoutspace = str_replace(' ', '+', $MaskingID);
$Message = "This is a Test Message from Sender."; //$Message

$Messagewithoutspace = str_replace(' ', '+', $Message);
$userString = $UserName . '|' . $Password;
$AuthToken = base64_encode($userString); //$AuthToken


//$link = "http://116.212.108.50/BulkSMSAPI/BulkSMSExtAPI.php?SendFrom=";
$mainlink = "http://116.212.108.50/BulkSMSAPI/BulkSMSExtAPI.php?";

//$link1 = "SendFrom=";
$InMsgID = $MSISDN . date('YmdHis') . rand(1, 99); //$InMsgID

echo $url = $mainlink."SendFrom=".$maskingwithoutspace."&SendTo=".$MSISDN."&InMSgID=".$InMsgID."&AuthToken=".$AuthToken."&Msg=".$Messagewithoutspace;
?>