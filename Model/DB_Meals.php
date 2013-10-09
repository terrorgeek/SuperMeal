<?php session_start();
$breakfast_hash=array();
$lunch_hash=array();
$dinner_hash=array();
$meal=array();
$recent_two_weeks=date("Y-m-d",strtotime("-14 day"));
function list_meals($user_id)
{
	$recent_two_weeks=date("Y-m-d",strtotime("-14 day"));
	// $sql="select * from meal where user_id='".$user_id."' and date>".$recent_two_weeks." GROUP BY left(date,10)";
	$sql="select * from meal where user_id='".$user_id."' and date>".$recent_two_weeks;
	$query=mysql_query($sql);
	return $query;
}

function find_include($food_name_array,&$Hash_Table)//找交集
{
	for ($i=0; $i <count($food_name_array) ; $i++) { 
		if($Hash_Table[$food_name_array[$i]]==null||$Hash_Table[$food_name_array[$i]]==0||!isset($Hash_Table[$food_name_array[$i]]))
			$Hash_Table[$food_name_array[$i]]==1;
		else
			$Hash_Table[$food_name_array[$i]]++;
	}
}
function find_eat_too_much($meal_array)//找出吃的多的
{
	$suggestion_array=array();
	foreach ($meal_array as $key => $value) {
		if($meal_array[$key]>=3)
		    array_push($suggestion_array,$key);
	}
	return $suggestion_array;
}
function delete_eat_too_much($meal_array)
{
	foreach ($meal_array as $key => $value) {
		if($meal_array[$key]>=3)
		    unset($meal_array[$key]);
	}
	return $meal_array;
}
?>