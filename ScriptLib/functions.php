<?php session_start();
function Get_Array_First_Value($array)
{
	$index=0;
	foreach ($array as $key => $value) {
		return $key;
	}
}
function Get_Rank_More_Accurate($food_name,$element_name)
{
	$sql="select ".$element_name." from food where name='".$food_name."'";
	$q=mysql_query($sql);
	$value=mysql_fetch_array($q);
	$result=Get_Array_By_ELement_Name($element_name);
	sort($result);
    $quotient=count($result)/8;
	for($i=0;$i<count($result);$i++)
	{
		if($result[$i]==$value[$element_name])
		{
			if($i<$quotient)
			    return 10;
			else if($i>=$quotient&&$i<2*$quotient)
			    return 20;
			else if($i>=2*$quotient&&$i<3*$quotient)
				return 30;
			else if($i>=3*$quotient&&$i<4*$quotient)
			    return 40;
			else if($i>=4*$quotient&&$i<5*$quotient)
			    return 50;
			else if($i>=5*$quotient&&$i<6*$quotient)
			    return 60;
			else if($i>=6*$quotient&&$i<7*$quotient)
			    return 70;
			else 
				return 80;
		}
	}
}
function Get_Rank($food_name,$element_name)
{
	$sql="select ".$element_name." from food where name='".$food_name."'";
	//die($sql);
	$q=mysql_query($sql);
	$value=mysql_fetch_array($q);
	$result=Get_Array_By_ELement_Name($element_name);
	sort($result);
//	print_r($result);
    $quotient=count($result)/3;
//  echo 2*$quotient."<br/>";
	for($i=0;$i<count($result);$i++)
	{
		if($result[$i]==$value[$element_name])
		{
			if($i<$quotient)
			    return 10;
			else if($i>=$quotient&&$i<2*$quotient)
			    return 20;
			else
				return 30;
		}
	}
}
function Get_Array_By_ELement_Name($element_name)
{
	$sql="select ".$element_name." from food ORDER BY ".$element_name." ASC";
	$array=array();
	$q=mysql_query($sql);
	while($out=mysql_fetch_array($q))
	    array_push($array,$out[$element_name]);
	return $array;
}
function Get_All_Food_Array()
{
	$sql="select name,sugar,protein,fat,vitamin_A,vitamin_E,vitamin_C,folate,vitamin_B6,vitamin_B12,calcium,iron,potassium,
	      zinc,magnesium,copper,phosphorus,sodium,manganese,selenium,cholesterol,fiber,energy from food";
    $query=mysql_query($sql);
    $array=array();
	$index=0;
	while($out=mysql_fetch_array($query))
	{
		$temp=array("name"=>$out["name"],"sugar"=>$out["sugar"],"protein"=>$out["protein"],"fat"=>$out["fat"],"vitamin_A"=>$out["vitamin_A"],
		            "vitamin_E"=>$out["vitamin_E"],"vitamin_C"=>$out["vitamin_C"],"folate"=>$out["folate"],"vitamin_B6"=>$out["vitamin_B6"],
					"vitamin_B12"=>$out["vitamin_B12"],"calcium"=>$out["calcium"],"iron"=>$out["iron"],"potassium"=>$out["potassium"],
					"zinc"=>$out["zinc"],"magnesium"=>$out["magnesium"],"copper"=>$out["copper"],"phosphorus"=>$out["phosphorus"],
					"sodium"=>$out["sodium"],"manganese"=>$out["manganese"],"selenium"=>$out["selenium"],"cholesterol"=>$out["cholesterol"],
					"fiber"=>$out["fiber"],"energy"=>$out["energy"]);
	    array_push($array,$temp);
	}
	return $array;
}

function Get_All_Food_Array_For_Name()
{
	$name_array=array();
	$sql="select name from food";
	$query=mysql_query($sql);
	while($out=mysql_fetch_array($query))
		array_push($name_array,$out["name"]);
	return $name_array;
}

function Get_All_Food_ResultSet()
{
	$sql="select name,sugar,protein,fat,vitamin_A,vitamin_E,vitamin_C,folate,vitamin_B6,vitamin_B12,calcium,iron,potassium,
	      zinc,magnesium,copper,phosphorus,sodium,manganese,selenium,cholesterol,fiber,energy from food";
    $query=mysql_query($sql);
	return $query;
}

function Get_All_Element_Fields()//从food表里获的所有列的数组
{
	$fields_array=array();
	$sql="select * from food";
    $query=mysql_query($sql);
	for($i=2;$i<=23;$i++)
		array_push($fields_array,mysql_field_name($query, $i));
	return $fields_array;
}

function Get_Most_Recent_Body_Status_Array()
{
	$sql="select sugar,protein,fat,vitamin_A,vitamin_E,vitamin_C,folate,vitamin_B6,vitamin_B12,calcium,iron,potassium,
	      zinc,magnesium,copper,phosphorus,sodium,manganese,selenium,cholesterol,fiber,energy from body_status where 
	      user_id='".$_SESSION['user_id']."' ORDER BY date DESC";
	$query=mysql_query($sql);
	$array=array();
	if(mysql_num_rows($query)==0)
	    return "no data yet";
	else
	{
		$result=mysql_fetch_array($query);
		$array=array("sugar"=>$result["sugar"],"protein"=>$result["protein"],"fat"=>$result["fat"],"vitamin_A"=>$result["vitamin_A"],
		             "vitamin_E"=>$result["vitamin_E"],"vitamin_C"=>$result["vitamin_C"],"folate"=>$result["folate"],"vitamin_B6"=>$result["vitamin_B6"],
					 "vitamin_B12"=>$result["vitamin_B12"],"calcium"=>$result["calcium"],"iron"=>$result["iron"],"potassium"=>$result["potassium"],
					 "zinc"=>$result["zinc"],"magnesium"=>$result["magnesium"],"copper"=>$result["copper"],"phosphorus"=>$result["phosphorus"],
					 "sodium"=>$result["sodium"],"manganese"=>$result["manganese"],"selenium"=>$result["selenium"],"cholesterol"=>$result["cholesterol"],
					 "fiber"=>$result["fiber"],"energy"=>$result["energy"]);
	}
	return $array;
}
?>