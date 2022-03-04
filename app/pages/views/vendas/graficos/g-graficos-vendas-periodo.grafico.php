<?php
if(postVar('datainicial')!=''){$dataInicial = swdata(postVar('datainicial'));}
if(postVar('datafinal')!='')  {$dataFinal = swdata(postVar('datafinal'));}


$periodo = "Vendas diarias (".swdata($dataInicial)." até ".swdata($dataFinal).")";
/*
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
*/

$sql = "SELECT
        DATE(nfe_dataEmissao),
        ROUND(SUM(nfe_valorNota),2)
        FROM bs_notas
        WHERE
        nfe_tipo = 'S'
        AND (nfe_cfops = '5102' OR  nfe_cfops = '6108')
        AND DATE(nfe_dataEmissao) >= :dinicial
        AND DATE(nfe_dataEmissao) <= :dfinal
        AND (nfe_situacao = 'Autorizada'
        OR nfe_situacao = 'Emitida DANFE')
        ORDER BY `bs_notas`.`nfe_numero` ASC";



$res = dbf($sql,array(':dinicial'=>$dataInicial,':dfinal'=>$dataFinal),'fetch');




for ($i = 0; $i < count($res); $i++)
{
  $dataRow            = $res[$i];
  $dt_emissao         = $dataRow['DATE(nfe_dataEmissao)'];
  $nfe_autorizadas    = $dataRow['Autorizadas'];
  $nfe_emiDanfe       = $dataRow['EmitidasDanfe'];
  $nfe_canceladas     = $dataRow['Canceladas'];
  $nfe_rejeitadas     = $dataRow['Rejeitadas'];

  $tot_vendas         = $nfe_autorizadas+$nfe_emiDanfe;
  $vals[$dt_emissao]  = $tot_vendas;
}


?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Mês', 'Vendas', 'Despesas'],

      <?php
      foreach($vals as $key => $val){
      $ds = getWeekday($key);
      $dti = swdate($key)."($ds)";
      //echo '{ y: '.'0'.' , label: "Dia '.swdate($key)."($ds)".'" },'."\n";
      echo "['$dti',  $val,      0],\n";
      }
      ?>
    ]);

    var options = {
      title: 'Volume de vendas',
      hAxis: {title: '<?php echo $periodo;?>',  titleTextStyle: {color: '#333'}},
      vAxis: {minValue: 0}
    };

    var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }
</script>
