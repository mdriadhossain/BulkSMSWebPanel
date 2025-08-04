<?php
ob_start();
session_start();
require_once "Config/config.php";
require_once "Lib/lib.php";
$cn = ConnectDB();
$UserName = $_SESSION['User'];
$userDetail = "SELECT UserName,Email,IsSubscribed FROM BULKSMSPanel.dbo.UserInfo where UserName='$UserName'";
$result_userDetail = odbc_exec($cn, $userDetail);
$userInfo = odbc_fetch_array($result_userDetail);
$IsSubcribed = $userInfo['IsSubscribed'];
?>
<script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script>



<div id="page-content">
    <div id='wrap'>



        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>User Subscription Info </h4>
                </div>
                <div class="panel-body">
                    <?php if ($IsSubcribed == 0) { ?>

                        <div class="panel-body collapse in">
                            <p align="center"><h4 align="center">Subscription Package</h4></p>
                                            <!--<p align="center"><h3 align="center">Registration</h3></p>-->
                            <p align="center"><b> <h3 align="center">3,000 BDT</h3></b></p>
                            <div class="row">
                                <div class="col-md-5"></div>
                                <div class="col-md-4 price-list">
                                    <ul>
                                        <li>11,000 SMS</li>
                                        <li>0.27 BDT/SMS</li>
                                        <li>3 Months Validity</li>
                                        <li>Free API</li>
                                        <li>Add pack 1,000 SMS @ 0.27 BDT/SMS</li>
                                    </ul>

                                </div>
                                <div class="col-md-3"></div>

                            </div>

                            <form align="center" class="form-horizontal" action="" method="post"  enctype="multipart/form-data" name="changepassword" id="changepassword">
                                <div align="center" class="row form-group">
                                    <div><input  name="chkAll" type="checkbox" id="isSubscribed" value="1">&nbsp Do you want to Subscribed?</div>
                                </div> 

                                <div align="center" class="form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-6">
                                        <input name="Save"  class="btn btn-primary" type="submit" id="Save"  value="Subscribe">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <script type="text/javascript">
                            if ('<?php echo $IsSubcribed ?>' == 1) {
                                $('#isSubscribed').prop('checked', true);
                            }
                        </script>
                    <?php } ?>
                    <?php if ($IsSubcribed != 0) { ?>
                        <div class="panel-body collapse in">
                            <p align="center"><h4 align="center">You are already Subscribed</h4></p>
                            <form align="center" class="form-horizontal" action="" method="post"  enctype="multipart/form-data" name="" id="">
                                <div align="center" class="row form-group">
                                    <div><input  name="chk" type="checkbox" id="unSubscribed" value="0">&nbsp Do you want to Un-Subscribed?</div>
                                </div> 
                                <div align="center" class="form-group">
                                    <label for="focusedinput" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-6">
                                        <input name="update"  class="btn btn-primary" type="submit" id="Save"  value="UnSubscribe">
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php } ?>  
                </div>



                <div class="panel-body">


                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->


                        <?PHP
                        $url = base_url() . "index.php?parent=UserSubscription";
                        if ($_REQUEST['update'] == 'UnSubscribe') {
                            $check = $_REQUEST['chk'];
                            if ($check == 0) {
                                //popup($check);
                                $update = "update UserInfo set IsSubscribed='$check' where UserName='$UserName'";
                                $result_update = odbc_exec($cn, $update);
                                popup('Your UnSubscription Request Successfully done!.', $url);
                            }
                        }
                        if ($_REQUEST['Save'] == 'Subscribe') {
                            $check = $_REQUEST['chkAll'];
                            if ($check == 1) {

                                $update = "update UserInfo set IsSubscribed='$check' where UserName='$UserName'";
                                $result_update = odbc_exec($cn, $update);

                                popup('Your Subscription Request Successfully done!.', $url);
                            }
                        }
                        ?>

                    </div>

                </div>
            </div>
        </div>
    </div> <!-- row -->
</div> <!-- container -->
</div> <!-- page-content -->

</div> <!-- wrap -->

</div> <!-- page-content -->
