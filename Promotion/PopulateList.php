<?php

// Previous Database Name : CMS_1_0
// Local Database Name :  BULKSMSPanel


// ini_set('display_errors', 1);
// error_reporting(E_ALL);

$userDetail = "SELECT UserID, UserName FROM CMS_1_0.dbo.UserInfo  Order By UserName ASC";
$result_userDetail = odbc_exec($cn, $userDetail);
?>

<link rel="stylesheet" href="bootstrap-select/dist/css/bootstrap-select.css">
<script type="text/javascript" src="bootstrap-select/dist/js/bootstrap-select.js"></script>

<div id="page-content">
    <div id='wrap'>



        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>Populate Schedule SMS List</h4>
                </div>
                <div class="panel-body" style="min-height: 500px;">


                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->





                        <form class="form-horizontal" id="PopulatePromoListID" name="smsupload" method="post" action="" enctype="multipart/form-data">

                            <?php
                            if ($User == "Admin" || $User == "admin") {
                            ?>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label">Select User Name :</label>
                                    <div class="col-sm-6">


                                        <select name="opt" id="opt" type="text" class="form-control selectpicker" data-live-search="true" onchange="ShowDropDown('opt', 'ShortCodeDiv', 'ShowMaskingId', 'ShowService')">

                                            <option selected=''>please select user name</option>
                                            <?php
                                            // while ($n = odbc_fetch_row($result_userDetail)) {

                                            //     $UserID = odbc_result($result_userDetail, "UserID");
                                            //     $UserName = odbc_result($result_userDetail, "UserName");
                                            //     echo "<option value='$UserName'>$UserName</option>";
                                            // }

                                            if ($result_userDetail) {
                                                $hasRows = false;
                                                while (odbc_fetch_row($result_userDetail)) {
                                                    $hasRows = true;
                                                    $UserID = odbc_result($result_userDetail, "UserID");
                                                    $UserName = odbc_result($result_userDetail, "UserName");
                                                    echo "<option value='$UserName'>$UserName</option>";
                                                }
                                                if (!$hasRows) {
                                                    echo "<option disabled>No users found</option>";
                                                }
                                            } else {
                                                echo "<option disabled>Error loading users</option>";
                                            }



                                            ?>
                                        </select>
                                    </div>
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label">User Name</label>
                                    <div class="col-sm-6">



                                        <select name="opt" id="opt" type="text" class="form-control selectpicker" data-live-search="true" onchange="ShowDropDown('opt', 'ShortCodeDiv', 'ShowMaskingId',
                                                        'ShowService')">
                                            <option selected=''>please select user name hello</option>
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
                                <label for="focusedinput" class="col-sm-3 control-label">Scheduled SMS List Name:</label>
                                <div class="col-sm-6">



                                    <input name="PromoName" type="text" id="PromoNameID" class="form-control" placeholder="Please do not use any special charecters (e.g: @,#,$,~,& etc.)">
                                </div>
                            </div>




                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Upload CSV File[MSISDN only] :</label>
                                <div class="col-sm-6">



                                    <input class="form-control" name="uploadcsv" type="file" id="uploadcsv"><br />
                                    Please download sample csv here( <a href="Promotion/sample.csv">Download )</a><br />
                                    Please download Notepad++ Software here [3.88 MB]( <a href="Promotion/Notepad.exe"> Download </a> )
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label"></label>
                                <div class="col-sm-6">

                                    <input name="Upload" class="btn btn-primary" type="submit" id="Upload" value="Upload">

                                </div>
                            </div>

                            <!-- Newly Added -->
                            <div id="ShortCodeDiv"></div>

                        </form>
                    </div>
                    <script language="JavaScript" type="text/javascript">
                        var frmvalidator = new Validator("PopulatePromoListID");
                        frmvalidator.addValidation("opt", "dontselect=0", "Please Select the Operator Name.");
                        frmvalidator.addValidation("PromoNameID", "req", "Write The promotional Name.");
                        frmvalidator.addValidation("uploadcsv", "req", "Must Upload the CSV Number file.");
                    </script>
                    <?PHP
                    $InValidMsisdn = 0;
                    if (isset($_POST['Upload']) && $_POST['Upload'] == 'Upload') {
                        $cn = ConnectDB();

                        $User = strtoupper($_SESSION['User']);
                        $filename = $_FILES['uploadcsv']['name'];
                        $filename = str_replace(' ', '_', $filename);
                        $filepath = "./CSV/";
                        //$filepath="C:/Windows/Temp/";
                        //$filepath=csvFilePath();
                        $tmp_name = $_FILES['uploadcsv']['tmp_name'];
                        $ext = getFileextension($filename);
                        $header = substr($filename, 0, -5) . date("YmdHis") . '.' . $ext;
                        $filelink = $filepath . $header;

                        $PromoName = trim($_REQUEST['PromoName']);
                        $PromoName = str_replace(" ", "_", $PromoName);
                        $UName = $_REQUEST['opt'];
                        //exit;

                        $ckUser = ckUserExist($PromoName, $UName, $cn);

                        if ($ckUser == '0') {
                            if (move_uploaded_file($tmp_name, $filelink)) {
                                $InValidMsisdn = 0;
                                $handle = fopen($filelink, "r");
                                fgetcsv($handle, 1000, ",");

                                // ✅ Start the transaction
                                odbc_exec($cn, "BEGIN TRANSACTION");

                                while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                                    // do your thing
                                    $MobileNumber1 = $data[0];
                                    $MSISDNCHK = strlen($MobileNumber1);

                                    if ($MSISDNCHK > 10 && is_numeric($MobileNumber1)) {
                                        $InitialMSISDN = substr($MobileNumber1, -10);
                                        $SendTo = "880" . $InitialMSISDN;
                                        $MobileNumber = $SendTo;
                                        // $msg = str_replace("'", "''", $data[3]);
                                        $qry = "insert into [CMS_1_0].dbo.PromoList([MSISDN],[UserName],[PromoListName],[UpdateDate],[UpdateBy])
	                                            values('$MobileNumber','$UName','$PromoName',getdate(),'$User')";

                                        //echo $qry."<br/>";
                                        $rs = odbc_exec($cn, $qry);
                                    } else {

                                        if ($MobileNumber1 != '') {
                                            $InValidMsisdn++;
                                        }
                                    }
                                }
                                //exit;

                                // if (odbc_error())
                                //     odbc_exec("ROLLBACK");
                                // else {
                                //     odbc_exec("COMMIT");
                                //     MsgBox('Promotional List Successfully Uploaded');
                                // }

                                if (odbc_error($cn)) {
                                    odbc_exec($cn, "ROLLBACK");
                                    MsgBox("Failed to upload data. Rolled back transaction.");
                                } else {
                                    odbc_exec($cn, "COMMIT");
                                    MsgBox('Promotional List Successfully Uploaded');
                                }


                                fclose($handle);
                                unlink($filelink);
                            } else {
                                MsgBox('failed to upload');
                            }
                        } else {
                            echo $ckUser;
                        }
                    ?>
                        <?php if ($InValidMsisdn > 0) {
                        ?>
                            <div class="alert alert-danger" role="alert">
                                <p>Total Invalid Number Found: <span class="badge"><?php echo $InValidMsisdn; ?></span></p><br />



                            </div>
                        <?php }
                        ?>
                    <?php
                    }

                    function ckUserExist($UserName, $Operator, $cn)
                    {
                        $existUser = 0;
                        $isexistUser = "SELECT COUNT(*) AS count 
                    FROM [CMS_1_0].dbo.PromoList 
                    WHERE PromoListName = '$UserName' 
                    AND UserName = '$Operator'";

                        $result_isexistUser = odbc_exec($cn, $isexistUser);

                        if (!$result_isexistUser) {
                            echo "Query Failed: " . odbc_errormsg($cn);
                            return 1; // Assume record exists to prevent insertion
                        }

                        while (odbc_fetch_row($result_isexistUser)) {
                            $existUser = odbc_result($result_isexistUser, "count");
                        }

                        if ($existUser > 0) {
                            $url = base_url() . "index.php?parent=PopulateList";
                            popup("Sorry!! Already same Name Promotional List is Available for $Operator. Please Choose Another Name.", $url);
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