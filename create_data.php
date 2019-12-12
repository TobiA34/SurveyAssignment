<?php

// Things to notice:
// This file is the first one we will run when we mark your submission
// Its job is to:
// Create your database (currently called "skeleton", see credentials.php)...
// Create all the tables you will need inside your database (currently it makes a simple "users" table, you will probably need more and will want to expand fields in the users table to meet the assignment specification)...
// Create suitable test data for each of those tables
// NOTE: this last one is VERY IMPORTANT - you need to include test data that enables the markers to test all of your site's functionality

// read in the details of our MySQL server:
require_once "credentials.php";

// We'll use the procedural (rather than object oriented) mysqli calls

// connect to the host:
$connection = mysqli_connect($dbhost, $dbuser, $dbpass);

// exit the script with a useful message if there was an error:
if (!$connection)
{
	die("Connection failed: " . $mysqli_connect_error);
}



// build a statement to create a new database:
$sql = "CREATE DATABASE IF NOT EXISTS " . $dbname;

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql))
{
	echo "Database created successfully, or already exists<br>";
}
else
{
	die("Error creating database: " . mysqli_error($connection));
}

// connect to our database:
mysqli_select_db($connection, $dbname);

//unset checking for foreign keys - resetting the DB
$sqlForeignKey = "SET FOREIGN_KEY_CHECKS = 0";

if(mysqli_query($connection,$sqlForeignKey))
{
	echo "Foreign key set to 0 <br>";
}
else
{
	die("Error creating database".mysqli_error($connection));
}

///////////////////////////////////////////
////////////// USERS TABLE //////////////
///////////////////////////////////////////

// if there's an old version of our table, then drop it:
$sql = "DROP TABLE IF EXISTS users";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql))
{
	echo "Dropped existing table: users<br>";
}

else
{
	die("Error checking for existing table: " . mysqli_error($connection));
}

// make our table:
// notice that the username field is a PRIMARY KEY and so must be unique in each record
$sql = "CREATE TABLE users (
username VARCHAR(16), 
password VARCHAR(16), 
email VARCHAR(64),
first_name VARCHAR(32),
surname VARCHAR(64),
telephone VARCHAR(16),
dob DATE,
user_type VARCHAR(6),
PRIMARY KEY(username))";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql))
{
	echo "Table created successfully: users<br>";
}

else
{
	die("Error creating table: " . mysqli_error($connection));
}

// put some data in our table:
// create an array variable for each field in the DB that we want to populate
$usernames[] = 'admin'; $passwords[] = 'secret'; $emails[] = 'barry@m-domain.com';$first_name[] = 'barry';$surname[] = 'man'; $telephone[] = '01616942804';$dob[] = '1984-10-03';'01616942804';$user_type[] = 'admin';
$usernames[] = 'mandyb'; $passwords[] = 'abc123'; $emails[] = 'webmaster@mandy-g.co.uk';$first_name[] = 'mandy';$surname[] = 'ben'; $telephone[] = '01616932804';$dob[] = '2000-10-03';$user_type[] = 'users';
$usernames[] = 'timmy'; $passwords[] = 'secret95'; $emails[] = 'timmy@lassie.com';$first_name[] = 'timmy';$surname[] = 'nam'; $telephone[] = '01618932804';$dob[] = '1980-9-03';$user_type[] = 'users';

// loop through the arrays above and add rows to the table:
for ($i=0; $i<count($usernames); $i++)
{
	// create the SQL query to be executed
//    $sql = "INSERT INTO users (username, password, email , first_name,surname,telephone,dob,user_type) VALUES ('$usernames[$i]', '$passwords[$i]', '$emails[$i]', '$first_name[$i]', '$surname[$i]', '$telephone[$i]', '$dob[$i]')";
		     $sql = "INSERT INTO users (username, password, email,first_name,surname,telephone,dob,user_type) VALUES ('$usernames[$i]', '$passwords[$i]', '$emails[$i]','$first_name[$i]','$surname[$i]','$telephone[$i]','$dob[$i]','$user_type[$i]')";

	// run the above query '$sql' on our DB
    // no data returned, we just test for true(success)/false(failure):
	if (mysqli_query($connection, $sql))
	{
		echo "row inserted<br>";
	}

	else
	{
		die("Error inserting row: " . mysqli_error($connection));
	}
}




//////////////////////////////////////////////
//////////////// SURVEY TYPE TABLE /////////////////
//////////////////////////////////////////////


// if there's an old version of our table, then drop it:
$sql = "DROP TABLE IF EXISTS survey_type";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql))
{
	echo "Dropped existing table: survey_type<br>";
}

else
{
	die("Error checking for existing table: " . mysqli_error($connection));
}

// make our table:
// notice that the username field is a PRIMARY KEY and so must be unique in each record
$sql = "CREATE TABLE survey_type (
survey_type_id INT NOT NULL AUTO_INCREMENT,
 type VARCHAR(40),
 PRIMARY KEY(survey_type_id))";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql))
{
	echo "Table created successfully: survey_type<br>";
}

else
{
	die("Error creating table: " . mysqli_error($connection));
}
////clear the array
$type  = array();
// put some data in our table:
// create an array variable for each field in the DB that we want to populate
$type [] = "number";
$type [] = "text";
$type [] = "select";

 //loop through the arrays above and add rows to the table:
for ($i=0; $i<count($type); $i++)
{
	// create the SQL query to be executed
//    $sql = "INSERT INTO users (username, password, email , first_name,surname,telephone,dob,user_type) VALUES ('$usernames[$i]', '$passwords[$i]', '$emails[$i]', '$first_name[$i]', '$surname[$i]', '$telephone[$i]', '$dob[$i]')";
	$sql = "INSERT INTO survey_type (type) VALUES ('$type[$i]')";

	// run the above query '$sql' on our DB
	// no data returned, we just test for true(success)/false(failure):
	if (mysqli_query($connection, $sql))
	{
		echo "row inserted<br>";
	}

	else
	{
		die("Error inserting row: " . mysqli_error($connection));
	}
}

//////////////////////////////////////////////
//////////////// SURVEY TABLE /////////////////
//////////////////////////////////////////////


// if there's an old version of our table, then drop it:
$sql = "DROP TABLE IF EXISTS survey";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql))
{
	echo "Dropped existing table: survey<br>";
}

//else
//{
//	die("Error checking for existing table: " . mysqli_error($connection));
//}
//
//// make our table:
//// notice that the username field is a PRIMARY KEY and so must be unique in each record
$sql = "CREATE TABLE survey (
 id INT NOT NULL AUTO_INCREMENT,
 title VARCHAR(150), 
 instructions VARCHAR(250),
 PRIMARY KEY(id), 
 survey_type_id INT(11) NOT NULL , 
 user_id VARCHAR(64),
 FOREIGN KEY(user_id) REFERENCES users(username), 
 FOREIGN KEY(survey_type_id) REFERENCES survey_type(survey_type_id))";

//
//// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql))
{
	echo "Table created successfully: survey<br>";
}

else
{
	die("Error creating table: " . mysqli_error($connection));
}
//clear the array
$title = $instructions = $username = array();
// put some data in our table:
// create an array variable for each field in the DB that we want to populate





// loop through the arrays above and add rows to the table:
for ($i=0; $i<count($title); $i++)
{
	// create the SQL query to be executed
//    $sql = "INSERT INTO users (username, password, email , first_name,surname,telephone,dob,user_type) VALUES ('$usernames[$i]', '$passwords[$i]', '$emails[$i]', '$first_name[$i]', '$surname[$i]', '$telephone[$i]', '$dob[$i]')";
	$sql = "INSERT INTO survey (username,title,instructions) VALUES ('$username[$i]','$title[$i]', '$instructions[$i]')";

	// run the above query '$sql' on our DB
	// no data returned, we just test for true(success)/false(failure):
	if (mysqli_query($connection, $sql))
	{
		echo "row inserted<br>";
	}

	else
	{
		die("Error inserting row: " . mysqli_error($connection));
	}
}


//////////////////////////////////////////////
//////////////// SURVEY QUESTION TABLE /////////////////
//////////////////////////////////////////////


// if there's an old version of our table, then drop it:
$sql = "DROP TABLE IF EXISTS survey_question";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql))
{
	echo "Dropped existing table: survey_question<br>";
}

else
{
	die("Error checking for existing table: " . mysqli_error($connection));
}

//// make our table:
//// notice that the username field is a PRIMARY KEY and so must be unique in each record
$sql = "CREATE TABLE survey_question (
id INT NOT NULL AUTO_INCREMENT, 
title VARCHAR(200), 
survey_id INT(11) NOT NULL, 
PRIMARY KEY(id),
FOREIGN KEY(survey_id)  REFERENCES survey(id))";
//
//// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql))
{
	echo "Table created successfully: survey_question<br>";
}

else
{
	die("Error creating table: " . mysqli_error($connection));
}
////clear the array
$title = $survey_id = array();
// put some data in our table:
// create an array variable for each field in the DB that we want to populate



// loop through the arrays above and add rows to the table:
for ($i=0; $i<count($title); $i++)
{
	// create the SQL query to be executed
//    $sql = "INSERT INTO users (username, password, email , first_name,surname,telephone,dob,user_type) VALUES ('$usernames[$i]', '$passwords[$i]', '$emails[$i]', '$first_name[$i]', '$surname[$i]', '$telephone[$i]', '$dob[$i]')";
	$sql = "INSERT INTO survey_question (title,survey_id) VALUES ('$title[$i]')";

	// run the above query '$sql' on our DB
	// no data returned, we just test for true(success)/false(failure):
	if (mysqli_query($connection, $sql))
	{
		echo "row inserted<br>";
	}

	else
	{
		die("Error inserting row: " . mysqli_error($connection));
	}
}

//////////////////////////////////////////////
//////////////// SURVEY ANSWER TABLE /////////////////
//////////////////////////////////////////////


// if there's an old version of our table, then drop it:
$sql = "DROP TABLE IF EXISTS survey_answer";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql))
{
	echo "Dropped existing table: survey_answer<br>";
}

else
{
	die("Error checking for existing table: " . mysqli_error($connection));
}

//// make our table:
//// notice that the username field is a PRIMARY KEY and so must be unique in each record
$sql = "CREATE TABLE survey_answer (
 answer_id INT NOT NULL AUTO_INCREMENT,
 answer VARCHAR(300), 
 survey_id INT(11) NOT NULL, 
 user_id VARCHAR(64), 
 survey_question_id INT(11) NOT NULL, 
 PRIMARY KEY(answer_id),
 FOREIGN KEY(survey_id) REFERENCES survey(id), 
 FOREIGN Key(user_id) REFERENCES users(username),
 FOREIGN Key(survey_question_id) REFERENCES survey_question(id))";
//
//// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql))
{
	echo "Table created successfully: survey_answer<br>";
}

else
{
	die("Error creating table: " . mysqli_error($connection));
}
////clear the array
$answer  = array();
// put some data in our table:
// create an array variable for each field in the DB that we want to populate
//$names [] = "Test List for Admin 1"; $usernames[] = "admin"; $created[] = $updated[] = "2019-12-01";$visible[] = 0;
//$names [] = "Test List for mandyb"; $usernames[] = "mandyb"; $created[] = $updated[] = "2019-12-18";$visible[] = 1;
//$names [] = "Test List2 for mandyb"; $usernames[] = "mandyb"; $created[] = $updated[] = "2019-12-04";$visible[] = 0;
//$names [] = "Test List for timmy"; $usernames[] = "timmy"; $created[] = $updated[] = "2019-12-12";$visible[] = 1;

// loop through the arrays above and add rows to the table:
for ($i=0; $i<count($title); $i++)
{
	// create the SQL query to be executed
//    $sql = "INSERT INTO users (username, password, email , first_name,surname,telephone,dob,user_type) VALUES ('$usernames[$i]', '$passwords[$i]', '$emails[$i]', '$first_name[$i]', '$surname[$i]', '$telephone[$i]', '$dob[$i]')";
	$sql = "INSERT INTO survey_answer (answer) VALUES ('$answer[$i]')";

	// run the above query '$sql' on our DB
	// no data returned, we just test for true(success)/false(failure):
	if (mysqli_query($connection, $sql))
	{
		echo "row inserted<br>";
	}

	else
	{
		die("Error inserting row: " . mysqli_error($connection));
	}
}



//////////////////////////////////////////////
//////////////// TEMP SURVEY  TABLE /////////////////
//////////////////////////////////////////////
// if there's an old version of our table, then drop it:
$sql = "DROP TABLE IF EXISTS temp_survey";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql))
{
	echo "Dropped existing table: temp_survey<br>";
}

else
{
	die("Error checking for existing table: " . mysqli_error($connection));
}

//// make our table:
//// notice that the username field is a PRIMARY KEY and so must be unique in each record
$sql = "CREATE TABLE temp_survey (
 id INT NOT NULL AUTO_INCREMENT,
 survey_title VARCHAR(300), 
 survey_answer VARCHAR(200), 
 PRIMARY KEY(id))";
//
//// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql))
{
	echo "Table created successfully: temp_survey<br>";
}

else
{
	die("Error creating table: " . mysqli_error($connection));
}
////clear the array
$survey_title =  $survey_answer  = array();
// put some data in our table:
// create an array variable for each field in the DB that we want to populate
$survey_title [] = "How many games do you own"; $survey_answer[] = "6";
$survey_title [] = "How many game console do you own"; $survey_answer[] = "2";
$survey_title [] = "What is your favourite game"; $survey_answer[] = "God of War";
$survey_title [] = "What is your favourite game genre"; $survey_answer[] = "sports";
$survey_title [] = "What game do you hate"; $survey_answer[] = "need for speed";
$survey_title [] = "What game are you most excited for"; $survey_answer[] = "gta 6";
$survey_title [] = "What game are you least excited for"; $survey_answer[] = "nfl 19";
$survey_title [] = "What is your favourite game of all time"; $survey_answer[] = "fifa 20";


// loop through the arrays above and add rows to the table:
for ($i=0; $i<count($survey_title); $i++)
{
	// create the SQL query to be executed
 	$sql = "INSERT INTO temp_survey (survey_title,survey_answer) VALUES ('$survey_title[$i]','$survey_answer[$i]')";

	// run the above query '$sql' on our DB
	// no data returned, we just test for true(success)/false(failure):
	if (mysqli_query($connection, $sql))
	{
		echo "row inserted<br>";
	}

	else
	{
		die("Error inserting row: " . mysqli_error($connection));
	}
}


//reset checking for foreign key checks
$sqlResetForeignKey = "SET FOREIGN_KEY_CHECKS = 1";

if(mysqli_query($connection,$sqlResetForeignKey))
{
	echo "Foreign key set to 1 <br>";
}
else
{
	die("Error creating database".mysqli_error($connection));

}



// we're finished, close the connection:
mysqli_close($connection);
?>
