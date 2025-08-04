<?php
$cn = ConnectDB();
?>
<script type="text/JavaScript">
    function confirmDelete(){
    var agree=confirm("Are you sure you want to delete this entry?");
    if (agree)
    return true ;
    else
    return false ;
    }

    $(document).ready(function() {
    $('#example').dataTable( {
    "order": [[ 0, "asc" ]]
    } );
    } );

</script>
<div id="page-content">
    <div id='wrap'>



        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>Show WAP Code</h4>
                </div>
                <div class="panel-body">


                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->




                        <form class="form-horizontal" name="testform" method='POST' action=''>


                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-3 control-label">Select Content Type :</label>
                                <div class="col-sm-6">



                                    <select class="form-control" name="ContentType" id="opt" type="text" class="form-control" >
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
                                <label for="focusedinput" class="col-sm-3 control-label"></label>
                                <div class="col-sm-6">





                                    <input  class="btn btn-primary" name="ShowContent" id="IODInformation" type="submit" value="Show" />


                                </div>
                            </div>
                        </form>
                    </div>
                    <script language="JavaScript" type="text/javascript">
                        var frmvalidator = new Validator("testform");
                        frmvalidator.addValidation("ContentType", "dontselect=0", "Please Select a Content Type .");
                    </script>

                </div>

                <div class="panel-body">


                    <div class="panel-body collapse in">
                        <!--//onSubmit="return validateUserInfo();-->

                        <?php
                        if ($_REQUEST['ShowContent'] == 'Show') {

                            $cn = ConnectDB();


                            $ContentType = $_REQUEST['ContentType'];

                            $ServiceIDQuery = "select [ID],[Keyword],[ContentCode],[ContentURL],[IsActive],[HitCount] from [SpecialServices].[dbo].[WapCode] where [Keyword]='$ContentType'";
                            ?>
                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables">


                                <thead>
                                    <tr role="row">
                                        <th>WAP Content Code</th>


                                    </tr>
                                    <tr role="row">
                                        <th>ID</th>
                                        <th>Keyword</th>
                                        <th>Content Code</th>

                                        <th>Content URL</th>
                                        <th>Is Active</th>
                                        <th>Hit Count</th>


                                        <th>Edit</th>
                                        <th>Delete</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <?PHP
                                    $ServiceIDResult = odbc_exec($cn, $ServiceIDQuery);



                                    while ($n = odbc_fetch_array($ServiceIDResult)) {

                                        $ID = $n['ID'];
                                        $Keyword = $n['Keyword'];
                                        $ContentCode = $n['ContentCode'];
                                        $ContentURL = $n['ContentURL'];
                                        $IsActive = $n['IsActive'];
                                        $HitCount = $n['HitCount'];
                                        ?>
                                        <tr>
                                            <td><?php echo $ID; ?></td>
                                            <td><?php echo $Keyword; ?></td>

                                            <td><?php echo $ContentCode; ?></td>
                                            <td><?php echo $ContentURL; ?></td>

                                            <td><?php echo $IsActive; ?></td>
                                            <td><?php echo $HitCount; ?></td>

                                            <td><b><font color="#663300"><a href="SpecialServices/EditWapCode.php?id=<?php echo $ID; ?>"><button type="button" class="btn btn-success">Edit</button></a></font></b></td>
                                            <td><a href="SpecialServices/deleteWapCode.php?id=<?php echo $ID; ?>" onClick="return confirmDelete();"><button type="button" class="btn btn-danger">Delete</button></a></td>

                                        </tr>
                                        <?PHP
                                    }
                                }
//db_close($cn);
                                ?>
                            </tbody>

                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div> <!-- row -->
</div> <!-- container -->
</div> <!-- page-content -->

</div> <!-- wrap -->

</div> <!-- page-content -->
