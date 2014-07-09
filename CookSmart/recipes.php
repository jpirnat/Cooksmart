<?php
	session_start();
	include_once "dbinfo.php";
	include_once "header.php";
	
	
	
	$link = mysql_connect($dbhost, $dbuser, $dbpass) or die("could not connect to server");
	$db = mysql_select_db("cooksmart", $link) or die("could not connect to database");
	$user_id=0;
	$sql = '';
	$filter=false;
	$searchterms='';
	$time = 9999999;
	if(isset($_SESSION["user_id"]))
	{ 
		$user_id = $_SESSION["user_id"];
	}
	if (isset($_POST['filtered']))
	{
		if ($_POST['filtered'] == "true")
		{
			$filter = true;
		}
	}
	if (isset($_POST['search']))
	{
		$searchterms=mysql_real_escape_string($_POST['search']);
	}
	if (isset($_POST['time']))
	{
		$time=mysql_real_escape_string($_POST['time']);
		if (!is_numeric($time))
		{
			$time = 9999;
		}
	}
	echo '<script>function validate()
	{
		var s=document.forms["searchbox"]["search"].value;
		var t=document.forms["searchbox"]["time"].value;
		if (s==null)
		{
			return false;
		}
		if (s=="")
		{
			return false;
		}	
		if (t==null)
		{
			document.forms["searchbox"]["time"].value=9999;
		}
		if (t=="")
		{
			document.forms["searchbox"]["time"].value=9999;
		}
	}</script>';
	
	if ($filter==true)
	{
		$sql = 'select distinct r.*, u.* from recipes r, users u, pantry p, recipe_ingredients ri'
         . ' where r.recipe_name like \'%'.stripslashes($searchterms).'%\' and r.prep_time <= '.stripslashes($time).' and not exists (select ri.ingredient_id from pantry p, recipe_ingredients ri where p.ingredient_id = ri.ingredient_id and p.quantity < ri.quantity and p.user_id = \''.$user_id.'\' and ri.recipe_id=r.recipe_id) and p.user_id = \''.$user_id.'\' and not exists ('
         . '      select ri2.ingredient_id from recipe_ingredients ri2 where ri2.ingredient_id not in ('
         . '            SELECT ingredient_id FROM pantry where user_id = \''.$user_id.'\')'
         . '      and ri2.ingredient_id = ri.ingredient_id) AND r.recipe_id = ri.recipe_id '
         . ' and (u.user_id = r.user_id AND (r.privacy = 1 OR r.user_id = \''.$user_id.'\' OR (r.privacy = 3 AND' 
         . ' (r.user_id IN (SELECT f2.user_id1 from friends f2 WHERE f2.user_id2 = \''.$user_id.'\')'
         . ' OR r.user_id IN (SELECT f3.user_id2 from friends f3 WHERE f3.user_id1 = \''.$user_id.'\')'
         . ' ))))'
         . ' order by r.creation_datetime desc';
         echo '<form action="recipes.php" method="post">
				<input type="hidden" name="filtered" value="false">
				<input type="submit" name="submit" value="Show me all recipes">
		</form>';
		echo '<form action="recipes.php" name = "searchbox" method="post" onsubmit="return validate()">
				<input type="hidden" name="filtered" value="true">
				Search term:<input type="text" name ="search"><br>
				Prep Time: <input type="text" name ="time"><br>
				<input type="submit" name="submit" value="Search">
		</form>';
	}
	else 
	{
		$sql ='select distinct r.*, u.* from recipes r, users u'
        . ' where u.user_id = r.user_id AND r.recipe_name like \'%'.stripslashes($searchterms).'%\' and r.prep_time <= '.stripslashes($time).' and (r.privacy = 1 OR r.user_id = \''.$user_id.'\' OR (r.privacy = 3 AND'
        . ' (r.user_id IN (SELECT f2.user_id1 from friends f2 WHERE f2.user_id2 = \''.$user_id.'\')'
        . ' OR r.user_id IN (SELECT f3.user_id2 from friends f3 WHERE f3.user_id1 = \''.$user_id.'\')'
        . ' )))'
        . ' order by r.creation_datetime desc';
        echo '<form action="recipes.php" method="post">
				<input type="hidden" name="filtered" value="true">
				<input type="submit" name="submit" value="Only show me recipes I can make">
		</form>';
		echo '<form action="recipes.php" name = "searchbox" method="post" onsubmit="return validate()">
				<input type="hidden" name="filtered" value="false">
				Search term:<input type="text" name ="search"><br>
				Prep Time: <input type="text" name ="time"><br>
				<input type="submit" name="submit" value="Search">
		</form>';

	}
	
	$result = mysql_query($sql);
    


		?>		
		<!--
		<table border="1" bordercolor="#FFCC00" style="background-color:#FFFFCC" width="100%" cellpadding="3" cellspacing="3">
			<tr>
				<td>Recipe Name</td>
				<td>Preparation Time</td>
				<td>Vegetarian</td>
				<td>Uploaded By</td>
				<td>Rating</td>
			</tr>-->
			<?
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
				$userid = $row["user_id"];
				$preptime = $row["prep_time"];
				echo "<a href=\"recipe.php?recipe_id=$recipeid\"><div class=\"recipename\">";
				echo $row["is_veg"] ? '<img src="http://bestclipartblog.com/clipart-pics/leaf-clip-art-12.jpg" height = "30px">' : '';
				echo "<b>$recipename</b> takes $preptime minutes to prepare.</div><img src=\"$imgurl\"/></a> by <a href=\"user.php?id=$userid\">$username</a>";
				echo "</div>";

			}
			mysql_free_result($result);
		}
		?>
		<!--</table>-->
<?php
	include_once "footer.php";
?>