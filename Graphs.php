<?php
require_once "header.php";
if (isset($_SESSION['loggedInSkeleton']) && ($_SESSION['username']=='admin')) {

    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if(!$connection){

        die("Connection failed: " . $mysqli_connect_error);

        mysqli_select_db($connection,$dbname);
        $query = "SELECT * answer FROM survey_answer";
        $result = mysqli_query($connection,$query);
        $n = mysqli_num_rows($result);


        echo <<<_END
           <!--Load the AJAX API-->
           <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
           <script type="text/javascript">

           // Load the Visualization API and the corechart package.
           google.charts.load('current',{'packages' : ['corechart', 'controls']});
           
           google.charts.setOnLoadCallback(drawChart);
            
            
           function drawChart() {

        // Create the data table.
            var data = new google.visualization.DataTable();
                
                var jsonData = $.ajax({
                    url:"api/surveys.php?surveys=yes",
                    dataType:"json",
                    async: false               
                }).responseText;
                
                var data = new google.visualization.DataTable(jsonData);
                
                var stockData = new google.visualization.DataView(data);
                stockData.setColums(['Question name'],['answer']);
                
                
                var dashboard = new google.visualization.Dashbord({
                      document.getElementById('answer_div_dash');
                      
                       var slider = new google.visualization.ControlWrapper({
                'controlType': 'NumberRangeFilter',
                'containerId': 'answer_filter',
                'options':{
                    'filterColumnLabel': 'Answer',
             
                'ui':{
                    'orientation': 'Vertical'
                }
                 
                });
                
                
               
                
                var stockData = new google.visualization.DataView(Data);
                stockData.setColums(['Question Name'],['Answer']);
                
                var chart = new google.visualization.ChartWrapper({
                'chartType': 'ColumnChart',
                'containerId': 'stock_Column',
                'options':{
                    'title': 'Survey Answers',
                    'width': 800,
                    'height': 360,
                    'legend': 'none'
                }
                });
                
                  dashboard.bind(slider,chart);
                  dashboard.draw(stockData);
                


        
        _END;


    }

}


require_once "footer.php";
?>