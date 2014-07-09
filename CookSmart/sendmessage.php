<?php
	session_start();
	include_once "dbinfo.php";
	include_once "header.php";

?>

<?php
	if (isset($_POST["to_user_id"]))
	{
		$link = mysql_connect($dbhost, $dbuser, $dbpass);
		$db = mysql_select_db("cooksmart", $link);
		$to_user_id = mysql_real_escape_string($_POST["to_user_id"]);
		$sql = "SELECT first_name, last_name FROM users WHERE user_id=$to_user_id;";
		$result = mysql_query($sql, $link) or die(mysql_error($link));
		if ($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$to_first_name = $row["first_name"];
			$to_last_name = $row["last_name"]; ?>
			
			<form action="sent.php" method="post">
				<input type="hidden" name="to_user_id" value="<?php echo $to_user_id ?>"> <br>
				<?php echo "Sending message to $to_first_name $to_last_name:"; ?> <br>
				<textarea name="message_text" rows="10" cols="100"></textarea> <br>
				<input type="submit" name="message_sent" value="Submit">
			</form>
			
<?php	}
		else
		{
			echo "<p>How did you even get to this page?</p>";
		}
	}
?>



<?php
	include_once "footer.php";
?>