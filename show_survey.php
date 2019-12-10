<?php
require_once "header.php";
require "SurveyObject.php";

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
$survey_obj = unserialize($_SESSION['new_survey']);
$Number = 1;
$question = "Q";


echo <<<_END
    <h1 id="survey_title">{$_SESSION['username']} survey</h1>
      
_END;



$getSurveyId = "SELECT id FROM survey WHERE title = " . "'" . $survey_obj->getTitle() ."'";
$surveyIdResult = mysqli_query($connection, $getSurveyId);
$surveyIdRows = mysqli_num_rows($surveyIdResult);
$surveyIdValue = mysqli_fetch_assoc($surveyIdResult);
$survey_fk_id = $surveyIdValue["id"];

//SELECT `title` FROM survey_question WHERE survey_id = 1
$getSurveyQuestions = "SELECT title FROM survey_question WHERE survey_id = '$survey_fk_id'";
$surveyQuestionTitleResult = mysqli_query($connection, $getSurveyQuestions);
$surveyQuestionTitleRows = mysqli_num_rows($surveyQuestionTitleResult);







if ($surveyQuestionTitleResult->num_rows > 0){
    $surveyQuestionTitle = mysqli_fetch_assoc($surveyQuestionTitleResult);
    $questionTitle = $surveyQuestionTitle['title'];
 //     var_dump($survey_fk_id);


    $questions = $survey_obj->getQuestions();

         $questionNumber =  $question . $Number++;
         echo <<<_END
            <h2>Football</h2>
            <div class ="text_entry_container">
                <h2>$questionNumber</h2>
                
                <h2 class= "text_entry_title">$questionTitle</h2>
                <input name="survey_question" class="center_form_box" type = text maxlength="200" value="">
			</div>
_END;

}

//var_dump($surveyQuestionTitleRows);


require_once "footer.php";
?>