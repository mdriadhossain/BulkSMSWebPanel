<?php
ob_start();
session_start();
require_once "Config/config.php";
require_once "Lib/lib.php";
$cn = ConnectDB();
$UserName = $_SESSION['User'];
$userDetail = "SELECT UserName,Email FROM BULKSMSPanel.dbo.UserInfo where UserName='$UserName'";
$result_userDetail = odbc_exec($cn, $userDetail);
$userInfo = odbc_fetch_array($result_userDetail);
$tran_id = generateRandomString();
?>
<div id="page-content">
    <div id='wrap'>
        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>Recharge Balance</h4>
                </div>
                <div class="panel-body">
                    <div class="panel-body collapse in">
                        <form  id="payment_gw" name="payment_gw" method="POST" action="<?php echo $paymentGateWayPostAPI; ?>">
                            <input type="hidden" name="store_id" id="store_id" value="<?php echo PAYMENT_GATEWAY_STORE_ID; ?>" />
                            <input type="hidden" name="tran_id" name="tran_id" value="<?php echo $tran_id; ?>" />
                            <input type="hidden" name="success_url" value="<?php echo $paymentGateWaySuccessURL; ?>" />
                            <input type="hidden" name="fail_url" value="<?php echo $paymentGateWayFailedOrCancelURL; ?>" />
                            <input type="hidden" name="cancel_url" value="<?php echo $paymentGateWayFailedOrCancelURL; ?>" />
                            <input type="hidden" name="cus_name" value="<?php echo $userInfo['UserName']; ?>">
                            <input type="hidden" name="cus_email"  value="<?php echo $userInfo['Email']; ?>">                         
<input type='hidden' name='multi_card_name' value='dbblmobilebanking,bankasia,city,ibbl,mtbl'>  
<div class=" row form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Interested Package:</label>
                                <div class="col-sm-6">
                                    <select class="form-control" id="selectedPackage" name="InterestedPackage" onchange="calculate(1)">
                                        <option value="0" selected="selected">Please Select a Package</option>
                                        <option value="<?php echo PACKAGE_TYPE_ID_NON_MASKING; ?>">Non-Masking</option>
                                        <option value="<?php echo PACKAGE_TYPE_ID_MASKING; ?>">Masking</option>
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
                                <label for="focusedinput" class="col-sm-3 control-label">Mobile No :</label>
                                <div class="col-sm-6">
                                    <input type="text" name="cus_phone" id="cus_phone" class="form-control"/>

                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Amount :</label>
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
                            <div class="row form-group" id="paymentId">
                                <label for="focusedinput" class="col-sm-3 control-label"></label>
                                <div class="col-sm-6">


                                    <input id="payNow" type="submit" name="submit" value="Pay Now"  class="btn btn-primary" />

                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

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
        if (identity == 1) {
            if (typeof numberOfSMS == "undefined" || numberOfSMS == null || numberOfSMS == 0) {
                if (selectedPackage == <?php echo PACKAGE_TYPE_ID_NON_MASKING; ?>) {
                    $("#NumberOfSMS").val(<?php echo PACKAGE_TYPE_ID_NON_MASKING_MINIMUM_NO_OF_SMS; ?>);
                } else if (selectedPackage == <?php echo PACKAGE_TYPE_ID_MASKING; ?>) {
                    $("#NumberOfSMS").val(<?php echo PACKAGE_TYPE_ID_MASKING_MINIMUM_NO_OF_SMS; ?>);
                }

            }
        }
        numberOfSMS = $("#NumberOfSMS").val();
        var totalAmount = 0;
        if (selectedPackage == <?php echo PACKAGE_TYPE_ID_NON_MASKING; ?> && numberOfSMS < <?php echo PACKAGE_TYPE_ID_NON_MASKING_MINIMUM_NO_OF_SMS; ?>) {
            if (identity == 1) {
                $("#NumberOfSMS").val(<?php echo PACKAGE_TYPE_ID_NON_MASKING_MINIMUM_NO_OF_SMS; ?>);
            } else if (identity == 3) {
                $("#NumberOfSMS").val(<?php echo PACKAGE_TYPE_ID_NON_MASKING_MINIMUM_NO_OF_SMS; ?>);
                numberOfSMS = $("#NumberOfSMS").val();
                alert("For Non masking Package the Minimum Purchase Quantity is 5,000 SMS.");
            }

        } else if (selectedPackage == <?php echo PACKAGE_TYPE_ID_MASKING; ?> && numberOfSMS < <?php echo PACKAGE_TYPE_ID_MASKING_MINIMUM_NO_OF_SMS; ?>) {
            if (identity == 1) {
                $("#NumberOfSMS").val(<?php echo PACKAGE_TYPE_ID_MASKING_MINIMUM_NO_OF_SMS; ?>);
                numberOfSMS = $("#NumberOfSMS").val();
            } else if (identity == 3) {
                $("#NumberOfSMS").val(<?php echo PACKAGE_TYPE_ID_MASKING_MINIMUM_NO_OF_SMS; ?>);
                numberOfSMS = $("#NumberOfSMS").val();
                alert("For Masking Package the Minimum Purchase Quantity is 50,000 SMS.");
            }

        }

        if (selectedPackage == <?php echo PACKAGE_TYPE_ID_NON_MASKING; ?> && numberOfSMS < 10000) {
            totalAmount = numberOfSMS * <?php echo PACKAGE_TYPE_ID_NON_MASKING_PER_SMS_RATE_LESS_10000; ?>;
            $("#PerSMSRate").val(<?php echo PACKAGE_TYPE_ID_NON_MASKING_PER_SMS_RATE_LESS_10000; ?>);

        } else if (selectedPackage == <?php echo PACKAGE_TYPE_ID_NON_MASKING; ?> && numberOfSMS > 10000) {
            totalAmount = numberOfSMS * <?php echo PACKAGE_TYPE_ID_NON_MASKING_PER_SMS_RATE_10000_UP; ?>;
            $("#PerSMSRate").val(<?php echo PACKAGE_TYPE_ID_NON_MASKING_PER_SMS_RATE_10000_UP; ?>);

        } else if (selectedPackage == <?php echo PACKAGE_TYPE_ID_MASKING; ?> && numberOfSMS < 100000) {
            totalAmount = numberOfSMS * <?php echo PACKAGE_TYPE_ID_MASKIN_WITH_PER_SMS_RATE_LESS_100000; ?>;
            $("#PerSMSRate").val(<?php echo PACKAGE_TYPE_ID_MASKIN_WITH_PER_SMS_RATE_LESS_100000; ?>);
        } else if (selectedPackage == <?php echo PACKAGE_TYPE_ID_MASKING; ?> && numberOfSMS > 100000) {
            totalAmount = numberOfSMS * <?php echo PACKAGE_TYPE_ID_MASKIN_WITH_PER_SMS_RATE_100000_UP; ?>;
            $("#PerSMSRate").val(<?php echo PACKAGE_TYPE_ID_MASKIN_WITH_PER_SMS_RATE_100000_UP; ?>);
        }
        $("#total_amount").val(totalAmount);
        $("#validitydate").val(<?php echo SMS_VALIDATION_DATE; ?>);
    }
    $(function () {
        $("#payment_gw").submit(function () {
            var selectedPackage = $('#selectedPackage').val();
            var totalAmount = $('#total_amount').val();
            var NumberOfSMS = $('#NumberOfSMS').val();
            var cellNo = $('#cus_phone').val();
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
            return true;
        });

        var frmvalidator = new Validator("payment_gw");
        frmvalidator.addValidation("selectedPackage", "dontselect=0", "Please Select A Package.");
        frmvalidator.addValidation("cus_phone", "req", "Please Give a Mobile Number.");
        frmvalidator.addValidation("total_amount", "req", "Please Give an Amount.");
    });
</script>





