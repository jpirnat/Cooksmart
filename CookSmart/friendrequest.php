<?php

	session_start();
	
	include_once "dbinfo.php";
	include_once "header.php";
	
	$link = mysql_connect($dbhost, $dbuser, $dbpass);
	$db = mysql_select_db("cooksmart", $link);
	
	if (!isset($_SESSION["is_logged_in"]))
	{
		echo "<p>You must be logged in to view this page.</p>";
	}
	else
	{
		$user_id = $_SESSION["user_id"];
		
		if(isset($_POST["add_id"]))
		{
			$friending_id = $_POST["add_id"];
			$sql = "insert into friends (user_id1, user_id2, status) values ($user_id, $friending_id, 1) on duplicate key update status=1";
			$result = mysql_query($sql, $link);
			echo '
	            <script type="text/javascript">
	                window.location="user.php?id='.$friending_id.'";
	            </script>
	        ';
		}
		else if(isset($_POST["accept_id"]))
		{
			$accepting_id = $_POST["accept_id"];
			$sql = "update friends set status=2 where user_id1=$accepting_id and user_id2=$user_id";
			$result = mysql_query($sql, $link);
			echo '
	            <script type="text/javascript">
	                window.location="user.php?id='.$accepting_id.'";
	            </script>
	        ';
		}
		else
		{
			echo("No friend id provided.");
		}
		
	}
	
	include_once "footer.php";
	
?>