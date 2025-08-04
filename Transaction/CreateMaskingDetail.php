<?php
require_once "Config/config.php";
require_once "Lib/lib.php";
$cn = ConnectDB();
?>

<?php
$userDetail = "SELECT UserID, UserName FROM BULKSMSPanel.dbo.UserInfo where Username<>'admin' Order By UserName ASC";
$result_userDetail = odbc_exec($cn, $userDetail);
?>
<link rel="stylesheet" href="style.css" type="text/css" />
<!--<script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script>-->
<script type="text/javascript">
    $(document).ready(function ()
    {


        $("#MaskingName").keyup(function ()
        {
            var name = $(this).val();

            if (name.length > 3)
            {
                $("#result").html('checking...');

                /*$.post("username-check.php", $("#reg-form").serialize())
                 .done(function(data){
                 $("#result").html(data);
                 });*/
                var url = '<?php echo base_url() ?>Transaction/maskingidcheck.php'
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
<div id="page-content">
    <div id='wrap'>

        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>Create Masking Detail</h4>
                </div>
                <div class="panel-body">
                    <?php
                    random_string(6);
                    $uniqueIdTime = time();
                    $uniqueIdRand = mt_rand();

//echo $providedcode = date("His") . rand(pow(10, 4 - 1), pow(10, 4) - 1);
                    ?>

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
                                <label for="focusedinput" class="col-sm-3 control-label">Masking ID:</label>
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
                                <label for="focusedinput" class="col-sm-3 control-label">GP Masking IS Active:</label>
                                <div class="col-sm-6">

                                    <select class="form-control" name="GPMaskingIsActive" id="GPMaskingIsActive">
                                        <option selected="selected" value='0'>In-Active</option>
                                        <option value='1'>Active</option>

                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">RO Masking IS Active:</label>
                                <div class="col-sm-6">

                                    <select class="form-control" name="ROMaskingIsActive" id="ROMaskingIsActive">
                                        <option selected="selected" value='0'>In-Active</option>
                                        <option value='1'>Active</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">BL Masking IS Active:</label>
                                <div class="col-sm-6">

                                    <select class="form-control" name="BLMaskingIsActive" id="BLMaskingIsActive">
                                        <option selected="selected" value='0'>In-Active</option>
                                        <option value='1'>Active</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">AT Masking IS Active:</label>
                                <div class="col-sm-6">

                                    <select class="form-control" name="ATMaskingIsActive" id="ATMaskingIsActive">
                                        <option selected="selected" value='0'>In-Active</option>
                                        <option value='1'>Active</option>                                        
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">TT Masking IS Active:</label>
                                <div class="col-sm-6">

                                    <select class="form-control" name="TTMaskingIsActive" id="TTMaskingIsActive">
                                        <option value='0'>In-Active</option>
                                        <option value='1'>Active</option>                                        
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
<!--                                <label for="focusedinput" class="col-sm-3 control-label">CC Masking IS Active:</label>
                                <div class="col-sm-6">

                                    <select class="form-control" name="CCMaskingIsActive" id="TTMaskingIsActive">
                                        <option value='0'>In-Active</option>
                                        <option value='1'>Active</option>                                        
                                    </select>
                                </div>
                            </div>-->
                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Requesting IP:</label>
                                <div class="col-sm-6">

                                    <input class="form-control" placeholder="127.0.0.1" name="RequestingIP" value="127.0.0.1" type="text" id="RequestingIP" >
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

                            frmvalidator.addValidation("UserName", "dontselect=0", "Please Select User Name.");
                            frmvalidator.addValidation("MaskingName", "req", "Please Type MaskingID.");
                            frmvalidator.addValidation("RequestingIP", "req", "Please Type RequestingIP.");
                            //frmvalidator.addValidation("end_date", "req", "Select The End Date.");</script>

                    </div>
                    <form id="reg-form" action="" method="post" autocomplete="off">

                    </form>
                    <?php

                    function random_string($length) {
                        $key = '';
                        $keys = array_merge(range(0, 9));

                        for ($i = 0; $i < $length; $i++) {
                            $key .= $keys[array_rand($keys)];
                        }

                        return $key;
                    }

                    if ($_REQUEST['Save'] == 'Save') {
                        $UserName = $_REQUEST['UserName'];
                        $MaskingID = $_REQUEST['MaskingName'];
                        $GPMaskingIsActive = $_REQUEST['GPMaskingIsActive'];
                        $ROMaskingIsActive = $_REQUEST['ROMaskingIsActive'];
                        $BLMaskingIsActive = $_REQUEST['BLMaskingIsActive'];
                        $ATMaskingIsActive = $_REQUEST['ATMaskingIsActive'];
                        $TTMaskingIsActive = $_REQUEST['TTMaskingIsActive'];
                    //    $CCMaskingIsActive = $_REQUEST['CCMaskingIsActive'];

                        $RequestingIP = $_REQUEST['RequestingIP'];

                        $ckMaskingID = ckMaskingIDExist($MaskingID, $cn);
                        if ($ckMaskingID == 0) {
                             //$insertMaskingDetailquery = "INSERT INTO MaskingDetail (UserName, MaskingID,RequestingIP,MaskingForGP,MaskingForRO,MaskingForBL,MaskingForAT,MaskingForTT,MaskingForCC) VALUES ('$UserName', '$MaskingID', '$RequestingIP','$GPMaskingIsActive','$ROMaskingIsActive','$BLMaskingIsActive','$ATMaskingIsActive','$TTMaskingIsActive','$CCMaskingIsActive')";
                            $insertMaskingDetailquery = "INSERT INTO MaskingDetail (UserName, MaskingID,RequestingIP,MaskingForGP,MaskingForRO,MaskingForBL,MaskingForAT,MaskingForTT) VALUES ('$UserName', '$MaskingID', '$RequestingIP','$GPMaskingIsActive','$ROMaskingIsActive','$BLMaskingIsActive','$ATMaskingIsActive','$TTMaskingIsActive')";
                            
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