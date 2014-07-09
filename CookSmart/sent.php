<?php
	session_start();
	include_once "dbinfo.php";
	
	include_once "header.php";

	if (isset($_POST["message_sent"]) && isset($_POST["to_user_id"]) && isset($_POST["message_text"]))
	{
		$link = mysql_connect($dbhost, $dbuser, $dbpass);
		$db = mysql_select_db("cooksmart", $link);

		$from_user_id = $_SESSION["user_id"];
		$to_user_id = $_POST["to_user_id"];
		$message_text = mysql_real_escape_string(strip_tags($_POST["message_text"]));
		$sql = "INSERT INTO messages (from_user_id, to_user_id, message_text, message_time) VALUES ($from_user_id, $to_user_id, \"$message_text\", NOW());";
		$result = mysql_query($sql, $link) or die(mysql_error($link));
		
		echo "Message sent";
	}
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
		$sql = "SELECT m.message_id, m.to_user_id, m.message_text, m.message_time, u.first_name, u.last_name FROM messages as m INNER JOIN users as u ON m.to_user_id=u.user_id WHERE m.from_user_id=$user_id;";
		$result = mysql_query($sql, $link);
		?>
		<!--<table border="1"  style="background-color:#FFFFCC" width="100%" cellpadding="3" cellspacing="3">-->
		<table class="msg" id="sent" border="0" width="100%" cellpadding="3" cellspacing="3">

				<tr class="msg_toprow">
					<td class="msg_topcell">From</td>
					<td class="msg_topcell">Message</td>
					<td class="msg_topcell">Time</td>
				</tr>
		<?
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$message_id = $row["message_id"];
			//$from_user_id = $row["from_user_id"];
			$to_user_id = $row["to_user_id"];
			$to_first_name = stripslashes($row["first_name"]);
			$to_last_name = stripslashes($row["last_name"]);
			$message_text = stripslashes($row["message_text"]);
			$message_time = $row["message_time"];
			echo "<tr class=\"msg_row\">\n";
			echo "<td class=\"msg_cell\"><a href=\"user.php?id=$to_user_id\">$to_first_name $to_last_name</a></td>\n";
			echo "<td class=\"msg_cell\">$message_text</td>\n";
			echo "<td class=\"msg_cell\">$message_time</td></tr>";
			
			/*
			echo "<p>";
			echo "To <a href=\"user.php?id=$to_user_id\">$to_first_name $to_last_name</a> on $message_time: $message_text";
			echo "</p>";*/
		}
		echo "</table>";
	}
?>

<?php
	include_once "footer.php";
?>
