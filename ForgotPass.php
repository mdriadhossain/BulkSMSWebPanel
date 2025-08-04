<HTML>
    <HEAD>
        <TITLE></TITLE>
        <link href="CSS/site.css" rel="stylesheet" type="text/css" />
    </HEAD>
    <BODY>
        <?PHP
//include "Config/config.php";
//include "Lib/lib.php";
        $db = getDBMain();
        ?>
        <table align="center">
            <tr>
                <td>
                    <table width="500" border="1" align="center" cellpadding="0" class="tableBorder">
                        <tr>
                            <td valign="top">
                                <table border="0" width="100%" align="center">
                                    <form id="role" name="role" method="post" action="" onSubmit="return validateForgotPass();" >
                                        <tr class="fromheader">
                                            <td colspan="2">Reset Password </td>
                                        </tr>
                                        <tr>
                                            <td align="right" class="fromtable">User Name: </td>
                                            <td><span class="fromtable">
                                                    <input name="UName" type="text" id="UName">
                                                </span></td>
                                        </tr>
                                        <tr>
                                            <td align="right" class="fromtable">Question:</td>
                                            <td><label>
                                                    <select name="Question" id="Question">
                                                        <?php
                                                        $cond = "where 1=1";
                                                        ddlData($cn, $db, 'securityquestion', 'QID', 'Question', $cond, "");
                                                        ?>
                                                    </select>
                                                </label></td>
                                        </tr>
                                        <tr>
                                            <td align="right" class="fromtable">			    Answer: </td>
                                            <td><label><span class="fromtable">
                                                        <input name="Answer" type="text" id="Answer">
                                                    </span></label></td>
                                        </tr>
                                        <tr>
                                            <td align="right" class="fromtable">Password:</td>
                                            <td><span class="fromtable">
                                                    <input name="Password" type="password" id="Password">
                                                </span></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>
                                                <input name="Save" type="submit" id="Save" value="Reset">
                                                <a href="index.php"> Login</a>
                                            </td>
                                        </tr>
                                        <tr class="fromheader">
                                            <td colspan="2">&nbsp;</td>
                                        </tr>
                                    </form>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <?PHP
                    if ($_REQUEST['Save'] == 'Reset') {
                        $UName = $_REQUEST['UName'];
                        $Question = $_REQUEST['Question'];
                        $Answer = $_REQUEST['Answer'];
                        $Password = $_REQUEST['Password'];

                        if (isExit($cn, $db, 'user', "UserName='$UName'") == 0) {
                            MsgBox('Wrong UserName');
                        } else if (isExit($cn, $db, 'user', "UserName='$UName' and Question='$Question'") == 0) {
                            MsgBox('Question does not match');
                        } else if (isExit($cn, $db, 'user', "UserName='$UName' and Question='$Question' and Answer='$Answer'") == 0) {
                            MsgBox('Answer does not match');
                        } else {
                            $param = "Password='$Password'";
                            $cond = "UserName='$UName'";

                            if (Edit($cn, $db, 'user', $param, $cond)) {
                                MsgBox('Password Reset Successfully');
                                ReDirect("index.php");
                            } else
                                MsgBox('failed to reset password');
                        }
                    }
                    db_close($cn);
                    ?>

                    <p></p>

                </td>
            </tr>
        </table>


    </BODY>
</HTML>
