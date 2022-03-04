<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function () {

//Better to construct options first and then pass it as a parameter
var options = {
	animationEnabled: true,
	title:{
		text: "Vendas no período"
	},
	axisY:{
		title:"Volume de vendas"
	},
	toolTip: {
		shared: true,
		reversed: true
	},
	data: [{
		type: "stackedColumn",
		name: "Devoluções",
		showInLegend: "true",
		yValueFormatString: "#,##0 devolucoes",
		dataPoints: [

		<?php for ($i = 1; $i <= 30; $i++)
		{
			echo '{ y: '.rand(0,15).' , label: "Dia '.$i.'" },';
		}
		?>
		]
	},
	{
		type: "stackedColumn",
		name: "Vendas",
		showInLegend: "true",
		yValueFormatString: "#,##0 pedidos",
		dataPoints: [

		<?php for ($n = 1; $n <= 30; $n++)
		{
			echo '{ y: '.rand(0,6).' , label: "Dia '.$n.'" },';
		}
		?>
		]
	}]
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
