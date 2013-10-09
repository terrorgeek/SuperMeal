<?php session_start();
date_default_timezone_set('US/Eastern');
include_once '../Model/DBConnect.php';
include_once '../ScriptLib/functions.php';
//echo Get_Rank("CHEESE NEUFCHATEL","protein");
$breakfast=$_POST["breakfast_hidden"];
$lunch=$_POST["lunch_hidden"];
$dinner=$_POST["dinner_hidden"];
$total_meal=$breakfast.",".$lunch.",".$dinner;
$meal_array=explode(",", $total_meal);

$temp_for_add=array("sugar"=>0,"protein"=>0,"fat"=>0,"vitamin_A"=>0,
		    "vitamin_E"=>0,"vitamin_C"=>0,"folate"=>0,"vitamin_B6"=>0,
			"vitamin_B12"=>0,"calcium"=>0,"iron"=>0,"potassium"=>0,
			"zinc"=>0,"magnesium"=>0,"copper"=>0,"phosphorus"=>0,
			"sodium"=>0,"manganese"=>0,"selenium"=>0,"cholesterol"=>0,
			"fiber"=>0,"energy"=>0);

$all_food_array=Get_All_Food_Array();
$food_table_element_fields_array=Get_All_Element_Fields();
$all_food_name=Get_All_Food_Array_For_Name();
for($i=0;$i<count($meal_array);$i++)
{
	if(in_array($meal_array[$i], $all_food_name))
	{
		//找到，开始加,先往daily_nutrition里加，这个最简单！
		for($j=0;$j<count($temp_for_add);$j++)
		{
			$value=Get_Rank($meal_array[$i],$food_table_element_fields_array[$j]);
			$temp_for_add[$food_table_element_fields_array[$j]]+=$value;
		}
	}
}
//print_r($temp_for_add);echo "<br/>";
$date_now=date("Y-m-d");
//-----------------------daily_nutrition-------------------------------
$sql="insert into daily_nutrition (sugar,protein,fat,vitamin_A,vitamin_E,vitamin_C,folate,vitamin_B6,vitamin_B12,calcium,iron,potassium,
      zinc,magnesium,copper,phosphorus,sodium,manganese,selenium,cholesterol,fiber,energy,date,user_id) values (";
for($i=0;$i<count($temp_for_add);$i++){
	$sql.=$temp_for_add[$food_table_element_fields_array[$i]].",";
}
$sql=substr($sql,0,strlen($sql)-1).",'".$date_now."','".$_SESSION['user_id']."')";
//echo $sql;
//$query=mysql_query($sql);
//----------------------------meals------------------------------------
$sql_insert_meal="insert into meal (breakfast, lunch, dinner, date, user_id) values 
                 ('".$breakfast."','".$lunch."','".$dinner."','".$date_now."','".$_SESSION['user_id']."')";
//mysql_query($sql_insert_meal);
//----------------------------body_status------------------------------
//往body_status里插
$recent_body_status=Get_Most_Recent_Body_Status_Array();
if($recent_body_status=="no data yet")
{
	  // $sql_insert_body_status="insert into body_status(sugar,protein,fat,vitamin_A,vitamin_E,vitamin_C,folate,vitamin_B6,vitamin_B12,calcium,iron,potassium,
      // zinc,magnesium,copper,phosphorus,sodium,manganese,selenium,cholesterol,fiber,energy,date,user_id) values (";
      // for($i=0;$i<count($temp_for_add);$i++){
	     // $sql_insert_body_status.=$temp_for_add[$food_table_element_fields_array[$i]].",";
      // }
      // $sql_insert_body_status=substr($sql_insert_body_status,0,strlen($sql_insert_body_status)-1).",'".$date_now."','".$_SESSION['user_id']."')";
      // $query=mysql_query($sql_insert_body_status);
	  // if($query)
	      echo "<script>window.location.href='../View/personal_info/body_status.php';</script>";
}
else
{
	//先减
	// echo "<br/>";
	// for($i=0;$i<count($recent_body_status);$i++)
		// $recent_body_status[$food_table_element_fields_array[$i]]-=40;
	// for($i=0;$i<count($recent_body_status);$i++){
	    // $recent_body_status[$food_table_element_fields_array[$i]]+=$temp_for_add[$food_table_element_fields_array[$i]];
	// }
	// $sql="insert into body_status(sugar,protein,fat,vitamin_A,vitamin_E,vitamin_C,folate,vitamin_B6,vitamin_B12,calcium,iron,potassium,
      // zinc,magnesium,copper,phosphorus,sodium,manganese,selenium,cholesterol,fiber,energy,date,user_id) values (";
	// for($i=0;$i<count($recent_body_status);$i++)
		// $sql.=$recent_body_status[$food_table_element_fields_array[$i]].",";
	// $sql=substr($sql,0,strlen($sql)-1).",'".$date_now."','".$_SESSION['user_id']."')";
	// $query=mysql_query($sql);
	// if($query)
	    echo "<script>window.location.href='../View/personal_info/body_status.php';</script>";
}
?>