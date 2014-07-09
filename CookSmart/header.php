<?php
	// session_start(); //currently in every other file
	
	include_once "dbinfo.php";
	
?>

<html>
	<head>
		<title></title>
		<LINK rel="stylesheet" href="main.css" type="text/css" />
		<script type="text/javascript" src="include/jquery-1.8.3.min.js"></script>
	</head>
	<body>
		<div id="header">
			<a href="index.php"><h1>CookSmart</h1></a>
			<div id="right_header">
			<?php
				if (isset($_SESSION["is_logged_in"]))
				{
					echo "Welcome to CookSmart, <b>" . stripslashes($_SESSION["username"]) . "</b>.<br><br>";
					echo "<div align=\"right\"><a href=\"user.php\"><u>Profile</u></a></div>";
					echo "<div align=\"right\"><a href=\"logout.php\"><u>Logout</u></a></div>";
				}
				else
				{
					echo "<form method=\"post\" action=\"login.php\">
			Username: <input type=\"text\" name=\"username\"> <br>
			Password: <input type=\"password\" name=\"password\"> <br>
			<input type=\"submit\" name=\"login\" value=\"Login\">
		</form>";
				}
			?>
			</div>
			<div class="navbar">
				<a href="recipes.php">Recipes</a>
				<?
				if (!isset($_SESSION['user_id']))
				{
					echo "<a href=\"register.php\">Register</a>";
				}
				else
				{
					$link = mysql_connect($dbhost, $dbuser, $dbpass);
					$db = mysql_select_db("cooksmart", $link);
					$sql = "SELECT count(*) as num_friend_reqs FROM friends as f WHERE f.user_id2=".$_SESSION['user_id']." AND f.status=1";
					$result = mysql_query($sql, $link);
					$row = mysql_fetch_array($result);
					$num_friend_reqs = $row[0];
					$friends_num = $num_friend_reqs > 0 ? " (".$num_friend_reqs.")" : '';
					echo "<a href=\"pantry.php\">Pantry</a>";
					echo "<a href=\"upload.php\">Upload</a>";
					echo "<a href=\"favorites.php\">Favorites</a>";
					echo "<a href=\"friends.php\">Friends".$friends_num."</a>";
					echo "<a href=\"inbox.php\">Inbox</a>";
					echo "<a href=\"sent.php\">Sent</a>";
				}
				?>
								
			</div>
			<!-- dynamically generate links for logged in VS. guest -->
		</div>