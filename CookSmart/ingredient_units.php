<?php // for upload.php's ajax
	include_once "dbinfo.php";
	
	$ingredient_id = $_POST["ingredient_id"];
	if ($ingredient_id === "default")
	{
		echo "";
	}
	else
	{
		$link = mysql_connect($dbhost, $dbuser, $dbpass);
		$db = mysql_select_db("cooksmart", $link);
		$sql = "SELECT * FROM ingredient_units WHERE ingredient_id=$ingredient_id;";
		$result = mysql_query($sql, $link);
		echo "<select name=\"units[]\" class=\"units_select\">";
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$iu_id = $row["iu_id"];
			$unit_name = $row["unit_name"];
			echo "<option value=\"$iu_id\">$unit_name</option>\n";
		}
		echo "</select>";

	}
?>
