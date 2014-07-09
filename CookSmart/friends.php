<?php
	session_start();
	include_once "dbinfo.php";
	
	include_once "header.php";

?>

<?php
	if (!isset($_SESSION["is_logged_in"]))
	{
		echo "<p>You must be logged in to view this page.</p>";
	}
	else
	{
		$your_id = $_SESSION["user_id"];
		
		$link = mysql_connect($dbhost, $dbuser, $dbpass);
		$db = mysql_select_db("cooksmart", $link);

		
		echo "<div class=\"friends\">\n";
			// current friends
			echo "Current Friends: \n";
			$sql = "SELECT u.username, u.user_id FROM friends as f INNER JOIN users as u WHERE f.user_id1=$your_id AND f.user_id2=u.user_id AND f.status=2
					UNION
					SELECT u.username, u.user_id FROM friends as f INNER JOIN users as u WHERE f.user_id1=u.user_id AND f.user_id2=$your_id AND f.status=2";
			$result = mysql_query($sql, $link);
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$fuser_id = $row["user_id"];
				$fusername = $row["username"];
				echo "<p><a href=\"user.php?id=$fuser_id\">$fusername</a></p>\n";
			}
			if(mysql_num_rows($result) == 0) { echo "None!"; }
			echo "</div>";
			

			// friend requests
			echo "<div class=\"friends\">\n";
			$sql = "SELECT f.user_id1, u.username FROM friends as f INNER JOIN users as u ON f.user_id1=u.user_id WHERE f.user_id2=$your_id AND f.status=1;";
			$result = mysql_query($sql, $link);
			$i = 0;
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				if (!$i++) echo "Friend Requests: \n";
				$fuser_id = $row["user_id1"];
				$fusername = $row["username"];
				echo "<p><a href=\"user.php?id=$fuser_id\">$fusername</a></p>\n";
			}
			echo "</div>";
			
			
			// pending friend requests
			echo "<div class=\"friends\">\n";
			$sql = "SELECT f.user_id2, u.username FROM friends as f INNER JOIN users as u ON f.user_id1=$your_id WHERE f.user_id2=u.user_id AND f.status=1;";
			$result = mysql_query($sql, $link);
			$i = 0;
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				if (!$i++) 	echo "Pending Requests: \n";
				$fuser_id = $row["user_id2"];
				$fusername = $row["username"];
				echo "<p><a href=\"user.php?id=$fuser_id\">$fusername</a></p>\n";
			}			
			echo "</div>";
		
	}

?>
	
<?php
	include_once "footer.php";
?>