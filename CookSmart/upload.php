<?php
	session_start();
	include_once "dbinfo.php";
	
	include_once "header.php";
	
	// jesse is currently (6:34pm tuesday) working on this file.

	
	
	if (isset($_POST["submit"]))
	{
		$errors = 0;
		if (empty($_POST["recipe_name"]))
		{
			echo "Please enter a recipe name.<br>\n";
			$errors++;
		}
		if (empty($_POST["prep_time"]))
		{
			echo "Please enter the recipe's preparation time.<br>\n";
			$errors++;
		}
		else if (!is_numeric($_POST["prep_time"]))
		{
			echo "Please enter the recipe's preparation time as a number.<br>\n";
			$errors++;
		}
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
		// validate appliances - to do
		
		if (empty($_POST["instructions_text"]))
		{
			echo "Please enter the recipe's instructions.<br>\n";
			$errors++;
		}
		if (empty($_POST["privacy"]))
		{
			echo "Please choose a privacy setting.<br>\n";
			$errors++;
		}
		
		if ($errors === 0)
		{
		
			$link = mysql_connect($dbhost, $dbuser, $dbpass);
			$db = mysql_select_db("cooksmart", $link);
			
			$user_id = $_SESSION["user_id"];
			$recipe_name = mysql_real_escape_string(strip_tags($_POST["recipe_name"]));
			$prep_time = $_POST["prep_time"];
			$image_url = mysql_real_escape_string(strip_tags($_POST["image_url"]));
			if(strpos($image_url , ".php") != false)
			{
				$image_url="";
			}
			else if(strpos($image_url , ".htm") != false)
			{
				$image_url="";
			}
			$is_veg = 1; // TO DO
			$instructions_text = mysql_real_escape_string(nl2br(strip_tags($_POST["instructions_text"])));
			$privacy = mysql_real_escape_string($_POST["privacy"]);
			$comments_allowed = $_POST["comments_allowed"];
			if ($comments_allowed === "yes")
				$comments_allowed = 1;
			else
				$comments_allowed = 0;
			
			$sql = "INSERT INTO recipes (user_id, recipe_name, prep_time, is_veg, instructions_text, image_url, privacy, comments_allowed, creation_datetime, modified_datetime) VALUES ($user_id, \"$recipe_name\", $prep_time, $is_veg, \"$instructions_text\", \"$image_url\", $privacy, $comments_allowed, NOW(), NOW());";
			$result = mysql_query($sql, $link);
			$recipe_id = mysql_insert_id($link);
			
			if ($recipe_id==0)
			{
				echo mysql_error($link);
			}
			else
			{
				
			}
			
			// ingredients
			$ingredients = $_POST["ingredients"];
			$qty = $_POST["qty"];
			$units = $_POST["units"];
			for ($i=0; $i<count($ingredients); $i++)
			{
				$ingredient_id = $ingredients[$i];
				$quant = $qty[$i];
				$unit_id = $units[$i];
				
				$unitsql = "SELECT * FROM ingredient_units WHERE iu_id=$unit_id;";
				$unitresult = mysql_query($unitsql, $link);
				if ($unitrow = mysql_fetch_array($unitresult, MYSQL_ASSOC))
				{
					$unit_name = $unitrow["unit_name"];
				}
				else
				{
					$unit_name = "units";
				}
				
				$sql = "INSERT INTO recipe_ingredients (recipe_id, ingredient_id, quantity, unit_name) VALUES ($recipe_id, $ingredient_id, $quant, \"$unit_name\");";
				$result = mysql_query($sql, $link);
			}
			
			// is_veg
			$vegsql = "SELECT MIN(is_veg) FROM recipe_ingredients as ri INNER JOIN ingredients as i ON ri.ingredient_id=i.ingredient_id WHERE ri.recipe_id=$recipe_id";
			$vegresult = mysql_query($vegsql, $link);
			$vegrow = mysql_fetch_array($vegresult, MYSQL_ASSOC);
			$is_veg = $vegrow["MIN(is_veg)"];
			$updatesql = "UPDATE recipes SET is_veg=$is_veg WHERE recipe_id=$recipe_id";
			mysql_query($updatesql, $link);
			
			// appliances
			if (isset($_POST["appliances_necessary"]))
			{
				$appliances = $_POST["appliances"];
				for ($i=0; $i<count($appliances); $i++)
				{
					$appliance = $appliances[$i];
					$sql = "INSERT INTO recipe_appliances (recipe_id, appliance_id) VALUES ($recipe_id, $appliance);";
					$result = mysql_query($sql, $link);
				}
			}
			
			echo "<p>Your recipe has been uploaded!</p>";
		
		} // if ($errors === 0)
		
	} // if (isset($_POST["submit"]))
?>

<script type="text/javascript">
$(document).ready(function()
{
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

function appliances_showhide()
{
	var e = document.getElementById("appliances_div")
	if (e.style.display=="")
	{
		e.style.display = "none";
	}
	else
	{
		e.style.display = "";
	}
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


		<form method="post" action="upload.php" onsubmit="return validateForm()">
			Recipe name: <input type="text" name="recipe_name" value="<?php echo empty($_POST["recipe_name"]) ? "" : $_POST["recipe_name"]; ?>" > <br><br>
			Preparation time: <input type="text" name="prep_time" value="<?php echo empty($_POST["prep_time"]) ? "" : $_POST["prep_time"]; ?>" > minutes<br><br>
			Image of food item (URL): <input type="text" name="image_url"> <br><br>
			
<table id="ingredients_table" border="0">
	<thead>
		<tr>
			<th>Ingredient</th>
			<th>Quantity</th>
			<th><!-- units --></th>
		</tr>
	</thead>
	<tbody id="ingredients_table_body">
		<tr class="ingredient_row">
			<td>
				<select name="ingredients[]" class="ingredients_select">
					<option value="default">---</option>
					<?php //ingredients
						$link = mysql_connect($dbhost, $dbuser, $dbpass);
						$db = mysql_select_db("cooksmart", $link);
						$sql = "SELECT * FROM ingredients;";
						$result = mysql_query($sql, $link);
						
						while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
						{
							$ingredient_id = $row["ingredient_id"];
							$ingredient_name = $row["ingredient_name"];
							echo "<option value=\"$ingredient_id\">$ingredient_name</option>\n";
						}
					?>
				</select>
			</td>
			<td>
				<input type="text" name="qty[]" class="ingredient_qty">
			</td>
			<td class="units_td">
				<div name="ingredient_units[]" class="ingredient_units"></div>
			</td>
			<td>
				<input type="button" class="remove_ingredient" value="Remove">
			</td>
		</tr>
	</tbody>
</table>
<input type="button" name="addingredientbutton" value="Add new ingredient" onclick="add_ingredient()"> <br><br>

<input type="checkbox" name="appliances_necessary" value="yes" onclick="appliances_showhide()"> Requires special appliances? <br>
<div id="appliances_div" style="display:none;">
	<table id="appliances_table" border="0">
		<thead>
			<tr>
				<th>Appliances</th>
				<th><!-- remove button --></th>
			</tr>
		</thead>
		<tbody id="appliances_table_body">
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
			</tr>
		</tbody>
	</table>
	<input type="button" name="addappliancebutton" value="Add new appliance" onclick="add_appliance()">
</div><br><br>

			
			Recipe instructions: <br>
			<textarea name="instructions_text" rows="10" cols="100"><?php echo empty($_POST["instructions_text"]) ? "" : stripslashes(strip_tags($_POST["instructions_text"])); ?></textarea> <br><br>
			
			Recipe privacy: <br>
			<input type="radio" name="privacy" value="1" checked="checked"> Public <br>
			<input type="radio" name="privacy" value="2"> Private <br>
			<input type="radio" name="privacy" value="3"> Friends only <br>
			
			Allow comments? <br>
			<input type="radio" name="comments_allowed" value="yes" checked="checked"> Yes <br>
			<input type="radio" name="comments_allowed" value="no"> No <br>
			
			<input type="submit" name="submit" value="Submit">
		</form>
		
<?php
	include_once "footer.php";
?>
