
var win = null;
function NewWindow(mypage, myname, w, h, scroll) {
    LeftPosition = (screen.width) ? (screen.width - w) / 2 : 0;
    TopPosition = (screen.height) ? (screen.height - h) / 2 : 0;
    settings =
            'height=' + h + ',width=' + w + ',top=' + TopPosition + ',left=' + LeftPosition + ',scrollbars=' + scroll + ',resizable'
    win = window.open(mypage, myname, settings)
}

function deleteUserRole(uid, rid)
{
    confirmed = confirm("Are You Sure you want to delete?");
    if (confirmed)
        location.href = "UserRole/deleteUserRole.php?UserId=" + uid + "&RoleId=" + rid;
}
function deleteRole(rid)
{
    confirmed = confirm("Are You Sure you want to delete?");
    if (confirmed)
        location.href = "UserRole/deleteRole.php?RoleId=" + rid;
}

function deleteKeyword(kw, sc)
{
    confirmed = confirm("Are You Sure you want to delete?");
    if (confirmed)
        location.href = "deleteKeyword.php?Keyword=" + kw + "&ShortCode=" + sc;
}
function deletemask(sr, ms)
{
    confirmed = confirm("Are You Sure you want to delete?");
    if (confirmed)
        location.href = "deletemask.php?src=" + sr + "&msk=" + ms;
}
function deleteSC(sc, sms, def)
{
    confirmed = confirm("Are You Sure you want to delete?");
    if (confirmed)
        location.href = "deleteSC.php?sc=" + sc + "&sms=" + sms + "&def=" + def;
}

function validateRoleInfo()
{
    var mess = "Plesae Input All Field";
    if (document.getElementById('RoleId').value == "")
    {
        alert("Plesae Input Role Id ");
        return false;
    }
    else if (document.getElementById('RoleName').value == "")
    {
        alert("Plesae Input Role Name ");
        return false;
    }
    else
    {
        return true;
    }
    //document.forms[voteinfo].submit();
}

function validateCriteriaInfo()
{
    if (document.getElementById('Date1').value == "")
    {
        alert("Plesae Enter From Date ");
        return false;
    }
    if (document.getElementById('Date2').value == "")
    {
        alert("Plesae Enter To Date ");
        return false;
    }

    if (!document.getElementById('chkAllSourceNo').checked)
    {
        if (document.getElementById('SourceNo').value == "")
        {
            alert("Plesae Input Source No ");
            return false;
        }

    }
}

function validateCriteriasInfo()
{
    if (document.getElementById('Date1').value == "")
    {
        alert("Plesae Enter From Date ");
        return false;
    }
    if (document.getElementById('Date2').value == "")
    {
        alert("Plesae Enter To Date ");
        return false;
    }
}

function validateUserInfo()
{
    var mess = "Plesae Input All Field";
    if (document.getElementById('UserName').value == "")
    {
        alert("Plesae Input User Name ");
        return false;
    }
    else if (document.getElementById('Password').value == "")
    {
        alert("Plesae Input Password ");
        return false;
    }
    else if (document.getElementById('Answer').value == "")
    {
        alert("Plesae Input Answer");
        return false;
    }
    else
    {
        return true;
    }
    //document.forms[voteinfo].submit();

}
function validateForgotPass()
{
    var mess = "Plesae Input All Field";
    if (document.getElementById('UName').value == "")
    {
        alert("Plesae Input User Name ");
        return false;
    }
    else if (document.getElementById('Answer').value == "")
    {
        alert("Plesae Input Answer");
        return false;
    }
    else if (document.getElementById('Password').value == "")
    {
        alert("Plesae Input Password ");
        return false;
    }
    else
    {
        return true;
    }
    //document.forms[voteinfo].submit();

}


function validateKeyword()
{
    if (document.getElementById('keyword').value == "")
    {
        alert("Plesae Input Keyword ");
        return false;
    }
    else if (document.getElementById('shortcode').value == "")
    {
        alert("Plesae Input Short Code ");
        return false;
    }
    else
    {
        return true;
    }
    //document.forms[voteinfo].submit();
}

function smsUpload()
{
    if (document.getElementById('uploadcsv').value == "")
    {
        alert("Plesae select csv file ");
        return false;
    }
    else if (!checkExtensions(document.getElementById('uploadcsv')))
    {
        alert("File Type should be csv");
        return false;
    }
    else
    {
        return true;
    }
}

function smsBroadcast()
{
    if (document.getElementById('uploadcsv').value == "")
    {
        alert("Plesae select csv file ");
        return false;
    }
    else if (!checkExtensions(document.getElementById('uploadcsv')))
    {
        alert("File Type should be csv");
        return false;
    }
    else if (document.getElementById('msg').value == "")
    {
        alert("Plesae write a sms ");
        return false;
    }
    else if (document.getElementById('sourceName').value == "")
    {
        alert("Plesae enter a Source No ");
        return false;
    }
    else
    {
        return true;
    }
}

function validateForm(groupForm)
{
    if (document.getElementById('sub_no').value == "")
    {
        alert("Subscriber no should be given");
        document.getElementById('sub_no').focus();
        return false;
    }
    var num = document.getElementById('sub_no').value;
    if (num.length != 11) {
        alert('Number should be of 11 digit.');
        document.getElementById('sub_no').focus();
        return false;
    }
    document.forms[groupForm].submit();

}

/*** Validation functions ***/
function validate_string(input)
{
    if (input.value == "")
    {
        alert("Please input colored field");
        input.focus();
        input.style.background = 'Yellow';
    }
    else
        input.style.background = 'White';
}

function isNull(input)
{
    if (input.value == "") {
        return false;
//		input.style.background = 'Yellow';
        //return input.value;
    }
    else {
//		input.style.background = 'White';
//		return input.value;
        return true;
    }
}

function validate_numeric(fdl)
{
    var RegExPattern = /^([0-9][0-9]*)$/;

    if (!fdl.value.match(RegExPattern))
    {
        return false;
    }
    return true;
}
function validate_float(fdl)
{
    var RegExPattern = /^([0-9]+\.?[0-9]*|\.[0-9])$/;

    if (!fdl.value.match(RegExPattern))
    {
        return false;
    }
    return true;
}

function checkDateFormat(form) //this
{
    re = /^[0-9]{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])/;
    if (form.value != '' && !form.value.match(re))
    {
        //alert("Invalid date format: \n correct format yyyy-mm-dd" );
        return false;
    }
    else
    {
        return true;
    }
}


function checkDateRange(fromDate, toDate)
{
    if (fromDate.value > toDate.value)
    {
        //alert ("Start Date is greater");
        return false;
    }
    else
    {
        return true;
    }
}


function checkSpecialChar(data)
{
    //var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?~_";
    var iChars = "$%@^&*()+=[]\\\';/{}|\":<>~_";
    for (var i = 0; i < data.length; i++)
    {
        if (iChars.indexOf(data.charAt(i)) != -1)
        {
            // alert ("Your string has special characters. \nThese are not allowed.");
            return false;
        }
    }
    return true;
}
function validateprogramfield() {

    var service = document.getElementById('service').value;
    var program = document.getElementById('program').value;
    var episode = document.getElementById('episode').value;
    var sms = document.getElementById('sms').value;
    //alert(sms);
    if (service == '')
    {
        alert("Service is not optional");
        return false;
    }
    else if (program == '')
    {
        alert("Programe name is not optional.");
        return false;
    }
    else {
        if (service == 'Vote') {
            if (episode == '') {
                alert("No of Episode is not optional");
                return false;

            }
            else if (!validate_numeric(document.getElementById('episode'))) {
                alert("No of Episode Should be numeric");
                return false;
            }
        }
        else if (sms == '') {
            alert("User SMS is not optional.");
            return false;

        }

    }
//	alert(service);
    return true;
}

function deleteProgramContent(service, p1, p2)
{
    confirmed = confirm("Are You Sure?");
    if (confirmed)
        location.href = "del_programContent.php?service=" + service + "&p1=" + p1 + "&p2=" + p2;
}

function checkDateTimeRange(fromDate, toDate, frmH, toH, frmM, toM)
{
    frmHour = parseInt(frmH.value);
    toHour = parseInt(toH.value);
    frmMint = parseInt(frmM.value);
    toMnt = parseInt(toM.value);
    if (fromDate.value > toDate.value)
    {
        return false;
    }
    else if (fromDate.value == toDate.value) {
        if (frmHour > toHour) {
            return false;
        }
        else if ((frmHour == toHour) && (frmMint >= toMnt)) {
            return false;
        }

    }

    return true;

}

function strrpos(haystack, needle, offset)
{
    var i = (haystack + '').lastIndexOf(needle, offset); // returns -1
    return i >= 0 ? true : false;
}

function ansCount(cnt)
{
    var i = 0;
    for (i = 0; i < cnt; i++)
    {
        if (document.getElementById('a' + i).value == "")
            return false;
    }
    return true;
}

function checkExtensions(inFile) {

    var extension = new Array();
    var fieldvalue = inFile.value;

    extension[0] = ".csv";
    /*extension[1] = ".gif";
     extension[2] = ".jpg";*/

    var thisext = fieldvalue.substr(fieldvalue.lastIndexOf('.'));
    for (var i = 0; i < extension.length; i++)
    {
        if (thisext == extension[i])
        {
            return true;
        }
    }
    //alert("Soory you cannot upload this file.");
    return false;
}
