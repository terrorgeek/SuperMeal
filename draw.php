<?php session_start();
require_once 'Model/DBConnect.php';
require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_bar.php');
require_once ('jpgraph/src/jpgraph_line.php');
function Get_Max_Id($table_name,$user_id)
{
	$sql="select MAX(id) as max from ".$table_name." where user_id=".$user_id;
	$q=mysql_query($sql);
	$r=mysql_fetch_array($q);
	return $r["max"];
}
function Get_Recent_Time($user_id)
{
	$sql="select left(date,10) from meal where user_id=".$user_id." ORDER BY date DESC ";
	$query=mysql_query($sql);
	$result=mysql_fetch_array($query);
	return $result[0];
}
echo Get_Recent_Time(1);
?>