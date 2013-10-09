<?php session_start();
$conn=mysql_connect("localhost","root","photowall");
mysql_select_db("supermeal",$conn);
function Find_Single_Food($target_food)//return an array for one single food
{
	$sql="select * from food where name=".$target_food;
    $query=mysql_query($sql);
	return mysql_fetch_array($query);
}

function Get_All_Foods()//return a 2 dimensional array
{
	$sql="select * from food";
    $query=mysql_query($sql);
	while($out=mysql_fetch_array($query))
    {
       $result="";
	   for ($i=1; $i <= 23; $i++) {
		  $result.=str_replace(" ", "", $out[$i].",");//notice that that space is not really whitespace, it's asc2 is 194
	   }
	   $result.="<br/>";
    }
	return $result;
}

function Send_REST_Get_Request($url)
{
    $ch = curl_init();
	//$url="http://api.esha.com/nutrients?apikey=6ggpufugv7qz9f959yw2t365";
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $json_result = curl_exec($ch);
    $array_result = json_decode($json_result, true);
    curl_close($ch);
    return $array_result;
}

?>