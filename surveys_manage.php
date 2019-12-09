<?php

// Things to notice:
// This is the page where each user can MANAGE their surveys
// As a suggestion, you may wish to consider using this page to LIST the surveys they have created
// Listing the available surveys for each user will probably involve accessing the contents of another TABLE in your database
// Give users options such as to CREATE a new survey, EDIT a survey, ANALYSE a survey, or DELETE a survey, might be a nice idea
// You will probably want to make some additional PHP scripts that let your users CREATE and EDIT surveys and the questions they contain
// REMEMBER: Your admin will want a slightly different view of this page so they can MANAGE all of the users' surveys

// execute the header script:
require_once "header.php";

// checks the session variable named 'loggedInSkeleton'
// take note that of the '!' (NOT operator) that precedes the 'isset' function
if (!isset($_SESSION['loggedInSkeleton']))
{
	// user isn't logged in, display a message saying they must be:
	echo "You must be logged in to view this page.<br>";
}

// the user must be signed-in, show them suitable page content
else
{
	echo <<<_END
	<!DOCTYPE html>
<html>
 <head>
    <meta charset="utf-8">
    <title>Survey Manage</title>
</head>
 <body>
    <div class ="survey_container">
			<h2 class ="survey_title"> Survey </h2>
			<div class ="multiple_choice_container">
			<h2 class= "multiple_choice_title"> What is your favourite game console?</h2>
			<div class = "multiple_choice_form">
			<form action="surveys_manage.php" method="post">
			  <select name="consoleChoice">
			    <option = value="PS4">PS4</option>
			    <option value="Xbox-One">Xbox-One</option>
			    <option value="Nintendo-Switch">Nintendo-Switch</option>
			  </select>
			  <br><br>
			</div>
			</div>

 

			<div class ="number_input_container">
			<h2 class= "number_input_title"> How many game console do you own?</h2>
			<div class = "number_input_form">
			<input type="number" name="numberValue" value="name" step=1 min=0 max=99>
				<br><br>
 			</div>
			</div>

		<div class ="text_entry_container">
			<h2 class= "text_entry_title"> What is your favourite genre?</h2>
			<div class = "text_entry_form">
			<input type="text" name="textValue" value="name">
				<br><br>
 			</div>
			</div>
			
			<div class ="text_entry_container">
			<h2 class= "text_entry_title"> What is your favourite game that you own?</h2>
			<div class = "text_entry_form">
			<input type="text" name="textValue2" value="name">
				<br><br>
 			</div>
			</div>


			<div class ="slider_container">
			<h2 class= "slider_title"> Are you a strong gammer?</h2>
			<div class = "slider_form">
					<input type="range" name="rangeValue" min="1" max="5" value="1" class="slider"><br>
			
			</div>
			
		    	<input class="center_button" type="submit" name="submit">
			</form>
		</div>
		</div>
		
</body>
_END;

	if(isset($_POST['submit'])){
		$consoleChoice = $_POST['consoleChoice'];
		$rangeValue = $_POST['rangeValue'];
 	  	$numberValue = $_POST['numberValue'];
	 	$textValue = $_POST['textValue'];
		$textValue2 = $_POST['textValue2'];


		echo "$consoleChoice<br>";
	 	echo "$rangeValue<br>";
	 	echo "$numberValue<br>";
	 	echo "$textValue<br>";
		echo "$textValue2<br>";

		$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

		if(!$connection){

			die("Connection Failed: " . $mysqli_connect_error);

		}
		else{
			$query = "INSERT INTO temp_Survey(answer) VALUES ('$consoleChoice','$rangeValue','$numberValue','$textValue','$textValue2')";
		}
		if (mysqli_query($connection, $query)) {
			echo "Saved survey";
			// everything is OK, show the user table in admin view

		}

		else {
			die("Error inserting row: " . mysqli_error($connection));
		}

	}


	// a little extra text that only the admin will see:
	if ($_SESSION['username'] == "admin")
	{
		echo "[admin sees more!]<br>";
	}

}

// finish off the HTML for this page:
require_once "footer.php";

?>
