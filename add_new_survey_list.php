<?php
    require_once "header.php";
    require_once "credentials.php";

    $name_errors = "";
    $usernames_errors = "";
    $showSurveyList = false;
    $errors = $name_errors = $usernames_errors;


    if(isset($_SESSION['loggedInSkeleton']))
    {
        if(isset($_SESSION['newLists']))
        {
            $name = $_GET['name'];
            $usernames = $_GET['username'];
        }

	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if (!$connection)
    {
        die("connection field: " . $mysqli_connect_error);
    }

    $name = sanitise($name, $connection);
    $usernames = sanitise($usernames,$connection);

    $errors = $name_errors . $usernames_errors;

    if($errors == "")
    {
        $sql = "INSERT INTO lists(name,username,created,updated) VALUES ('$name','$username','$created','$updated')";

        //no data returned, we just test for success or failure
        if (mysqli_query($connection, $sql))
        {
            echo "New List added";
            $showSurveyList = true;
        }
        else
        {
            die("Error inserting row:" . mysqli_error($connection));
        }
        // close connection
        mysqli_close($connection);
    }
        else
         {
             /// deal with server side errors";
             /// show form again, highlighting problems
             $showSurveyList = true;
         }
    }

    // user has arrived at the page for the first time
    else
    {
        $showSurveyList = true;

    }

    if($showSurveyList)
    {
        echo <<<_END
            <form action = "add_new_survey_list" method = "post" id="new_list" enctype="multipart/form-data">
                <h2>Add new Survey List</h2>
                <tr><th>Name</th></td><input size ="40" type="text" name = "name" minlength="1" maxlength="64" required><b>{$name_errors}</b></td><tr>
         _END;

        //check to see if the user is admin
        //The admin is able to create a new list for any site users
        if($_SESSION['username'] == 'admin')
        {
            ////Connect to database to get list of usernames
            /// Connect to host
            $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
            //exit with the script with a message about error
            if(!$connection)
            {
                die("Error inserting row:" . mysqli_error($connection));
            }
            // connect to database:
            mysqli_select_db($connection,$name);
            //run query to get the contents of the USERS Table
            $query = "SELECT username FROM users";
            //this will return the usernames from the table users
            $result = mysqli_query($connection,$result);
            //how many rows came back
            $n = mysqli_num_rows($result);
            echo "<tr><th> OWNER</th><td><select name=\"username\" required>";
            if($n>0)
            {
                for($i=0;$i < $n;$i++)
                {
                    $row = mysqli_fetch_assoc($result);
                    echo "<option value = \"{$row['username']}\">{$row['username']}</option>";
                }
                echo "</select>";
            }
        }
        else
         {
             echo "<tr><th>OWNER</th></td><input type=\"text\" name=\"username\"  minlength=\"1\" maxlength=\"32\" value=\"{$_SESSION['username']}\" readonly required>";
         }
    }


?>