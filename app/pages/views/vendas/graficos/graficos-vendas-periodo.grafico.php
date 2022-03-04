<?php

//~ $dataInicial = '2021-10-29';
//~ $dataFinal = '2022-02-14';

$dataInicial = postVar('datainicial');
$dataFinal = postVar('datafinal');


$sql = "SELECT
        DATE(emissao),
        SUM(situacaonfe = 'Autorizada') AS Autorizadas,
        SUM(situacaonfe = 'Emitida DANFE') AS EmitidasDanfe,
        SUM(situacaonfe = 'Cancelada') AS Canceladas,
        SUM(situacaonfe = 'Rejeitada') AS Rejeitadas
        FROM converse_nfesbling
        WHERE
        emissao BETWEEN DATE(:dinicial) AND DATE(:dfinal)
        GROUP BY DATE(emissao) ORDER BY emissao ASC";

$res = dbf($sql,array(':dinicial'=>$dataInicial,':dfinal'=>$dataFinal),'fetch');




for ($i = 0; $i < count($res); $i++)
{
  $dataRow            = $res[$i];
  $dt_emissao         = $dataRow['DATE(emissao)'];
  $nfe_autorizadas    = $dataRow['Autorizadas'];
  $nfe_emiDanfe       = $dataRow['EmitidasDanfe'];
  $nfe_canceladas     = $dataRow['Canceladas'];
  $nfe_rejeitadas     = $dataRow['Rejeitadas'];

  $tot_vendas         = $nfe_autorizadas+$nfe_emiDanfe;
  $vals[$dt_emissao]  = $tot_vendas;
}


?>


<script>
window.onload = function () {

//Better to construct options first and then pass it as a parameter
var options = {
	animationEnabled: true,
	title:{
		text: "Vendas no período"
	},
	axisY:{
		title:"Pedidos un."
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
      <?php
      foreach($vals as $key => $val){
      $ds = getWeekday($key);
      echo '{ y: '.'0'.' , label: "Dia '.swdate($key)."($ds)".'" },'."\n";
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

		<?php
      foreach($vals as $key => $val){
      $ds = getWeekday($key);
      echo '{ y: '.$val.' , label: "Dia '.swdate($key)."($ds)".'" },'."\n";
      }
		?>
		]
	}]
};

$("#chartContainer").CanvasJSChart(options);
}
</script>
