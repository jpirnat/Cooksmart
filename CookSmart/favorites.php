<?php
	session_start();
	include_once "dbinfo.php";
	include_once "header.php";
	
	$user_id=0; // logged in user
	$t_userid=0; // user for recipe
	if(isset($_SESSION["user_id"]))
	{ 
		$user_id = $_SESSION["user_id"];
	}
	if(isset($_SESSION["is_logged_in"]))
	{
		$link = mysql_connect($dbhost, $dbuser, $dbpass);
		$db = mysql_select_db("cooksmart", $link);
		$username = "";
		$sql = "SELECT * FROM recipes as r INNER JOIN favorites as f ON r.recipe_id=f.recipe_id INNER JOIN users as u on r.user_id = u.user_id WHERE f.user_id=$user_id;";
		$result = mysql_query($sql, $link);
		if (isset($result))
		{
			while ($row = mysql_fetch_array($result)) 
			{
			/*
				echo "<tr>\n";
				echo "<td><a href=\"recipe.php?recipe_id=".$row["recipe_id"]."\">".stripslashes($row["recipe_name"])."</a></td>\n";
				echo "<td>".$row["prep_time"]." minutes</td>\n";
				echo "<td>";
				echo $row["is_veg"] ? 'Yes' : 'No';
				echo "</td>\n";
				echo "<td>".$row["username"]."</td>\n";
				echo "<td>Rating</td></tr>";*/
				echo "<div class=\"home_recipe\">";
				$username = $row["username"];
				$recipename = stripslashes($row["recipe_name"]);
				$imgurl = $row["image_url"];
				$recipeid = $row["recipe_id"];
				$t_userid = $row["user_id"];
				$preptime = $row["prep_time"];
				echo "<a href=\"recipe.php?recipe_id=$recipeid\"><div class=\"recipename\">";
				echo $row["is_veg"] ? '<img src="http://bestclipartblog.com/clipart-pics/leaf-clip-art-12.jpg" height = "30px">' : '';
				echo "<b>$recipename</b> takes $preptime minutes to prepare.</div><img src=\"$imgurl\"/></a> by <a href=\"user.php?id=$t_userid\">$username</a>";
				echo "</div>";

			}
			mysql_free_result($result);
		}
		else
		{
			echo "";
		}
		/*
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$recipe_id = $row["recipe_id"];
			$recipe_name = $row["recipe_name"];
			echo "<a href=\"recipe.php?recipe_id=$recipe_id\">$recipe_name</a> <br>\n";
		}*/
	}
	else
	{
		echo "<p>You must be logged in to view this page.</p>";
	}
?>
		
<?php
	include_once "footer.php";
?>
