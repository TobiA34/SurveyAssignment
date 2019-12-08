
<?php

include_once "header.php";

 //create myObject
require "SurveyObject.php";

$showQuestionPage = false;




$title = "";
$instruction = "";
$user_type = "";

$title_val = "";
$instruction_val = "";



//
//$survey_instruction = $_POST['survey_instructions'];
//$survey_title = $_POST['survey_title'];


if (!isset($_SESSION['loggedInSkeleton']))
{
    // user isn't logged in, display a message saying they must be:
    echo "You must be logged in to view this page.<br>";
}
else {


        echo <<<_END
<div class ="survey_custom_survey_form">
    <h2 class ="survey_title"> Custom Survey </h2>
    
  <form action="custom_survey_page.php" method="post">
    <div class="custom_survey_container">
        <h2>Set survey title</h2>
            <input class="center_form_box" name="survey_title" type = text required maxlength="200"  >
            <br>
            <br>
    </div>
    
        <div class="custom_survey_container">
        <h2>Set survey instructions</h2>
            <textarea class="center_form_box" type = "text" required max ="1" min="1" value="$instruction"  name="survey_instructions" ></textarea>
            <br>
            <br>
    </div>
    
    <div class="custom_survey_container">
        <h2>Set survey type</h2>
           <select name= "question_type" value="$user_type" id="select_choice">
                <option>Number</option>
                <option>Text</option>
                 <option>Select</option>
           </select>
 
    </div>   
    <input class ="button_style" type="submit"  name="saveInput" value="submit">
      </form>
    
</div>
_END;


    }

  if(!empty($_POST["saveInput"])) {

      $surveyObject = new SurveyObject();
      $surveyObject->setTitle($_POST['survey_title']);
      $surveyObject->setInstructions($_POST['survey_instructions']);
      $surveyObject->setSurveyType($_POST['question_type']);

      $_SESSION["new_survey"] = serialize($surveyObject);

      header('Location:survey_questions.php');
  }

  else
  {
      $message = "  failed to add title and instructions, please check the errors shown above and try again<br>";
}

// we're finished with the database, close the connection:

//if(isset($_POST["nextPage"])) {
//    // Check if any option is selected
//    echo "<p>you have clicked the next page button</p>";
//}
include_once "footer.php";
?>
