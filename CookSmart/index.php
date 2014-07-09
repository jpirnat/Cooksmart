<?php
	session_start();
	include_once "dbinfo.php";
	
	include_once "header.php";


	$link = mysql_connect($dbhost, $dbuser, $dbpass);
	$db = mysql_select_db("cooksmart", $link);
	$user_id=0;
	if(isset($_SESSION["user_id"]))
	{ 
		$user_id = $_SESSION["user_id"];
	}
	
	$sql = 'select r.recipe_id, r.prep_time, u.user_id, r.privacy, u.username, r.recipe_name, r.image_url, r.is_veg from recipes r, users u'
        . ' where u.user_id = r.user_id AND (r.privacy = 1 OR r.user_id = \''.$user_id.'\' OR (r.privacy = 3 AND'
        . ' (r.user_id IN (SELECT f2.user_id1 from friends f2 WHERE f2.user_id2 = \''.$user_id.'\')'
        . ' OR r.user_id IN (SELECT f3.user_id2 from friends f3 WHERE f3.user_id1 = \''.$user_id.'\')'
        . ' )))'
        . ' order by r.creation_datetime desc limit 10';
    $result = mysql_query($sql, $link);
    if($result == true) { echo ('<h2>Recent Recipes</h2>'); } else { /* problem */ }
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		echo '<div class="home_recipe">';
		$username = $row["username"];
		$recipename = stripslashes($row["recipe_name"]);
		$imgurl = $row["image_url"];
		$recipeid = $row["recipe_id"];
		$userid = $row["user_id"];
		$preptime = $row["prep_time"];
		echo "<a href=\"recipe.php?recipe_id=$recipeid\"><div class=\"recipename\">";
		echo $row["is_veg"] ? '<img src="http://bestclipartblog.com/clipart-pics/leaf-clip-art-12.jpg" height = "30px">' : '';
		echo "<b>$recipename</b> takes $preptime minutes to prepare.</div><img src=\"$imgurl\"/></a> by <a href=\"user.php?id=$userid\">$username</a>";
		echo "</div>";
	}  
        

?>
		
		
<?php
	include_once "footer.php";
?>