<?php
 session_start();
 $email=$_SESSION['email'];

$dataPoints = array();
$data = array();

try{

    $link = new \PDO(   'mysql:host=localhost;dbname=coincount;charset=utf8mb4', //'mysql:host=localhost;dbname=canvasjs_db;charset=utf8mb4',
                        'root',
                        '', 
                        array(
                            \PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            \PDO::ATTR_PERSISTENT => false
                        )
                    );
	
    $handle = $link->prepare("select description, sum(amount) as amount  from transactions where email= '$email' group by description"); 
    $handle->execute(); 
    $result = $handle->fetchAll(\PDO::FETCH_OBJ);
		
    foreach($result as $row){
        array_push($dataPoints, array("label"=> $row->description, "y"=> $row->amount));
    }

    $handle1 = $link->prepare("select month, sum(amount) as amount  from transactions where email= '$email' group by month"); 
    $handle1->execute(); 
    $result1 = $handle1->fetchAll(\PDO::FETCH_OBJ);
    foreach($result1 as $row1){
        array_push($data, array("label"=> $row1->month, "y"=> $row1->amount));
    }
	$link = null;
}
catch(\PDOException $ex){
    print($ex->getMessage());
}
	
?>


<!DOCTYPE HTML>
<html>
<head>
    <style>
        .total {
    flex-basis: 100%;
    margin-top: 20px;
    text-align:center;

    padding :30px 30px 30px 30px;
    display: flex;
}
    </style>
<script>
window.onload = function() {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "dark2",
	title:{
		text: "Expenses "
	},
	axisY: {
		title: "Amount (in Rs)"
	},
	data: [{
		type: "column",
		yValueFormatString: "#,##0.## Rs",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();

var pi = new CanvasJS.Chart("pichartContainer", {
	animationEnabled: true,
	theme: "dark2",
	title:{
		text: "Expenses"
	},
	axisY: {
		title: "Amount (in Rs)"
	},
	data: [{
		type: "pie",
		yValueFormatString: "#,##0.## Rs",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});


pi.render();



var line = new CanvasJS.Chart("linechartContainer", {
	animationEnabled: true,
	theme: "dark2",
	title:{
		text: "Monthly Expenses"
	},
	axisY: {
		title: "Amount (in Rs)"
	},
	data: [{
		type: "line",
		yValueFormatString: "#,##0.## Rs",
		dataPoints: <?php echo json_encode($data, JSON_NUMERIC_CHECK); ?>
	}]
});


line.render();




 
}
</script>
</head>
<body>
    <br>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<br>

<div class="total">

<div id="pichartContainer" style="height: 370px; width: 100%;"></div>
&nbsp;&nbsp;
<div id="linechartContainer" style="height: 370px; width: 100%;"></div>

</div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html>                              