<?php
ob_start();
error_reporting(0);
set_time_limit(0);
require_once "Config/config.php";
require_once "Lib/lib.php";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>.:SMS Panel:.</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Avant">
        <meta name="author" content="The Red Team">

        <!-- <link href="assets/less/styles.less" rel="stylesheet/less" media="all"> -->
        <link rel="stylesheet" href="assets/css/styles.css">
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<!-- <script type="text/javascript" src="assets/js/less.js"></script> -->
    </head>
    <body class="focusedform">

        <div class="verticalcenter">

            <div class="panel panel-primary">
                <div class="panel-body">
                    <center><img align="center" src="images/solvers_logo.png" alt="Solvers" width="250" hight="80"/></center>
                    <p align="center"><h4 align="center">Registration</h4></p>
                 <!--<p align="center"><h3 align="center">Registration</h3></p>-->
                    <p align="center"><b>Please Put a Valid Mobile Number For Registration</b></p>
                    <?php echo $mgs; ?>
                    <form action="" class="form-horizontal" enctype="multipart/form-data" method="post" style="margin-bottom: 0px !important;">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                    <input type="text" class="form-control" name="userName"  placeholder="Mobile Number" id="Recipients">
                                </div>
                            </div>
                        </div>					
                        <span id="mnInvalidLocation"></span>
                        <p id="mgsarea"></p>
                        <script type="text/javascript">
                            function userRegistration() {
                                var mobileNumer = $("#Recipients").val();
                                if (typeof mobileNumer == "undefined" || mobileNumer == "") {
                                    alert("Please Give a Mobile Number.");
                                    return false;
                                }
                            }

                            $('#Recipients').on("input propertychange", function () {
                                var data = $('#Recipients').val();
                                data = data.replace(/\n/g, ',');
                                var numbers = data.split(",");
                                var invalid = 0;
                                var total = 0;
                                for (var i = 0; i < numbers.length; i++) {
                                    if (numbers[i].trim() != "") {
                                        total++;
                                        if (window.mobileCheck(numbers[i]) == null) {
                                            invalid++;
                                        }
                                    }
                                }
                                var valid = total - invalid;
                                $('#mnValidMobile').html(valid);
                                if (valid == 1) {
                                    $('#mgsarea').html("Remarks: Your Number is Valid");
                                } else {
                                    $('#mgsarea').html("Remarks: Your Number is not Valid.Please put valid BD Mobile Number only.");
                                }
                                $('#mnInvalidMobile').html(invalid);

                            });

                            function mobileCheck(mobileNumber) {
                                mobileNumber = mobileNumber.replace(/\W+/g, "")
                                var chkVal = mobileNumber.match(/^(?:\+?88)?0?1[15-9]\d{8}$/);
                                //alert(chkVal);
                                return chkVal;
                            }

                        </script>

                        <div class="row form-group">
                            <div class="col-sm-1"><input  name="chkAll" type="checkbox" id="chkAll" value="chk"></div> <div class="col-sm-10">I agree to the Barta SMS service </div>
                            <div >
                                <a href="TermsConditions.php">Terms & Conditions</a> | <a href="PrivacyPolicy.php">Privacy Policy</a>
                            </div>

                        </div> 
                        <div class="clearfix">
                        </div>
                </div>
                <div class="panel" align="center">
                    <input class="btn btn-primary btn-block" id="submit" type="submit" name="submit"  value="Registration" onclick="userRegistration()">

                </div>


                </form>
                <?php
                $IsSubcribed = $_GET['IsSubcribed'];
                $cn = ConnectDB();
                if ($_POST['submit'] == "Registration") {

                    $userName = $_POST['userName'];
                    if (cell_number_validation($userName) == FALSE) {
                        return FALSE;
                    }
                    $userName = "88".$userName;
                    $userPass = $_POST['userPass'];

                    $check = $_REQUEST['chkAll'];

                    /* if ($userName > 10) {
                      $InitialMSISDN = substr($userName, -10);
                      $SendTo = "880" . $InitialMSISDN;
                      $MSISDN = $SendTo;
                      }
                      $FINALMSISDN=strlen($MSISDN);
                      echo $FINALMSISDN;
                      echo $userName; */
                    if ($check == "" || $check == null) {
                        popup('You have to agree with Our Terms & Conditions and Privacy Policy.Please click the check box.');

                    }











//echo"test";



                    $ScheduleTime = date('Y-m-d H:i:s');

                    $ScheduleTime = $ScheduleTime . '.000';

                    function random_string($length) {
                        $key = '';
                        $keys = array_merge(range(0, 9));

                        for ($i = 0; $i < $length; $i++) {
                            $key .= $keys[array_rand($keys)];
                        }

                        return $key;
                    }

//echo "tid";
                    $tid = random_string(6);

                    function getUserID($cn) {
                        $getLastID = "select top 1 UserID from UserInfo order by UserID desc";
                        $result_getLastID = odbc_exec($cn, $getLastID);
                        while ($rsc = odbc_fetch_row($result_getLastID)) {
                            $userID = odbc_result($result_getLastID, "UserID");
                        }
                        return $userID;
                    }

                    $lastUserID = getUserID($cn);
                    $newUserID = $lastUserID + 1;
                    $inserttempuserquery = "INSERT INTO UserInfo ( UserID,UserName,Password, MobileNo,IsActive,CreatedBy, CreateDate,HeaderText ) VALUES ('$newUserID','TempOnlineUser', '$tid', '$userName','0','Admin', getdate(),'TempOnlineUser')";
                    $rs = odbc_exec($cn, $inserttempuserquery);
               


                    $showUser = "select UserName,Password,MobileNo from UserInfo where MobileNo='$userName'";
                    $result_showUser_exec = odbc_exec($cn, $showUser);

                    $result_showUser_result = odbc_fetch_array($result_showUser_exec);
                    $UserName = $result_showUser_result['UserName'];
                    $MobileNo = $result_showUser_result['MobileNo'];
                    $Password = $result_showUser_result['Password'];




                    $mainlink = "http://smsreport.solversbd.com";

                    $msg = "Thank you for registering at BARTA SMS Service.Your Password :" . $Password . " Please Visit " . $mainlink . " Call 8801973390330 for help.";

                    /*
                      $sql_insertoutbox ="INSERT INTO [BULKSMSGateway_1_0].[dbo].[SMSOutbox] (srcMN,dstMN, msg, writeTime, sentTime, msgStatus, retrycount, srcTON, srcNPI, msgType, esm_Class, Data_Coding, smsPart, totalPart, refID,Schedule,srcAccount, destAccount, Remarks,ContentSubCategoryID,ServiceID,IN_MSG_ID)
                      VALUES ('DEMO','$MobileNo','$msg', getdate(),'', 'QUE', '3', '1','1', 'TEXT', '64', '1', '1', '1', '','$ScheduleTime','Admin', 'Admin', '','','','' )";

                      $result = odbc_exec($cn, $sql_insertoutbox);

                     */

                    //echo $ScheduleTime;

                    $InMSgID = $MobileNo . date('YmdHis') . rand(1, 99);
                    $SMSPermitQuery = 'DECLARE @returnValue INT;';
                    $SMSPermitQuery.='EXEC @returnValue=[BULKSMSPanel].[dbo].[PermitSMSProc]';
                    $SMSPermitQuery.="@UserName ='SOLVERS',";
                    $SMSPermitQuery.="@Password ='solvers@bulk432',";
                    $SMSPermitQuery.="@RequestedIP='127.0.0.1',";
                    $SMSPermitQuery.="@SendFrom ='SOLVERSBD',";
                    $SMSPermitQuery.="@SendTo ='$MobileNo',";
                    $SMSPermitQuery.="@InMSgID ='$InMSgID',";
                    $SMSPermitQuery.="@ScheduleTime ='$ScheduleTime',";
                    $SMSPermitQuery.="@msg ='$msg';";
                    $SMSPermitQuery.="select @returnValue as ReturnVal; ";
                    //echo $SMSPermitQuery="SELECT count(ID) as ReturnVal from BULKSMSPanel.dbo.[ExpenceHistory]"; //exit;
                    $SMSPermitQuery;


                    $result = odbc_exec($cn, $SMSPermitQuery);
                    $PermitReturnValArray = odbc_fetch_array($result);
                    $PermitReturnVal = $PermitReturnValArray['ReturnVal'];


                    $UserEmail = "sse1@solversbd.com";

                    //$file = file_get_contents("http://45.64.135.90/PHPMailer/examples/test_smtp_basic.php?sub=New%20User%20Registration&number=88019139999", FILE_USE_INCLUDE_PATH);
                    $file = file_get_contents(get_mail_server_url() . "test_smtp_basic.php?sub=NewUserRegistration&number=$MobileNo", FILE_USE_INCLUDE_PATH);


                    ReDirect("PasswordConfirmation.php?parent=home&IsSubcribed=$IsSubcribed");
                }

                // else if ($('#chkAll:checked').length <= 0){
                //if($('#chkAll').attr('checked')){


                /* $arr = isExit3($cn, $userName, $userPass);
                  if ($arr > '0') {
                  $_SESSION['User'] = $userName;
                  $_SESSION["Login"] = "True";
                  ReDirect("index.php?parent=home");
                  } else {
                  echo "<font color='#FF0000'><p align='center'>Wrong User ID and/or Password.</p></font>";
                  } */


                function cell_number_validation($cell_no) {
                    if (preg_match("/^((^\880|0)[1][1|5|6|7|8|9])[0-9]{8}$/", $cell_no) === 0) {
                        RETURN FALSE;
                    } else {
                        RETURN TRUE;
                    }
                }

                function ckUserExist($UserName, $cn) {
                    $user = $UserName;
                    $isexistUser = "select count(*) as count from UserInfo where UserName = '$UserName'";
                    $result_isexistUser = odbc_exec($cn, $isexistUser);
                    while ($rs = odbc_fetch_row($result_isexistUser)) {
                        $existUser = odbc_result($result_isexistUser, "count");
                    }
                    If ($existUser == '1') {
                        $url = base_url() . "index.php?parent=ShowUserInfo";
                        popup('Sorry!! User Already Exist.', $url);
                    } else {
                        return $existUser;
                    }
                }

                function isExit3($cn, $userName, $userPass) {
                    $userName = $userName;
                    $userPass = $userPass;
                    $query = "select count(*) as Total from [BULKSMSPanel].[dbo].[UserInfo] where UserName='$userName' and [Password]='$userPass'";
                    $result = odbc_exec($cn, $query);
                    $arr = odbc_fetch_array($result);
                    $arr = $arr['Total'];
                    return $arr;
                }
                ?>
            </div>
        </div>

    </body>
</html>
