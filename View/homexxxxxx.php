<?php session_start();
require_once '../Model/DBConnect.php';
$sql="select name from food ORDER BY name";
$q=mysql_query($sql);
$result="";
$index=0;
while($out=mysql_fetch_array($q))
{
	$result.=$out[name].",";
	$index++;
}
$result=substr($result, 0,strlen($result)-1); 
?>
<html>
<head>
		<script type='text/javascript' src='js/jquery.js'></script>
<link href="../Model/bootstrap/css/bootstrap.css" rel="stylesheet" >
<link href="../Model/bootstrap/css/bootstrap-responsive.css" rel="stylesheet" >
<script src="../Model/bootstrap/js/bootstrap.js"></script>

<link rel="stylesheet" type="text/css" href="http://twitter.github.com/bootstrap/assets/css/bootstrap.css">
 <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script>
$(document).ready(function(){
    $("#add_breakfast").click(function(){
    	$("#breakfast_div").append("breakfast:<input type='text' name='breakfast' id='meal_breakfast' style='height: 30px;' />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
    });
    $("#add_lunch").click(function(){
    	$("#lunch_div").append("lunch:<input type='text' name='lunch' id='meal_lunch' style='height: 30px;' />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
    });
    $("#add_dinner").click(function(){
    	$("#dinner_div").append("dinner:<input type='text' name='dinner' id='meal_dinner' style='height: 30px;' />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
    });
});
function add_breakfast()
{
	var add_b=document.getElementById("breakfast_div");
	var previous_value=add_b.innerHTML;
	var new_value=document.getElementById("meal_breakfast").value;
	
	var final_value="";
	if(previous_value=="")
	    final_value+=new_value;
	else
	    final_value=previous_value+","+new_value;
	    
	document.getElementById("breakfast_div").innerHTML=final_value.substring(0,final_value.length);
	document.getElementById("meal_breakfast").value="";
}
function add_lunch()
{
	var add_b=document.getElementById("lunch_div");
	var previous_value=add_b.innerHTML;
	var new_value=document.getElementById("meal_lunch").value;
	
	var final_value="";
	if(previous_value=="")
	    final_value+=new_value;
	else
	    final_value=previous_value+","+new_value;
	
	document.getElementById("lunch_div").innerHTML=final_value.substring(0,final_value.length);
	document.getElementById("meal_lunch").value="";
}
function add_dinner()
{
	var add_b=document.getElementById("dinner_div");
	var previous_value=add_b.innerHTML;
	var new_value=document.getElementById("meal_dinner").value;
	
	var final_value="";
	if(previous_value=="")
	    final_value+=new_value;
	else
	    final_value=previous_value+","+new_value;
	
	document.getElementById("dinner_div").innerHTML=final_value.substring(0,final_value.length);
	document.getElementById("meal_dinner").value="";
}
function submit_form()
{
	var breakfast_hidden_obj=document.getElementById("breakfast_hidden");
	var lunch_hidder_obj=document.getElementById("lunch_hidden");
	var dinner_hidden_obj=document.getElementById("dinner_hidden");
	
	var breakfast_div=document.getElementById("breakfast_div").innerHTML;
	var lunch_div=document.getElementById("lunch_div").innerHTML;
	var dinner_div=document.getElementById("dinner_div").innerHTML;
	
	breakfast_hidden_obj.value=breakfast_div;
	lunch_hidder_obj.value=lunch_div;
	dinner_hidden_obj.value=dinner_div;
	alert(breakfast_hidden_obj.value+","+lunch_hidder_obj.value+","+dinner_hidden_obj.value);
	if(breakfast_div!=""&&lunch_div!=""&&dinner_div!="")
	    document.getElementById("form1").submit();
	else
	    alert("meal can't be blank!");
}
</script>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>new_file</title>
		<meta name="author" content="sy" />
		<!-- Date: 2013-09-04 -->
	</head>
	<body>
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
    <a class="brand" href="">Home</a>
    <a class="brand" href="personal_info/daily_nutrition.php">Daily Nutrition</a>
    <a class="brand" href="personal_info/body_status.php">Body Status</a>
    <a class="brand" href="personal_info/meal_list.php">Meal List</a>
     
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
                     <a href="#">Logout</a>
                  </li>
               </ul>
          </li>
        </ul>
    </div>
     
    </div>
    </div>
</div>
<h1>Today you eat</h1>
<fieldset>
	<form action="../Controller/eat_action.php" method="post" id="form1" class="navbar-form">
	   breakfast:<input type='text' name='breakfast' id='meal_breakfast' style='height: 30px;' />&nbsp;&nbsp;&nbsp;
	   <input type="button" value="add breakfast" class="btn btn-primary" onclick="add_breakfast();"/><br/>
	   lunch:<input type='text' name='lunch' id='meal_lunch' style='height: 30px;' />&nbsp;&nbsp;&nbsp;
	   <input type="button" value="add lunch" class="btn btn-primary" onclick="add_lunch();" /><br/>
	   dinner:<input type='text' name='dinner' id='meal_dinner' style='height: 30px;' />&nbsp;&nbsp;&nbsp;
	   <input type="button" value="add dinner" class="btn btn-primary" onclick="add_dinner();" /><br/>
	   <input type="button" value="submit" class="btn btn-primary" onclick="submit_form();" />
	   
	   <input type="hidden" name="breakfast_hidden" id="breakfast_hidden" />
	   <input type="hidden" name="lunch_hidden" id="lunch_hidden" />
	   <input type="hidden" name="dinner_hidden" id="dinner_hidden" />
	</form>
</fieldset>
Breakfast:<div id="breakfast_div"></div>
Lunch:<div id="lunch_div"></div>
Dinner:<div id="dinner_div"></div>
	</body>
	<script>
$(function() {
    var food='<?php echo $result; ?>';
    var availableTags = food.split(",");;
    $( "#meal_breakfast" ).autocomplete({
       source: availableTags
    });
    $( "#meal_lunch" ).autocomplete({
       source: availableTags
    });
    $( "#meal_dinner" ).autocomplete({
       source: availableTags
    });
});
</script>
</html>

