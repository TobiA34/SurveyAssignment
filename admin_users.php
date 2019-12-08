<?php

// This script allows the ADMIN to administer other site users
// It begins by providing a list of all site users
// From there, the ADMIN can edit, delete and add new ones

// execute the header script:
require_once "header.php";
// read in the details of our MySQL server:
require_once "credentials.php";

// setup variables to help with functionality and validation of data
$usernames = "";
$passwords = "";
$emails = "";
$first_name = "";
$surname = "";
$telephone = "";
$dob = "";
$user_type = "";

$usernames_val = "";
$passwords_val = "";
$emails_val = "";
$first_name_val = "";
$surname_val = "";
$telephone_val = "";
$dob_val = "";
$user_type_val = "";

// error messages to display about each field to be used for combination of all server-side  val
$username_val = $passwords_val = $first_name_val = $surname_val = $email_val = $dob_val = $telephone_val = $user_type_val = $errors = "";
$message = "";

// default field to sort users by
$sortUsers = "username";
$sortOrder = "ASC";

// switch the table of users off and on
$showUsers = true;




// check that the current user is the ADMIN user
if (isset($_SESSION['loggedInSkeleton']) && ($_SESSION['username']=='admin')) {

	// see if the user has clicked a field to sort the user
	if (isset($_GET['sortUsers']) && isset($_GET['sort'])) {
		$sortUsers = $_GET['sortUsers'];

        $sortOrder = $_GET['sort'];

		if ($sortOrder=="ASC") {
            $sortOrder = "DESC";
		}
		else {
            $sortOrder = "ASC";
		}
	}

	else if (isset($_GET['sortUsers'])) {
		$sortUsers = $_GET['sortUsers'];
	}

	else if (isset($_GET['operation']) && (isset($_GET['id']))) {

		// is this a delete operation? If so, do it!
		if ($_GET['operation']=="delete") {
			delUsers($dbhost, $dbuser, $dbpass, $dbname, $_GET['id']);
			$showUsers = true;
		}

		//if the admin wants to edit and existing, or add a new, user - provide that option
		else if ($_GET['operation']=="new" || $_GET['operation']=="edit"){
			$showUsers = false;

			if ($_GET['operation']=="new") {
				$action="Add New";
				$usernameAction = "";
				$dbAction = "newUser";
				$editRow['username'] = $editRow['password'] = $editRow['first_name'] = $editRow['surname'] = $editRow['dob'] = $editRow['email'] = $editRow['telephone'] = $editRow['user_type'] = "";
			}

			else {
				$action="Edit";
				$dbAction = "changeUser";
				$usernameAction = "readonly";
				$editRow = editUsers($dbhost, $dbuser, $dbpass, $dbname, $_GET['id']);
			}

            echo <<<_END
              <form action="admin_users.php" method="post" enctype="multipart/form-data">
                 <h2 align="left"> $action USER</h2><table>
                
                 <tr><th>Username: <input type="text" name="username" maxlength="16" class="textfield" value="{$editRow['username']}" $usernameAction required> $username_val <br></th></tr>
                 <tr><th>Password: <input type="password" name="password" maxlength="16" class="textfield" value="{$editRow['password']}" required> $passwords_val<br></th></tr>
                 <tr><th>Email: <input type="email" name="email" maxlength="64" value="{$editRow['email']}" class="textfield" required> $email_val<br></th></tr>
                 <tr><th>First name:<input type="text" name="first_name" class="textfield" maxlength="32" value="{$editRow['first_name']}" required> $first_name_val<br></th></tr>
                 <tr><th>Surname: <input type="text" name="surname" class="textfield" maxlength="64" value="{$editRow['surname']}" required> $surname_val<br></th></tr>
                 <tr><th>Telephone: <input type="text" name="telephone" class="textfield" maxlength="16" value="{$editRow['telephone']}" required> $telephone_val<br></th></tr>
                 <tr><th>Dob: <input type="date" name="dob" class="textfield" value="{$editRow['dob']}" required>  <br></th></tr>
                 <tr><th>User type: <select name = "user_type" value="{$editRow['user_type']}" class="select">
                    <option>users</option>$user_type_val
                    <option>admin</option>$user_type_val
                 </select></th></tr>
                 <tr><th><input type="submit" name="$dbAction" value="$action user"></th></tr>
                 <tr><th><a href="admin_users.php">back</a></th></tr>
                 </table>
              </form>

           _END;


        }

	}

	elseif (isset($_POST['changeUser']) || (isset($_POST['newUser']))) {
		// admin has attempted to add a new user to the database


		$usernames = $_POST['username'];
		$passwords = $_POST['password'];
		$first_name = $_POST['first_name'];
		$surname = $_POST['surname'];
		$dob = $_POST['dob'];
		$emails = $_POST['email'];
		$telephone = $_POST['telephone'];
        $user_type = $_POST['user_type'];





        // connect to the host:
		$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
		// exit the script with a useful message if there was an error:
		if (!$connection) {
			die("Connection failed: " . $mysqli_connect_error);
		}

        //Server side Validation
        $usernames = sanitise($usernames, $connection);
        $passwords = sanitise($passwords, $connection);
        $emails = sanitise($emails, $connection);
        $first_name = sanitise($first_name, $connection);
        $surname = sanitise($surname, $connection);
        $telephone = sanitise($telephone, $connection);
        $dob = sanitise($dob, $connection);
        $user_type = sanitise($user_type, $connection);

        //validating user input
        $usernames_val = validateString($usernames, 1, 16);
        $passwords_val = validateString($passwords, 1, 16);
        //the following line will validate the email as a string, but maybe you can do a better job...
        $emails_val = validateString($emails, 1, 64);
        $first_name_val = validateString($first_name, 1, 32);
        $surname_val = validateString($surname, 1, 64);
        $telephone_val = validateString($telephone, 1, 16);
        $user_type_val = validateString($user_type, 1, 6);


		// concatenate the  val from both validation calls
		$errors = $username_val . $passwords_val . $first_name_val . $surname_val . $telephone_val . $emails_val . $dob_val.$user_type_val;

		if ($errors == "") {

			// NEW USER being added by admin
			if (isset($_POST['newUser'])) {

                $query = "INSERT INTO users( username, password, email,first_name,surname,telephone,dob,user_type) VALUES ('$usernames', '$passwords', '$emails','$first_name','$surname','$telephone','$dob','$user_type')";


                // no data returned, we just test for true(success)/false(failure):
				if (mysqli_query($connection, $query)) {
					echo "New user $usernames has been added";
					// everything is OK, show the user table in admin view
					$showUsers = true;
				}

				else {
					die("Error inserting row: " . mysqli_error($connection));
				}
			}

			// EXISTING USER being updated by admin
			else {

				$sql = "UPDATE users SET username='$usernames', password='$passwords', first_name='$first_name',  surname='$surname', dob='$dob', email='$emails', telephone='$telephone', user_type='$user_type' 
            WHERE username='$usernames'";

				// no data returned, we just test for true(success)/false(failure):
				if (mysqli_query($connection, $sql)) {

					echo "User $usernames has been edited";
					// everything is OK, show the user table in admin view
					$showUsers = true;
				}
				else {
					die("Error updating row: " . mysqli_error($connection));
				}

			}

		}
		// we're finished with the database, close the connection:
		mysqli_close($connection);
	}


	// if set to TRUE then sort the USERS list and display in the browser
	if ($showUsers) {
		// call the function that sorts and displays the users in the table
		sortUsers($dbhost, $dbuser, $dbpass, $dbname, $sortUsers, $sortOrder);
	}

}

else {
	echo "Sorry, you must be an administrator to access this resource";
}



/////////////////////////
// SORT USERS FUNCTION //
/////////////////////////
function sortUsers($dbhost, $dbuser, $dbpass, $dbname, $field, $sortOrder) {

	// connect to the host:
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	// exit the script with a useful message if there was an error:
	if (!$connection)
	{
		die("Connection failed: " . $mysqli_connect_error);
	}

	// connect to our database:
	mysqli_select_db($connection, $dbname);
	// run query to get the contents of the USERS table
	$query = "SELECT * FROM users ORDER BY $field $sortOrder";
	// this query can return data ($result is an identifier):
	$result = mysqli_query($connection, $query);
	// how many rows came back?:
	$n = mysqli_num_rows($result);

	//format a table and layout
	echo "<div id=\"admin_page_container\"><fieldset><h2>Manage Users</h2><table id='manage_user_table'>";
	echo "<tr><th><a href='admin_users.php?sortUsers=username&sort={$sortOrder}'>Sort Username</a></th><th><a href='admin_users.php?sortUsers=first_name&sort={$sortOrder}'>First Name</a></th>
            <th><a href='admin_users.php?sortUsers= surname&sort={$sortOrder}'>Sort Surname</a></th>
            <th><a href='admin_users.php?sortUsers=email&sort={$sortOrder}'>Sort Email</a></th><th>Action</th></tr>";

	if ($n>0) {

		for ($i = 0; $i < $n; $i++) {
			$row = mysqli_fetch_assoc($result);
			echo <<<_END
                <tr><td>{$row['username']}</td><td>{$row['first_name']}</td><td>{$row['surname']}</td>
                <td>{$row['email']}</td>
                <td><a href="admin_users.php?operation=edit&id={$row['username']}">Edit User</a> || <a href="admin_users.php?operation=delete&id={$row['username']}">Delete User</a></td></tr>
_END;

		}

		// complete formatting for the table

		echo "</div></table></fieldset>";

        echo "<div id =\"add_new_user_container\">
        <a id=\"add_user_link\" href='admin_users.php?operation=new&id=new'>Add new User</a></td></tr>
        <div id=\"image_container\">
            <img id=\"user_png\"src=\"Images/boy.png\">
        </div>
       </div>";

        echo "<div id =\"add_new_user_container\">
             <a id=\"add_user_link\" href='download.php?download=users'>Download CSV</a>
                 <div id=\"image_container\">
                    <img id=\"file_png\"src=\"Images/file.png\">
                 </div>
             </div>";
	}

	else {
		echo "No information found in users table";
	}
	// we're finished with the database, close the connection:
	mysqli_close($connection);
}


//////////////////////////
// DELETE USER FUNCTION //
//////////////////////////

function delUsers ($dbhost, $dbuser, $dbpass, $dbname, $field) {
	// connect to the host:
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	// exit the script with a useful message if there was an error:
	if (!$connection)
	{
		die("Connection failed: " . $mysqli_connect_error);
	}

	// stop admin account from being removed
	if ($field=="admin") {
		echo "Admin account cannot be deleted!<br>";
	}

	else {
		// disable foreign key checks to allow users with lists to be removed
		$sql = "SET FOREIGN_KEY_CHECKS=0";
		mysqli_query($connection, $sql);

		// connect to our database:
		mysqli_select_db($connection, $dbname);
		$query = "DELETE FROM users WHERE username='$field'";
		$result = mysqli_query($connection, $query);
		if ($result) {
			echo "user has been deleted<br>";
		} else {
			echo "No user has been deleted - error<br>";
		}
		// run query
		$query = "DELETE FROM users WHERE username='$field'";
		$result = mysqli_query($connection, $query);
		if ($result) {
			echo "deleted - user account";
		} else {
			echo "No user has been deleted - error <br>";
		}

		// Re-enable foreign key checks
		$sql = "SET FOREIGN_KEY_CHECKS=1";
		mysqli_query($connection, $sql);

		// we're finished with the database, close the connection:
		mysqli_close($connection);
	}

}


/////////////////////
// EDIT USER FUNCTION //
/////////////////////

function editUsers ($dbhost, $dbuser, $dbpass, $dbname, $field) {
	// connect to the host:
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	// exit the script with a useful message if there was an error:
	if (!$connection)
	{
		die("Connection failed: " . $mysqli_connect_error);
	}

	// connect to our database:
	mysqli_select_db($connection, $dbname);
	// run query to get the contents of the USERS table
	$query = "SELECT * FROM users WHERE username='$field'";
	$result = mysqli_query($connection, $query);
	$row = mysqli_fetch_assoc($result);
	// we're finished with the database, close the connection:
	mysqli_close($connection);
	// send back the associative array to be edited
	return $row;
}


// finish of the HTML for this page:
require_once "footer.php";

?>