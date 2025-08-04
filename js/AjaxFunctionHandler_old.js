
function AjaxController() {
    var ajaxRequest;
    try {
        ajaxRequest = new XMLHttpRequest();
    }
    catch (e) {
        try {
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (e) {
            try {
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch (e) {
                alert("Your browser broke!");
                return false;
            }
        }
    }
    return ajaxRequest;
}

function ShowDropDown(RequestedFromID, ShowToID, ShowFunction, NextCallingFunction)
{
    var ajaxRequest = AjaxController();
    var RequestingURL = "../SMSWebPanel/Lib/AjaxDropDownHandler.php?";

    var RequestedValue = document.getElementById(RequestedFromID).value;
    var RequestingParams = "ShowFunction=" + ShowFunction + "&RequestingValue=" + RequestedValue + "&NextCallFunction=" + NextCallingFunction + "";
    var SendRequest = RequestingURL + RequestingParams;
    //alert(SendRequest);
    ajaxRequest.open("POST", SendRequest, true);
    ajaxRequest.send();
    ajaxRequest.onreadystatechange = function () {
        if (ajaxRequest.readyState == 4) {
            // alert("Response :: "+ajaxRequest.responseText);
            document.getElementById(ShowToID).innerHTML = ajaxRequest.responseText;
        }
    }
}

	