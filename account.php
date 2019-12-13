<?php

// Things to notice:
// The main job of this script is to execute a SELECT statement to find the user's profile information (then display it)

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
    // user is already logged in, read their username from the session:
	$username = $_SESSION["username"];

	// now read their account data from the table...
	// connect directly to our database (notice 4th argument - database name):
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

	// if the connection fails, we need to know, so allow this exit:
	if (!$connection)
	{
		die("Connection failed: " . $mysqli_connect_error);
	}

	// check for a row in our profiles table with a matching username:
	$query = "SELECT * FROM users WHERE username='$username'";

	// this query can return data ($result is an identifier):
	$result = mysqli_query($connection, $query);

	// how many rows came back? (can only be 1 or 0 because username is the primary key in our table):
	$n = mysqli_num_rows($result);




	// if the operation equals delete then delete
	if((isset($_GET['operation']) && ($_GET['operation'])=="delete"))
	{
		delList($dbhost,$dbhost,$dbuser,$dbpass,$dbname,$_GET['id']);
	}


	// if there was a match then extract their profile data:
	if ($n > 0) {
		// use the identifier to fetch one row as an associative array (elements named after columns):
		$row = mysqli_fetch_assoc($result);

		echo <<<_END
<head>
<link rel="stylesheet" href="main.css" type="text/css">
</head>
<body>
<div id="container-for-my-account">
<h2 class="center">My Account</h2>
<div id="my_account">
 <div id="border-for-my_account">
		<img id="account_image" src="Images/account.png">
		<p>Username: {$row['username']}<br></p>
		<p>Password: {$row['password']}<br></p>
	    <p>Email: {$row['email']}<br></p>
	    <p>first name: {$row['first_name']}<br></p>
		<p>Surname: {$row['surname']}<br></p>
	    <p>Telephone: {$row['telephone']}<br></p>
	    <p>Dob: {$row['dob']}<br></p>
	    <p>User Type: {$row['user_type']}<br></p>
		<p><br>You can <a href='account_set.php'>update</a> your account details here.<br></p>
 </div>
 

</body>
_END;
	}

	// we're finished with the database, close the connection:
	mysqli_close($connection);

}




// finish off the HTML for this page:
require_once "footer.php";
?>
