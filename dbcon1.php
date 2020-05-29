<!DOCTYPE html>
<html>
<head>
	<script src="chartsloader.js"></script>
<script type="text/javascript">


var dbr = <?php
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM project where count > 1 and word not like '\'%' and word not REGEXP '[0-9]' and word not in ('twitter','tweet','location','add','website','share','code','developer','updates','topic','information','try','instant','copying','learn','instantly')";
$result = $conn->query($sql);

$conn->close();
echo json_encode($result->fetch_all());
//delete *from project; //Because we need to delete data from table for using next time.
?>;

console.log(typeof dbr);

google.charts.load('current', {packages: ['corechart']});
google.charts.load('current', {'packages':['table']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      // Define the chart to be drawn.
      
      
      //const jsonData = JSON.parse(JSON.stringify(dbr));
	  //console.log("jsonData", jsonData);
	  console.log(dbr);
	  for(i=0;i<dbr.length;i++){
      dbr[i][1] = Number(dbr[i][1]); //It's an array of two-columned arrays. 0th column is words and 1st column is number
    }
	  var data = google.visualization.arrayToDataTable(dbr,true); //false if there are headers
       var options = {
          title: 'Keywords',
          is3D: true,
        };
        var options1 = {
          title: 'Keywords',
          pieHole : 0.4,
        };
        var options2 = {
          title: 'Keywords',
          legend: 'none',
          pieSliceText: 'label',
          slices: {  4: {offset: 0.2},
                    12: {offset: 0.3},
                    14: {offset: 0.4},
                    15: {offset: 0.5},
                    50 :{offset: 0.6},
                    75 :{offset: 0.7},
                    100 :{offset: 0.5},
                    125 :{offset: 0.4},
                    150 :{offset: 0.6},
                    175 :{offset: 0.3},
                    200 :{offset: 0.6},
                    225 :{offset: 0.5},
          },
        };
        
      // Instantiate and draw the chart.
      /*
      var chart = new google.visualization.PieChart(document.getElementById('myPieChart'));
      chart.draw(data, options);
      var chart = new google.visualization.ColumnChart(document.getElementById('myColumnChart'));
      chart.draw(data, options);
      var chart = new google.visualization.ScatterChart(document.getElementById('myScatterChart'));
      chart.draw(data, options);
      var chart = new google.visualization.BarChart(document.getElementById('myBarChart'));
      chart.draw(data, options);
      var chart = new google.visualization.PieChart(document.getElementById('myDonutChart'));
      chart.draw(data, options1);
      var chart = new google.visualization.PieChart(document.getElementById('mySliceChart'));
      chart.draw(data, options2);
      */
      var table = new google.visualization.Table(document.getElementById('table_div'));
	    table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
      
      

    }
</script>
<script>
  var newshit=<?php  
session_start(); 
    $myVar = $_SESSION['varName'];
    echo $myVar;
    ?>;
    console.log(typeof newshit);
    console.log(newshit);
</script>
<p id="paragp" >
  </p>
<!--new function for tabs-->
<script>
  function drawChartsnew(chartname) {
      console.log(dbr);
	  for(i=0;i<dbr.length;i++){
      dbr[i][1] = Number(dbr[i][1]); //It's an array of two-columned arrays. 0th column is words and 1st column is number
    }
	  var data = google.visualization.arrayToDataTable(dbr,true); //false if there are headers
       var options = {
          title: 'Keywords',
          is3D: true,
        };
        var options1 = {
          title: 'Keywords',
          pieHole : 0.4,
        };
        var options2 = {
          title: 'Keywords',
          legend: 'none',
          pieSliceText: 'label',
          slices: {  4: {offset: 0.2},
                    12: {offset: 0.3},
                    14: {offset: 0.4},
                    15: {offset: 0.5},
                    50 :{offset: 0.6},
                    75 :{offset: 0.7},
                    100 :{offset: 0.5},
                    125 :{offset: 0.4},
                    150 :{offset: 0.6},
                    175 :{offset: 0.3},
                    200 :{offset: 0.6},
                    225 :{offset: 0.5},
          },
        };
        
        if(chartname=='PieChart'){
          var chart = new google.visualization.PieChart(document.getElementById('chart'));
          chart.draw(data, options);
        }
        else if(chartname=='ColumnChart'){
          var chart = new google.visualization.ColumnChart(document.getElementById('chart'));
          chart.draw(data, options);
        }
        else if(chartname=='ScatterChart'){
          var chart = new google.visualization.ScatterChart(document.getElementById('chart'));
          chart.draw(data, options);
        }
        else if(chartname=='BarChart'){
          var chart = new google.visualization.BarChart(document.getElementById('chart'));
          chart.draw(data, options);
        }
        else if(chartname=='DonutChart'){
          var chart = new google.visualization.PieChart(document.getElementById('chart'));
          chart.draw(data, options1);
        }
        else if(chartname=='SliceChart'){
          var chart = new google.visualization.PieChart(document.getElementById('chart'));
          chart.draw(data, options2);
        }
        var table = new google.visualization.Table(document.getElementById('table_div'));
	      table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
      }
  </script>




  <link rel="stylesheet" href="assets/css/main.css" />
  <style>
  body {
  background-color: #606060FF;
}
  </style>
</head>
<body>
<script>
  document.write('<h1 style="color:white;">Summary :'  + newshit + '</h1>');
</script>

<!-- Header -->
<header id="header">
	<h1><strong><a href="index.html">Keyword Extraction</a></h1>
	<nav id="nav">
		<ul>
			<li><a href="index.html">Home</a></li>
			<li><a href="about.html">About</a></li>
			<li><a href="contactus.html">Contact Us</a></li>
		</ul>
	</nav>
</header>

<a href="#menu" class="navPanelToggle"><span class="fa fa-bars"></span></a>


<!-- Identify where the chart should be drawn. -->
  <div id="table_div" style="width: 600px; height: 400px;"> </div>

  <br>

  <div class="w3-bar w3-black">
  <button class="w3-bar-item w3-button" onclick="drawChartsnew('PieChart')">PieChart</button>
  <button class="w3-bar-item w3-button" onclick="drawChartsnew('ColumnChart')">ColumnChart</button>
  <button class="w3-bar-item w3-button" onclick="drawChartsnew('ScatterChart')">ScatterChart</button>
  <button class="w3-bar-item w3-button" onclick="drawChartsnew('BarChart')">BarChart</button>
  <button class="w3-bar-item w3-button" onclick="drawChartsnew('DonutChart')">DonutChart</button>
  <button class="w3-bar-item w3-button" onclick="drawChartsnew('SliceChart')">SliceChart</button>
</div>

<br>
<div id="PieChart" class="tabcontent">
  <div id="chart" style="width: 1400px; height: 500px;"> </div></div>
  <br>


<!--
<br>
<div id="PieChart" class="tabcontent">
  <div id="myPieChart" style="width: 1400px; height: 500px;"> </div></div>
  <br>
<div id="ColumnChart" class="tabcontent">
  <div id="myColumnChart" style="width: 1400px; height: 500px;"> </div>
  <br>
<div id="ScatterChart" class="tabcontent">
  <div id="myScatterChart" style="width: 1400px; height: 500px;"> </div>
  <br>
<div id="BarChart" class="tabcontent">
  <div id="myBarChart" style="width: 1400px; height: 500px;"> </div>
  <br>
<div id="DonutChart" class="tabcontent">
  <div id="myDonutChart" style="width: 1400px; height: 500px;"> </div>
  <br>
<div id="SliceChart" class="tabcontent">
  <div id="mySliceChart" style="width: 1400px; height: 500px;"> </div>
  <br>
  <br>
-->
<?php
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "DELETE FROM project";
$conn->query($sql);


$conn->close();
?>


</body>
</html>