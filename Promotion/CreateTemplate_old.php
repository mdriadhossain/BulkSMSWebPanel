<?php session_start(); ?>
<?php
    $serverName = "localhost";
    $database = "BULKSMSGateway_1_0";
    $uid = 'sa';
    $pwd = 'nopass@1234';

    try {
      echo  $conn = new PDO(
            "sqlsrv:server=$serverName;Database=$database",
            $uid,
            $pwd,
            array(
                //PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            )
        );
    }
    catch(PDOException $e) {
        die("Error connecting to SQL Server: " . $e->getMessage());
    }

?>

<?php
$userDetail = "SELECT UserID, UserName FROM BULKSMSPanel.dbo.UserInfo where Username<>'admin'";
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

<link rel="stylesheet" href="style.css" type="text/css" />
<script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script>
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
                    <h4>Create Template Text</h4>
                </div>
                <div class="panel-body">


                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->

                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" id="UserInfoID" name="CreateTemplate">

                            <?php
                            if ($User == "Admin" || $User == "admin") {
                                ?>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label">Select User Name :</label>
                                    <div class="col-sm-6">


                                        <select name="opt" id="opt" type="text" class="form-control" onchange="ShowDropDown('opt', 'ShortCodeDiv', 'ShowMaskingId', 'ShowService')">

                                            <option selected=''>please select user name</option>
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
                            } else {
                                ?>
                                <div class = "form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label">User Name</label>
                                    <div class="col-sm-6">



                                        <select name="opt" id="opt" type="text" class="form-control" onchange="ShowDropDown('opt', 'ShortCodeDiv', 'ShowMaskingId',
                                                            'ShowService')">
                                            <option selected=''>please select user name</option>
                                            <option value='<?php echo $User; ?>'><?php echo $User; ?></option>
                                            <?php
//                                        while ($n = odbc_fetch_row($result_userDetail)) {
//                                            $UserID = odbc_result($result_userDetail, "UserID");
//                                            $UserName = odbc_result($result_userDetail, "UserName");
//                                            echo "<option value='$UserID'>$UserName</option>";
//                                        }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>


                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Template SMS Text</label>
                                <div class="col-sm-6">



                                    <textarea class="form-control" name="SMSText" id="SMSTextID" cols="100" rows="3" onKeyDown="limitText(this.form.SMSText,
                                                    this.form.countdown, 160);"onKeyUp="limitText(this.form.SMSText, this.form.countdown, 160);"></textarea>
                                    <font size="1">(Maximum characters: 160)<br>You have <input readonly type="text" name="countdown" size="3" value="160"> characters
                                    left.</font>
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
                            var frmvalidator = new Validator("CreateTemplate");

                            //frmvalidator.addValidation("Status", "dontselect=0", "Please Select Status.");
                            frmvalidator.addValidation("opt", "dontselect=0", "Please Select the User Name.");
                            frmvalidator.addValidation("SMSTextID", "req", "SMS Text Can not be null.");//frmvalidator.addValidation("end_date", "req", "Select The End Date.");</script>

                    </div>
                    <form id="reg-form" action="" method="post" autocomplete="off">

                    </form>
                    <?php
                    if ($_REQUEST['Save'] == 'Save') {
                        $UserName = $_REQUEST['opt'];
                        $SMSText = $_REQUEST['SMSText'];
                        //echo $User;
                        $UploadedBy = $User;
                        //exit;
                        //$ckMaskingID = ckMaskingIDExist($MaskingID, $cn);
                        // if ($ckMaskingID == 0) {
                        echo $insertMaskingDetailquery = "INSERT INTO TemplateText (UserName, TemplateSMS,UploadedBy,UploadedDate) VALUES ('$UserName', 'N$SMSText', '$UploadedBy',getdate())";
                        $stmt = $conn->query($insertMaskingDetailquery);


                        //$result = odbc_exec($cn, $SMSPermitQuery);
                        //$PermitReturnValArray = odbc_fetch_array($result);                     
                        // $PermitReturnVal = $PermitReturnValArray['ReturnVal'];
// exit;
                        // $rs = odbc_exec($cn, $insertMaskingDetailquery);
                        //$url = base_url() . "index.php?parent=CreateTemplate";
                        popup('Succesfully Created  Template Text.', $url);
                        // }
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
