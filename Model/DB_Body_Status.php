<?php session_start();
require_once("../../ScriptLib/functions.php");
// $recent_two_weeks=date("Y-m-d",strtotime("-14 day"));
// $sql_get_body_status="select * from body_status where date >".$recent_two_weeks." ORDER BY date";
// $query=mysql_query($sql_get_body_status);
function Get_Benefits($element_name)
{
	$sql="select benefits from element_benefit where element_name='".$element_name."'";
	$q=mysql_query($sql);
	$r=mysql_fetch_array($q);
	return $r["benefits"];
}

function Get_Food_From_Element_Food($element_name)
{
	$sql="select food_contained_by from element_food where element_name='".$element_name."'";
	//die($sql);
	$q=mysql_query($sql);
	$r=mysql_fetch_array($q);
	return $r['food_contained_by'];
}
function my_sort($a, $b)
{
    if ($a == $b) return 0;
        return ($a > $b) ? -1 : 1;
}
function Get_Max_Min_Element_In_Body()
{
	$sql="select * from body_status where user_id='".$_SESSION['user_id']."' ORDER BY id DESC";
	$query=mysql_query($sql);
	$all_fields=Get_All_Element_Fields();
	$temp=array();$index=0;
	while($out=mysql_fetch_array($query))
	{
		$temp[$all_fields[$index]]=$out[$all_fields[$index]];
		$index++;
	}
	uasort($temp,"my_sort");
	return $temp;
}
function Make_Array($start,$end,$array)//返回数组 
{
	$answer=array();
	$index=0;
	for($i=$start;$i<=$end;$i++)
	{
		$answer[$index]=$array[$i];
		$index++;
	}
	return $answer;
}
function Handle_Disease_Text($diseases,$range)
{
	$array=explode(",", $diseases);
	$q=count($array)/3;
	if($range=="1")
	    return Make_Array(0, 2, $array);
	else if($range=="2")
	    return Make_Array(3, 4, $array);
	else
		return Make_Array(5, count($array)-1, $array);
}


function Make_Suggestion_For_Ate_Least($field_array,$food_name)
{
	$temp=array();
	for ($i=0; $i <count($field_array) ; $i++) { 
		$value=Get_Rank_More_Accurate($food_name,$field_array[$i]);
		$temp[$field_array[$i]]=$value;
	}
	uasort($temp,"my_sort");
	$answer=array($food_name,Get_Array_First_Value($temp));
	return $answer;
}
function Get_Diseases_By_Single_Element($element_name)
{
	$sql="select * from disease_high_bound where element_description='".$element_name."'";
	$q=mysql_query($sql);
	$result=mysql_fetch_array($q);
	return $result["name"];
}
function Find_Diseases($elements_high)
{
	$high_array=explode(",", $elements_high);
	$answer=array();
	for($i=0;$i<count($high_array);$i++)
	{
		$temp=array($high_array[$i],Get_Diseases_By_Single_Element($high_array[$i]));
		array_push($answer,$temp);
	}
	return $answer;
}
function Give_Eat_Most_Suggestions($top_eat_most)//返回二维数组 
{
	$answer=array();
	$top_eat_most_array=explode(",", $top_eat_most);
	$all_fields=Get_All_Element_Fields();
	for($i=0;$i<count($top_eat_most_array);$i++)
	{
		$temp=array();
		for($j=0;$j<count($all_fields);$j++)
		{
			$temp[$all_fields[$j]]=Get_Rank_More_Accurate($top_eat_most_array[$i],$all_fields[$j]);
		}
		uasort($temp,"my_sort");
		$a=array($top_eat_most_array[$i],Get_Array_First_Value($temp));
		array_push($answer,$a);
	}
	return $answer;
}

function Get_The_Ate_Most($num,$array)//返回自符串
{
	$index=1;
	$answer="";
	foreach ($array as $key => $value) {
		$answer.=$key.",";
		$index++;
		if($index>$num)
		    break;
	}
	$answer=substr($answer, 0,strlen($answer)-1);
	return $answer;
}
function Get_The_Ate_Least($array)//得到吃的最少的
{
	$index=0;
	$answer="";
	foreach ($array as $key => $value) {
		if($index==count($array)-1)
		{
			$answer=$key;
			return $key;
		}
		$index++;
	}
}

function list_meals($user_id)
{
	$recent_two_weeks=date("Y-m-d",strtotime("-14 day"));
	//$sql="select * from meal where user_id='".$user_id."' and date>".$recent_two_weeks." GROUP BY left(date,10)";
	$sql="select * from meal where user_id='".$user_id."' and date>".$recent_two_weeks;
	$query=mysql_query($sql);
	return $query;
}

function Get_All_Elements()
{
	$sql="select * from food";
	$query=mysql_query($sql);
	$field_array=array();
	$field_number=mysql_num_fields($query);
	for ($i=2; $i <=23; $i++)
		array_push($field_array,mysql_field_name($query, $i));
	return $field_array;
}
function Get_Daily_Nutrition_Data()//仅仅是反回表中的数据
{
	$recent_two_weeks=date("Y-m-d",strtotime("-14 day"));
    $sql_get_daily_nutrition="select * from daily_nutrition where user_id='".$_SESSION['user_id']."' and date >".$recent_two_weeks." ORDER BY date";
    $query=mysql_query($sql_get_daily_nutrition);
	return $query;
}

//得到某个元素的最低何最高设入量,传参时要有性别，返回的数组只有两个元素，第一个是最低直，第二个是最高直
function Get_Standard_Inject($element,$gender)
{
//	$sql_lowert_inject="select ".$element." from element_inject_everyday where sex='".$gender."'";
	$sql_lowert_inject="select * from element_inject_everyday where sex='".$gender."'";
//	die($sql_lowert_inject);
	$query=mysql_query($sql_lowert_inject);
	$result="";
	while($out=mysql_fetch_array($query))
	{
		$age_range=$out["age"];
		$age_array=explode("-", $out["age"]);
		if($_SESSION["age"]>$age_array[0]&&$_SESSION["age"]<$age_array[1])
		{$result=$out;break;}
	}
	$first_index=stripos($result[$element], "(");
	$second_index=stripos($result[$element], ")");
	$temp=substr($result[$element], $first_index+1,$second_index-$first_index-1);
	$array=explode("-", $temp);
	return $array;
}
//这个函数作用是输入一个天数，然后计算这几天之中某一个元素那天的设入量有几天低于/高于最低/最高设入量
//参数第一个是你要查几天前的，第二个是你要查什么元素，返回一个数组，第一个元素是有几天低了，第二个元素是有几天高了
function How_Many_Days_Lower_Or_Higher_Than_Standard_Amount_For_An_ELement($days,$element_name,$gender)
{
	$days_for_below=0;
	$days_for_up=0;
	$bound=Get_Standard_Inject($element_name, $gender);
	$low_bound=$bound[0];$high_bound=$bound[1];
	$sql="select SUM(".$element_name.") from daily_nutrition where user_id='".$_SESSION['user_id']."' GROUP BY left(date,10) ORDER BY date DESC";
	$query=mysql_query($sql);
	for ($i=0; $i <$days ; $i++) { 
		$out=mysql_fetch_array($query);
		if($out[0]<$low_bound)
		    $days_for_below++;
		elseif ($out[0]>$high_bound)
			$days_for_up++;
	}
	$array=array($days_for_below,$days_for_up);
	return $array;
}
function get_first_food_from_element_food_table($element_name)
{
	$sql="select * from element_food where element_name='".$element_name."'";
	$query=mysql_query($sql);
	$result=mysql_fetch_array($query);
	$a=explode(",", $result[2]);
	return $a[0];
}
function get_foods_by_element($element_name)//返回包含一个元素的所有吃的，返回的是个数组
{
	$sql="select * from element_food where element_name='".$element_name."'";
	$query=mysql_query($sql);
	$result=mysql_fetch_array($query);
	return explode(",", $result["food_contained_by"]);
}
function get_disease_low_bound($element_name)
{
	$sql="select * from disease_low_bound where element_description='".$element_name."'";
	$query=mysql_query($sql);
	return $query;
}
function get_disease_high_bound($element_name)
{
	$sql="select * from disease_high_bound where element_description='".$element_name."'";
	$query=mysql_query($sql);
	return $query;
}
function divide_disease_names($diseases)
{
	//传进来的参数是字符串，一般都大于三种疾病
	$arr=explode(",", $diseases);
	$quotient=count($arr)/3;
	$text="the initial symptom will be ";
	for ($i=0; $i <$quotient ; $i++) 
		$text.=$arr[$i];
	$text.=". if you still ignore it, you will get ";
	for ($i=$quotient; $i <$quotient+$quotient ; $i++) 
		$text.=$arr[$i];
	$text.=". If you still don't care, may be some terrible diseases will happen to you, such as "; 
	for ($i=$quotient+$quotient; $i < count($arr); $i++)
	    $text.=$arr[$i];
	$text.=".";
	return $text;
}
// function get_disease_high_bound($diseases)
// {
	// //传进来的参数是字符串，一般都大于三种疾病
	// $arr=explode(",", $diseases);
	// $quotient=count($arr)/3;
	// $text="the initial symptom will be ";
	// for ($i=0; $i <$quotient ; $i++) 
		// $text.=$arr[$i];
	// $text.=". if you still ignore it, you will get ";
	// for ($i=$quotient; $i <$quotient+$quotient ; $i++) 
		// $text.=$arr[$i];
	// $text.=". If you still don't care, may be some terrible diseases will happen to you, such as "; 
	// for ($i=$quotient+$quotient; $i < count($arr); $i++)
	    // $text.=$arr[$i];
	// $text.=".";
	// return $text;
// }
?>