<?php
require_once "header.php";
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
$result = mysqli_query($connection, "SELECT * FROM temp_survey");
//if($result){
//    echo "CONNECTED";
//}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Code', 'Continent', 'Region'],

                <?php

                if(mysqli_num_rows($result)> 0){

                    while($row = mysqli_fetch_array($result)){

                        echo "['".$row['Code']."', '".$row['Continent']."', ['".$row['Region']."']],";

                    }


                }



                ?>

            ]);
            var options = {
                chart: {
                    title: 'Company Performance',
                    subtitle: 'Sales, Expenses, and Profit: 2014-2017',
                    width: 5000,
                    height: 500
                }
            };

            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>

</head>
<body>

<div id="columnchart_material"></div>


</body>
</html>
