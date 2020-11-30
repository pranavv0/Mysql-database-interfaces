<!DOCTYPE html>
<html lang="en">
<head>
<?php 
session_start();
?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.8/ace.js"> </script>
<style type="text/css">
#jsEditor{
    height: 200px;
 }
</style>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
* {
  box-sizing: border-box;
}

body {
  font: 16px Arial;  
}

/*the container must be positioned relative:*/
.autocomplete {
  position: relative;
  display: inline-block;
}

input {
  border: 1px solid transparent;
  background-color: #f1f1f1;
  padding: 10px;
  font-size: 16px;
}

input[type=text] {
  background-color: #f1f1f1;
  width: 100%;
}

input[type=submit] {
  background-color: DodgerBlue;
  color: #fff;
  cursor: pointer;
}

.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}

.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}

/*when hovering an item:*/
.autocomplete-items div:hover {
  background-color: #e9e9e9; 
}

/*when navigating through the items using the arrow keys:*/
.autocomplete-active {
  background-color: DodgerBlue !important; 
  color: #ffffff; 
}
</style>
</head>     
<body>

<!--Make sure the form has the autocomplete function switched off:-->
<h2> Enter query : </h2>
<form autocomplete="off" action="run.php" method="post">
  <div class="autocomplete" style="width:300px;">
    <input id="myInput"  type="text" name="sql">
  </div>
  <script type="text/javascript">
      var e=ace.edit("sql");
      e.getSession().setMode("ace/mode/javascript");
      e.renderer.setShowGutter(false);
  </script>
  <h2> Enter what you want to do : </h2>
  <input type = "radio" name = "want" value = "1" > Create <br>
  <input type = "radio" name = "want" value = "2" > Insert <br>
  <input type = "radio" name = "want" value = "3" > Read <br>
  <input type = "radio" name = "want" value = "4" > Update <br>
  <input type = "radio" name = "want" value = "5" > Delete <br>
  <input type="submit">
</form>
<script>
function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

/*An array containing all the keywords names in the pgsql:*/
var countries = ["A","ABORT","ABS","ABSOLUTE","ACCESS","ACTION","ADA","ADD","ADMIN","AFTER","AGGREGATE","ALIAS","ALL","ALLOCATE","ALSO","ALTER","ALWAYS","ANALYSE","ANALYZE","AND","ANY","ARE","ARRAY","AS","ASC","ASENSITIVE","ASSERTION","ASSIGNMENT","ASYMMETRIC","AT","ATOMIC","ATTRIBUTE","ATTRIBUTES","AUTHORIZATION","AVG","BACKWARD","BEFORE","BEGIN","BERNOULLI","BETWEEN","BIGINT","BINARY","BIT","BITVAR","BIT_LENGTH","BLOB","BOOLEAN","BOTH","BREADTH","BY","C","CACHE","CALL","CALLED","CARDINALITY","CASCADE","CASCADED","CASE","CAST","CATALOG","CATALOG_NAME","CEIL","CEILING","CHAIN","CHAR","CHARACTER","CHARACTERISTICS","CHARACTERS","CHARACTER_LENGTH","CHARACTER_SET_CATALOG","CHARACTER_SET_NAME","CHARACTER_SET_SCHEMA","CHAR_LENGTH","CHECK","CHECKED","CHECKPOINT","CLASS","CLASS_ORIGIN","CLOB","CLOSE","CLUSTER","COALESCE","COBOL","COLLATE","COLLATION","COLLATION_NAME","COLLATION_SCHEMA","COLLECT","COLUMN","COLUMN_NAME","COMMAND_FUNCTION","COMMAND_FUNCTION_CODE","COMMENT","COMMIT","COMMITTED","COMPLETION",
                 "CONDITION","CONDITION_NUMBER","CONNECT","CONNECTION","CONNECTION_NAME","CONSTRAINT","CONSTRAINTS","CONSTRAINT_CATALOG","CONSTRAINT_NAME","CONSTRAINT_SCHEMA","CONSTRUCTOR","CONTAINS","CONTINUE","CONVERSION","COPY","CORR","CORRESPONDING","COUNT","COVAR_POP","COVAR_SAMP","CREATE","CREATE TABLE","CREATEDB","CREATEROLE","CREATEUSER","CROSS","CSV","CUBE","CUME_DIST","CURRENT","CURRENT_DATE","CURRENT_DEFAULT_TRANSFORM_GROUP","CURRENT_PATH","CURRENT_ROLE","CURRENT_TIME","CURRENT_TIMESTAMP","CURRENT_TRANSFORM_GROUP_FOR_TYPE","CURRENT_USER","CURSOR","CURSOR_NAME","CYCLE","DATA","DATABASE","DATE","DATETIME_INTERVAL_CODE","DATETIME_INTERVAL_PRECISION","DAY","DEALLOCATE","DEC","DECIMAL","DECLARE","DEFAULT","DEFAULTS","DEFERRABLE","DEFERRED","DEFINED","DEFINER","DEGREE","DELETE","DELIMITER","DELIMITERS","DENSE_RANK","DEPTH","DEREF","DERIVED","DESC","DESCRIBE","DESCRIPTOR","DESTROY","DESTRUCTOR","DETERMINISTIC","DIAGNOSTICS","DICTIONARY","DISABLE","DISCONNECT","DISPATCH","DISTINCT","DO","DOMAIN","DOUBLE",
                 "DROP","DYNAMIC","DYNAMIC_FUNCTION","DYNAMIC_FUNCTION_CODE","EACH","ELEMENT","ELSE","ENABLE","ENCODING","ENCRYPTED","END","END-EXEC","EQUALS","ESCAPE","EVERY","EXCEPT","EXCEPTION","EXCLUDE"]
/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
autocomplete(document.getElementById("myInput"), countries);
</script>

</body>
</html>



