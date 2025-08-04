<script language="javascript">

    function checkEmail() {

        var email = document.getElementById('EmailAddress');
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        if (!filter.test(email.value)) {
            alert('Please provide a valid email address');
            //email.focus;
            return false;
        }
    }</script>
<div id="page-content">
    <div id='wrap'>
        <div class="container">
            <div class="panel panel-sky">
                <div class="panel-heading">
                    <h4>Create User</h4>
                </div>
                <div class="panel-body">
                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" id="UserInfoID">
                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Name</label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="UserName" type="text" id="UserName">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Password</label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="Password" type="password" id="Password" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Mobile Number</label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="MobileNo" type="text" id="MobileNo" >
                                </div>
                            </div>
							
							
							 <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-6">
                                    <input name="Email" type="text" id="Email" class="form-control" >
                                </div>
                            </div>
							
							
                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Company Name</label>
                                <div class="col-sm-6">
                                    <input name="CompanyName" type="text" id="CompanyName" class="form-control" >
                                </div>
                            </div>





                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Header Text</label>
                                <div class="col-sm-6">

                                    <input name="HeaderText" type="text" id="HeaderText" class="form-control" >
                                </div>
                            </div>



                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label"></label>
                                <div class="col-sm-6">



                                    <input name="Save"  class="btn btn-primary" type="submit" id="Save"  value="Save">
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div> <!-- row -->
</div> <!-- container -->
</div> <!-- page-content -->

</div> <!-- wrap -->
<script language="JavaScript" type="text/javascript">
    var frmvalidator = new Validator("UserInfoID");
    frmvalidator.addValidation("UserNameID", "req", "Write The User Name.");
    frmvalidator.addValidation("PasswordID", "req", "Write the password.");
	frmvalidator.addValidation("Email", "req", "Write the Email Address.");
    frmvalidator.addValidation("HeaderText", "req", "Write the Header Text.");
</script>

</div> <!-- page-content -->

<?php

function random_pass_generator($length) {
    $key = '';
    $keys = array_merge(range(0, 9));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key;
}

if ($_REQUEST['Save'] == 'Save') {
    $UserName = $_REQUEST['UserName'];
    $Password = $_REQUEST['Password'];
    $MobileNo = $_REQUEST['MobileNo'];
	$Email = $_REQUEST['Email'];
    $CompanyName = $_REQUEST['CompanyName'];
    $HeaderText = $_REQUEST['HeaderText'];

    $ckUser = ckUserExist($UserName, $cn);
    $lastUserID = getUserID($cn);
    $newUserID = $lastUserID + 1;

    if ($ckUser == '0') {
        $insertUserData = insertUser($cn, $UserName, $Password, $MobileNo,$Email, $CompanyName, $ckUser, $newUserID, $HeaderText);
        $url = base_url() . "index.php?parent=ShowUserInfo";
        popup('Succesfully Created User.', $url);
    } else {
        echo $ckUser;
    }
}

function getUserID($cn) {
    $getLastID = "select top 1 UserID from UserInfo order by UserID desc";
    $result_getLastID = odbc_exec($cn, $getLastID);
    while ($rsc = odbc_fetch_row($result_getLastID)) {
        $userID = odbc_result($result_getLastID, "UserID");
    }
    return $userID;
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

function insertUser($cn, $UserName, $Password, $MobileNo,$Email, $CompanyName, $ckUser, $newUserID, $HeaderText) {
    $insUser = $UserName;
    $insPass = $Password;
    $insMobileNo = $MobileNo;
	$insEmail =$Email;
    $insCompanyName = $CompanyName;
    $insUserID = $newUserID;
    $HeaderText = $HeaderText;

    $insertquery = "INSERT INTO UserInfo (UserID, UserName, Password, MobileNo,Email, CompanyName, CreatedBy, CreateDate,HeaderText) VALUES ('$insUserID', '$insUser', '$insPass', '$insMobileNo','$insEmail', '$insCompanyName', 'Admin', getdate(),'$HeaderText')";
//    exit; 
   $rs = odbc_exec($cn, $insertquery);
    echo "<center><h3>User Created Successfully.</h3></center>";
}
?>
