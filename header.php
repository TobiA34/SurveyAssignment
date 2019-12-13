<?php

// Things to notice:
// This script is called by every other script (via require_once)
// It begins the HTML output, with the customary tags, that will produce each of the pages on the web site
// It starts the session and displays a different set of menu links depending on whether the user is logged in or not...
// ... And, if they are logged in, whether or not they are the admin
// It also reads in the credentials for our database connection from credentials.php

// database connection details:
require_once "credentials.php";

// our helper functions:
require_once "helper.php";

// start/restart the session:
// this allows use to make use of session variables
session_start();

// checks the session variable named 'loggedInSkeleton'
if (isset($_SESSION['loggedInSkeleton']))
{
	// THIS PERSON IS LOGGED IN
	// show the logged in menu options:

    // add an extra menu option if this was the admin:
    // this allows us to display the admin tools to them only
	if (isset($_SESSION['loggedInSkeleton']) && $_SESSION['username'] == "admin")
	{
		echo <<<_END
		  <!DOCTYPE html>
		  <html>
		  <head>
		  <title>Survey Lion</title>
		  <link rel="stylesheet" href="main.css" type="text/css">
		  </head>
		  <body>
		  <h1 id="website-name">Survey Lion</h1>
		  <div class="nav">
			<a href='about.php'>About</a> ||
			<a href='account.php'>My Account</a> ||
			<a href='admin.php'>Admin Tools</a> ||
			<a href='surveys_manage.php'>My Surveys</a> ||
			<a href='competitors.php'>Design and Analysis</a> ||
			<a href="custom_survey_page.php">Custom survey</a> ||
			<a href='sign_out.php'>Sign Out ({$_SESSION['username']})</a>
		   </div>
_END;
	}
	else{
		echo <<<_END
		<!DOCTYPE html>
		<html>
			<head>
				<title>Survey Lion</title>
				<link rel="stylesheet" href="main.css" type="text/css">
			</head>
		<body>
			<h1 id="website-name">Survey Lion</h1>
		<div class="nav">
			<a href='about.php'>About</a> ||
			<a href='account.php'>My Account</a> ||
			<a href='surveys_manage.php'>My Surveys</a> ||
			<a href='competitors.php'>Design and Analysis</a> ||
			<a href="custom_survey_page.php">Custom survey</a>||
			<a href='sign_out.php'>Sign Out ({$_SESSION['username']})</a>
		</div>
_END;
	}
}

else
{
	// THIS PERSON IS NOT LOGGED IN
	// show the logged out menu options:
echo <<<_END
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="main.css" type="text/css">
</head>
 <body>
<h1 id="website-name">Survey Lion</h1>
<div class="nav">
	 <a href='about.php'>About</a></li> ||
	 <a href='sign_up.php'>Sign Up</a></li> ||
	 <a href='sign_in.php'>Sign In</a></li> ||
	 <a href='competitors.php'>Competitors</a></li>
</div>
_END;
}



?>
