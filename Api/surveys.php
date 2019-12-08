<?php
// This script simply returns ALL of the SURVEY contained in the SURVEY table
// bring in the credentials required to access the MySQL database
// notice the ".." prefix as we are ascending back up the directory structure
// since this script is in the "htdocs/api/" folder and credentials.php is in the parent folder

include_once "../credentials.php";

//Declare some empty variables to store the data we'll send back to caller
$thisRow = array();
$allRows = array();

if(!isset($_POST['surveys']))
{
    // set the kind of data we're sending back and an error response code:
    header("Content-Type: application/json", NULL, 400);
    //send
    echo json_encode($allRows);
    exit;
}

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

$query = "SELECT surveyTitle,surveyType,answer FROM survey ORDER BY surveyTitle";

// this will return the data
$result = mysqli_query($connection,$query);

//how many rows come back
$n = mysqli_num_rows($result);


//if we have some data store inside a big array
if($n > 0)
{
    $allRows['cols'][] = array('id' => '', 'label' => 'title','type' => 'String');
    $allRows['cols'][] = array('id' => '', 'label' => 'surveyType','type' => 'String');
    $allRows['cols'][] = array('id' => '', 'label' => 'answer','type' => 'String');


//loop over all rows , adding them into our array:
for($i = 0; $i < $n; $i++)
{
    //fetch one row as an associative array
    $thisRow = mysqli_fetch_assoc($result);
    //add current row to all the rows to be sent back
    $allRows['rows'][] = array('c' => array( array('v'=>$thisRow['surveyTitle']), array('v'=>$thisRow['surveyType']), array('v'=>$thisRow['answers'])));

}
}

//we have finished closed the database
mysqli_close($connection);

//set the kind of data we're setting back and a success code
header("Content-Type: application/json", NULL, 200);
 echo json_encode($allRows);
?>