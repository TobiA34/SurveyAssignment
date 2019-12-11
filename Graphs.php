<?php
require_once "header.php";
if (isset($_SESSION['loggedInSkeleton']) && ($_SESSION['username']=='admin')) {

    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);



    if(!$connection) {

        die("Connection failed: " . $mysqli_connect_error);
    }
    else{

        $getSurvey = "SELECT COUNT(*) FROM temp_survey";
        $surveyIdResultn = mysqli_query($connection, $getSurvey);
        $surveyIdRowsl = mysqli_num_rows($surveyIdResultn);

        if($surveyIdRowsl > 0) {

            $surveyIdValuef = mysqli_fetch_assoc($surveyIdResultn);
//            $surveyIdValuef['survey_answers'];

            var_dump($surveyIdValuef);



            }



        }


}


require_once "footer.php";
?>