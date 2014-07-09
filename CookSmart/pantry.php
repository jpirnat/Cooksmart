<?php
	session_start();
	include_once "dbinfo.php";
	
	include_once "header.php";

?>

<?php

	if (isset($_POST["submit"]))
	{
		$errors = 0;
		if (in_array("default", $_POST["ingredients"]))
		{
			echo "Please choose actual ingredients.<br>\n";
			$errors++;
		}
		if (max(array_count_values($_POST["ingredients"])) > 1)
		{
			echo "Please make each ingredient unique.<br>\n";
			$errors++;
		}
		if (in_array(false, array_map("is_numeric", $_POST["qty"])))
		{
			echo "Please choose numbers for the ingredient quantities.<br>\n";
			$errors++;
		}
		if ((in_array("default", $_POST["appliances"])) && (count($_POST["appliances"]) > 1))
		{
			echo "Please choose actual appliances.<br>\n";
			$errors++;
		}
		
		
		if ($errors === 0)
		{
			$link = mysql_connect($dbhost, $dbuser, $dbpass);
			$db = mysql_select_db("cooksmart", $link);
			$user_id = $_SESSION["user_id"];

			$sql = "DELETE FROM pantry WHERE user_id=$user_id";
			$result = mysql_query($sql, $link) or die(mysql_error());
			
			$sql = "DELETE FROM pantry_appliances WHERE user_id=$user_id";
			$result = mysql_query($sql, $link) or die(mysql_error());
			
			$ingredients = $_POST["ingredients"];
			$quantities = $_POST["qty"];
			$units = $_POST["units"];
			
			for ($i=0; $i<count($ingredients); $i++)
			{
				$ingredient_id = $ingredients[$i];
				$qty = $quantities[$i];
				$unit_id = $units[$i];
				
				$sql = "SELECT unit_name FROM ingredient_units WHERE iu_id=$unit_id";	
				$result = mysql_query($sql, $link) or die(mysql_error());
				$row = mysql_fetch_array($result, MYSQL_ASSOC) or die(mysql_error());
				$unit_name = $row["unit_name"];
				
				$sql = "INSERT INTO pantry (user_id, ingredient_id, quantity, unit_name) VALUES ($user_id, $ingredient_id, $qty, \"$unit_name\")";
				$result = mysql_query($sql, $link) or die(mysql_error());
			}
			
			// add appliances - to do
			$appliances = $_POST["appliances"];
			if ($appliances[0] != "default")
			{
				for ($i=0; $i<count($appliances); $i++)
				{
					$appliance = $appliances[$i];
					$sql = "INSERT INTO pantry_appliances (user_id, appliance_id) VALUES ($user_id, $appliance);";
					$result = mysql_query($sql, $link) or die(mysql_error());
				}
			}
			
			echo "<p>Your pantry has been updated.</p>\n";
		} // if ($errors === 0)

	}
	else
	{

	}






	if (!isset($_SESSION["is_logged_in"]))
	{
		echo "<p>You must be logged in to view this page.</p>";
	}
	else
	{
		$user_id = $_SESSION["user_id"];
?>

<script type="text/javascript">
$(document).ready(function()
{
	if ($(".ingredient_row").length > 1)
	{
		$(".ingredient_row:first").remove();
	}
	
	if ($(".appliances_row").length > 1)
	{
		$(".appliances_row:first").remove();
	}
	
	$(".ingredients_select").on("change", function()
	{
		var id = $(this).val();
		var select = $(this);
		$.post("ingredient_units.php", {ingredient_id: id}, function(xml)
		{
			select.parents(".ingredient_row").children(".units_td").children(".ingredient_units").html(xml);
		});
	});
	
	$(".remove_ingredient").on("click", function()
	{
		if (($(".ingredient_row").length) > 1)
		{
			$(this).parent().parent().remove();
		}
	});
	
	$(".remove_appliance").on("click", function()
	{
		if (($(".appliances_row").length) > 1)
		{
			$(this).parent().parent().remove();
		}
	});

});

function add_ingredient()
{
	$(document).ready(function()
	{
		$(".ingredient_row:first").clone().appendTo("#ingredients_table_body");
		
		//$(".ingredient_row:last").css("");
		$(".ingredients_select:last").children().each(function()
		{
			$(this).removeAttr("selected");
		});		
		$(".ingredient_qty:last").val("");
		$(".ingredient_units:last").text("");
		
		$(".ingredients_select").on("change", function()
		{
			var id = $(this).val();
			var select = $(this);
			$.post("ingredient_units.php", {ingredient_id: id}, function(xml)
			{
				select.parents(".ingredient_row").children(".units_td").children(".ingredient_units").html(xml);
			});
		});
		
		$(".remove_ingredient").on("click", function()
		{
			if (($(".ingredient_row").length) > 1)
			{
				$(this).parent().parent().remove();
			}
		});
		
	});	
}

function add_appliance()
{
	$(document).ready(function()
	{
		$(".appliances_row:first").clone().appendTo("#appliances_table_body");
		$(".remove_appliance").on("click", function()
		{
			if (($(".appliances_row").length) > 1)
			{
				$(this).parent().parent().remove();
			}
		});
	});	
}

function validateForm()
{
	return true;
}

</script>


<form method="post" action="pantry.php" onsubmit="return validateForm()">

<table id="ingredients_table" border="0">
	<thead>
		<tr>
			<th>Ingredient</th>
			<th>Quantity</th>
			<th><!-- units --></th>
		</tr>
	</thead>
	<tbody id="ingredients_table_body">
		<?php
			$theselect = "<select name=\"ingredients[]\" class=\"ingredients_select\">\n";
			$theselect .= "\t<option value=\"default\">---</option>";

			$link = mysql_connect($dbhost, $dbuser, $dbpass);
			$db = mysql_select_db("cooksmart", $link);
			$sql = "SELECT * FROM ingredients;";
			$result = mysql_query($sql, $link);
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$ingredient_id = $row["ingredient_id"];
				$ingredient_name = $row["ingredient_name"];
				$theselect .= "\t<option value=\"$ingredient_id\">$ingredient_name</option>\n";
			}
			$theselect .= "</select>";

			$ingredient_row = "<tr class=\"ingredient_row\">\n"
								. "\t<td>\n"
									. "$theselect\n"
								. "\t</td>\n"
								. "\t<td>\n"
									. "\t\t<input type=\"text\" name=\"qty[]\" class=\"ingredient_qty\">\n"
								. "\t</td>\n"
								. "\t<td class=\"units_td\">\n"
									. "\t\t<div name=\"ingredient_units[]\" class=\"ingredient_units\"></div>\n"
								. "\t</td>\n"
								. "\t<td>\n"
									. "\t\t<input type=\"button\" class=\"remove_ingredient\" value=\"Remove\">\n"
								. "\t</td>\n"
							. "</tr>";
			echo $ingredient_row;
			
			$sql = "SELECT * FROM pantry WHERE user_id=$user_id;";
			$result = mysql_query($sql, $link);
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$thisrow = $ingredient_row;
				$ingredient_id = $row["ingredient_id"];
				$quantity = $row["quantity"];
				
				// select the right ingredient
				$thisrow = str_replace("value=\"$ingredient_id\"", "value=\"$ingredient_id\" selected=\"selected\"", $thisrow);
				
				// and give it the right quantity
				$thisrow = str_replace("name=\"qty[]\"", "name=\"qty[]\" value=\"$quantity\"", $thisrow);
				
				
				// and give it the right units
				// first need to know what the currently selected unit is
				$unitsql = "SELECT unit_name FROM pantry WHERE ingredient_id=$ingredient_id AND user_id=$user_id;";
				$unitresult = mysql_query($unitsql, $link);
				if ($unitrow = mysql_fetch_array($unitresult, MYSQL_ASSOC))
				{
					$current_unit = $unitrow["unit_name"];
				}
				else
				{
					$current_unit = "ERROR";
				}
				
				$unitsql = "SELECT * FROM ingredient_units WHERE ingredient_id=$ingredient_id;";
				$unitresult = mysql_query($unitsql, $link);
				$unitselect = "<select name=\"units[]\" class=\"units_select\">";
				while ($unitrow = mysql_fetch_array($unitresult, MYSQL_ASSOC))
				{
					$iu_id = $unitrow["iu_id"];
					$unit_name = $unitrow["unit_name"];
					$selected = ($unit_name === $current_unit) ? "selected" : "";
					$unitselect .= "<option value=\"$iu_id\" $selected>$unit_name</option>\n";
				}
				$unitselect .= "</select>";
				
				$thisrow = str_replace("class=\"ingredient_units\">", "class=\"ingredient_units\">$unitselect", $thisrow);
				
				echo $thisrow;

			}
		?>
	</tbody>
</table>
<input type="button" name="addingredientbutton" value="Add new ingredient" onclick="add_ingredient()"> <br><br>

<table id="appliances_table" border="0">
	<thead>
		<tr>	
			<th>Appliances</th>
			<th><!-- remove button --></th>
		</tr>
	</thead>
	<tbody id="appliances_table_body">
		<?php
			//calculate app select
			$appselect = "<select name=\"appliances[]\" class=\"appliances_select\">"
						. "\t<option value=\"default\">---</option>";
						
			$sql = "SELECT * FROM appliances;";
			$result = mysql_query($sql, $link);
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$appliance_id = $row["appliance_id"];
				$appliance_name = $row["appliance_name"];
				$appselect .= "\t<option value=\"$appliance_id\">$appliance_name</option>\n";
			}
			$appselect .= "</select>";
			
			$appliance_row = "<tr class=\"appliances_row\">\n"
							. "\t<td>\n"
								. "$appselect\n"
							. "\t</td>\n"
							. "\t<td>\n"
								. "\t\t<input type=\"button\" class=\"remove_appliance\" value=\"Remove\">\n"
							. "\t</td>\n"
							. "</tr>";
			echo $appliance_row;
			
			$sql = "SELECT * FROM pantry_appliances WHERE user_id=$user_id;";
			$result = mysql_query($sql, $link);
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$thisrow = $appliance_row;
				$appliance_id = $row["appliance_id"];
				
				// select the right appliance
				$thisrow = str_replace("value=\"$appliance_id\"", "value=\"$appliance_id\" selected=\"selected\"", $thisrow);
								
				echo $thisrow;
			}
			
		?>
		<!--
		<tr class="appliances_row">
			<td>
				<select name="appliances[]" class="appliances_select">
					<?php // appliances
						$link = mysql_connect($dbhost, $dbuser, $dbpass);
						$db = mysql_select_db("cooksmart", $link);
						$sql = "SELECT * FROM appliances;";
						$result = mysql_query($sql, $link);
						while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
						{
							$appliance_id = $row["appliance_id"];
							$appliance_name = $row["appliance_name"];
							
							echo "<option value=\"$appliance_id\">$appliance_name</option>\n";
						}
					?>
				</select>
			</td>
			<td>
				<input type="button" class="remove_appliance" value="Remove">
			</td>
		</tr> -->
	</tbody>
</table>
<input type="button" name="addappliancebutton" value="Add new appliance" onclick="add_appliance()"> <br><br>

<input type="submit" name="submit" value="Update pantry"> <!-- onclick="return validateForm()" -->

</form>
		
	<?php
	}
?>
		
		
<?php
	include_once "footer.php";
?>