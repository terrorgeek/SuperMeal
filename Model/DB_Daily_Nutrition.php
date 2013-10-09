<?php session_start();
function Get_Daily_Nutrition_Data()//仅仅是反回表中的数据
{
	$recent_two_weeks=date("Y-m-d",strtotime("-14 day"));
    $sql_get_daily_nutrition="select * from daily_nutrition where user_id='".$_SESSION['user_id']."' and date >".$recent_two_weeks." ORDER BY date";
// $sql_get_daily_nutrition="select * from daily_nutrition where user_id='".$_SESSION['user_id']."' and date >".$recent_two_weeks." ORDER BY date";
    $query=mysql_query($sql_get_daily_nutrition);
	return $query;
}

?>