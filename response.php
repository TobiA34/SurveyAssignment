<?php
require_once "header.php";
if (isset($_SESSION['loggedInSkeleton']) && ($_SESSION['username']=='admin')) {

    //connection to the database
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if (!$connection) {

        die("Connection failed: " . $mysqli_connect_error);
    }


    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    // connect to our database:
    mysqli_select_db($connection, $dbname);
    // run query to get the contents of the USERS table
    $query = "SELECT survey_answer,survey_title FROM temp_survey";
    // this query can return data ($result is an identifier):
    $result = mysqli_query($connection, $query);
    // how many rows came back?:
    $n = mysqli_num_rows($result);


    mysqli_select_db($connection, $dbname);
    // run query to get the contents of the USERS table
    $query2 = "SELECT survey_title FROM temp_survey";
    // this query can return data ($result is an identifier):
    $result2 = mysqli_query($connection, $query2);
    // how many rows came back?:
    $n2 = mysqli_num_rows($result2);




    if ($n > 0) {
        for ($i = 0; $i < 1; $i++) {
            $row = mysqli_fetch_assoc($result);
            // display so html
            echo <<<_END
            <table class="table_colour">
            <tr class="table_colour">
            <th class="table_colour">Number of response</th>
            </tr>
            <tr class="table_colour">
            <td id ="num_response_total">$n</td>
            </tr>
            </table class="table_colour">
            
            <br>
            <br>
            <br>       
_END;

        }
    }


    if ($n2 > 0) {
        for ($i = 0; $i < 1; $i++) {
            $row2 = mysqli_fetch_assoc($result2);
            // display some html
            echo <<<_END
            <table class="table_colour">
            <tr class="table_colour">
            <th class="table_colour">Number of questions</th>
            </tr>
            <trclass="table_colour">
            <td id ="num_response_total">$n2</td>
            </tr>
            </table>
_END;

        }
    }

    // simple query to get all columns out of the database
    $sql = "SELECT * FROM temp_survey";
    // execute the query
    $result = mysqli_query($connection, $sql);

    echo <<<_END
                <br>
                <br>
                <br>
                <th >Number of questions and Answer</th>

_END;

    while ($row = mysqli_fetch_assoc($result)) { // Important line !!! Check summary get row on array ..
        echo "<tr>";
        for($i=1;$i<2;$i++) { // I you want you can right this line like this: foreach($row as $value) {
//            echo "<td>" . $value . "</td>"; // I just did not use "htmlspecialchars()" function.
            echo <<<_END
            <table class="table_colour">
            <tr class="table_colour">
             </tr> 
            <tr>
            <td id ="class="table_colour"">
            <tr class="table_colour"><td>{$row['survey_title']}</td>
            <tr class="table_colour"><td>{$row['survey_answer']}</td>
            </td>
            </tr>
            </table>
_END;
        }
        echo "</tr>";
    }


}

require_once "footer.php";
?>