<?php session_start();

?>
<script src="../Model/bootstrap/js/bootstrap.js"></script>
<script src="js/jquery.js"></script>
<script>
function do_it(){
	var p1=document.getElementById("password").value;
	var p2=document.getElementById("pass_con").value;
	if(p1!=p2)
	{
		alert("2 password is not same!");
		return;
	}
	else
	    document.getElementById("form2").submit();
}

</script>
<center><h1>Login</h1>
<link href="../Model/bootstrap/css/bootstrap.min.css" rel="stylesheet" >
<link href="../Model/bootstrap/css/bootstrap.css" rel="stylesheet" >
<form action="../Controller/form_action.php" method="post" class="navbar-form">
	username:<input type="text" name="username" style="height: 30px;" /><br/>
	password:<input type="password" name="password" style="height: 30px;" /><br/>
	<input type="hidden" value="login" name="action" />
	<input type="submit" value="submit" class="btn btn-primary"  />
</form>
</center>
<!-- <h2>Register</h2>
<form action="../Controller/form_action.php" method="post" id="form2">
	username:<input type="text" name="username" style="height: 30px;" /><br/>
	password:<input type="password" name="password" id="password" style="height: 30px;" /><br/>
	password confirm:<input type="password" name="pass_con" id="pass_con" style="height: 30px;"  /><br/>
	gender:<input type="radio" name="sex" id="sex" value="m" />&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="radio" name="sex" id="sex" value="f"/><br/>
	<input type="hidden" value="login" name="register" /><br/>
	<input type="button" value="submit" onclick="do_it()" class="btn btn-primary" />
</form> -->

