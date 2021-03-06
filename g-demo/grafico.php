<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function () {

//Better to construct options first and then pass it as a parameter
var options = {
	title: {
		text: "Column Chart in jQuery CanvasJS"              
	},
	data: [              
	{
		// Change type to "doughnut", "line", "splineArea", etc.
		type: "column",
		dataPoints: [
		<?php for ($i = 1; $i <= 30; $i++)
		{
			echo '{ label: "'.$i.'",  y: '.rand(0,15).'  },';
		}
		?>
		]
	}
	]
};

$("#chartContainer").CanvasJSChart(options);
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
</body>
</html>
