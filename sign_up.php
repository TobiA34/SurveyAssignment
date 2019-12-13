<?php

// Things to notice:
// The main job of this script is to execute an INSERT statement to add the submitted username, password and email address
// However, the assignment specification tells you that you need more fields than this for each user.
// So you will need to amend this script to include them. Don't forget to update your database (create_data.php) in tandem so they match
// This script does client-side validation using "password","text" inputs and "required","maxlength" attributes (but we can't rely on it happening!)
// we sanitise the user's credentials - see helper.php (included via header.php) for the sanitisation function
// we validate the user's credentials - see helper.php (included via header.php) for the validation functions
// the validation functions all follow the same rule: return an empty string if the data is valid...
// ... otherwise return a help message saying what is wrong with the data.
// if validation of any field fails then we display the help messages (see previous) when re-displaying the form

// execute the header script:
require_once "header.php";

// default values we show in the form:
$usernames = "";
$passwords = "";
$emails = "";
$first_name = "";
$surname = "";
$telephone = "";
$dob = "";
$user_type = "";

// strings to hold any validation error messages:
$usernames_val = "";
$passwords_val = "";
$emails_val = "";
$first_name_val = "";
$surname_val = "";
$telephone_val = "";
$dob_val = "";
$user_type_val = "";


// should we show the signup form?:
$show_signup_form = false;
// message to output to user:
$message = "";

// checks the session variable named 'loggedInSkeleton'
if (isset($_SESSION['loggedInSkeleton']))
{
	// user is already logged in, just display a message:
	echo "You are already logged in, please log out if you wish to create a new account<br>";

}

elseif (isset($_POST['username']))
{
	// user just tried to sign up:

	// connect directly to our database (notice 4th argument) we need the connection for sanitisation:
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

	// if the connection fails, we need to know, so allow this exit:
	if (!$connection)
	{
		die("Connection failed: " . $mysqli_connect_error);
	}

	// SANITISATION (see helper.php for the function definition)

	// take copies of the credentials the user submitted, and sanitise (clean) them:
	$usernames = sanitise($_POST['username'], $connection);
	$passwords = sanitise($_POST['password'], $connection);
    $emails = sanitise($_POST['email'], $connection);
	$first_name = sanitise($_POST['first_name'], $connection);
	$surname = sanitise($_POST['surname'], $connection);
	$telephone = sanitise($_POST['telephone'], $connection);
	$dob = sanitise($_POST['dob'], $connection);
	$user_type = sanitise($_POST['user_type'], $connection);


	// VALIDATION (see helper.php for the function definitions)
	// now validate the data (both strings must be between 1 and 16 characters long):
	// (reasons: we don't want empty credentials, and we used VARCHAR(16) in the database table for username and password)
    // firstname is VARCHAR(32) and lastname is VARCHAR(64) in the DB
    // email is VARCHAR(64) and telephone is VARCHAR(16) in the DB
	$usernames_val = validateString($usernames, 1, 16);
	$passwords_val = validateString($passwords, 1, 16);
    //the following line will validate the email as a string, but maybe you can do a better job...
    $emails_val = validateString($emails, 1, 64);
	$first_name_val = validateString($first_name, 1, 32);
	$surname_val = validateString($surname, 1, 64);
	$telephone_val = validateString($telephone, 1, 16);
	$user_type_val = validateString($user_type, 1, 6);

	// concatenate all the validation results together ($errors will only be empty if ALL the data is valid):
	$errors = $usernames_val . $passwords_val . $emails_val.$first_name_val.$surname_val.$telephone_val.$user_type_val;

	// check that all the validation tests passed before going to the database:
	if ($errors == "")
	{

		// try to insert the new details:
		$query = "INSERT INTO users (username, password, email,first_name,surname,telephone,dob,user_type) VALUES ('$usernames', '$passwords', '$emails','$first_name','$surname','$telephone','$dob','$user_type')";

		$result = mysqli_query($connection, $query);

		// no data returned, we just test for true(success)/false(failure):
		if ($result)
		{
			// show a successful signup message:
			$message = "Signup was successful, please sign in<br>";
		}
		else
		{
			// show the form:
			$show_signup_form = true;
			// show an unsuccessful signup message:
			$message = "Sign up failed, please try again<br>";
		}

	}

	else
	{
		// validation failed, show the form again with guidance:
		$show_signup_form = true;
		// show an unsuccessful signin message:
		$message = "Sign up failed, please check the errors shown above and try again<br>";
	}

	// we're finished with the database, close the connection:
	mysqli_close($connection);

}

else
{
	// just a normal visit to the page, show the signup form:
	$show_signup_form = true;

}

if ($show_signup_form)
{
// show the form that allows users to sign up
// Note we use an HTTP POST request to avoid their password appearing in the URL:
echo <<<_END
<!DOCTYPE html>
<html>

<head>
     <meta charset="utf-8">
    <title>About</title>
</head>

<body>
<div id="container_for_sign_up">
 <div id="sign_up_form">
<div id="border_for_sign_up_form">
<form action="sign_up.php" method="post">

    Username: <input type="text" name="username" maxlength="16" class="textfield" value="$usernames" required> $usernames_val
    Password: <input type="password" name="password" maxlength="16" class="textfield" value="$passwords" required> $passwords_val
    Email: <input type="email" name="email" maxlength="64" value="$emails" class="textfield" required> $emails_val
   	Firstname: <br> <input type="text" name="first_name" class="textfield" maxlength="32" value="$first_name" required> $first_name_val
	Surname: <input type="text" name="surname" class="textfield" maxlength="64" value="$surname" required> $surname_val
	Telephone: <input type="text" name="telephone" class="textfield" maxlength="16" value="$telephone" required> $telephone_val
	Dob: <br><input type="date" name="dob" class="textfield" value="$dob" required>  
	User type: <br><select name = "user_type" value="$user_type" class="select">
					 <option  name="user_type"  required>users</option>$user_type_val
				</select>
   <br><input type="submit" value="Submit">
</form>
</div>
</div>
</div>
_END;
}

// display our message to the user:
echo $message;

// finish off the HTML for this page:
require_once "footer.php";

?>
