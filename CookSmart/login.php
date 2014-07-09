<?php
	session_start();
	include_once "dbinfo.php";
	
	$link = mysql_connect($dbhost, $dbuser, $dbpass);
	$db = mysql_select_db("cooksmart", $link);
	$url = "index.php";
	if (isset($_SERVER["HTTP_REFERER"]))
	{
		$url = $_SERVER["HTTP_REFERER"];
	}
	if (isset($_POST["login"]))
	{
		$username = stripslashes($_POST["username"]);
		$password = md5($_POST["password"]);
		$sql = "SELECT * FROM users WHERE username=\"$username\" AND password=\"$password\"";
		$result = mysql_query($sql, $link);
		if ($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$_SESSION["is_logged_in"] = true;
			
			$_SESSION["user_id"] = $row["user_id"];
			$_SESSION["username"] = stripslashes($row["username"]);
			$_SESSION["first_name"] = stripslashes($row["first_name"]);
			$_SESSION["last_name"] = stripslashes($row["last_name"]);
			$_SESSION["email"] = stripslashes($row["email"]);
		}
	}
	
	include_once "header.php";
?>

<?php
	if (isset($_SESSION["is_logged_in"]))
	{
		//echo "<p>You are logged in. Click <a href=\"index.php\">here</a> to return to the main page.";
		echo "
	            <script type=\"text/javascript\">
	                window.location=\"$url\";
	            </script>
	            ";
	}
	else
	{
?>
		<!--<form method="post" action="login.php">
			Username: <input type="text" name="username"> <br>
			Password: <input type="password" name="password"> <br>
			<input type="submit" name="login" value="Login">
		</form>-->
<?php
	}
?>

<?php
	include_once "footer.php";
?>