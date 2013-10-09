<?php session_start();
if(isset($_SESSION["user_id"]))
{
	unset($_SESSION["user_id"]);
	unset($_SESSION["username"]);
	unset($_SESSION["gender"]);
	unset($_SESSION["age"]);
	session_destroy();
	echo "<script>window.location.href='../View/index.php';</script>";
}
?>