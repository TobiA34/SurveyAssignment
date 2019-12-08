<?php
// This script gets the contents (SURVEYS) from a specified LIST
// If the caller is the ADMIN user, they can access ALL toy LISTS
// Otherwise, a caller can only see their OWN LISTS
// bring in the credentials required to access the MySQL database
// notice the ".." prefix as we are ascending back up the directory structure
// since this script is in the "htdocs/api/" folder and credentials.php is in the parent folder

include_once "../credentials.php";

//Declare some empty variables to store the data we'll send back to caller
$thisRow = array();
$allRows = array();

//check to make sure the caller has accessed the script with POST
// and that they have included the parameters required for it to the function

if((isset($_POST['id']) || (isset($_POST['username']))))
{
     // set the kind of data we're sending back and an error response code:
    header("Content-Type: application/json", NULL, 400);
    //send
    echo json_encode($allRows);
    exit;
}
elseif (isset($_POST['id']) || (isset($_POST['username'])))
{
    // store the list ID and username locally
    $id = $_POST['id'];
    $usernames = $_POST['username'];

    //connect directly to our database
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    //connect failed, return error
    if(!$connection)
    {
        // set the kind of data we're sending back and an failure response code:
        header("Content-Type: application/json", NULL, 500);
        //send
        echo json_encode($allRows);
        //exit the script
        exit;
    }

    // has the POST come from an ADMIN user?
    if($usernames == "admin")
    {
        //create the query
        $query = "SELECT * FROM contents INNER JOIN survey on contents.surveyID=survey.id INNER JOIN lists on contents.listID=list.id WHERE listID ='$id' AND lists.username='$usernames'";

    }
    // this will return the data
    $result = mysqli_query($connection,$query);

    //how many rows will come back
    $n = mysqli_num_rows($result);

    //if we got some results then add them into our big array
    if($n > 0)
    {

        //loop over all rows, adding them into our array

        for($i = 0; $i < $n; $i++)
        {
            //fetch one row as an associative array
            $thisRow = mysqli_fetch_assoc($result);

            //add current row to all the rows to be sent back
            $allRows[] = $thisRow;
        }
    }

    //we have finished closed the database
    mysqli_close($connection);

//set the kind of data we're setting back and a success code
    header("Content-Type: application/json", NULL, 200);

    echo json_encode($allRows);


}
?>