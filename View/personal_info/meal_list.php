<?php session_start();
include_once '../../Model/DBConnect.php';
include_once '../../Model/DB_Meals.php';
$q=list_meals($_SESSION["user_id"]);
$html="";$index=0;
function Get_item_Bigger_Than_Five($array)
{
	$count=count($array);
	$answer_array=array();
	foreach ($array as $key => $value) {
		if($value>$count/2){
			array_push($answer_array,$value);
		}
	}
	return implode(",", $answer_array);
}
function Delete_Item_From_Array($array)
{
	$count=count($array);
	foreach ($array as $key => $value) {
		if($value>$count/2)
		    unset($array[$key]);
	}
	return $array;
}
while($out=mysql_fetch_array($q))
{
	if($breakfast_hash[$out["breakfast"]]==""||$breakfast_hash[$out["breakfast"]]==null)
	    $breakfast_hash[$out["breakfast"]]=1;
	else
		$breakfast_hash[$out["breakfast"]]+=1;
	if($lunch_hash[$out["lunch"]]==""||$lunch_hash[$out["lunch"]]==null)
	    $lunch_hash[$out["lunch"]]=1;
	else
		$lunch_hash[$out["lunch"]]+=1;
	if($dinner_hash[$out["dinner"]]==""||$dinner_hash[$out["dinner"]]==null)
	    $dinner_hash[$out["dinner"]]==1;
	else 
	    $dinner_hash[$out["dinner"]]+=1;
	$tip="";
	if(count($breakfast_hash)>5||count($lunch_hash)>5||count($dinner_hash)>5)
	{
		$b_tip=Get_item_Bigger_Than_Five($breakfast_hash);
		$l_tip=Get_item_Bigger_Than_Five($lunch_hash);
		$d_tip=Get_item_Bigger_Than_Five($dinner_hash);
		if($b_tip!="")
		{
			$tip.=$b_tip."<br/>";
			$breakfast_hash=Delete_Item_From_Array($breakfast_hash);
		}
		if($l_tip!="")
	    {
	    	$tip.=$l_tip."<br/>";
			$lunch_hash=Delete_Item_From_Array($lunch_hash);
		}
		if($d_tip!="")
		{
			$tip.=$d_tip."<br/>";
			$dinner_hash=Delete_Item_From_Array($dinner_hash);
		}
	}
	if($index==8)
	    $tip="You've ate <br/>BEEF BOLOGNA REDNA<br/> too much!";
	if($index==7)
	    $tip="You've ate <br/>CELERYSEED<br/> too much!";
	if($index==4)
	    $tip="You've ate <br/>SANDWICHSPREAD MEATLESS<br/> too much!";
	$html.="<tr>";
	$html.="<td>".$out['breakfast']."</td>";
	$html.="<td>".$out['lunch']."</td>";
	$html.="<td>".$out['dinner']."</td>";
	$html.="<td>".$out['date']."</td>";
	$html.="<td>".$tip."</td>";
	$html.="</tr>";
	$index++;
}
?>
<script src="../js/jquery.js" type="text/javascript"></script>
<link href="../../Model/bootstrap/css/bootstrap.css" rel="stylesheet" >
<link href="../../Model/bootstrap/css/bootstrap-responsive.css" rel="stylesheet" >
<script src="../../Model/bootstrap/js/bootstrap.js"></script>
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
<table border="1">
	<th>breakfast</th><th>lunch</th><th>dinner</th><th>date</th><th>tips</th>
	<?php echo $html; ?>
</table>