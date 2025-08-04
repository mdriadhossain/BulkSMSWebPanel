<?php
require_once "Config/config.php";
require_once "Lib/lib.php";
$cn = ConnectDB();
?>
<div id="page-content">
    <div id='wrap'>



        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>Create WAP Content Code</h4>
                </div>
                <div class="panel-body">


                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->




                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" id="UserInfoID">


                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Select Content Type :</label>
                                <div class="col-sm-6">



                                    <select name="ContentType" id="opt" type="text" class="form-control" >
                                        <option value=''>Select Content Type</option>
                                        <option value="WP">WALLPAPER</option>
                                        <option value="AN">ANIMATION</option>
                                        <option value="VD">VIDEO</option>
                                        <option value="MP3">MP3</option>
                                        <option value="FT">FULLTRACK</option>
                                        <option value="TT">TRUETONE</option>
                                        <option value="PT">POLYTONE</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Content Code:</label>
                                <div class="col-sm-6">



                                    <input class="form-control" name="ContentCode" type="text" id="ContentCode" >
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Content ID:</label>
                                <div class="col-sm-6">




                                    <input class="form-control" name="ContentID" type="text" id="ContentCode" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Active/ InActive</label>
                                <div class="col-sm-6">





                                    <select class="form-control" name="IsActive" >

                                        <option value="1" selected="selected">Active</option>
                                        <option value="0">InActive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label"></label>
                                <div class="col-sm-6">




                                    <input class="btn btn-primary" name="Save"  type="submit" id="Save"  value="Save">


                                </div>
                            </div>
                        </form>
                    </div>
                    <script language="JavaScript" type="text/javascript">
                        var frmvalidator = new Validator("UserInfoID");
                        frmvalidator.addValidation("ContentType", "dontselect=0", "Please select The Content Type.");
                        frmvalidator.addValidation("ContentCode", "req", "Write the Content Code.");
                        frmvalidator.addValidation("ContentID", "req", "Write the Content ID.");

                    </script>
                    <?php
                    if ($_REQUEST['Save'] == 'Save') {
                        $ContentType = $_REQUEST['ContentType'];
                        $ContentCode = $_REQUEST['ContentCode'];
                        $ContentID = $_REQUEST['ContentID'];
                        $IsActive = $_REQUEST['IsActive'];



                        $ckUser = ckCodeExist($ContentType, $ContentCode, $cn);
                        //$lastUserID = getUserID($cn);
                        //$newUserID = $lastUserID + 1;



                        if ($ckUser == '0') {

                            $GetCategory = GetCategory($ContentType);

                            $URL = "http://bfunbd.com/WapNotify.php?category=$GetCategory&id=$ContentID";

                            $insertUserData = insertUser($cn, $ContentType, $ContentCode, $URL, $IsActive);
                            $url = base_url() . "index.php?parent=CreateWapCode";
                            popup('Succesfully WAP Code Created.', $url);
                        } else {
                            echo $ckUser;
                        }
                    }

                    function GetCategory($ContentType) {
                        if ($ContentType == 'WP')
                            return "WALLPAPER";
                        else if ($ContentType == 'AN')
                            return "ANIMATION";
                        else if ($ContentType == 'VD')
                            return "VIDEO";
                        else if ($ContentType == 'MP3')
                            return "MP3";
                        else if ($ContentType == 'FT')
                            return "FULLTRACK";
                        else if ($ContentType == 'TT')
                            return "TRUETONE";
                        else if ($ContentType == 'PT')
                            return "POLYTONE";
                    }

                    function ckCodeExist($ContentType, $ContentCode, $cn) {

                        $isexistUser = "select count(id) as count from [SpecialServices].[dbo].[WapCode] where Keyword='$ContentType' and ContentCode='$ContentCode'";
                        $result_isexistUser = odbc_exec($cn, $isexistUser);
                        while ($rs = odbc_fetch_row($result_isexistUser)) {
                            $existUser = odbc_result($result_isexistUser, "count");
                        }
                        If ($existUser > 0) {
                            $url = base_url() . "index.php?parent=CreateWapCode";
                            popup('Sorry!! This Code is Already Exist.', $url);
                        } else {
                            return $existUser;
                        }
                    }

                    function insertUser($cn, $ContentType, $ContentCode, $URL, $IsActive) {
                        $insUser = $UserName;
                        $insPass = $Password;
                        $insMobileNo = $MobileNo;
                        $insCompanyName = $CompanyName;
                        $insUserID = $newUserID;
                        $HeaderText = $HeaderText;

                        $insertquery = "insert into [SpecialServices].[dbo].[WapCode] ([Keyword],[ContentCode],[ContentURL],[IsActive]) values('$ContentType','$ContentCode','$URL','$IsActive')";

                        //echo $insertquery;exit;

                        $rs = odbc_exec($cn, $insertquery);
                        // echo "<center><h3>User Created Successfully.</h3></center>";
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
