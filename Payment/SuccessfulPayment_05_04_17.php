<?php
ob_start();
require_once "Config/config.php";
require_once "Lib/lib.php";
$cn = ConnectDB();
$UserName = $_SESSION['User'];
$userDetail = "SELECT * FROM BULKSMSPanel.dbo.UserInfo where UserName='$UserName'";
$result_userDetail = odbc_exec($cn, $userDetail);
$userInfo = odbc_fetch_array($result_userDetail);
?>
<div id="page-content">
    <div id='wrap'>
        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>Payment Successful</h4>
                </div>
                <div class="panel-body">
                    <div class="panel-body collapse in">

                        <?php
                        
                           function _SSLCOMMERZ_hash_varify($store_passwd = "") {

                            if (isset($_POST) && isset($_POST['verify_sign']) && isset($_POST['verify_key'])) {
                                # NEW ARRAY DECLARED TO TAKE VALUE OF ALL POST

                                $pre_define_key = explode(',', $_POST['verify_key']);

                                $new_data = array();
                                if (!empty($pre_define_key)) {
                                    foreach ($pre_define_key as $value) {
                                        if (isset($_POST[$value])) {
                                            $new_data[$value] = ($_POST[$value]);
                                        }
                                    }
                                }
                                # ADD MD5 OF STORE PASSWORD
                                $new_data['store_passwd'] = md5($store_passwd);

                                # SORT THE KEY AS BEFORE
                                ksort($new_data);

                                $hash_string = "";
                                foreach ($new_data as $key => $value) {
                                    $hash_string .= $key . '=' . ($value) . '&';
                                }
                                $hash_string = rtrim($hash_string, '&');

                                if (md5($hash_string) == $_POST['verify_sign']) {

                                    return true;
                                } else {
                                    return false;
                                }
                            } else
                                return false;
                        }
                        
                        if (isset($_POST['tran_id'])) {
                            $transation_info = new stdClass();
                            $transation_info->UserName = $UserName;
                            $transation_info->MobileNo = $userInfo['MobileNo'];
                            $transation_info->Amount = $_POST['amount'];
                            $transation_info->TransactionId = $_POST['tran_id'];
                            $transation_info->ValidationId = $_POST['val_id'];
                            $transation_info->Status = $_POST['status'];
                            $transation_info->DataEntryDate = $_POST['tran_date'];
                            $transation_info->VerifySign = $_POST['verify_sign'];
                            $transation_info->Response = json_encode($_POST);
                            if (_SSLCOMMERZ_hash_varify(PAYMENT_GATEWAY_STORE_PASSWORD)) {
                                $transation_info->HashValStatus = TRANSACTION_HASH_VALIDATION_TYPE_TRUE;
                            } else {
                                $transation_info->HashValStatus = TRANSACTION_HASH_VALIDATION_TYPE_FALSE;
                            }

                            $insertquery = "INSERT INTO OnlinePaymentHistory (UserName,MobileNo,Amount,TransactionId,Status,Response,DataEntryDate,HashValStatus) VALUES "
                            . "('$transation_info->UserName','$transation_info->MobileNo','$transation_info->Amount','$transation_info->TransactionId','$transation_info->Status','$transation_info->Response','$transation_info->DataEntryDate','$transation_info->HashValStatus')";
                            $rs = odbc_exec($cn, $insertquery);


                            $val_id = urlencode($_POST['val_id']);
                            $store_id = urlencode(PAYMENT_GATEWAY_STORE_ID);
                            $store_passwd = urlencode(PAYMENT_GATEWAY_STORE_PASSWORD);
//Payment validation check
                            $requested_url = $paymentGateWayValidationAPI . "val_id=" . $val_id . "&store_id=" . $store_id . "&store_passwd=" . $store_passwd . "&v=1&format=json";
                            $handle = curl_init();
                            curl_setopt($handle, CURLOPT_URL, $requested_url);
                            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
                            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

                            $result = curl_exec($handle);

                            $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

                            if ($code == 200 && !( curl_errno($handle))) {


                                $result = json_decode($result);
                                $status = $result->status;
                                 $UpdatePaymentValidationStatus = "UPDATE OnlinePaymentHistory SET PaymentValStatus ='$status' where TransactionId='$transation_info->TransactionId'";
                                $rsval = odbc_exec($cn, $UpdatePaymentValidationStatus);
                                echo "<br>The following transaction request is successfully done.</br>";
                                echo "<br>Please check your mail for confermation! Thank You!!!.</br>";
                            } else {

                                echo "Failed to connect with SSLCOMMERZ";
                                return false;
                            }
                        }

//Transaction status validation check
//                        $tran_id = urlencode($_POST['tran_id']);
//                        $requested_url = $paymentGateWayTransactionValAPI . "tran_id=" . $tran_id . "&store_id=" . $store_id . "&store_passwd=" . $store_passwd . "&v=3&format=json";
//                        $handle = curl_init();
//                        curl_setopt($handle, CURLOPT_URL, $requested_url);
//                        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
//                        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
//                        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
//
//                        $result = curl_exec($handle);
//
//                        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
//
//                        if ($code == 200 && !( curl_errno($handle))) {
//                            $transaction_status_result = json_decode($result);
//                            if (property_exists($transaction_status_result, 'element')) {
//                                $status = $transaction_status_result->element[0]->status;
//                                $UpdateTransactionStatus = "UPDATE OnlinePaymentHistory SET TransValStatus ='$status' where TransactionId='$transation_info->TransactionId'";
//                                $rsval1 = odbc_exec($cn, $UpdateTransactionStatus);
//                                echo "<br>The following transaction request is successfully done.</br>";
//                                echo "<br>Please check your mail for confermation! Thank You!!!.</br>";
//                            }
//                        } else {
//
//                            echo "Failed to connect with SSLCOMMERZ";
//                        }
//
                     
                        ?>




                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function () {
            var url = '<?php echo $paymentGateWayPaymentUtilityURL; ?>'
            var transactionId = '<?php echo $_POST['tran_id'] ?>';
            if (typeof transactionId !== 'undefined' && transactionId != "") {
                var TansactionDataArray = {};
                TansactionDataArray.transactionId = transactionId;
                TansactionDataArray.selectedPackage = $.session.get('selectedPackage');
                TansactionDataArray.totalAmount = $.session.get('totalAmount');
                TansactionDataArray.cellNo = $.session.get('cellNo');
                TansactionDataArray.NumberOfSMS = $.session.get('NumberOfSMS');
                TansactionDataArray.PerSMSRate = $.session.get('PerSMSRate');
                $.ajax({
                    type: 'POST',
                    url: url,
                    dataType: "application/json",
                    data: {myData: TansactionDataArray},
                    success: function (data) {
                        $.session.remove('selectedPackage');
                        $.session.remove('totalAmount');
                        $.session.remove('cellNo');
                        $.session.remove('NumberOfSMS');
                        $.session.remove('PerSMSRate');
                    }

                });
            }
        });

    </script>