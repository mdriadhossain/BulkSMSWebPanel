<?php
require_once 'tinieditor.php';
$conn = PDOConnectDB();
$userDetail = "SELECT UserID, UserName FROM BULKSMSPanel.dbo.UserInfo Order By UserName ASC";
$result_userDetail = odbc_exec($cn, $userDetail);
?>
<script language="javascript" type="text/javascript">
    function limitText(limitField, limitCount, limitNum) {
        if (limitField.value.length > limitNum) {
            limitField.value = limitField.value.substring(0, limitNum);
        } else {
            limitCount.value = limitNum - limitField.value.length;
        }
    }
</script>

<link rel="stylesheet" href="bootstrap-select/dist/css/bootstrap-select.css">
<script type="text/javascript" src="bootstrap-select/dist/js/bootstrap-select.js"></script>

<div id="page-content">
    <div id='wrap'>
        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>Group Email</h4>
                </div>
                <div class="panel-body">
                    <div class="panel-body collapse in">
                        <form onSubmit="return validationCheck()" class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="SchedulePromotionID" id="user" >

                            <?php
                            if ($User == "Admin" || $User == "admin") {
                                ?>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label">Select User Name :</label>
                                    <div class="col-sm-6">
                                        <select name="opt" id="opt" type="text" class="form-control selectpicker"  data-live-search="true" >
                                            <option selected='All'>All</option>
                                            <?php
                                            while ($n = odbc_fetch_row($result_userDetail)) {
                                                $UserID = odbc_result($result_userDetail, "UserID");
                                                $UserName = odbc_result($result_userDetail, "UserName");
                                                echo "<option value='$UserName'>$UserName</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>


                            <div id="autoUpdate" class="autoUpdate">
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label">Subject</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="EmailSubject" id="EmailSubject" cols="100" rows="1" >
                                    </div>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Body</label>
                                <div class="col-sm-6">

                                    <textarea class="form-control" name="SMSText" ></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label"></label>
                                <div class="col-sm-6">
                                    <input  class="btn btn-primary" name="submit" type="submit" value="send">
                                </div>
                            </div>
                        </form>
                    </div>

                    <script language="JavaScript" type="text/javascript">

                        var frmvalidator = new Validator("SchedulePromotionID");
//                        frmvalidator.addValidation("opt", "dontselect=0", "Please Select the Operator Name.");
                        frmvalidator.addValidation("SMSTextID", "req", "Body Can not be null.");
                    </script>
                    <?php
                    if ($_REQUEST['submit'] == "send") {

                        $selectUser = $_REQUEST['opt'];
                        $body = $_REQUEST['SMSText'];
                        $subject = $_REQUEST['EmailSubject'];
                        if ($selectUser == 'All') {
                            $Query = "SELECT Email FROM BULKSMSPanel.dbo.UserInfo where  Email LIKE '%_@__%.__%'";
                        } else {
                            $Query = "SELECT Email FROM BULKSMSPanel.dbo.UserInfo where  UserName = '$selectUser' and Email LIKE '%_@__%.__%'";
                        }
                        $result = odbc_exec($cn, $Query);
                        $receiptEmail = "";
                        while ($row = odbc_fetch_array($result)) {
                            $receiptEmail = $receiptEmail . $row['Email'] . ",";
                        }
                         $MailURL = get_mail_server_url() . "test_smtp_group_mail.php?subject=$subject&receipent=$receiptEmail&body=$body";
                        $MainMailURL = str_replace(" ", "+", $MailURL);

                        //echo $ChargingInterfaceURL;exit;

                        $ChargingURLResponce = file_get_contents($MainMailURL);
                        popup('Email Sent Successfully!');
                        exit;
                    }
                    ?>
                </div>


            </div>
        </div>
    </div> <!-- row -->
</div> <!-- container -->

