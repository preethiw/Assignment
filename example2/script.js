function AddTextBox(strTxtName, strDiv, indexValue, innerValue)
{
    document.getElementById(strDiv).innerHTML = "";
    for (i = 0; i < indexValue; i++) {
        for (j = 0; j < innerValue; j++) {
            var txt = document.createElement("Input");
            txt.setAttribute("name", strTxtName + "_" + i + "_" + j);
            txt.setAttribute("id", strTxtName + "_" + i + "_" + j);
			txt.setAttribute("required", "true");
            if (j == 0) {
                txt.setAttribute("maxlength", 50);
                txt.setAttribute("onkeypress", "return AlphabetsWithSpace(event,this);");
            }

            if (j == 1) {
                txt.setAttribute("maxlength", 50);
                txt.setAttribute("onkeypress", "return onlyAlphabets(event,this);");
            }

            if (j == 2) {
                txt.setAttribute("maxlength", 1);
                txt.setAttribute("onkeypress", "return OnlyYnN(event,this);");
            }
            if (j == 3) {
                var txtS1 = strTxtName + "_" + i + "_" + 0;
                var txtV1 = strTxtName + "_" + i + "_" + j;
                txt.setAttribute("onblur", "return checkValue(this.value,'" + txtS1 + "','" + txtV1 + "');");
            }
            document.getElementById(strDiv).appendChild(document.createElement("br"));
            document.getElementById(strDiv).appendChild(txt);
        }
        document.getElementById(strDiv).appendChild(document.createElement("hr"));
    }
}

function getTextbox(strValue, strTxtName, strDiv) {
    if (strValue <= 100) {
        var res = strValue.split(" ");
        AddTextBox(strTxtName, strDiv, res[0], 4);
    }
}

function onlyAlphabets(e, t) {
    try {
        if (window.event) {
            var charCode = window.event.keyCode;
        } else if (e) {
            var charCode = e.which;
        } else {
            return true;
        }
        if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123))
            return true;
        else
            return false;
    } catch (err) {
        alert(err.Description);
    }
}

function AlphabetsWithSpace(e, t) {
    try {
        if (window.event) {
            var charCode = window.event.keyCode;
            if ((charCode == 32))
                return true;
            else
                return onlyAlphabets(e, t);
        } else {
            return true;
        }
    } catch (err) {
        console.log(err.Description);
    }
}

function OnlyYnN(e, t) {
    try {
        if (window.event) {
            var charCode = window.event.keyCode;
            if ((charCode == 78) || (charCode == 89))
                return true;
            else
                return false;
        } else {
            return true;
        }
    } catch (err) {
        console.log(err.Description);
    }
}

function checkValue(enterValue, S1, V1)
{
    var txtname = document.getElementsByName(S1);
    var len = txtname[0].value.length;
    if (enterValue <= (len - 1))
        return true;
    
	if (len < -1) {
		alert("Field cannot be empty");
	}
	else {
        alert("Please enter a value less than the length of string");
        return false;
    }
}

function checkBlankValue(txtValue) {
    if (txtValue.length <= 0) {
        alert("Field cannot be empty");
    }
	if (txtValue.length <= -1) {
		alert("Field cannot be empty");
	}
}
function getResult(strValue, strTxtName, strDiv) {
    var res = strValue.split(" ");
    AddTextBox(strTxtName, strDiv, res[0], 1);
    var dic = [];
    var Test1value = $('#Text1').val();
    for (i = 0; i < Test1value; i++) {
        var dictionaryarr = [];
        for (y = 0; y < 4; y++) {
            dictionaryarr.push($('#txtDictonary_' + i + '_' + y).val());
        }
        dic.push({i: dictionaryarr});
    }
    $.ajax({
        type: "POST",
        url: "controlHandler.php",
        data: {jsondata: dic}})
            .done(function (data) { // if getting done then call.
                jsondata = jQuery.parseJSON(data);
                var Testvalue = $('#Text1').val();

                for (i = 0; i < Testvalue; i++) {
                    $('#txtResult_' + i + '_0').val(jsondata[i]);
                }
            });
}
