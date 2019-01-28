<!DOCTYPE html>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="script.js"></script>
    </head>
    <body>
        <label>Number of test cases : </label>
        <input id="Text1" type="number" min="1" max= "100" onblur="getTextbox(this.value, 'txtDictonary', 'divContentDictonary')" />
        <div id="divContentDictonary"></div>	
        <br />
        <input type="button" id="btn" value="Result" onclick="getResult(document.getElementById('Text1').value, 'txtResult', 'divContentResult')" />
        <br />
        <div id="divContentResult"></div>
    </body>
</html>