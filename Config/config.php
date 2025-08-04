<?PHP
set_time_limit(0);
//echo "From config";
date_default_timezone_set("ASIA/Dhaka");
$CPName="SOLVERS";

function getDBMain(){
    return 'BULKSMSPanel';
}

function ConnectDB() {
    //$Server = "116.212.108.50";
    $Pass = "bmWfjg88";
   
    $Server = "localhost";    
    //$Pass = "nopass@1234";

    $User = "sa";
    $DBName = getDBMain();
    $cn = odbc_connect("Driver={SQL Server};Server=$Server;Database=$DBName", "$User", "$Pass");
    if (!$cn) {
        die('Cannot connect to DataBase');
        return FALSE;
    } else {
        return $cn;
    }
}

function PDOConnectDB() {
    $serverName = "localhost";
   // $serverName = "116.212.108.50";
    $database = "BULKSMSGateway_1_0";
    $uid = 'sa';
    $pwd = 'bmWfjg88';
    try {
       return $conn = new PDO(
                "sqlsrv:server=$serverName;Database=$database", $uid, $pwd, array(
            //PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
        );
    } catch (PDOException $e) {
        die("Error connecting to SQL Server: " . $e->getMessage());
        return FALSE;
    }
}

function PDOConnectDB2() {
    $serverName = "localhost";
   // $serverName = "116.212.108.50";
    $database = "BULKSMSPanel";
    $uid = 'sa';
    $pwd = 'bmWfjg88';
    try {
       return $conn = new PDO(
                "sqlsrv:server=$serverName;Database=$database", $uid, $pwd, array(
            //PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
        );
    } catch (PDOException $e) {
        die("Error connecting to SQL Server: " . $e->getMessage());
        return FALSE;
    }
}


/* function SMSPanelDB(){ return "SMSPanel";}
  function cgwGPDB(){ return "CGW_1_0_GP";}
  function cgwROBIDB(){ return "CGW_1_0_ROBI";}
  function cgwBLDB(){  return "CGW_1_0_BL";}
  function cgwTTDB(){  return "CGW_1_0_TT";}
  function cgwATDB(){  return "CGW_1_0_AT";}
  function cgwCCDB(){  return "CGW_1_0_CC";}
  function SMSGatewayGPDB(){  return "SMSGateway_1_0_GP";}
  function SMSGatewayROBIDB(){  return "SMSGateway_1_0_ROBI";}
  function SMSGatewayBLDB(){  return "SMSGateway_1_0_BL";}
  function SMSGatewayTTDB(){  return "SMSGateway_1_0_TT";}
  function SMSGatewayATDB(){  return "SMSGateway_1_0_AT";}
  function SMSGatewayCCDB(){  return "SMSGateway_1_0_CC";}
  function DWHDB(){  return "DWH_1_0";}
  function CMSDB(){  return "CMS_1_0";} */

function FindOperatorDB($OperatorName, $DBType) {
    if (($OperatorName == 'GP') && ($DBType == 'SMS')) {
        return "SMSGateway_1_0_GP";
    } else if (($OperatorName == 'GP') && ($DBType == 'CGW')) {
        return "CGW_1_0_GP";
    } else if (($OperatorName == 'RO') && ($DBType == 'SMS')) {
        return "SMSGateway_1_0_ROBI";
    } else if (($OperatorName == 'RO') && ($DBType == 'CGW')) {
        return "CGW_1_0_ROBI";
    } else if (($OperatorName == 'BL') && ($DBType == 'SMS')) {
        return "SMSGateway_1_0_BL";
    } else if (($OperatorName == 'BL') && ($DBType == 'CGW')) {
        return "CGW_1_0_BL";
    } else if (($OperatorName == 'TT') && ($DBType == 'SMS')) {
        return "SMSGateway_1_0_TT";
    } else if (($OperatorName == 'TT') && ($DBType == 'CGW')) {
        return "CGW_1_0_TT";
    } else if (($OperatorName == 'AT') && ($DBType == 'SMS')) {
        return "SMSGateway_1_0_AT";
    } else if (($OperatorName == 'AT') && ($DBType == 'CGW')) {
        return "CGW_1_0_AT";
    } else if (($OperatorName == 'CC') && ($DBType == 'SMS')) {
        return "SMSGateway_1_0_CC";
    } else if (($OperatorName == 'CC') && ($DBType == 'CGW')) {
        return "CGW_1_0_CC";
    }
}

function FindOperator($mobile_number) {
    $number_tester = substr($mobile_number, -10);
    $number_tester = substr($mobile_number, 0, 2);
    if ($number_tester == '15')
        return "TT";
    if ($number_tester == '16')
        return "AT";
    if ($number_tester == '17')
        return "GP";
    if ($number_tester == '18')
        return "RO";
    if ($number_tester == '19')
        return "BL";
    if ($number_tester == '11')
        return "CC";
}

function SMSSendingURL() {
    return "http://localhost/CommonOperator/sendSingleSMS.php?";
}

function base_url() {
   // return "http://localhost/BulkSMSWebPanel/";
    //return "http://116.212.108.50/BulkSMSWebPanel/";
	
	return "http://smsreport.solversbd.com/";
}
function get_mail_server_url(){
    return "http://116.212.108.50/PHPMailer/examples/";
}

function ReDirect($src) {
    echo '<script language="JavaScript">
   window.location="' . $src . '";
   </script>';
}

function db_query($qry, $cn) {
    return odbc_exec($qry, $cn);
}

function db_fetch_array($rs) {
    return odbc_fetch_array($rs);
}

function db_num_rows($rs) {
    return odbc_num_rows($rs);
}

function db_close($cn) {
    return odbc_close($cn);
}

function MsgBox($msg) {
    echo '<script language="JavaScript">
   alert("' . $msg . '");
   </script>';
}
$paymentGateWayPostAPI = "https://securepay.sslcommerz.com/gwprocess/v3/process.php";
$paymentGateWayValidationAPI = "https://securepay.sslcommerz.com/validator/api/validationserverAPI.php?";
$paymentGateWayPostAPITest = "https://sandbox.sslcommerz.com/gwprocess/v3/process.php";
$paymentGateWayValidationAPITest = "https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php?";
$paymentGateWayTransactionValAPI = "https://sandbox.sslcommerz.com/validator/api/merchantTransIDvalidationAPI.php?";
$paymentGateWaySuccessURL = base_url()."index.php?parent=SuccessPayment";
$paymentGateWayFailedOrCancelURL = base_url()."index.php?parent=FailedPayment";
$paymentGateWayPaymentUtilityURL = base_url()."index.php?parent=PaymentUtility";
define("IsSubscribedOn",                   1);
define("IsSubscribedOff",                   0);
define("PACKAGE_TYPE_ID_NON_MASKING", 3);
//define("PACKAGE_TYPE_ID_NON_MASKING_WITH_GP",                   2);
define("PACKAGE_TYPE_ID_MASKING", 1);

define("PACKAGE_TYPE_ID_NON_MASKING_PER_SMS_RATE_FOR_SUBSCRIBER", 0.27);
define("PACKAGE_TYPE_ID_NON_MASKING_PER_SMS_RATE_LESS_1000", 0.35);
define("PACKAGE_TYPE_ID_NON_MASKING_PER_SMS_RATE_5000_UP", 0.30);
define("PACKAGE_TYPE_ID_NON_MASKING_PER_SMS_RATE_10000_UP", 0.25);
define("PACKAGE_TYPE_ID_MASKIN_WITH_PER_SMS_RATE_LESS_100000", 0.45);
define("PACKAGE_TYPE_ID_MASKIN_WITH_PER_SMS_RATE_100000_UP", 0.40);
define("PACKAGE_TYPE_ID_NON_MASKING_MINIMUM_NO_OF_SMS", 1000);
define("PACKAGE_TYPE_ID_MASKING_MINIMUM_NO_OF_SMS", 50000);
define("PACKAGE_TYPE_ID_SUBSCRIBER_NUMBER_OF_SMS", 11000);
define("PAYMENT_GATEWAY_STORE_ID", "solversbd001live");
define("PAYMENT_GATEWAY_STORE_PASSWORD", "solversbd001live45542");
define("PAYMENT_GATEWAY_STORE_ID_TEST", "test_solversbd");
define("PAYMENT_GATEWAY_STORE_PASSWORD_TEST", "test_solversbd@ssl");
define("TRANSACTION_HASH_VALIDATION_TYPE_TRUE", 1);
define("TRANSACTION_HASH_VALIDATION_TYPE_FALSE", 0);
define("SMS_VALIDATION_DATE", 365);
define("SMS_VALIDATION_DATE_FOR_SUBSCRIBER", 90);
define("TRANSACTION_PROCESSING_RATE_FOR_BKASH_MOBILE_BANKING", 18.5);
define("TRANSACTION_PROCESSING_RATE_FOR_bankasia_MOBILE_BANKING", 10);
define("TRANSACTION_PROCESSING_RATE_FOR_city_MOBILE_BANKING", 10);
define("TRANSACTION_PROCESSING_RATE_FOR_ibbl_MOBILE_BANKING", 10);
define("TRANSACTION_PROCESSING_RATE_FOR_mtbl_MOBILE_BANKING", 10);
define("TRANSACTION_PROCESSING_RATE_FOR_DBBL_Mobile_Banking", 10);

define("TRANSACTION_PROCESSING_RATE_FOR_DBBL_MASTER", 57);
define("TRANSACTION_PROCESSING_RATE_FOR_DBBL_VISA", 57);
define("TRANSACTION_PROCESSING_RATE_FOR_DBBL_NEXUS", 57);

define("TRANSACTION_PROCESSING_RATE_FOR_CITY_MASTER", 50);
define("TRANSACTION_PROCESSING_RATE_FOR_CITY_AMEX", 50);
define("TRANSACTION_PROCESSING_RATE_FOR_CITY_VISA", 50);
define("TRANSACTION_PROCESSING_RATE_FOR_BRACK_MASTER", 10);
define("TRANSACTION_PROCESSING_RATE_FOR_BRACK_VISA", 10);
define("TRANSACTION_PROCESSING_RATE_FOR_EBL_MASTER", 10);
define("TRANSACTION_PROCESSING_RATE_FOR_EBL_VISA", 10);
define("PAYMENT_GATEWAY_NAME_BKASH", "bkash");
define("PAYMENT_GATEWAY_NAME_bankasia", "bankasia");
define("PAYMENT_GATEWAY_NAME_city", "city");
define("PAYMENT_GATEWAY_NAME_ibbl", "ibbl");
define("PAYMENT_GATEWAY_NAME_mtbl", "mtbl");
define("PAYMENT_GATEWAY_NAME_DBBL_Mobile_Banking", "dbblmobilebanking");

define("PAYMENT_GATEWAY_NAME_DBBL_Nexus", "dbbl_nexus");
define("PAYMENT_GATEWAY_NAME_Dutch_Bangla_MASTER", "dbbl_master");
define("PAYMENT_GATEWAY_NAME_Dutch_Bangla_VISA", "dbbl_visa");

define("PAYMENT_GATEWAY_NAME_BRAC_MASTER", "brac_master");
define("PAYMENT_GATEWAY_NAME_BRAC_VISA", "brac_visa");

define("PAYMENT_GATEWAY_NAME_CITY_MASTER", "city_master");
define("PAYMENT_GATEWAY_NAME_CITY_AMEX", "city_amex");
define("PAYMENT_GATEWAY_NAME_CITY_VISA", "city_visa");
define("PAYMENT_GATEWAY_NAME_EBL_MASTER", "ebl_master");
define("PAYMENT_GATEWAY_NAME_EBL_VISA", "ebl_visa");



?>