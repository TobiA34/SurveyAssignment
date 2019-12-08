<?php
include_once "header.php";
require "SurveyObject.php";

 $showQuestionForm = false;
$message = "";
$survey_question = "";
$survey_question_val = "";


if (!isset($_SESSION['loggedInSkeleton']))
{
    // user isn't logged in, display a message saying they must be:
    echo "You must be logged in to view this page.<br>";
}

elseif (isset($_POST['username']))
{
    // user just tried to sign up:

    // connect directly to our database (notice 4th argument) we need the connection for sanitisation:
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    // if the connection fails, we need to know, so allow this exit:
    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }

    // SANITISATION (see helper.php for the function definition)

    // take copies of the credentials the user submitted, and sanitise (clean) them:
//    $survey_question = sanitise($_POST['survey_question'], $connection);
//    $_SESSION['survey_page'] = $survey_question;



    // VALIDATION (see helper.php for the function definitions)
    // now validate the data (both strings must be between 1 and 200 characters long):

    $survey_question_val = validateString($survey_question, 1, 200);

    // concatenate all the validation results together ($errors will only be empty if ALL the data is valid):
    $errors = $survey_question_val;

    // check that all the validation tests passed before going to the database:
    if ($errors == "")
    {

        // try to insert the new details:
        $query = "INSERT INTO survey_question (title) VALUES ('$survey_question')";

        $result = mysqli_query($connection, $query);

        // no data returned, we just test for true(success)/false(failure):
        if ($result)
        {
            // show a successful signup message:
            $message = "set question was succsesful<br>";
        }
        else
        {
            // show the form:
            $showQuestionForm = true;
            // show an unsuccessful signup message:
            $message = "set question was not succsesful<br>";
        }

    }

    else
    {
        // validation failed, show the form again with guidance:
        $showQuestionForm = true;
        // show an unsuccessful signin message:
        $message = "Sign up failed, please check the errors shown above and try again<br>";
    }

    // we're finished with the database, close the connection:
    mysqli_close($connection);

}

else
{
    // just a normal visit to the page, show the signup form:
    $showQuestionForm = true;

}

if ($showQuestionForm)
{
// show the form that allows users to sign up
// Note we use an HTTP POST request to avoid their password appearing in the URL:
    echo <<<_END
<div class ="survey_custom_survey_form" xmlns="http://www.w3.org/1999/html">
    <h2 class ="survey_title"> Survey question</h2>


    <div class="custom_survey_container">
        <h2>Set survey question</h2>
        <form action="survey_questions.php" method="POST">
            <input name="survey_question" class="center_form_box" type = text required maxlength="200" value="$survey_question">
            <br>
            <br>
    </div>
    <input class="center_button"  name = "create_survey" type="submit" value="Create">
    <input class="center_button"  name ="add_question" type="submit" value="Add Question">

    </form>
    <a class="center_button" href="custom_survey_page.php">
        <button id="back_page_button">Back</button>
    </a>
        <a class="center_button" href="custom_survey_page.php">
        <button id="back_page_button">Show survey</button>
    </a>
    
    </a>
</div>


_END;
}

if (isset($_POST['submit_question'])){
     echo "$survey_question";
    // Do some insert into the database table
//    if(!$connection)
//    {
//        die("Connection failed: " . $mysqli_connect_error);
//    }
//    else
//    {
//        $sql = "INSERT INTO survey_question (title) VALUES ('$title')";
//        $result = mysqli_query($connection, $sql);
//    }
//    if ($result)
//    {
//        // show a successful signup message:
//        $message = "title,instructions added to database<br>";
//    }
//    else
//    {
//        $message = "title,instructions not added to the database<br>";
//    }
}

if (isset($_POST['add_question'])){

    if (isset($_SESSION['new_survey'])) {

        $survey_obj = unserialize($_SESSION['new_survey']);
        $survey_obj->setQuestions($_POST["survey_question"]);

        $_SESSION["new_survey"] = serialize($survey_obj);
    }
}

// Checking to create survey
if(isset($_POST['create_survey'])) {

    // Making sure survey object isn't null
    if(isset($_SESSION['new_survey'])) {

        // Getting the survey object
        $survey_obj = unserialize($_SESSION['new_survey']);

        // Start connection
        $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
        if (!$connection)
        {
            die("Connection failed: " . $mysqli_connect_error);
        }

        // Build query to filter out survey type
        $getSurveyTypeQuerySql = "SELECT survey_type_id from survey_type WHERE type = " . "'" . $survey_obj->getSurveyType() . "'";

        $result = mysqli_query($connection, $getSurveyTypeQuerySql);

        $n = mysqli_num_rows($result);

        // Making sure we have more than one row back
        if ($n > 0) {

            // Get the first row so we can extract values
            $row = mysqli_fetch_assoc($result);
            $survey_type_fk_id = $row["survey_type_id"];
            $survey_title = $survey_obj->getTitle();
            $survey_instructions = $survey_obj->getInstructions();
            $userId = $_SESSION['username'];

            // INSERT INTO survey(`title`, `instructions`, `survey_type_id`, `user_id`) VALUES ("Adsda","Make sure you fill in the database",1,"mandyb")
           $insertNewSuveryQuerySql = "INSERT INTO survey(title, instructions, survey_type_id, user_id) VALUES (" . "'" . $survey_title . "'," . "'" . $survey_instructions . "'," . $survey_type_fk_id . ",'" . $userId . "')";

           // Execute the insert into the survey
           mysqli_query($connection, $insertNewSuveryQuerySql);

           // Get the survey id based on the title, store in a variable

           //


           // var_dump($survey_obj->getQuestions());


        }


    }
}


function getID($dbhost, $dbuser, $dbpass, $dbname)
{

   $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }

 // Check connection
    $query = "SELECT username FROM users WHERE username ='admin'";
    $result = mysqli_query($connection, $query);
    $n = mysqli_num_rows($result);

if ($n > 0) {
    for ($i = 0; $i < $n; $i++) {
        // fetch one row as an associative array (elements named after columns):
        $row = mysqli_fetch_assoc($result);
        // set the size of the bar to plot based upon number of votes versus total votes
        echo "'{$row['username']}'";
    }
}

}




include_once "footer.php";

?>



