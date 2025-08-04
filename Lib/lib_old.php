<?PHP

//echo "From lib";

function IsDNDNumber($MSISDN, $cn) {

    $MSISDN = substr($MSISDN, -10);
    //$IsUserExistQuery="select count(MSISDN) as count from [CMS_1_0].dbo.DNDList where MSISDN='$MSISDN' and Operator='$Operator'";
    $IsUserExistQuery = "select count(ID) as count from [CMS_1_0].dbo.DNDList where '$MSISDN' between FromMSISDN and ToMSISDN";

    // echo $IsUserExistQuery."<br/>";

    $IsUserExistResult = odbc_fetch_array(odbc_exec($cn, $IsUserExistQuery));
    $IsUserExist = $IsUserExistResult['count'];

    if ($IsUserExist > 0) {
        return TRUE;
    } else
        return FALSE;
}

function popup($vMsg, $vDestination) {
    echo("<html>\n");
    echo("<head>\n");
    echo("<title>System Message</title>\n");
    echo("<meta http-equiv=\"Content-Type\" content=\"text/html;
		charset=iso-8859-1\">\n");

    echo("<script language=\"JavaScript\" type=\"text/JavaScript\">\n");
    echo("alert('$vMsg');\n");
    echo("window.location = ('$vDestination');\n");
    echo("</script>\n");
    echo("</head>\n");
    echo("<body>\n");
    echo("</body>\n");
    echo("</html>\n");
    exit;
}

function Save($cn, $DB, $table, $field, $value) {
    mssql_select_db($DB, $cn);
    $SQL = "INSERT INTO $table($field)  ";
    echo $SQL.="VALUES($value)";
    if (db_query($SQL, $cn))
        return true;
    else
        return false;
}

function ddlData($cn, $DB, $table, $value, $caption, $cond, $selct) {
    mssql_select_db($DB, $cn);
    $SQL = "select distinct $value,$caption from $table ";
    $SQL.=("$cond");
    $rs = db_query($SQL, $cn);
    while ($row = db_fetch_array($rs)) {
        if ($row[0] == $selct) {
            echo "<option value='" . $row[0] . "' selected>" . $row[1] . "</option>";
        } else {
            echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
        }
    }
}

function getURL($cn, $DB, $parent) {
    mssql_select_db($DB, $cn);
    $SQL = "select MenuURL from MenuDefine where MenuId='$parent'";
    echo $rs = mssql_query($SQL, $cn);
    $row = mssql_fetch_array($rs);
    echo $row[0];
    return $row[0];
}

function getURL1() {

    return "ok";
}

function Edit($cn, $DB, $table, $param, $cond) {
   // mssql_select_db($DB, $cn);
    $SQL = "update $table set ";
    $SQL.="$param ";
    $SQL.="where $cond";
    //echo $SQL;exit; 
    if (odbc_exec($cn,$SQL))
        return true;
    else
        return false;
}

function Delete($cn, $DB, $table, $cond) {
   // mssql_select_db($DB, $cn);
    $SQL = "delete from $table ";
    $SQL.="where $cond";
     if (odbc_exec($cn,$SQL))
        return true;
    else
        return false;
}

function isExit($cn, $DB, $table, $cond) {
    //mssql_select_db($DB, $cn);
    $SQL = "select count(*) as tt from $table ";
    $SQL.="where $cond";
   //echo	$SQL; exit;
    $rs = (odbc_exec($cn,$SQL));
    $row = mssql_fetch_row($rs);
    return $row[0];
}

function getValue($cn, $DB, $table, $field, $cond) {
    mssql_select_db($DB, $cn);
    $SQL = "select $field as tt from $table ";
    $SQL.="where $cond";
//echo	$SQL;
    $rs = db_query($SQL, $cn);
    $row = mssql_fetch_row($rs);
    return $row[0];
}

function View_Menu($cn, $DB) {
    mssql_select_db($DB, $cn);
    $SQL = "select MenuId,MenuLavel from MenuDefine Order by MenuOrder";
    $rs = db_query($SQL, $cn);
    $data = array();
    while ($row = db_fetch_array($rs)) {
        $temp = array('MenuId' => $row[0], 'MenuLavel' => $row[1]);
        array_push($data, $temp);
    }
    //db_close($cn);
    return $data;
}

function View_Contest($cn, $DB) {
    mssql_select_db($DB, $cn);
    $SQL = "select ContestName from ContestDef where Status='Active'";
    $rs = db_query($SQL, $cn);
    $data = array();
    while ($row = db_fetch_array($rs)) {
        $temp = array('ContestName' => $row[0]);
        array_push($data, $temp);
    }
    //db_close($cn);
    return $data;
}

function isContestRolePermission($cn, $DB, $conName, $roleid) {
    mssql_select_db($DB, $cn);
    $SQL = "select Permission from contestinrole where RoleId='$roleid' and ContestName='$conName'";
    $rs = db_query($SQL, $cn);
    while ($row = db_fetch_array($rs)) {
        $permision = $row[0];
    }
    //db_close($cn);
    return $permision;
}

function isMenuPermission($cn, $DB, $menuid, $roleid) {
    mssql_select_db($DB, $cn);
    $SQL = "select Permission from RoleMenu where RoleId='$roleid' and MenuId='$menuid'";
    $rs = db_query($SQL, $cn);
    while ($row = db_fetch_array($rs)) {
        $permision = $row[0];
    }
    //db_close($cn);
    return $permision;
}

function Edit_MenuPer($cn, $DB, $roleid, $menuPer, $userid) {
    mssql_select_db($DB, $cn);
    foreach ($menuPer as $menuid) {
        $SQL = "insert into RoleMenu(RoleId,MenuId,Permission,CreatedBy,CreateDate) VALUES('$roleid','$menuid',1,'$userid',now())";
        db_query($SQL, $cn);
    }
    return true;
}

function Edit_ContestPer($cn, $DB, $roleid, $conPer, $userid) {
    mssql_select_db($DB, $cn);
    foreach ($conPer as $conName) {
        $SQL = "insert into contestinrole(RoleId,ContestName,Permission,CreatedBy,CreateDate) VALUES('$roleid','$conName',1,'$userid',now())";
        db_query($SQL, $cn);
    }
    return true;
}

function getTotalPerPage() {
    return 20;
}

function isCurrentEpisode($cn, $DB, $Contest, $Episode) {
    mssql_select_db($DB, $cn);
    $SQL = "select count(*) from ContestDef  where ContestName='$Contest' and CurrentlyActiveEpisode='$Episode'";
    $rs = db_query($SQL, $cn);
    $row = db_fetch_array($rs);

    if ($row[0] > 0)
        return true;
    else
        return false;
}

function showList($cn, $qry, $pageno = 0, $count = 0, $url = "", $rowstart = "<tr class=\"textRpt\">", $rowend = "</tr>", $colstart = "<td>", $colend = "</td>") {
    $rs = mssql_query($qry, $cn);
    $n = mssql_num_fields($rs);

    $N = mssql_num_rows($rs);
    if ($count == 0)
        $count = $N;

    $start = $pageno * $count;
    $totalpage = ceil($N / $count) - 1;
    mssql_data_seek($rs, $start);
    for ($x = $start; $x < $start + $count && $x < $N; $x++) {
        $dt = mssql_fetch_array($rs);
        echo($rowstart);
        for ($i = 0; $i < $n; $i++) {
            $val = $dt[$i];
            echo("$colstart$val$colend");
        }
        echo($rowend);
    }
    $prev = $pageno - 1;
    if ($prev < 0)
        $prev = 0;
    $next = $pageno + 1;
    if ($next >= $totalpage)
        $next = $totalpage;
    $totalpage+=1;
    $pageno+=1;
    $pagingstring = "<a href=$url$prev>Previous</a> Page $pageno/$totalpage <a href=$url$next>Next</a>";
    return $pagingstring;
}

;

function getFileextension($filename) {
    return end(explode(".", $filename));
}

function CgangeSchedule($cn, $DB, $msgId, $scTime) {
    mssql_select_db($DB, $cn);
    foreach ($msgId as $mid) {
        $SQL = "Update smsoutbox set schedule='$scTime' where msgID='$mid'";
        db_query($SQL, $cn);
    }
    return true;
}

?>