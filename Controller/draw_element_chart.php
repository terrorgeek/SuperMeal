<?php session_start();
include_once '../Model/DBConnect.php';
include_once '../Model/DB_Daily_Nutrition.php';

require_once ('../jpgraph/src/jpgraph.php');
require_once ('../jpgraph/src/jpgraph_bar.php');
require_once ('../jpgraph/src/jpgraph_line.php');
function Get_X_Axis_Data($query)
{
	$result_array=array();
	while($out=mysql_fetch_array($query))
		array_push($result_array,substr($out["date"], 0,10));
	mysql_data_seek($query, 0);
	return $result_array;
}
function Get_Y_Axis_Data($query,$element_name)
{
	$result_array=array();
	while($out=mysql_fetch_array($query))
		array_push($result_array,$out[$element_name]);
	mysql_data_seek($query, 0);
	echo $out[$element_name]."<br/>";
	return $result_array;
}
if($_REQUEST["element_name"]&&$_REQUEST["element_name"]!="")
{
	$element_name=$_REQUEST["element_name"];
	$recent_two_weeks=date("Y-m-d",strtotime("-14 day"));
	$sql_for_draw="select  ".$element_name." ,date from daily_nutrition where date > ".$recent_two_weeks."
	                 ORDER BY date LIMIT 0,10";
//	die($sql_for_draw);
	$query=mysql_query($sql_for_draw);
	$graph = new Graph(1200,600);                            //创建新的Graph对象  
    $graph->SetScale("textlin");                         //设置刻度样式  
    $graph->img->SetMargin(0,0,0,0);
	$graph->title->Set("element ".$element_name." condition in recent 2 weeks");  //设置图表标题
	$result_array=array();
	while($out=mysql_fetch_array($query)){
		array_push($result_array,$out[$element_name]);
		echo $out["element_name"];
	}
	mysql_data_seek($query, 0);
	$lineplot=new LinePlot($result_array);  //Y 轴
	
	$lineplot->SetLegend("Amount");   //设置图例文字  
    $lineplot->SetColor("red");                 // 设置曲线的颜色  
    
    // Add the plot to the graph  
    $graph->Add($lineplot);   
	$result_array2=array();
	while($out=mysql_fetch_array($query))
		array_push($result_array2,substr($out["date"], 0,10));
	mysql_data_seek($query, 0);
    $graph->xaxis->SetTickLabels($result_array2);                  //在统计图上绘制曲线  
    // Display the graph  
    $graph->Stroke(); 
}
?>