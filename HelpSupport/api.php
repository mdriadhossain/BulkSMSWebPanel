<?php
$name = $_POST['name'];
$number = $_POST['phone'];
$Email = $_POST['email'];
//echo $combo = $_POST['combo'];
$mgs = $_POST['mgs'];
$MailURL = "http://localhost/BulkSMSWebPanel/PHPMailer/examples/test_smtp_basic_barta_new.php?name=$name&number=$number&Email=$Email&mgs=$mgs";
	

$MainMailURL = str_replace(" ", "+", $MailURL);
    
	//echo $ChargingInterfaceURL;exit;
	
$ChargingURLResponce = file_get_contents($MainMailURL);
//$url = "http://45.64.135.90/PHPMailer/examples/test_smtp_basic_barta.php?name=$name&number=$number&combo=$combo&Email=$Email&mgs=$mgs";
//echo $string = file_get_contents("http://45.64.135.90/PHPMailer/examples/test_smtp_basic_barta.php?name=$name&number=$number&combo=$combo&Email=$Email&mgs=$mgs", true);
//echo "[".$name."]";
?>










