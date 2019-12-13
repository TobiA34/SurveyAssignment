<?php
require_once "header.php";
require "SurveyObject.php";

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
$survey_obj = unserialize($_SESSION['new_survey']);
$Number = 1;
$question = "Q";






$getSurveyId = "SELECT * FROM survey WHERE title = " . "'" . $survey_obj->getTitle() ."'";
$surveyIdResult = mysqli_query($connection, $getSurveyId);
$surveyIdRows = mysqli_num_rows($surveyIdResult);
$surveyIdValue = mysqli_fetch_assoc($surveyIdResult);
$survey_fk_id = $surveyIdValue["id"];
$survey_type_id = $surveyIdValue['survey_type_id'];
$surveyTitle = $surveyIdValue["title"];

echo <<<_END
    <h1 id="survey_title">{$_SESSION['username']} survey</h1>
    <div id="custom_survey_container">
    <img  id ="survey_png" src="Images/survey.png">
    <h3 id="custom_survey_title">$surveyTitle</h3>
    <br>
    <br>
_END;

//SELECT `title` FROM survey_question WHERE survey_id = 1
$getSurveyQuestions = "SELECT * FROM survey_question WHERE survey_id = '$survey_fk_id'";
$surveyQuestionTitleResult = mysqli_query($connection, $getSurveyQuestions);
$surveyQuestionTitleRows = mysqli_num_rows($surveyQuestionTitleResult);






if ($surveyQuestionTitleResult->num_rows > 0){
    $surveyQuestionTitle = mysqli_fetch_assoc($surveyQuestionTitleResult);
    $questionTitle = $surveyQuestionTitle['title'];
    $surveyQuestionID = $surveyQuestionTitle['id'];

    $questions = $survey_obj->getQuestions();
    $type = $survey_obj->getSurveyType();

//    $questions = $survey_obj->getQuestions();
    for($i = 0; $i < count($questions); $i++) {

        $questionTitles = $questions[$i];
        $questionNumber = $question . $Number++;
        if ($survey_type_id = $type) {
            echo <<<_END
        <div id="show_survey_Container">
           
             <div class ="text_entry_container">
                <h2>$questionNumber</h2>
                <form  action="show_survey.php" method="post">
                <h2 class= "text_entry_title">$questionTitles</h2>
                <input name ="question" class="center_form_box" $type >
			</div>
        </div>
       
        
_END;
        }
    }
}



echo <<<_END
    
    <input type = "submit" name="save_answer" class="center_button">
    </form>
    </div>
_END;

if(isset($_POST['save_answer'])) {

    getSurveyID($dbhost, $dbuser, $dbpass, $dbname);
    getUserID($dbhost, $dbuser, $dbpass, $dbname);
    getQuestionID($dbhost, $dbuser, $dbpass, $dbname);


}

function getSurveyID($dbhost, $dbuser, $dbpass, $dbname){
     $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    $survey_obj = unserialize($_SESSION['new_survey']);

    // Get the survey id based on the title, store in a variable
    $getSurveyId = "SELECT id FROM survey WHERE title = ". "'" . $survey_obj->getTitle() . "'";
    $surveyIdResult = mysqli_query($connection, $getSurveyId);
    $surveyIdRows = mysqli_num_rows($surveyIdResult);

    if($surveyIdRows > 0) {

        $surveyIdValue = mysqli_fetch_assoc($surveyIdResult);

        $survey_fk_id = $surveyIdValue["id"];





        for($i = 0; $i < count($surveyIdRows); $i++){

 //                    var_dump($question);

            $insertNewSurveyID = "INSERT INTO survey_answer(survey_id) VALUES('$survey_fk_id')";

            mysqli_query($connection, $insertNewSurveyID);

        }
}

function getUserID($dbhost, $dbuser, $dbpass, $dbname){
        $survey_obj = unserialize($_SESSION['new_survey']);
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

        $userId = $_SESSION['username'];
        $surveyIdResult = mysqli_query($connection, $getSurveyId);
        $surveyIdRows = mysqli_num_rows($surveyIdResult);



        mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);



    }


function getQuestionID($dbhost, $dbuser, $dbpass, $dbname)
{
    mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    $survey_obj = unserialize($_SESSION['new_survey']);
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    $getSurveyQuestionId = "SELECT id FROM survey_question WHERE title = " . "'" . $survey_obj->getTitle() . "'";
    $surveyQuestionIdResult = mysqli_query($connection, $getSurveyQuestionId);
    $surveyQuestionIdRows = mysqli_num_rows($surveyQuestionIdResult);
    $questions = $survey_obj->getQuestions();

    //Get question ID

    //Insert into question ID
    if ($surveyQuestionIdRows > 0) {

        $surveyQuestionIdValue = mysqli_fetch_assoc($surveyQuestionIdResult);

        $survey_fk_id = $surveyQuestionIdValue["id"];


        for ($i = 0; $i < count($questions); $i++) {

            //                    var_dump($question);

            $insertNewSurveyID = "INSERT INTO survey_answer(survey_id) VALUES('$survey_fk_id')";

            mysqli_query($connection, $insertNewSurveyID);

        }

    }
  }
}
require_once "footer.php";
?>