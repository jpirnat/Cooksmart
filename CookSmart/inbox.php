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
		$user_id = $_SESSION["user_id"];
		$link = mysql_connect($dbhost, $dbuser, $dbpass);
		$db = mysql_select_db("cooksmart", $link);
		$sql = "SELECT * FROM messages WHERE to_user_id=$user_id;";
		$sql = "SELECT m.message_id, m.from_user_id, m.message_text, m.message_time, u.first_name, u.last_name FROM messages as m INNER JOIN users as u ON m.from_user_id=u.user_id WHERE m.to_user_id=$user_id;";

		$result = mysql_query($sql, $link);
		?>
		<table class="msg" id="inbox" border="0" width="100%" cellpadding="3" cellspacing="3">
				<tr>
					<td class="msg_topcell">From</td>
					<td class="msg_topcell">Message</td>
					<td class="msg_topcell">Time</td>
				</tr>

		<?

		while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
		
			$message_id = $row["message_id"];
			$from_user_id = $row["from_user_id"];
			$from_first_name = $row["first_name"];
			$from_last_name = $row["last_name"];
			//$to_user_id = $row["to_user_id"];
			$message_text = stripslashes($row["message_text"]);
			$message_time = $row["message_time"];
			
			echo "<tr class=\"msg_row\">\n";
			echo "<td class=\"msg_cell\"><a href=\"user.php?id=$from_user_id\">$from_first_name $from_last_name</a></td>\n";
			echo "<td class=\"msg_cell\">$message_text</td>\n";
			echo "<td class=\"msg_cell\">$message_time</td></tr>";

			
			
			/*echo "<p>";
			echo "From <a href=\"user.php?id=$from_user_id\">$from_first_name $from_last_name</a> on $message_time: $message_text";
			echo "</p>";*/
		}
		echo "</table>";
	}
?>

<?php
	include_once "footer.php";
?>