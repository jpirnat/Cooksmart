<?php
	session_start();
	include_once "dbinfo.php";
	include_once "header.php";
	$link = mysql_connect($dbhost, $dbuser, $dbpass) or die("could not connect to server");
	$db = mysql_select_db("cooksmart", $link) or die("could not connect to database");
	
    $recipe_id=0;
    $user_id=0;
	$recipe_name="";
	$prep_time="";
	$is_veg=0;
	$instructions_text="";
	$image_url="";
	$username="";
	$rating=0;
	
    if (isset($_GET['recipe_id'])) 
    {
    	$recipe_id=$_GET['recipe_id'];
    }
    else
    {
	    $recipe_id=1;
	}
	if(isset($_POST['comment']))
	{
		if (isset($_SESSION['user_id']))
		{
			$query = "INSERT INTO comments (recipe_id, user_id, comment_text, comment_time) VALUES ($recipe_id, ".$_SESSION['user_id'].", \"".mysql_real_escape_string(strip_tags($_POST['comment']))."\", NOW())";
			if(mysql_query($query))
	        {
	            echo "
	            <script type=\"text/javascript\">
	                window.location=\"recipe.php?recipe_id=".$recipe_id."\";
	            </script>
	            ";
	        }
	        else echo "Error, in mysql query"; 
        }
        else echo "You need to be logged in to comment.";
    }
    
    if(isset($_GET['favorite']))
	{
		if (isset($_SESSION['user_id']))
		{
			if ($_GET['favorite'] == 1)
			{
				$query = "INSERT INTO favorites (user_id, recipe_id) VALUES (".$_SESSION['user_id'].", ".$recipe_id.")";
			}
			else if ($_GET['favorite'] == 2)
			{
				$query = "DELETE FROM favorites where user_id = ".$_SESSION['user_id']." and recipe_id = ".$recipe_id;
			}
			if(mysql_query($query))
	        {
	            echo "
	            <script type=\"text/javascript\">
	                window.location=\"recipe.php?recipe_id=".$recipe_id."\";
	            </script>
	            ";
	        }
	        else echo "Error, in mysql query"; 
	        
	    }
	    else echo "You need to be logged in to favorite.";
    }

    /*if (isset($_SESSION['user_id']))
	{
		$result = mysql_query("SELECT * FROM recipes r join users u on r.user_id = u.user_id join ratings rt on r.recipe_id = rt.recipe_id and rt.user_id = ".$_SESSION['user_id']." WHERE r.recipe_id = $recipe_id");
	}
	else
	{*/
		$result = mysql_query("SELECT * FROM recipes r join users u on r.user_id = u.user_id WHERE r.recipe_id = $recipe_id");
	//}
	if (isset($result))
	{
		while ($row = mysql_fetch_array($result)) 
		{
			$user_id=stripslashes(mysql_result($result,0,"user_id"));
			$recipe_name=stripslashes(mysql_result($result,0,"recipe_name"));
			$prep_time=stripslashes(mysql_result($result,0,"prep_time"));
			$is_veg=stripslashes(mysql_result($result,0,"is_veg"));
			$instructions_text=stripslashes(mysql_result($result,0,"instructions_text"));
			$image_url=stripslashes(mysql_result($result,0,"image_url"));
			$username=stripslashes(mysql_result($result,0,"username"));
			$comments_allowed = stripslashes(mysql_result($result,0,"comments_allowed"));
			//if (isset($_SESSION['user_id']))
			//	$rating = stripslashes(mysql_result($result, 0,"rating"));
		}
		mysql_free_result($result);
	}
	if (isset($_SESSION['user_id']))
	{
		$result = mysql_query("SELECT rating FROM ratings WHERE recipe_id = $recipe_id and user_id = ".$_SESSION['user_id']);
		if (isset($result))
		{
			while ($row = mysql_fetch_array($result)) 
			{
				$rating = stripslashes(mysql_result($result, 0,"rating"));
			}
			mysql_free_result($result);
		}
	}
	

?>

		<p><b><?=$recipe_name?></b></p>
		<div id="uploadedBy">
		(Uploaded by <a href="user.php?id=<?=$user_id?>"><?=$username?></a>)
		</div>
		<br>
		<div id="recipe_image">
		<img src="<?=$image_url?>">
		<br>
		
		Ingredients: <br/>
		<?php
			$ingredsql = "SELECT i.ingredient_name, ri.quantity, ri.unit_name FROM recipe_ingredients as ri INNER JOIN ingredients as i ON ri.ingredient_id=i.ingredient_id WHERE ri.recipe_id=$recipe_id;";
			/*$ingredsql = "SELECT i.ingredient_name, ri.quantity, ri.unit_name"
							. "FROM recipe_ingredients as ri INNER JOIN ingredients as i"
							. "ON ri.ingredient_id=i.ingredient_id"
							. "WHERE ri.recipe_id=$recipe_id;";*/
			$ingredresult = mysql_query($ingredsql, $link);
			while ($ingredrow = mysql_fetch_array($ingredresult, MYSQL_ASSOC))
			{
				$ingredient_name = $ingredrow["ingredient_name"];
				$quantity = $ingredrow["quantity"];
				$unit_name = $ingredrow["unit_name"];
				echo "$ingredient_name - $quantity $unit_name <br>\n";
			}
		?>
		<br/>
		
		Appliances: <br/>
		<?php
			$applsql = "SELECT a.appliance_name FROM recipe_appliances as ra INNER JOIN appliances as a ON ra.appliance_id=a.appliance_id WHERE ra.recipe_id=$recipe_id;";
			$applresult = mysql_query($applsql, $link);
			while ($applrow = mysql_fetch_array($applresult, MYSQL_ASSOC))
			{
				$appliance_name = $applrow["appliance_name"];
				echo "$appliance_name<br>\n";
			}
		?>
		<br/>
		
		Instructions: 
		<br>
		<?=$instructions_text?>
		<br><br>
		
		Rating
		<form action="rate.php" method="post">
			<input type ="hidden" name = "recipe_id" value = "<?=$recipe_id?>">
			<input type="radio" name="rating" value="1" <? if ($rating == 1) echo "checked =\"true\""?>>1 
			<input type="radio" name="rating" value="2" <? if ($rating == 2) echo "checked =\"true\""?>>2 
			<input type="radio" name="rating" value="3" <? if ($rating == 3) echo "checked =\"true\""?>>3 
			<input type="radio" name="rating" value="4" <? if ($rating == 4) echo "checked =\"true\""?>>4 
			<input type="radio" name="rating" value="5" <? if ($rating == 5) echo "checked =\"true\""?>>5 
			<input type="submit">
		</form>
		<br>
		<?
		if (isset($_SESSION['user_id']))
		{
			$result = mysql_query("SELECT * FROM favorites WHERE recipe_id = ".$recipe_id." AND user_id = ".$_SESSION['user_id']);
			if (isset($result))
			{
				if (mysql_num_rows($result) == 0)
				{
					echo "<a href=\"recipe.php?recipe_id=$recipe_id&favorite=1\">Add to favorites</a>";
				}
				else
				{
					echo "<a href=\"recipe.php?recipe_id=$recipe_id&favorite=2\">Remove from favorites</a>";
				}
				mysql_free_result($result);
			}
		}
		
	// if comments_allowed
	if ($comments_allowed)
	{
		?>	
		<br>
		<form method="post" action="recipe.php?recipe_id=<?=$recipe_id?>">
			Comment: 
			<br>
			<!--<input type="text" name="comment"/> <br>-->
			<!--<input type="hidden" name = recipe_id value=<?=$recipe_id?>>-->
			<textarea name="comment"></textarea>
			<br>
			<input type="submit">
		</form>
		<br>
		
		Comments:
		<br>
		
		<table border="1"  style="background-color:#FFFFCC" width="100%" cellpadding="3" cellspacing="3">
				<tr>
					<td>User</td>
					<td>Comment</td>
					<td>Time</td>
				</tr>

		<?
		$result = mysql_query("SELECT * FROM comments c join users u on c.user_id = u.user_id WHERE c.recipe_id = $recipe_id");
		while ($row = mysql_fetch_array($result)) 
		{
			echo "<tr>\n";
			echo "<td>".$row["username"]."</td>\n";
			echo "<td>".stripslashes($row["comment_text"])."</td>\n";
			echo "<td>".$row["comment_time"];
			echo "</tr>";
		}
		echo "</table>";
		mysql_free_result($result);
		
		
	} // endif comments_allowed
		
				
		
	include_once "footer.php";
?>