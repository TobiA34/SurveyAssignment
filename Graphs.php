<?php
require_once "header.php";
if (isset($_SESSION['loggedInSkeleton']) && ($_SESSION['username']=='admin')) {

    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if(!$connection) {

        die("Connection failed: " . $mysqli_connect_error);
    }



        $getSurveyAnswer = "SELECT survey_title FROM temp_survey";
        $getSurveyAnswerResult = mysqli_query($connection, $getSurveyAnswer);
        $getSurveyAnswerRows = mysqli_num_rows($getSurveyAnswerResult);

        if($getSurveyAnswerRows > 0) {

            $row = mysqli_fetch_assoc($getSurveyAnswerResult);
            for($i=0;$i>count($row);$i++){
               echo $row['survey_title'];
            }


        }
}


require_once "footer.php";
?>