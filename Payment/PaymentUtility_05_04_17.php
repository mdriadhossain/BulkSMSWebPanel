<?php
ob_start();
require_once "Config/config.php";
require_once "Lib/lib.php";


$cn = ConnectDB();

if (isset($_POST)) {
    $transation_info = $_POST['myData'];
    $PurchaseFromAccountId = $transation_info['selectedPackage'];
    $Amount = $transation_info['totalAmount'];
    $NumberOfSMS = $transation_info['NumberOfSMS'];
    $transactionId = $transation_info['transactionId'];
    $TransactionType = "Credit";
    $PerSMSRate = $transation_info['PerSMSRate'];
    $validitydate = SMS_VALIDATION_DATE;
    $UserName = $_SESSION['User'];
    $PurchaseFromAccount = "";
    $PurchaseFromAccountQuery = "Select ID,UserName from [dbo].[MainAccount]";
    $result_PurchaseFromAccount = odbc_exec($cn, $PurchaseFromAccountQuery);
    while ($PurchaseFromAccountrow = odbc_fetch_array($result_PurchaseFromAccount)) {
        if ($PurchaseFromAccountrow['ID'] == $PurchaseFromAccountId) {
            $PurchaseFromAccount = $PurchaseFromAccountrow['UserName'];
        }
    }
    $insertquery = "INSERT INTO TransactionHistory (UserName, NumberOfSMS,TransactionType, PerSMSRate, Amount,FromMainAccount,TransactionId) VALUES ('$UserName', '$NumberOfSMS', '$TransactionType', '$PerSMSRate','$Amount', '$PurchaseFromAccount', '$transactionId')";
    $rs = odbc_exec($cn, $insertquery);
    $insertqueryadmin = "INSERT INTO TransactionHistory (UserName, NumberOfSMS,TransactionType, PerSMSRate, Amount,FromMainAccount, TransactionId) VALUES ('admin', '$NumberOfSMS', 'Debit', 'NULL','NULL','$PurchaseFromAccount', '$transactionId')";
    $rs = odbc_exec($cn, $insertqueryadmin);
    $AccountValSql = "Select CurrentNoOfSMS from MainAccount where username='$PurchaseFromAccount'";
    $AccountValResult = odbc_exec($cn, $AccountValSql);
    $AccountValue = odbc_fetch_array($AccountValResult);
    $UserCurrentSmsVal = $AccountValue[CurrentNoOfSMS];
    $TotalNumberOfSmsVal = $UserCurrentSmsVal - $NumberOfSMS;

    $UpdateMainAccountQuery = "UPDATE MainAccount set CurrentNoOfSMS = $TotalNumberOfSmsVal  where username='$PurchaseFromAccount' ";
    $s = odbc_exec($cn, $UpdateMainAccountQuery);
    $UserAccountValSql = "Select NumberOfSMS,ValidityDate from CurrentStatus where UserName = '$UserName'";
    $ValidityDateSql = "SELECT DATEADD(day, $validitydate, ValidityDate) AS ValidityDate FROM CurrentStatus where UserName = '$UserName'";
    $ValidityDateResult = odbc_exec($cn, $ValidityDateSql);
    $ValidityDateAccountValue = odbc_fetch_array($ValidityDateResult);
    $CurrentValidityDate = $ValidityDateAccountValue[ValidityDate];
    $UserAccountValResult = odbc_exec($cn, $UserAccountValSql);
    $UserAccountValue = odbc_fetch_array($UserAccountValResult);
    $UsersCurrentSmsVal = $UserAccountValue[NumberOfSMS];

    $SelectEmailSql = "Select Email from [dbo].[UserInfo] WHERE UserName='$UserName' ";
    $SelectEmailResult = odbc_exec($cn, $SelectEmailSql);
    $UserEmailValue = odbc_fetch_array($SelectEmailResult);
    $UserEmail = $UserEmailValue[Email];


    if (($UsersCurrentSmsVal == "") || ($UsersCurrentSmsVal == "NULL")) {
        $InsertCurrentStatusQuery = "Insert INTO CurrentStatus (UserName,NumberOfSMS,IsActive,ValidityDate) VALUES ('$UserName',$NumberOfSMS,1,DATEADD(day, $validitydate, convert(date,getdate())))";
        $rsval = odbc_exec($cn, $InsertCurrentStatusQuery);
    } else {
        $TestTotalNumberOfSmsVal = $UsersCurrentSmsVal + $NumberOfSMS;
        $UpdateCurrentStatusQuery = "UPDATE CurrentStatus set NumberOfSMS = $TestTotalNumberOfSmsVal,ValidityDate = '$CurrentValidityDate' WHERE UserName = '$UserName'";
        $rsval = odbc_exec($cn, $UpdateCurrentStatusQuery);
    }
    $file = file_get_contents(get_mail_server_url()."test_smtp_basic_onlinepayment.php?email=$UserEmail&uname=$UserName&NumberOfSMS=$NumberOfSMS&totalamount=$Amount&PerSMSRate=$PerSMSRate", FILE_USE_INCLUDE_PATH);
}
?>


?>