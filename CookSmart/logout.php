<?php
	session_start();
	include_once "dbinfo.php";
	
	$link = mysql_connect($dbhost, $dbuser, $dbpass);
	$db = mysql_select_db("cooksmart", $link);
	
	$_SESSION = array();
	session_destroy();
	header("Location: index.php");
?>

<html>
	<head>
	</head>
	<body>
		
	</body>
</html>
