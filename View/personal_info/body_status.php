<?php session_start();
include_once '../../Model/DBConnect.php';
include_once '../../Model/DB_Body_Status.php';

?>
<script src="../js/jquery.js" type="text/javascript"></script>
<link href="../../Model/bootstrap/css/bootstrap.css" rel="stylesheet" >
<link href="../../Model/bootstrap/css/bootstrap-responsive.css" rel="stylesheet" >
<script src="../../Model/bootstrap/js/bootstrap.js"></script>
<body background="20309-christmas-food.jpg">
<div class="navbar navbar-inverse">
    <div class="navbar-inner">
       <div class="container">
     
    <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
       <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
       </a>
     
    <!-- Be sure to leave the brand out there if you want it shown -->
    <a class="brand" href="../home.php">Home</a>
    <a class="brand" href="daily_nutrition.php">Daily Nutrition</a>
    <a class="brand" href="body_status.php">Body Status</a>
    <a class="brand" href="meal_list.php">Meal List</a>
     
    <!-- Everything you want hidden at 940px or less, place within here -->
    <div class="nav-collapse collapse navbar-responsive-collapse">
    	<ul class="nav">
          <li class="dropdown">
        	<a class="dropdown-toggle" data-toggle="dropdown" href="#">Action<b class="caret"></b></a>
        	   <ul class="dropdown-menu">
                  <li>
                     <a href="#">About</a>
                  </li>
                  <li>
                     <a href="#">Change profile</a>
                  </li>
                  <li>
                     <a href="../../Controller/logout.php">Logout</a>
                  </li>
               </ul>
          </li>
        </ul>
    </div>
     
    </div>
    </div>
</div>
<?php
$field_array=Get_All_Elements();
$meals=list_meals($_SESSION["user_id"]);
$meal_hash=array();$index=0;
while($out=mysql_fetch_array($meals))
{
	$breakfast=$out["breakfast"];
	$lunch=$out["lunch"];
	$dinner=$out["dinner"];
	$b_array=explode(",", $breakfast);$l_array=explode(",", $lunch);$d_array=explode(",", $dinner);
	for($i=0;$i<count($b_array);$i++)
	{
		if($meal_hash[$b_array[$i]]==""||$meal_hash[$b_array[$i]]==null)
		    $meal_hash[$b_array[$i]]=1;
		else
			$meal_hash[$b_array[$i]]++;
	}
	for($i=0;$i<count($l_array);$i++)
	{
		if($meal_hash[$l_array[$i]]==""||$meal_hash[$l_array[$i]]==null)
		    $meal_hash[$l_array[$i]]=1;
		else
			$meal_hash[$l_array[$i]]++;
	}
	for($i=0;$i<count($d_array);$i++)
	{
		if($meal_hash[$d_array[$i]]==""||$meal_hash[$d_array[$i]]==null)
		    $meal_hash[$d_array[$i]]=1;
        else
            $meal_hash[$d_array[$i]]++;
	}
	$index++;
}
uasort($meal_hash,"my_sort");
$top_eat_most=Get_The_Ate_Most(3,$meal_hash);
$eat_least=Get_The_Ate_Least($meal_hash);
$eat_least_array=Make_Suggestion_For_Ate_Least($field_array,$eat_least);

$sugguestion_eat_most=Give_Eat_Most_Suggestions($top_eat_most);

$sugguestion_text="";
$element_disease_high="";
if(strlen($top_eat_most)!=0)
{
	$sugguestion_text="Recently 2 weeks, you eat ";
	for($j=0;$j<1;$j++)
	{
		for ($i=0; $i <count($sugguestion_eat_most) ; $i++) {
			$sugguestion_text.=$sugguestion_eat_most[$i][0]." , ";
		} 
	}
	$sugguestion_text=substr($sugguestion_text,0,strlen($sugguestion_text)-2)." too much!<br/>";
	$sugguestion_text.=" Those food contains ";
	for($j=0;$j<1;$j++)
	{
		for ($i=0; $i <count($sugguestion_eat_most) ; $i++) {
			$sugguestion_text.=$sugguestion_eat_most[$i][1]." , ";
			$element_disease_high.=$sugguestion_eat_most[$i][1].",";
		} 
	}
	$sugguestion_text=substr($sugguestion_text,0,strlen($sugguestion_text)-2)." a lot!!<br/>";
	$sugguestion_text.="If you still ignore that, you will have a big possibility to get some diseases as following descriptions:";
	$element_disease_high=substr($element_disease_high, 0,strlen($element_disease_high)-1);
	echo $sugguestion_text;
	echo "<br/>";
	$diseases=Find_Diseases($element_disease_high);
	//print_r($diseases);
	//开始制表
	$table_html="<table border='1'><th>food</th><th>element</th>
	                <th>initial condition</th><th>Interim condition</th><th>serious condition</th>";
	
	$table_array=explode(",", $top_eat_most);
	$table_element_array=explode(",", $element_disease_high);
	//print_r($diseases);echo "<br/>";
	for ($i=0; $i <count($table_array) ; $i++) { 
		$table_html.="<tr>";
		$table_html.="<td>".$table_array[$i]."</td>";
		$table_html.="<td>".$table_element_array[$i]."</td>";
		$table_html.="<td>".implode(",", Handle_Disease_Text($diseases[$i][1],"1"))."</td>";
		$table_html.="<td>".implode(",", Handle_Disease_Text($diseases[$i][1],"2"))."</td>";
		$table_html.="<td>".implode(",", Handle_Disease_Text($diseases[$i][1],"3"))."</td>";
		$table_html.="</tr>";
	}
	$table_html.="</table>";
	echo $table_html."<br/><br/><br/><br/><br/>";
	echo "It seems like you ate ".$eat_least_array[0]." so less, but <br/>infact, it 
	      contains ".$eat_least_array[1]." a lot and it has functionality of ".Get_Benefits($eat_least_array[1]);
}
?>
<h1>body conditions</h1>
<?php
$element=Get_Max_Min_Element_In_Body();
$max_element=Get_Array_First_Value($element);
$min_element=Get_The_Ate_Least($element);

$max_text="The element <strong>".$max_element."</strong> in your body is too much, please make sure <br/>
           that don't eat too much the foods that as below that contains this element:<br/>";
$food_string=Get_Food_From_Element_Food($max_element);
$food_array=explode(",", $food_string);
$max_text.="<table border='1'><th>food name</th>";
for($i=0;$i<count($food_array);$i++)
{
	$max_text.="<tr>";
	$max_text.="<td>".$food_array[$i]."</td>";
	$max_text.="</tr>";
}
$max_text.="</table>";
echo $max_text;

$min_text="The element <strong>".$min_element."</strong> in your body is too less, please make sure <br/>
           that try to eat more foods that contains this element as below:<br/>";
$food_string=Get_Food_From_Element_Food($min_element);
$food_array=explode(",", $food_string);    
$min_text.="<table border='1'><th>food name</th>";
for($i=0;$i<count($food_array);$i++)
{
	$min_text.="<tr>";
	$min_text.="<td>".$food_array[$i]."</td>";
	$min_text.="</tr>";
}
$min_text.="</table>";
 
?>
<div style="margin-left: 700px;margin-top: -450px;">
	<?php echo $min_text; ?>
</div>
</body>