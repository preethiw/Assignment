<!DOCTYPE html>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="script.js"></script>
    </head>
    <body>
        <form method="post">
            <label>Number of words in Dictionary : </label>
            <input id="Text1" type="text" onblur="getTextbox(this.value, 'txtDictonary', 'divContentDictonary')" />
            <div id="divContentDictonary"></div>
            <br />
            <label >Number of queries : </label>
            <input id="Text2" type="number" min="1" max= "100" onblur="getTextbox(this.value, 'txtQuery', 'divContentQuery')" />
            <div id="divContentQuery"></div>
            <br />
            <input type="button" id="btn" value="Submit" onclick="getResult(document.getElementById('Text2').value, 'txtResult', 'divContentResult')" />
            <br />
            <label id="result" style="display:none">Results :</label>
            <div id="divContentResult"></div>
        </form>
    </body>
</html>