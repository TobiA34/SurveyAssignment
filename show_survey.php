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


function surveyTypeNumberfield(){
    if ($survey_type_id = 1){
        echo <<<_END
        <input  class="center_form_box" type = number max="10" value=""> 
_END;
    }
}

// if ($survey_type_id = 2){
//    echo <<<_END
//        <input   class="center_form_box" type = text maxlength="200" value="">
//_END;
// }

function surveyTypeSelect(){
    if ($survey_type_id = 2){
        echo <<<_END
        <input  class="center_form_box" type = text maxlength="200" value=""> 
_END;
    }
}



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
                <input class="center_form_box" $type >
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

//var_dump($surveyQuestionTitleRows);


require_once "footer.php";
?>