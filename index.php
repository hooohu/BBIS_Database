<html>
<head>

<script type="text/javascript">
function formSubmit(){
	var username = document.getElementById("user").value;
	var password = document.getElementById("psw").value;
	if (username == "database" && password == "team2") {
		document.getElementById("login_page").submit();
	} else {
		document.getElementById("errorSpan").innerHTML = "Wrong username or password!!";
	}
}
</script>
</head>
<body class="login_bgg">

<div id="words" style="padding-top:10%">
	<h1 style="font-size:30;color:black;text-align:center">Barkley Brothers Information System (BBIS)</h1>
	<div id="image" align="center">
		<img style="padding-top:7" src="welcome.jpg" />
	</div>
	<form id="login_page" action="BBIS_teamA.php" method="post">
	<div>
		<p style="text-align:center">username:<input type="text" id="user" name="username"/></p>
		<p style="text-align:center">password:<input type="password" id="psw" name="password"/></p>
		<p style="text-align:center"><span id="errorSpan" style="color:red"></span></p>
	</div>
    <div>
		<p style="text-align:center"><input type="button" class="login_btn" value="login" onclick="formSubmit()"/>
	</div>
    <!-- <input type="reset" class="but2" value="<spring:message code='Page.other.forgetPassword'/>" title="<spring:message code='Page.other.forgetPasswordSystemManager'/>"/> -->
    </form>
</div>
<p><small>Group Team-A 2014</small></p>
</body>
</html>
