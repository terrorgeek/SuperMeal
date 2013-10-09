<?php session_start();
include_once '../../Model/DBConnect.php';
include_once '../../Model/DB_Daily_Nutrition.php';
include_once '../../ScriptLib/functions.php';
$daily_nutrition_query=Get_Daily_Nutrition_Data();
$all_element_names=Get_All_Element_Fields();
$option_html="";
for($i=0;$i<count($all_element_names);$i++){
	$option_html.="<option>".$all_element_names[$i]."</option>";
}
$table_html="";
while($out=mysql_fetch_array($daily_nutrition_query))
{
	$table_html.="<tr>";
	$table_html.="<td>".$out['date']."</td><td>".$out['sugar']."</td>";
	$table_html.="<td>".$out['protein']."</td><td>".$out['fat']."</td>";
	
	$table_html.="<td>".$out['vitamin_A']."</td><td>".$out['vitamin_E']."</td>";
	$table_html.="<td>".$out['vitamin_C']."</td><td>".$out['folate']."</td>";
	$table_html.="<td>".$out['vitamin_B6']."</td><td>".$out['vitamin_B12']."</td>";
	$table_html.="<td>".$out['calcium']."</td><td>".$out['iron']."</td>";
	$table_html.="<td>".$out['potassium']."</td><td>".$out['zinc']."</td>";
	$table_html.="<td>".$out['magnesium']."</td><td>".$out['copper']."</td>";
	
	$table_html.="<td>".$out['phosphorus']."</td><td>".$out['sodium']."</td>";
	$table_html.="<td>".$out['manganese']."</td><td>".$out['selenium']."</td>";
	$table_html.="<td>".$out['cholesterol']."</td><td>".$out['fiber']."</td>";
	$table_html.="<td>".$out['energy']."</td><td>".$out['meal']."</td></tr>";
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

<script src="../js/jquery.js"></script>
<script src="../js/daily_nutrition_js.js"></script>
<table border="1">
	<th>date</th><th>sugar</th><th>protein</th><th>fat</th><th>Vitamin A</th><th>Vitamin E</th><th>Vitamin C</th>
	<th>folate</th><th>Vitamin B6</th><th>Vitamin B12</th><th>calcium</th><th>iron</th>
	<th>potassium</th><th>zinc</th><th>magnesium</th><th>copper</th><th>phosphorus</th><th>sodium</th>
	<th>manganese</th><th>selenium</th><th>cholesterol</th><th>fiber</th><th>energy</th><th>meal</th>
	<?php echo $table_html;?>
	<input type="button" value="see chart" onclick="see_chart();" class="btn btn-primary" />&nbsp;&nbsp;&nbsp;&nbsp;
	<select name="element_for_chart" id="element_for_chart">
		<?php echo $option_html; ?>
	</select><br/><br/>
</table>
