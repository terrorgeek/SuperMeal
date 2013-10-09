<?php session_start();
require_once "../Model/DBConnect.php";
    if($_POST["action"]=="login")
    {
    	$sql="select user_id, username,password,sex,age from user_table where username='".$_POST['username']."' and 
    	      password='".$_POST['password']."'";
		$query=mysql_query($sql);
	    if(mysql_num_rows($query)>0)
	    {
	    	$result=mysql_fetch_array($query);
	    	echo "<script>alert('login success!');</script>";
			$_SESSION["user_id"]=$result["user_id"];
			$_SESSION["username"]=$result["username"];
			$_SESSION["gender"]=$result["sex"];
			$_SESSION["age"]=$result["age"];
			echo $result["age"];
			echo "<script>window.location.href='../View/home.php'</script>";
	    }
		else{
			echo "<script>alert('login failed!');</script>";
			echo "<script>window.location.href='../View/index.php'</script>";
		}
    }
	else
	{
		$sql="insert into user_table (username,password) values ('".$_POST['username']."','".$_POST['password']."')";
		$q=mysql_query($sql);
		if($q)
		{
			$_SESSION["user_id"]=mysql_insert_id();
			$_SESSION["username"]=$_POST["username"];
			$_SESSION["gender"]=$_POST["sex"];
			$_SESSION["age"]=$_POST["age"];
			echo "<script>alert('register success!');</script>";
			echo "<script>window.location.href='../View/home.php'</script>";
		}
		else{
			echo "<script>alert('register failed!');</script>";
			echo "<script>window.location.href='../View/index.php'</script>";
		}
	}
?>