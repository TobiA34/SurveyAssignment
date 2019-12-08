<?php
// This script removes a SURVEY from a LIST - by removing the pairing
// bring in the credentials required to access the MySQL database
// notice the ".." prefix as we are ascending back up the directory structure
// since this script is in the "htdocs/api/" folder and credentials.php is in the parent folder

include_once "../credentials.php";
$allRows = "";

//check to see the caller has accessed the script with a post method
// and they have included a value for the paramater 'PairID'

if(!isset($_POST['PairID']))
{
    // set the kind of data we're sending back and an error response code:
    header("Content-Type: application/json", NULL, 400);
    //send
    echo json_encode($allRows);
    exit;
}
else
{
    //get the pairID value from the request
    $pairID = $_POST['pairID'];


    //connect directly to our database
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    //connect failed, return error
    if(!$connection){
        // set the kind of data we're sending back and an failure response code:
        header("Content-Type: application/json", NULL, 500);
        //send
        echo json_encode($allRows);
        //exit the script
        exit;
    }

    //delete the pairing between LIST and SURVEY from CONTENTS table
    $query = "DELETE From contents WHERE pairID='$pairID'";
    $result = mysqli_query($connection,$query);

    if($result){
        echo"deleted-list contents <br>";
    }


}
//we have finished closed the database
mysqli_close($connection);

//set the kind of data we're setting back and a success code
header("Content-Type: application/json", NULL, 200);
$allRows = $pairID;
echo json_encode($allRows);
?>