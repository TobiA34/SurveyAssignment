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
            <input name="survey_question" class="center_form_box" type = text maxlength="200" value="">
            <br>
            <br>
    </div>
    <input class="center_button"  name = "create_survey" type="submit" value="Create">
    <input class="center_button"  name ="add_question" type="submit" value="Add Question">

    </form>

    <div>
        <p id="custom_survey_title">-type in the textfield to set questions then click the add questions button to keep adding questions to survey</p>
        <p id="custom_survey_title">-type in the textfield to set questions then click the add questions button to keep adding questions to survey</p>
    </div>
</div>


_END;
}

//if (isset($_POST['submit_question'])){
//     echo "$survey_question";
//    // Do some insert into the database table
////    if(!$connection)
////    {
////        die("Connection failed: " . $mysqli_connect_error);
////    }
////    else
////    {
////        $sql = "INSERT INTO survey_question (title) VALUES ('$title')";
////        $result = mysqli_query($connection, $sql);
////    }
////    if ($result)
////    {
////        // show a successful signup message:
////        $message = "title,instructions added to database<br>";
////    }
////    else
////    {
////        $message = "title,instructions not added to the database<br>";
////    }
//}

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
            // store the survey type id in the foreign key
            $survey_type_fk_id = $row["survey_type_id"];
            // get the title from the object and store it in the survey title
            $survey_title = $survey_obj->getTitle();
            //get the instructions from the object and store it in the survey instructions
            $survey_instructions = $survey_obj->getInstructions();
            $userId = $_SESSION['username'];

           // store the insert statement into the variable
           $insertNewSuveryQuerySql = "INSERT INTO survey(title, instructions, survey_type_id, user_id) VALUES (" . "'" . $survey_title . "'," . "'" . $survey_instructions . "'," . $survey_type_fk_id . ",'" . $userId . "')";

            // Execute the insert into the survey
           mysqli_query($connection, $insertNewSuveryQuerySql);


           // Get the survey id based on the title, store in a variable
            $getSurveyId = "SELECT id FROM survey WHERE title = " . "'" . $survey_obj->getTitle() ."'";
            // execute the query
            $surveyIdResult = mysqli_query($connection, $getSurveyId);
            // get the number of rows
            $surveyIdRows = mysqli_num_rows($surveyIdResult);

            //check to see if the number of rows is greater than 0
            if($surveyIdRows > 0) {

                // fetch the values from the array
                $surveyIdValue = mysqli_fetch_assoc($surveyIdResult);

                $survey_fk_id = $surveyIdValue["id"];


                // Create the query to insert

                // INSERT INTO `survey_question`(`title`, `survey_id`) VALUES ("ddsas", 2)

                // get survey object from get questions
                $questions = $survey_obj->getQuestions();

                // loop through the number of questions
                for($i = 0; $i < count($questions); $i++){

                    //get the question at the index
                    $question = $questions[$i];

                     $insertNewSurveyQuestionsSql = "INSERT INTO survey_question(title,survey_id) VALUES(" . "'" . $question . "'," . $survey_fk_id .")";

                    mysqli_query($connection, $insertNewSurveyQuestionsSql);

                }

                // go to show_survey page
                header('Location:show_survey.php');


            }
        }
    }
}


include_once "footer.php";

?>



