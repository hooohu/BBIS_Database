<html>
<head>
<script>
function showRows(str) {
  if (str == "") {
    document.getElementById("Datashow").innerHTML = "Incomplete Request!";
    return;
  } else { 
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        document.getElementById("Datashow").innerHTML = xmlhttp.responseText;
      }
    }
    xmlhttp.open("GET","rows.php?q="+str,true);
    xmlhttp.send();
  }
}
function getParameter() {
  var ops = document.getElementById("Operations");
  var ops_str = ops.options[ops.selectedIndex].value;
  if (ops_str == "") return;
  var tbs = document.getElementById("Tables");
  var tbs_str = tbs.options[tbs.selectedIndex].value;
  if (tbs_str == "") return;

  var request = ops_str + "&t=" + tbs_str;

  if (ops_str == "3" || ops_str == "4") {
    var sele = document.getElementById("RetSelect");
    var sid = sele.options[sele.selectedIndex].value;
    if (sid == "") return;
    request += "&d=" + sid;
  }

  if (ops_str != "3") {
    var num_str = document.getElementById("RetNumber").value;
    request += "&n=" + num_str;
    var num = parseInt(num_str);
    var values = document.getElementsByName("RetValues");
    for (var i = 0; i < num; i++) {
      request += "&v" + i.toString() + "=" + values[i].value; 
    }
  }

  showRows(request);
}
function process_form(ostr,tstr) {
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      document.getElementById("Commands").innerHTML = xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET", "columns.php?q="+ostr+"&t="+tstr,true);
  xmlhttp.send();
}
function getOperation(str) {
  if (str == "") return;
  var tbs = document.getElementById("Tables");
  var tbs_str = tbs.options[tbs.selectedIndex].value;
  if (tbs_str == "") return;
  process_form(str,tbs_str);
}
function getTable(str) {
  if (str == "") return;
  var ops = document.getElementById("Operations");
  var ops_str = ops.options[ops.selectedIndex].value;
  if (ops_str == "") return;
  process_form(ops_str, str);
}

</script>
</head>
<body>
<p align="right" style="font-size:20"><a href="index.php" style="text-align:right">logout</a></p>
<h2> Barkley Brothers Information System (BBIS) </h2>
<form>
  <select id="Operations" onchange="getOperation(this.value)">
  <option value="">Select an Operation:</option>
  <option value="1">Search</option>
  <option value="2">Add</option>
  <option value="3">Delete</option>
  <option value="4">Modify</option>
  </select>
  <select id="Tables" onchange="getTable(this.value)">
  <option value="">Select a Table:</option>
  <option value="1">Property</option>
  <option value="2">Buyer</option>
  <option value="3">Seller</option>
  <option value="4">Agent</option>
  <option value="5">Office</option>
  </select>
  <button type="button" onclick="getParameter()">Execute!</button>
  <br>
  <div id="Commands"></div>
</form>
<br>
<div id="Datashow"></div>
<p> <small> Developed by Group Team-A. 2014 </small> </p>
</body>
</html>
