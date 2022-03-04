<!DOCTYPE HTML>
<html>
<head>
<script>

</script>
</head>
<body>
	
<div style="width:700px;height:500px;">
<div>
  <canvas id="myChart"></canvas>
</div>
</div>

<?php 
$char='';
$vhar='';
for ($i = 1; $i <= 30; $i++)
{
	if($i<=30){$s=', ';}else{$s='';}
	$char = $char.'"<a href="#">'.$i.'</a>"'.$s."\n";
	//$char = $char.$i.$s."";
	$vhar = $vhar.rand(0,13).$s;
}
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const labels = [
    <?php echo $char;?>
  ];

  const data = {
    labels: labels,
    datasets: [{
      label: 'Relatorio',
      backgroundColor: 'rgb(255, 99, 132)',
      borderColor: 'rgb(255, 99, 132)',
      data: [<?php echo $vhar;?>],
    }]
  };

  const config = {
    type: 'bar',
    data: data,
    options: {}
  };
  
  
function onClick(e){ 
        window.open(e.dataPoint.link,'_blank');  
};
  
</script>
<script>
  const myChart = new Chart(
    document.getElementById('myChart'),
    config
  );
</script>


</body>
</html>
