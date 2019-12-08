6G5Z2107 - 2CWK50 - 2019/20
<Tobi Adegoroye>
<18011328>


SETUP:
...

//start_up XAMPP by clicking start.
//Run create_data.php to create the data
// Then run about.php to go to the home screen



DOCUMENTATION:
...

/* USER ACCOUNT */

if ($errors == "")
	{
/**
* checks to see if errors is equal to nothing
* variable query holds the insert statement
* query variable and connection variable stored inside of results.
* checks to see if result is equal to true then store user details else show error message
* @param errors
*   
*/
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



/* LOGIN */

if ($errors == "")
		{
/**
* checks to see if result.num_rows is greater than 0
* sets the session variable loggedInSkeleton to true
* sets the session variable username to the variable username then logs the user in and if there is no match show error message
* @param errors
*   
*/
			$query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
			$result = mysqli_query($connection, $query);

			if ($result->num_rows > 0) {

				// set a session variable to record that this user has successfully logged in:
				$_SESSION['loggedInSkeleton'] = true;
				// and copy their username into the session data for use by our other scripts:
				$_SESSION['username'] = $username;

				// show a successful signin message:
				$message = "Hi, " . $_SESSION['username'] . " , you have successfully logged in, please <a href='account.php'>click here</a><br>";
				echo <<<_END
				<!DOCTYPE html>
					<html>
					 <head>
						<link rel="stylesheet" href="main.css" type="text/css">
						<meta charset="utf-8">
						<title>About</title>
					</head>
				_END;

			} else {
				// no matching credentials found so redisplay the signin form with a failure message:
				$show_signin_form = true;
				// show an unsuccessful signin message:
				$message = "Sign in failed, please try again<br>";
			}

		}
		else
		{
			// validation failed, show the form again with guidance:
			$show_signin_form = true;
			// show an unsuccessful signin message:
			$message = "Sign in failed, please check the errors shown above and try again<br>";
		}

		// we're finished with the database, close the connection:
		mysqli_close($connection);

	}
	else
	{
		// user has arrived at the page for the first time, just show them the form:
		// show signin form:
		$show_signin_form = true;
	}




/* UPDATE */
if ($n > 0)
{

/**
* checks to see if n > 0
* Update Sql statement stored inside of variable query 
* query variable and connection variable stored inside of results.
* check to see if results is true and update account details. If not successful displays update failed
* @param results
*/
			// we need an UPDATE:
			$query = "UPDATE users SET email='$emails' WHERE username='$username'";
			$result = mysqli_query($connection, $query);
		}

		if ($result)
		{
			// show a successful update message:
			$message = "Profile successfully updated<br>";

		}
		else
		{
			// show the set profile form:
			$show_account_form = true;
			// show an unsuccessful update message:
			$message = "Update failed<br>";
		}