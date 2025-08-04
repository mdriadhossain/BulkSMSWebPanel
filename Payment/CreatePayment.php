<?php
ob_start();
session_start();
require_once "Config/config.php";
require_once "Lib/lib.php";
$cn = ConnectDB();
$UserName = $_SESSION['User'];
$userDetail = "SELECT UserName,Email,IsSubscribed FROM BULKSMSPanel.dbo.UserInfo where UserName='$UserName'";
$result_userDetail = odbc_exec($cn, $userDetail);
$userInfo = odbc_fetch_array($result_userDetail);
$MinNumberOfSMS = PACKAGE_TYPE_ID_SUBSCRIBER_NUMBER_OF_SMS;
$IsSubscribedOn = IsSubscribedOn;
$counter_sql = "select count(*) as NumofTransaction from TransactionHistory join UserInfo on TransactionHistory.UserName=UserInfo.UserName where TransactionHistory.UserName='$UserName' and TransactionType ='Credit' and NumberOfSMS = '$MinNumberOfSMS' and UserInfo.IsSubscribed = '$IsSubscribedOn'";
$counter_sql = odbc_exec($cn, $counter_sql);
$counter_array = odbc_fetch_array($counter_sql);
$counter = $counter_array['NumofTransaction'];

$IsSubscribed = $userInfo['IsSubscribed'];
$tran_id = generateRandomString();
?>
<div id="page-content">
    <div id='wrap'>
        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>Recharge Balance</h4>
                </div>
                <div class="panel-body" align="right">
                    <div class="panel-body collapse in">
                        <form  id="payment_gw" name="payment_gw" method="POST" action="<?php echo $paymentGateWayPostAPI; ?>">
                            <input type="hidden" name="store_id" id="store_id" value="<?php echo PAYMENT_GATEWAY_STORE_ID; ?>" />
                            <input type="hidden" name="tran_id" name="tran_id" value="<?php echo $tran_id; ?>" />
                            <input type="hidden" name="success_url" value="<?php echo $paymentGateWaySuccessURL; ?>" />
                            <input type="hidden" name="fail_url" value="<?php echo $paymentGateWayFailedOrCancelURL; ?>" />
                            <input type="hidden" name="cancel_url" value="<?php echo $paymentGateWayFailedOrCancelURL; ?>" />
                            <input type="hidden" name="cus_name" value="<?php echo $userInfo['UserName']; ?>">
                            <input type="hidden" name="cus_email"  value="<?php echo $userInfo['Email']; ?>">
                            <div class=" row form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Interested Package:</label>
                                <div class="col-sm-6">
                                    <select class="form-control" id="selectedPackage" name="InterestedPackage" onchange="calculate(1)">
                                        <option value="0" selected="selected">Please Select a Package</option>
                                        <option value="<?php echo PACKAGE_TYPE_ID_NON_MASKING; ?>">Non-Masking</option>
                                        <!--<option value="<?php // echo PACKAGE_TYPE_ID_MASKING;       ?>">Masking</option>-->
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Number of SMS:</label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="NumberOfSMS" type="number" id="NumberOfSMS" oninput="calculate(2)" onchange="calculate(3)" >
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Per SMS Rate:</label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="PerSMSRate" type="text" id="PerSMSRate" oninput="calculate()" readonly="" >
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Payment Gateway :</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type='text' name='multi_card_name'  id="selectedPaymentGateway" readonly=""> 

                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Mobile No :</label>
                                <div class="col-sm-6">
                                    <input type="text" name="cus_phone" id="cus_phone" class="form-control"/>

                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">SMS Price :</label>
                                <div class="col-sm-6">
                                    <input type="text" name="sms_price" id="sms_price" class="form-control" readonly/>

                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Gateway Processing Fee  :</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type='text' name='processing_amount' id="processing_amount" readonly=""> 

                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Total Price :</label>
                                <div class="col-sm-6">
                                    <input type="text" name="total_amount" id="total_amount" class="form-control" readonly/>

                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Add Validity Days (like:365):</label>
                                <div class="col-sm-6">

                                    <input class="form-control" name="validitydate" type="text" id="validitydate" readonly="" >
                                </div>
                            </div>


                            <div class="row form-group">
                                <label for="focusedinput" class="col-sm-3 control-label"></label>
                                <div class="col-sm-6">
                                    <!-- payment_options Starts here -->
                                    <div id="payment_options">



                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs nav-tabs-payment">
                                            <li class="active"><a href="#bKash" id="tbkash" data-toggle="tab"> bKash</a></li>
                                            <li><a href="#credit" id="tcredit" data-toggle="tab">Credit or Debit Card</a></li>
                                            <li><a href="#internet_banking" id="tinternet_banking" data-toggle="tab">Internet Banking</a></li>
                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content">

                                            <div class="tab-pane active" id="bKash">
                                                <div class="mid_cont_btn">
                                                    <select style="display:none;" class="form-control" id="selected_mobile_transaction" name="selected_mobile_transaction"  >
                                                        <option value="1">bKash</option>
                                                    </select>

                                                </div>  

                                                <div class="clear"></div>
                                                <div class="v_gap"></div>
                                                <div class="clear"></div>

                                                <div id="bKash-panel-info">

                                                    <div class="col-md-12 " style="padding-top: 30px">
                                                        <div class="row form-group">
                                                            <div class="col-md-12">
                                                                <b style=""> Please select the check box if you want to pay via bkash</b>
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col-md-2">
                                                                <input type="checkbox" id='bkashPayment' onclick="getPaymentGateway('bkash')">
                                                            </div>
                                                            <div class="col-md-10">
                                                                <a  ><img class="hvr-push img-padding" src="<?php echo base_url() ?>images/payment_images/bkash-sq.png" width="62" height="62" alt="BKash" data-original-title="BKash" data-toggle="tooltip" data-placement="top"></a>
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col-md-1">
                                                                <i class="fa fa-info-circle"></i>   
                                                            </div>
                                                            <div class="col-md-11">
                                                                <i>  You would be redirected to a third party payment gateway where you can pay with your bkash account . Your payment transactions are 100% secure. On successful payment,  you would refilled your account.</i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="credit">
                                                <div class="col-md-12 " style="padding-top: 30px">
                                                    <div class="row form-group">
                                                        <label for="focusedinput" class="col-sm-4 control-label">Credit or Debit Card:</label>
                                                        <div class="col-sm-8 mid_cont_btn">
                                                            <select id="card_name" name="card_name_credit" class="form-control"   onchange="getPaymentGateway(this.value);" >
                                                                <option value="">Please select one</option>
                                                                <option value="dbbl_master" percentage="2.5">MASTER Dutch-Bangla </option>
                                                                <option value="dbbl_visa" percentage="2.5"> Dutch Bangla VISA </option>
                                                                <option value="dbbl_nexus" percentage="2">DBBL Nexus</option>
                                                                <option value="city_master" percentage="2.5">City Master Card</option>
                                                                <option value="city_amex" percentage="3.5">City Bank AMEX </option>
                                                                <option value="city_visa" percentage="2.5">City Bank Visa </option>
                                                                <option value="brac_master" percentage="3"> BRAC MASTER </option>
                                                                <option value="brac_visa" percentage="3">BRAC VISA </option>
                                                                <option value="ebl_master" percentage="2.5">EBL Master Card </option>
                                                                <option value="ebl_visa" percentage="2.5">EBL Visa</option>
                                                                <!--<option value="qcash" percentage="2.5">QCash</option>-->


                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row form-group">
                                                        <div class="col-md-12 info">
                                                            <div class="col-md-1">
                                                                <i class="fa fa-info-circle"></i>   
                                                            </div>
                                                            <div class="col-md-11">
                                                                <i>  You would be redirected to a third party payment gateway where you can pay with your credit or debit cards. Your payment transactions are 100% secure. On successful payment,  you would refilled your account.</i>
                                                            </div>  
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="internet_banking">
                                                <div class="col-md-12 " style="padding-top: 30px">
                                                    <div class="row form-group">
                                                        <label for="focusedinput" class="col-sm-4 control-label">Mobile Banking:</label>
                                                        <div class="col-sm-8 mid_cont_btn">
                                                            <select id="bank_card_name" name="card_name_mobile_banking" class="form-control"   onchange="getPaymentGateway(this.value);" >
                                                                <option value="">Please select one</option>
                                                                <option value="dbblmobilebanking" percentage="2">Rocket - DBBL Mobile Banking</option>
                                                                <option value="bankasia" percentage="2">Bank Asia Internet Banking</option>
                                                                <option value="city" percentage="3">City Touch Internet Banking</option>
                                                                <option value="ibbl" percentage="2">IBBL Internet & Mobile Banking</option>
                                                                <option value="mtbl" percentage="2">Mutual Trust Bank Internet Banking</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-12 info">
                                                            <div class="col-md-1">
                                                                <i class="fa fa-info-circle"></i>   
                                                            </div>
                                                            <div class="col-md-11">
                                                                <i> You would be redirected to a third party payment gateway where you can pay with your internet banking accounts. Your payment transactions are 100% secure. On successful payment,  you would refilled your account.</i>
                                                            </div>  
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row form-group" id="paymentId">
                                <label for="focusedinput" class="col-sm-3 control-label"></label>
                                <div class="col-sm-6">


                                    <input id="payNow" type="submit" name="submit" value="Pay Now"  class="btn btn-primary" />

                                </div>
                            </div>
                        </form>
                        <div class="row form-group">
                            <div class="col-md-3 pglogos">
                            </div>
                            <div class="col-md-9 pglogos">
                                Your payment transactions are 100% secure and 256-bit SSL encrypted.
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2 pglogos">

                            </div>
                            <div class="col-md-10 pglogos">
                                <img src="https://www.shohoz.com/img/sslcommerz_half.png" alt="sslcommerz" style="" />
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            function  getCalculation(smsPrice, processingCharge) {
                var processingPrice = (processingCharge * smsPrice) / 1000;
                var totalAmount = parseInt(smsPrice) + processingPrice;
                $("#processing_amount").val(processingPrice);
                totalAmount = Math.ceil(totalAmount);
                $("#total_amount").val(totalAmount);
            }
            function getPaymentGateway(selectedPakage) {
                var smsPrice = $("#sms_price").val();
                $("#selectedPaymentGateway").val(selectedPakage);

                switch (selectedPakage) {
                    case '<?php echo PAYMENT_GATEWAY_NAME_BKASH ?>':
                        if ($('#bkashPayment').is(':checked')) {
                            var processingCharge = '<?php echo TRANSACTION_PROCESSING_RATE_FOR_BKASH_MOBILE_BANKING ?>';
                            getCalculation(smsPrice, processingCharge);
                        } else {
                            $("#processing_amount").val(0);
                            $("#total_amount").val(smsPrice);
                            $("#selectedPaymentGateway").val("");
                        }
                        break;
                    case '<?php echo PAYMENT_GATEWAY_NAME_DBBL_Mobile_Banking ?>':
                        var processingCharge = '<?php echo TRANSACTION_PROCESSING_RATE_FOR_DBBL_Mobile_Banking ?>';
                        getCalculation(smsPrice, processingCharge);
                        break;
                    case '<?php echo PAYMENT_GATEWAY_NAME_Dutch_Bangla_MASTER ?>':
                        var processingCharge = '<?php echo TRANSACTION_PROCESSING_RATE_FOR_DBBL_MASTER ?>';
                        getCalculation(smsPrice, processingCharge);
                        break;
                    case '<?php echo PAYMENT_GATEWAY_NAME_Dutch_Bangla_VISA ?>':
                        var processingCharge = '<?php echo TRANSACTION_PROCESSING_RATE_FOR_DBBL_VISA ?>';
                        getCalculation(smsPrice, processingCharge);
                        break;
                    case '<?php echo PAYMENT_GATEWAY_NAME_DBBL_Nexus ?>':
                        var processingCharge = '<?php echo TRANSACTION_PROCESSING_RATE_FOR_DBBL_NEXUS ?>';
                        getCalculation(smsPrice, processingCharge);
                        break;
                    case '<?php echo PAYMENT_GATEWAY_NAME_CITY_AMEX ?>':
                        var processingCharge = '<?php echo TRANSACTION_PROCESSING_RATE_FOR_CITY_AMEX ?>';
                        getCalculation(smsPrice, processingCharge);
                        break;
                    case '<?php echo PAYMENT_GATEWAY_NAME_CITY_VISA ?>':
                        var processingCharge = '<?php echo TRANSACTION_PROCESSING_RATE_FOR_CITY_VISA ?>';
                        getCalculation(smsPrice, processingCharge);
                        break;
                    case '<?php echo PAYMENT_GATEWAY_NAME_CITY_MASTER ?>':
                        var processingCharge = '<?php echo TRANSACTION_PROCESSING_RATE_FOR_CITY_MASTER ?>';
                        getCalculation(smsPrice, processingCharge);
                        break;
                    case '<?php echo PAYMENT_GATEWAY_NAME_BRAC_MASTER ?>':
                        var processingCharge = '<?php echo TRANSACTION_PROCESSING_RATE_FOR_BRACK_MASTER ?>';
                        getCalculation(smsPrice, processingCharge);
                        break;
                    case '<?php echo PAYMENT_GATEWAY_NAME_BRAC_VISA ?>':
                        var processingCharge = '<?php echo TRANSACTION_PROCESSING_RATE_FOR_BRACK_VISA ?>';
                        getCalculation(smsPrice, processingCharge);
                        break;
                    case '<?php echo PAYMENT_GATEWAY_NAME_EBL_MASTER ?>':
                        var processingCharge = '<?php echo TRANSACTION_PROCESSING_RATE_FOR_BRACK_VISA ?>';
                        getCalculation(smsPrice, processingCharge);
                        break;
                    case '<?php echo PAYMENT_GATEWAY_NAME_EBL_VISA ?>':
                        var processingCharge = '<?php echo TRANSACTION_PROCESSING_RATE_FOR_EBL_VISA ?>';
                        getCalculation(smsPrice, processingCharge);
                        break;
                    case '<?php echo PAYMENT_GATEWAY_NAME_bankasia ?>':
                        var processingCharge = '<?php echo TRANSACTION_PROCESSING_RATE_FOR_bankasia_MOBILE_BANKING ?>';
                        getCalculation(smsPrice, processingCharge);
                        break;
                    case '<?php echo PAYMENT_GATEWAY_NAME_city ?>':
                        var processingCharge = '<?php echo TRANSACTION_PROCESSING_RATE_FOR_city_MOBILE_BANKING ?>';
                        getCalculation(smsPrice, processingCharge);
                        break;
                    case '<?php echo PAYMENT_GATEWAY_NAME_ibbl ?>':
                        var processingCharge = '<?php echo TRANSACTION_PROCESSING_RATE_FOR_ibbl_MOBILE_BANKING ?>';
                        getCalculation(smsPrice, processingCharge);
                        break;
                    case '<?php echo PAYMENT_GATEWAY_NAME_mtbl ?>':
                        var processingCharge = '<?php echo TRANSACTION_PROCESSING_RATE_FOR_mtbl_MOBILE_BANKING ?>';
                        getCalculation(smsPrice, processingCharge);
                        break;
                    default:
                        break;
                }

            }

            function numberValidation(phoneNumber) {
                var regexp = /^((^\880|0)[1][1|5|6|7|8|9])[0-9]{8}$/;
                var validPhoneNumber = phoneNumber.match(regexp);
                if (validPhoneNumber) {
                    return true;
                }
                return false;
            }
            function calculate(identity) {
                var selectedPackage = $("#selectedPackage").val();
                var numberOfSMS = $("#NumberOfSMS").val();
                var IsSubscribed = '<?php echo $IsSubscribed; ?>';
                if (identity == 1) {
                    if (typeof numberOfSMS == "undefined" || numberOfSMS == null || numberOfSMS == 0) {
                        if (IsSubscribed == <?php echo IsSubscribedOn; ?> && <?php echo $counter ?> == 0 ) {
                            $("#NumberOfSMS").val(<?php echo PACKAGE_TYPE_ID_SUBSCRIBER_NUMBER_OF_SMS; ?>);
                        }
                        else if (IsSubscribed == <?php echo IsSubscribedOn; ?> && <?php echo $counter ?> > 0) {
                            $("#NumberOfSMS").val(<?php echo PACKAGE_TYPE_ID_NON_MASKING_MINIMUM_NO_OF_SMS; ?>);
                        } else if (selectedPackage == <?php echo PACKAGE_TYPE_ID_NON_MASKING; ?>) {
                            $("#NumberOfSMS").val(<?php echo PACKAGE_TYPE_ID_NON_MASKING_MINIMUM_NO_OF_SMS; ?>);
                        } else if (selectedPackage == <?php echo PACKAGE_TYPE_ID_MASKING; ?>) {
                            $("#NumberOfSMS").val(<?php echo PACKAGE_TYPE_ID_MASKING_MINIMUM_NO_OF_SMS; ?>);
                        }

                    }
                }
                numberOfSMS = $("#NumberOfSMS").val();
                var smsPrice = 0;
                if (IsSubscribed == <?php echo IsSubscribedOn; ?> && <?php echo $counter ?> > 0 && numberOfSMS < <?php echo PACKAGE_TYPE_ID_NON_MASKING_MINIMUM_NO_OF_SMS; ?>) {
                    if (identity == 1) {
                        $("#NumberOfSMS").val(<?php echo PACKAGE_TYPE_ID_NON_MASKING_MINIMUM_NO_OF_SMS; ?>);
                    } else if (identity == 3) {
                        $("#NumberOfSMS").val(<?php echo PACKAGE_TYPE_ID_NON_MASKING_MINIMUM_NO_OF_SMS; ?>);
                        numberOfSMS = $("#NumberOfSMS").val();
                        alert("For Subscriber  the Minimum Purchase Quantity is 1000 SMS.");
                    }
                }
                else if (IsSubscribed == <?php echo IsSubscribedOn; ?> && <?php echo $counter ?> == 0 && numberOfSMS < <?php echo PACKAGE_TYPE_ID_SUBSCRIBER_NUMBER_OF_SMS; ?>) {
                    if (identity == 1) {
                        $("#NumberOfSMS").val(<?php echo PACKAGE_TYPE_ID_SUBSCRIBER_NUMBER_OF_SMS; ?>);
                    } else if (identity == 3) {
                        $("#NumberOfSMS").val(<?php echo PACKAGE_TYPE_ID_SUBSCRIBER_NUMBER_OF_SMS; ?>);
                        numberOfSMS = $("#NumberOfSMS").val();
                        alert("For Subscriber  the Minimum Purchase Quantity is 11,000 SMS.");
                    }
                } else if (selectedPackage == <?php echo PACKAGE_TYPE_ID_NON_MASKING; ?> && numberOfSMS < <?php echo PACKAGE_TYPE_ID_NON_MASKING_MINIMUM_NO_OF_SMS; ?>) {
                    if (identity == 1) {
                        $("#NumberOfSMS").val(<?php echo PACKAGE_TYPE_ID_NON_MASKING_MINIMUM_NO_OF_SMS; ?>);
                    } else if (identity == 3) {
                        $("#NumberOfSMS").val(<?php echo PACKAGE_TYPE_ID_NON_MASKING_MINIMUM_NO_OF_SMS; ?>);
                        numberOfSMS = $("#NumberOfSMS").val();
                        alert("For Non masking Package the Minimum Purchase Quantity is 1000 SMS.");
                    }

                } else if (selectedPackage == <?php echo PACKAGE_TYPE_ID_MASKING; ?> && numberOfSMS < <?php echo PACKAGE_TYPE_ID_MASKING_MINIMUM_NO_OF_SMS; ?>) {
                    if (identity == 1) {
                        $("#NumberOfSMS").val(<?php echo PACKAGE_TYPE_ID_MASKING_MINIMUM_NO_OF_SMS; ?>);
                        numberOfSMS = $("#NumberOfSMS").val();
                    } else if (identity == 3) {
                        $("#NumberOfSMS").val(<?php echo PACKAGE_TYPE_ID_MASKING_MINIMUM_NO_OF_SMS; ?>);
                        numberOfSMS = $("#NumberOfSMS").val();
                        alert("For Masking Package the Minimum Purchase Quantity is 1000 SMS.");
                    }

                }


                numberOfSMS = $("#NumberOfSMS").val();
                if (IsSubscribed == <?php echo IsSubscribedOn; ?> && <?php echo $counter ?> == 0) {
                    smsPrice = numberOfSMS * <?php echo PACKAGE_TYPE_ID_NON_MASKING_PER_SMS_RATE_FOR_SUBSCRIBER; ?>;
                    $("#PerSMSRate").val(<?php echo PACKAGE_TYPE_ID_NON_MASKING_PER_SMS_RATE_FOR_SUBSCRIBER; ?>);
                }
                else if (IsSubscribed == <?php echo IsSubscribedOn; ?> && <?php echo $counter ?> > 0) {
                    smsPrice = numberOfSMS * <?php echo PACKAGE_TYPE_ID_NON_MASKING_PER_SMS_RATE_FOR_SUBSCRIBER; ?>;
                    $("#PerSMSRate").val(<?php echo PACKAGE_TYPE_ID_NON_MASKING_PER_SMS_RATE_FOR_SUBSCRIBER; ?>);
                } else if (selectedPackage == <?php echo PACKAGE_TYPE_ID_NON_MASKING; ?> && numberOfSMS >= 1000 && 5000 > numberOfSMS) {
                    smsPrice = numberOfSMS * <?php echo PACKAGE_TYPE_ID_NON_MASKING_PER_SMS_RATE_LESS_1000; ?>;
                    $("#PerSMSRate").val(<?php echo PACKAGE_TYPE_ID_NON_MASKING_PER_SMS_RATE_LESS_1000; ?>);
                } 				
				else if (selectedPackage == <?php echo PACKAGE_TYPE_ID_NON_MASKING; ?> && numberOfSMS >= 5000 && 10000 > numberOfSMS) {
                    smsPrice = numberOfSMS * <?php echo PACKAGE_TYPE_ID_NON_MASKING_PER_SMS_RATE_5000_UP; ?>;
                    $("#PerSMSRate").val(<?php echo PACKAGE_TYPE_ID_NON_MASKING_PER_SMS_RATE_5000_UP; ?>);
                }				
				else if (selectedPackage == <?php echo PACKAGE_TYPE_ID_NON_MASKING; ?> && numberOfSMS >= 10000) {
                    smsPrice = numberOfSMS * <?php echo PACKAGE_TYPE_ID_NON_MASKING_PER_SMS_RATE_10000_UP; ?>;
                    $("#PerSMSRate").val(<?php echo PACKAGE_TYPE_ID_NON_MASKING_PER_SMS_RATE_10000_UP; ?>);
                } 
				else if (selectedPackage == <?php echo PACKAGE_TYPE_ID_MASKING; ?> && numberOfSMS < 100000) {
                    smsPrice = numberOfSMS * <?php echo PACKAGE_TYPE_ID_MASKIN_WITH_PER_SMS_RATE_LESS_100000; ?>;
                    $("#PerSMSRate").val(<?php echo PACKAGE_TYPE_ID_MASKIN_WITH_PER_SMS_RATE_LESS_100000; ?>);
                } else if (selectedPackage == <?php echo PACKAGE_TYPE_ID_MASKING; ?> && numberOfSMS > 100000) {
                    smsPrice = numberOfSMS * <?php echo PACKAGE_TYPE_ID_MASKIN_WITH_PER_SMS_RATE_100000_UP; ?>;
                    $("#PerSMSRate").val(<?php echo PACKAGE_TYPE_ID_MASKIN_WITH_PER_SMS_RATE_100000_UP; ?>);
                }
                $("#sms_price").val(smsPrice);
                if (IsSubscribed == <?php echo IsSubscribedOn; ?>) {
                    $("#validitydate").val(<?php echo SMS_VALIDATION_DATE_FOR_SUBSCRIBER; ?>);
                } else {
                    $("#validitydate").val(<?php echo SMS_VALIDATION_DATE; ?>);
                }
                var selectedPakage = $("#selectedPaymentGateway").val();
                if (typeof selectedPakage != "undefined" && selectedPakage != null && selectedPakage != "") {
                    getPaymentGateway(selectedPakage)
                }
//                console.log(numberOfSMS);
//                alert(numberOfSMS);
            }
            $(function () {
                $("#payment_gw").submit(function () {
                    var selectedPackage = $('#selectedPackage').val();
                    var totalAmount = $('#total_amount').val();
                    var NumberOfSMS = $('#NumberOfSMS').val();
                    var cellNo = $('#cus_phone').val();
                    var gatewayName = $("#selectedPaymentGateway").val();
                    var proceAmount = $("#processing_amount").val();
                    var MobileNo = $("#cus_phone").val();
                    if (numberValidation(cellNo) == false) {
                        alert("Please give a valid Mobile Number!");
                        return false;
                    }
                    var PerSMSRate = $('#PerSMSRate').val();
                    $.session.set('selectedPackage', selectedPackage);
                    $.session.set('totalAmount', totalAmount);
                    $.session.set('NumberOfSMS', NumberOfSMS);
                    $.session.set('cellNo', cellNo);
                    $.session.set('PerSMSRate', PerSMSRate);
                    $.session.set('PerSMSRate', PerSMSRate);
                    $.session.set('gatewayName', gatewayName);
                    $.session.set('proceAmount', proceAmount);
                    $.session.set('MobileNo', MobileNo);
                    return true;
                });
                $('#bkashPayment').prop('checked', true);
                $('#selectedPaymentGateway').val('<?php echo PAYMENT_GATEWAY_NAME_BKASH ?>')
                var frmvalidator = new Validator("payment_gw");
                frmvalidator.addValidation("selectedPackage", "dontselect=0", "Please Select A Package.");
                frmvalidator.addValidation("cus_phone", "req", "Please Give a Mobile Number.");
                frmvalidator.addValidation("multi_card_name", "req", "Please Select a Payment Gateway.");

//                $("#tcredit").on("click", function(){
////                   if ($('#bkashPayment').propertyIsEnumerable()
//                   $( '#bkashPayment' ).prop( "checked", false );
//                     var smsPrice = $("#sms_price").val();
//                     $('#selectedPaymentGateway').val("");
//                        getCalculation(smsPrice, 0);
//                });
            });
        </script>





