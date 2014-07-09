<?php
	session_start();
	include_once "dbinfo.php";
	include_once "header.php";
	$link = mysql_connect($dbhost, $dbuser, $dbpass) or die("could not connect to server");
	$db = mysql_select_db("cooksmart", $link) or die("could not connect to database");
	if (isset($_SESSION['user_id']))
	{
		if (isset($_POST['rating']) && isset($_POST['recipe_id'])) 
		{
	    	$rating = $_POST['rating'];
	    	$recipe_id = $_POST['recipe_id'];
	    	if ($rating > 0 && $rating < 6)
	    	{
		    	$query = "insert into ratings (recipe_id, user_id, rating) VALUES (".$recipe_id.", ".$_SESSION['user_id'].", ".$rating.") ON DUPLICATE KEY UPDATE rating= ".$rating;
		    	if (mysql_query($query))
		        {
		            echo "
		            <script type=\"text/javascript\">
		                window.location=\"recipe.php?recipe_id=".$recipe_id."\";
		            </script>
		            ";
		        }
		        else 
		        {
		        	echo "Error, in mysql query: ".$query; 
		        	echo "<br>".mysql_error();
		        }
		        
	    	}
	    	else
	    	{
		    	echo "Nice try. Keep it up and you'll get banned.";
	    	}
	    }
    }
    echo "
	    <script type=\"text/javascript\">
	        window.history.back();
	    </script>
	    ";
	include_once "footer.php";
?>