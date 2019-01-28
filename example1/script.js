function AddTextBox(strTxtName, strDiv, indexValue)
{
    document.getElementById(strDiv).innerHTML = "";
    for (i = 0; i < indexValue; i++) {
        var txt = document.createElement("Input");
        txt.setAttribute("name", strTxtName + i);
        txt.setAttribute("id", strTxtName + i);
        document.getElementById(strDiv).appendChild(document.createElement("br"));
        document.getElementById(strDiv).appendChild(txt);
    }
}

function getTextbox(strValue, strTxtName, strDiv) {
    result = getCount(strValue);
    AddTextBox(strTxtName, strDiv, result)
}


function getCount(strValue) {
    var res = strValue.split(" ");
    return res[0];
}
function getResult(strValue, strTxtName, strDiv) {
    $('#result').show();
    result = getCount(strValue);
    AddTextBox(strTxtName, strDiv, result);
    var dictionaryarr = [];
    var Test1value = $('#Text1').val();
    indexValue1 = getCount(Test1value);
    for (i = 0; i < indexValue1; i++) {
        dictionaryarr.push($('#txtDictonary' + i).val());
    }
    dic = [];
    dic.push({'dic': dictionaryarr});
    var queryarr = [];
    var Test2value = $('#Text2').val();
    indexValue2 = getCount(Test2value);
    for (i = 0; i < indexValue2; i++) {
        queryarr.push($('#txtQuery' + i).val());
    }

    query = [];
    query.push({'query': queryarr});
    var data = [[], []];
    data = [dic, query];
    $.ajax({
        type: "POST",
        url: "controlHandler.php",
        data: {jsondata: data}})
            .done(function (data) { // if getting done then call.
                jsondata = jQuery.parseJSON(data);
                var Test2value = $('#Text2').val();
                indexValue2 = getCount(Test2value);
                for (i = 0; i < indexValue2; i++) {

                    $('#txtResult' + i).val(jsondata[i]);
                }
            });
}

	