<?PHP

require_once "../Config/config.php";
require_once "../Lib/lib.php";

$cn = ConnectDB();

$RoleId = $_REQUEST["RoleId"];
$UserId = $_REQUEST["UserId"];

$deleteUserRole = "DELETE FROM [BULKSMSPanel].[dbo].[UserRole] WHERE RoleID='$RoleId'";

if (Delete) {
    odbc_exec($cn, $deleteUserRole);
    $url = base_url() . "index.php?parent=AddUserRole";
    popup('Successfully Deleted', $url);
} else {
    MsgBox('Failed to Delete');
}
?>