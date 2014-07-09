<?php
	session_start();
	include_once "dbinfo.php";
	include_once "header.php";
	$link = mysql_connect($dbhost, $dbuser, $dbpass);
	$db = mysql_select_db("cooksmart", $link);
?>
<?php
	if (!isset($_SESSION["is_logged_in"]))
	{
		echo "<p>You must be logged in to view this page.</p>";
	}
	else
	{
		$user_id = $_SESSION["user_id"];
		
		if (isset($_GET["id"]))
		{
			$get_user_id = mysql_real_escape_string($_GET["id"]);
		}
		else
		{
			$get_user_id = $_SESSION["user_id"];
		}
		
		
		$sql = "SELECT username, first_name, last_name, email, creation_datetime, modified_datetime FROM users WHERE user_id=$get_user_id;";
		$result = mysql_query($sql, $link);
		if (!($row = mysql_fetch_array($result, MYSQL_ASSOC)))
		{
			echo "<p>User not found</p>";
		}
		else
		{
			$username = stripslashes($row["username"]);
			$first_name = stripslashes($row["first_name"]);
			$last_name = stripslashes($row["last_name"]);
			$email = stripslashes($row["email"]);
			$creation_datetime = $row["creation_datetime"];
			$modified_datetime = $row["modified_datetime"];
			echo "<p>";
			echo "$username's profile";
			echo "</p>";
			
			if ($get_user_id != $user_id)
			{
				// add/remove friend
				$sql = "SELECT * FROM friends WHERE user_id1=$user_id AND user_id2=$get_user_id UNION SELECT * FROM friends WHERE user_id2=$user_id AND user_id1=$get_user_id";
				$result = mysql_query($sql, $link);
				if ($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
					// cases for each friendship status (pending, accepted, etc)
					$friendstatus = $row["status"];
					$user_id1 = $row["user_id1"]; // requester
					$user_id2 = $row["user_id2"]; // requestee
					if($friendstatus == 1  && $user_id2 == $user_id)
					{
					?>
						<form action="friendrequest.php" method="post">
						<input type="hidden" name="accept_id" value="<?=$get_user_id?>">
						<input type="submit" name="submit" value="Accept Friend Request">
						</form>
					<?
					}
					if($friendstatus == 1  && $user_id1 == $user_id)
					{
						echo "<p>Friend request pending.</p>";
					}
					else if($friendstatus == 2)
						echo "You're friends!<br/>";
				}
				else
				{
					$friendstatus = 0; // no relationship yet, add as friend?
					// Request Friend
					?>
					<form action="friendrequest.php" method="post">
						<input type="hidden" name="add_id" value="<?=$get_user_id?>">
						<input type="submit" name="submit" value="Request Friend">
					</form>
					<?php
				}
				 
				// send message
				?>
				<form action="sendmessage.php" method="post">
					<input type="hidden" name="to_user_id" value="<?=$get_user_id?>">
					<input type="submit" name="submit" value="Send message"> <br>
				</form>
				<?php
			}

			echo "<p>Uploaded recipes: <br>\n";
			// the complication here is from recipe privacy settings
			// conveniently, we already know from earlier on the page whether these users are friends
			if ($get_user_id == $user_id)
			{
				$sql = "SELECT recipe_id, recipe_name, modified_datetime FROM recipes WHERE user_id=$get_user_id";
			}
			else
			{
				if ($friendstatus == 2)
				{
					$sql = "SELECT recipe_id, recipe_name, modified_datetime FROM recipes WHERE user_id=$get_user_id AND (privacy=3 OR privacy=1)";
				}
				else
				{
					$sql = "SELECT recipe_id, recipe_name, modified_datetime FROM recipes WHERE user_id=$get_user_id AND privacy=1";
				}
			}
			$result = mysql_query($sql, $link);
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$recipe_id = $row["recipe_id"];
				$recipe_name = stripslashes($row["recipe_name"]);
				echo "<a href=\"recipe.php?recipe_id=$recipe_id\">$recipe_name</a> <br>\n";
			}
			echo "</p>";

			
			echo "<p>Recent activity: <br>\n";
			// recipes uploaded in the last 30 days
			$recentrecipessql = $sql . " AND (modified_datetime >= (NOW() - INTERVAL 1 MONTH))";
			$result = mysql_query($recentrecipessql, $link);
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$recipe_id = $row["recipe_id"];
				$recipe_name = $row["recipe_name"];
				$modified_datetime = $row["modified_datetime"];
				echo "Uploaded <a href=\"recipe.php?recipe_id=$recipe_id\">$recipe_name</a> on $modified_datetime <br>\n";
			}
		
		}
	}
	
?>

	
<?php
	include_once "footer.php";
?>
