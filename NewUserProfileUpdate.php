<?php
session_start();
error_reporting(0);
set_time_limit(0);
require_once "Config/config.php";
require_once "Lib/lib.php";
?>




<?php
//function isExit3($cn, $userName, $userPass) {
//    $userName = $userName;
//    $userPass = $userPass;
//    $query = "select count(*) as Total from [BULKSMSPanel].[dbo].[UserInfo] where UserName='$userName' and [Password]='$userPass'";
//    $result = odbc_exec($cn, $query);
//    $arr = odbc_fetch_array($result);
//    $arr = $arr['Total'];
//    return $arr;
//}
?>


<!DOCTYPE html>
<html lang="en">
    <head>


        <style>
            .label1{
                float: left;
                height: 30px;
                padding-right: 4px;
                padding-top: 2px;
                position: relative;
                text-align: right;
                vertical-align: middle;
                width: 73px;
            }
            .label:before{
                content:"*" ;
                color:red    
            }
        </style>
        <meta charset="utf-8">
        <title>.:SMS Panel:.</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Avant">
        <meta name="author" content="The Red Team">

        <!-- <link href="assets/less/styles.less" rel="stylesheet/less" media="all"> -->
        <link rel="stylesheet" href="assets/css/styles.css">
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>

        <script type='text/javascript' src='assets/js/jquery-1.10.2.min.js'></script>
        <script type='text/javascript' src='assets/js/jqueryui-1.10.3.min.js'></script>
        <script type='text/javascript' src='assets/js/bootstrap.min.js'></script>
        <script type='text/javascript' src='assets/js/enquire.js'></script>
        <script type='text/javascript' src='assets/js/jquery.cookie.js'></script>
        <script type='text/javascript' src='assets/js/jquery.nicescroll.min.js'></script>
        <script type='text/javascript' src='assets/plugins/codeprettifier/prettify.js'></script>
        <script type='text/javascript' src='assets/plugins/easypiechart/jquery.easypiechart.min.js'></script>
        <script type='text/javascript' src='assets/plugins/sparklines/jquery.sparklines.min.js'></script>
        <script type='text/javascript' src='assets/plugins/form-toggle/toggle.min.js'></script>

        <script type='text/javascript' src='assets/plugins/jqueryui-timepicker/jquery.ui.timepicker.min.js'></script>
        <script type='text/javascript' src='assets/plugins/form-daterangepicker/daterangepicker.min.js'></script>
        <script type='text/javascript' src='assets/plugins/form-datepicker/js/bootstrap-datepicker.js'></script>
        <script type='text/javascript' src='assets/plugins/form-daterangepicker/moment.min.js'></script>

        <script type='text/javascript' src='assets/plugins/form-datetimepicker/bootstrap-datetimepicker.js'></script>


        <script type='text/javascript' src='assets/plugins/datatables/jquery.dataTables.min.js'></script>
        <script type='text/javascript' src='assets/plugins/datatables/dataTables.bootstrap.js'></script>
        <script type='text/javascript' src='assets/demo/demo-datatables.js'></script>
        <script type='text/javascript' src='assets/js/placeholdr.js'></script>
        <script type='text/javascript' src='assets/js/application.js'></script>
        <script type='text/javascript' src='assets/demo/demo.js'></script>
        <script language="JavaScript" src="js/form_validatorv31.js" type="text/javascript"></script>
        <script language="JavaScript" src="js/global.js" type="text/javascript"></script>

        <script language="JavaScript" src="js/AjaxFunctionHandler.js" type="text/javascript"></script>


<!-- <script type="text/javascript" src="assets/js/less.js"></script> -->
    </head>
    <body class="focusedform">

        <div class="verticalcenter">

            <div class="panel panel-primary">
                <div class="panel-body">
                    <p align="center"><h1>Complete Your Profile</h1></p>


                    <?php //echo $mgs;   ?>
                    <?php
                    $cn = ConnectDB();
                    $IsSubcribed = $_REQUEST['IsSubcribed'];
                    $userPass = $_REQUEST["userPass"];
                    $NewUserId = $_REQUEST["id"];


                    $showUser = "select UserID,UserName,Password,MobileNo from UserInfo where UserID='$NewUserId'";
                    $result_showUser_exec = odbc_exec($cn, $showUser);

                    $result_showUser_result = odbc_fetch_array($result_showUser_exec);
                    $UserNameNew = $result_showUser_result['UserName'];
                    $MobileNo = $result_showUser_result['MobileNo'];
                    $UserID = $result_showUser_result['UserID'];
                    $Password = $result_showUser_result['Password'];

//$Password = $_REQUEST["pass"];
//$tp=$Password
                    ?>

                    <form action="" class="form-horizontal" enctype="multipart/form-data" method="post" onSubmit="return checkEmail()" style ="margin-bottom: 0px !important;">

                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" name="NewUserName" id="username" placeholder="Enter You New User Name"  required>



                                    <span class="input-group-addon">*</span>
                                </div>
                            </div>
                        </div>


                        <span id="result"></span>


                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" name="userPass" class="form-control" id="password" placeholder="Enter a New Password" value= "<?php echo $Password; ?>" required readonly="">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                                    <input type="text" name="CompanyName" class="form-control" id="CompanyName" placeholder="Enter Your Company Name" required>
                                    <span class="input-group-addon">*</span>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">


                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                    <input type="text" name="MobileNo" class="form-control" id="Recipients" placeholder="<?php echo $MobileNo; ?>"  value= "<?php echo $MobileNo; ?>" required  readonly="">

                                </div>
                            </div>
                        </div>


                        <span id="mnInvalidLocation"></span>

                        <p id="mgsarea"></p>

                        <div class="form-group">
                            <div class="col-sm-12">	
                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                    <input  type="text" name="Email" class="form-control" id="Email" placeholder="Enter  Email address" required onclick="checkEmail()">
                                    <span class="input-group-addon">*</span>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-1"><input  name="chkAll" type="checkbox" id="isSubscribed" value="chk"></div> <div class="col-sm-10">Do you want to Subscribed?</div>
                        </div> 
                        <div class="clearfix">

                        </div>


                </div>

                <div class="panel" align="center">
                    <input class="btn btn-primary btn-block" type="submit" name="submit"  value="Update">

                </div>






                </form>


                <script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script>
                <script type="text/javascript">

                                        if ('<?php echo $IsSubcribed ?>' == 1) {
                                            $('#isSubscribed').prop('checked', true);
                                        }
                                        function validateEmail(email) {
                                            var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                                            return re.test(email);
                                        }

                                        function checkEmail() {
                                            var email = $('#Email').val();
                                            if (typeof email != "undefined" && email.length != 0) {
                                                var varificationResult = validateEmail(email);
                                                if (varificationResult == false) {
                                                    alert('Please provide a valid email address');
                                                    return false;
                                                }
                                            }
                                            return true;
                                        }
                                        ;


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
                                                $('#mgsarea').html("your number is valid");
                                            } else {


                                                $('#mgsarea').html("your number is not valid");


                                            }
                                            $('#mnInvalidMobile').html(invalid);

                                        });

                                        function mobileCheck(mobileNumber) {
                                            mobileNumber = mobileNumber.replace(/\W+/g, "");
                                            var chkVal = mobileNumber.match(/^(?:\+?88)?0?1[15-9]\d{8}$/);
                                            //alert(chkVal);
                                            return chkVal;
                                        }

                                        $(document).ready(function ()
                                        {
                                            $("#username").keyup(function ()
                                            {

                                                var name = $(this).val();

                                                if (name.length > 3)
                                                {
                                                    $("#result").html('checking...');

                                                    /*$.post("username-check.php", $("#reg-form").serialize())
                                                     .done(function(data){
                                                     $("#result").html(data);
                                                     });*/
                                                    var url = '<?php echo base_url() ?>usernamecheck.php'
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: url,
                                                        data: $(this).serialize(),
                                                        success: function (data)
                                                        {
                                                            $("#result").html(data);
                                                        }
                                                    });
                                                    return false;

                                                }
                                                else
                                                {
                                                    $("#result").html('');
                                                }



                                            });

                                        });
                </script>





<!--                <script language="javascript">

                    function checkEmail() {
                        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                        if (!filter.test(email.value)) {
                            email.focus;
                            return false;
                        }
                        return true;
                    };


                    function mobileCheck(mobileNumber) {
                        //mobileNumber = mobileNumber.replace(/\W+/g, "")
                        var chkVal = mobileNumber.match(/^(?:\+?88)?0?1[15-9]\d{8}$/);
                        //alert(chkVal);
                        return chkVal;
                    };

                    $(document).ready(function () {
                        $("#submit").click(function () {
                            var contactNumber = $.trim($("#Recipients").val());
                            var Email = $.trim($("#Email").val());
                            
                            //alert(contactNumber);
                            if (mobileCheck(contactNumber) == null) {
                                alert("Please Enter a Valid Mobile Number");
                            }
                            if (checkEmail(Email) != true) {
                              alert('Please provide a valid email address');
                            }




                        });

                    });
                </script>-->




                <?php
                if ($_POST['submit'] == "Update") {
                //echo $tp;
                $NewUserName = str_replace(" ", "_", $_POST['NewUserName']);

                $maskingIDSql = "CREATE VIEW $NewUserName as (SELECT UserName FROM UserInfo where UserName = '$NewUserName')";
                odbc_exec($cn, $maskingIDSql);
                $newSQL = "SELECT * FROM $NewUserName";
                $result_maskingIDSql = odbc_exec($cn, $newSQL);
                $countArray = odbc_fetch_array($result_maskingIDSql);
                if (!empty($countArray)) {

                echo "<span style='color:brown;'>Sorry $NewUserName already taken !!! please select another.</span>";
                return;
                } 
                $userPass = $_POST['userPass'];
                $CompanyName = $_POST['CompanyName'];

                $NewMobileNo = $_REQUEST['MobileNo'];
                $Email = $_POST['Email'];
                $check = $_REQUEST['chkAll'];
                if ($check != "" || $check != null) {
                $IsSubscribed = IsSubscribedOn;
                } else {
                $IsSubscribed = IsSubscribedOff;
                }

                //$ckUserID = checkUserID($userName, $cn);

                $update = "update UserInfo set UserName='$NewUserName', Password = '$userPass',Email = '$Email',MobileNo='$NewMobileNo', CompanyName = '$CompanyName', HeaderText = '$NewUserName', IsSubscribed='$IsSubscribed', IsActive='1' where  UserID='$NewUserId'";
                $result_update = odbc_exec($cn, $update);

                $insertUserRole = "Insert into UserRole (UserID, RoleID, CreatedBy, CreateDate) Values ('$NewUserId','reseller','Admin',getdate())";
                odbc_exec($cn, $insertUserRole);
                //MsgBox('User Updated Successfully');
                //$_SESSION['User'] = $userName;
                $_SESSION['User'] = $NewUserName;
                $_SESSION["Login"] = "True";


                $file = file_get_contents(get_mail_server_url() . "test_smtp_basic_update_mail.php?sub=Thank+you+for+Registering&number=$MobileNo&uname=$NewUserName&password=$userPass&CompanyName=$CompanyName&Email=$Email", FILE_USE_INCLUDE_PATH);

                ReDirect("index.php?parent=home");







//echo "<font color='#008000'><p align='center'>Profile updated successfully.</p></font>";
// ReDirect("index.php?parent=home");
                }

                function checkUserID($userName, $cn) {
                $user = $userName;

                //echo $user='TempOnlineUser';
                $isexistUser = "select count(*) as count from  UserInfo where UserName = '$userName'";
                $result_isexistUser = odbc_exec($cn, $isexistUser);
                while ($rs = odbc_fetch_row($result_isexistUser)) {
                $isExistUser = odbc_result($result_isexistUser, "count");
                }

                $isExistUser;
                If ($isExistUser == '1') {

                } else {
                return $isExistUser;
                }
                }
                ?>

            </div>
        </div>

    </body>
</html>
