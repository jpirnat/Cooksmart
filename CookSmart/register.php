<?php
	session_start();
	include_once "dbinfo.php";

	include_once "header.php";
?>

<?php
	if (isset($_POST["register"]))
	{
		$errors = 0;
		if (empty($_POST["first_name"]))
		{
			echo "Please enter a first name.<br>\n";
			$errors++;
		}
		if (empty($_POST["last_name"]))
		{
			echo "Please enter a last name.<br>\n";
			$errors++;
		}
		if (empty($_POST["username"]))
		{
			echo "Please enter a username.<br>\n";
			$errors++;
		}
		if (empty($_POST["email"]))
		{
			echo "Please enter an email.<br>\n";
			$errors++;
		}
		if (empty($_POST["password1"]))
		{
			echo "Please enter a password.<br>\n";
			$errors++;
		}
		if (empty($_POST["password2"]))
		{
			echo "Please enter your password twice.<br>\n";
			$errors++;
		}
		if ($_POST["password1"] !== $_POST["password2"])
		{
			echo "Please enter the same password twice.<br>\n";
			$errors++;
		}
		
		if ($errors === 0)
		{
			$username = $_POST["username"];
			$first_name = $_POST["first_name"];
			$last_name = $_POST["last_name"];
			$email = $_POST["email"];
			$password1 = $_POST["password1"];
			$password2 = $_POST["password2"];
		
			$link = mysql_connect($dbhost, $dbuser, $dbpass);
			$db = mysql_select_db("cooksmart", $link);
			
			$username = mysql_real_escape_string(strip_tags($_POST["username"]));
			$first_name = mysql_real_escape_string(strip_tags($_POST["first_name"]));
			$last_name = mysql_real_escape_string(strip_tags($_POST["last_name"]));
			$email = mysql_real_escape_string(strip_tags($_POST["email"]));
			$password1 = md5($_POST["password1"]);
			
			$sql = "SELECT * FROM users WHERE username=\"$username\"";
			$result = mysql_query($sql, $link);
			if (mysql_num_rows($result) > 0)
			{
				echo "A user with that username already exists. Please pick another.<br>\n";
			}
			else
			{
				$sql = "INSERT INTO users (username, first_name, last_name, email, password, creation_datetime, modified_datetime) VALUES (\"$username\", \"$first_name\", \"$last_name\", \"$email\", \"$password1\", NOW(), NOW());";
				$result = mysql_query($sql, $link);
				echo "Your account has been made. Please log in.<br/>\n";
			}
		}
		
	}
	
?>

<?php
	if (isset($_SESSION["is_logged_in"]))
	{
		echo "You are already registered. Click <a href=\"index.php\">here</a> to return to the main page.";
	}
	else
	{
		?>
		<form method="post" action="register.php">
			First name: <input type="text" name="first_name" value="<?php echo empty($_POST["first_name"]) ? "" : $_POST["first_name"]; ?>" > <br>
			Last name: <input type="text" name="last_name" value="<?php echo empty($_POST["last_name"]) ? "" : $_POST["last_name"]; ?>" > <br>
			Username: <input type="text" name="username" value="<?php echo empty($_POST["username"]) ? "" : $_POST["username"]; ?>" > <br>
			Email: <input type="text" name="email" pattern="[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?"
						value="<?php echo empty($_POST["email"]) ? "" : $_POST["email"]; ?>" > <br>
			Password: <input type="password" name="password1"> <br>
			Confirm password: <input type="password" name="password2"> <br>
			<input type="submit" name="register" value="Register">
		</form>
		<?php
	}
?>
		
<?php
	include_once "footer.php";
?>