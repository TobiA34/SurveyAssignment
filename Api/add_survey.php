<?php
// This script adds a survey to a  list
// bring in the credentials required to access the MySQL database
// notice the ".." prefix as we are ascending back up the directory structure
// since this script is in the "htdocs/api/" folder and credentials.php is in the parent folder

include "../credentials.php";
$allRows ="";

// check to make sure the caller has accessed the script with a POST request
// and that they have included a value fo the parameter 'SurveyID'

if(!isset($_POST['surveyID']))
{
    // set the kind of data we're sending back and an error response code:
    header("Content-Type: application/json", NULL, 400);
    //send
    echo json_encode($allRows);
    exit;
}
else
{
  //get the surveyID and content_id from POST REQUEST
  // so we know which LIST to add which Survey to
  $surveyID = $_POST['surveyID'];
  $listID = $_POST['listID'];

  // connect to the database
  $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

  // connection failed, return an error:
if(!$connection)
{
    // set the kind of data we're sending back and an failure response code:
    header("Content-Type: application/json", NULL, 500);
    //send
    echo json_encode($allRows);
    //exit the script
    exit;
}

  //add new list/survey
  $query = "INSERT INTO contents(listID,surveyID) VALUES('$surveyID','$listID') ";
  $result = mysqli_query($connection,$query);
  if($result)
  {
      echo "added - survey to list <br>";
  }
  else
  {
      echo "List contents not deleted - error";
  }
}

//we have finished closed the database
mysqli_close($connection);

//set the kind of data we're setting back and a success code
header("Content-Type: application/json", NULL, 200);
$allRows = $surveyID;
echo json_encode($allRows);
?>