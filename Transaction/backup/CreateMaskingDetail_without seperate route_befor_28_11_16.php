<?php
require_once "Config/config.php";
require_once "Lib/lib.php";
$cn = ConnectDB();
?>

<?php
$userDetail = "SELECT UserID, UserName FROM BULKSMSPanel.dbo.UserInfo where Username<>'admin'";
$result_userDetail = odbc_exec($cn, $userDetail);
?>
<link rel="stylesheet" href="style.css" type="text/css" />
<script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
        $("#MaskingName").keyup(function()
        {
                var name = $(this).val();

                if(name.length > 3)
                {
                        $("#result").html('checking...');

                        /*$.post("username-check.php", $("#reg-form").serialize())
                                .done(function(data){
                                $("#result").html(data);
                        });*/

                $.ajax({
                    type: 'POST',
                    url: 'http://localhost/bulksmswebpanel/Transaction/maskingidcheck.php',
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
<div id="page-content">
    <div id='wrap'>

        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>Create Masking Detail</h4>
                </div>
                <div class="panel-body">


                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->

                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" id="UserInfoID" name="CreateMaskingDetail">

                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">User Name:</label>
                                <div class="col-sm-6">

                                    <select class="form-control" name="UserName" id="UserName">
                                        <option value=''>Select User:</option>
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


                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">MaskingID:</label>
                                <div class="col-sm-6">

                                    
                                    <fieldset>
                                        <div>
                                            <input class="form-control" type="text" name="MaskingName" id="MaskingName" maxlength="11" placeholder="MaskingID should not exceed 11  characters"/>
                                            <br/>
                                            <span id="result"></span>
                                        </div>
                                    </fieldset>

                                </div>
                            </div>


                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">RequestingIP:</label>
                                <div class="col-sm-6">

                                    <input class="form-control" name="RequestingIP" type="text" id="RequestingIP" >
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label"></label>
                                <div class="col-sm-6">

                                    <input class="btn btn-primary" name="Save"  type="submit" id="Save"  value="Save">

                                </div>
                            </div>
                        </form>
                        <script language="JavaScript" type="text/javascript">
                            var frmvalidator = new Validator("CreateMaskingDetail");

                            //frmvalidator.addValidation("Status", "dontselect=0", "Please Select Status.");
                            frmvalidator.addValidation("name", "req", "Please Type MaskingID.");
                            frmvalidator.addValidation("RequestingIP", "req", "Please Type RequestingIP.");
                            //frmvalidator.addValidation("end_date", "req", "Select The End Date.");</script>

                    </div>
                    <form id="reg-form" action="" method="post" autocomplete="off">
                        
                    </form>
                    <?php
                    if ($_REQUEST['Save'] == 'Save') {
                        $UserName = $_REQUEST['UserName'];
                        $MaskingID = $_REQUEST['MaskingName'];
                        $RequestingIP = $_REQUEST['RequestingIP'];

    $ckMaskingID = ckMaskingIDExist($MaskingID, $cn);
    if ($ckMaskingID == 0) {
        $insertMaskingDetailquery = "INSERT INTO MaskingDetail (UserName, MaskingID,RequestingIP) VALUES ('$UserName', '$MaskingID', '$RequestingIP')";
    $rs = odbc_exec($cn, $insertMaskingDetailquery);

        $url = base_url() . "index.php?parent=CreateMaskingDetail";
        popup('Succesfully Created Masking ID.', $url);
    }
}



    function ckMaskingIDExist($MaskingID, $cn) {
    //echo $user = $MaskingID;
    $isexistUser = "select count(*) as count from MaskingDetail where MaskingID = '$MaskingID'";
    $result_isexistUser = odbc_exec($cn, $isexistUser);
    while ($rs = odbc_fetch_row($result_isexistUser)) {
        $existUser = odbc_result($result_isexistUser, "count");
    }
    If ($existUser == '1') {
        $url = base_url() . "index.php?parent=CreateMaskingDetail";
        popup('Sorry!! Masking ID Already Exist.', $url);
    } else {
        return $existUser;
    }
}
                    ?>
                </div>


            </div>
        </div>
    </div> <!-- row -->
</div> <!-- container -->


</div> <!-- page-content -->

</div> <!-- wrap -->

</div> <!-- page-content -->
