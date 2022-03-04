<?php
if(postVar('datainicial')==''){$dataInicial = '2021-10-29';}else{$dataInicial = swdata(postVar('datainicial'));}
if(postVar('datafinal')=='')  {$dataFinal = date('Y-m-d');}else{$dataFinal = swdata(postVar('datafinal'));}


$sql = "SELECT
        emissao,
        MONTH(emissao),
        SUM(situacaonfe = 'Autorizada') AS Autorizadas,
        SUM(situacaonfe = 'Emitida DANFE') AS EmitidasDanfe,
        SUM(situacaonfe = 'Cancelada') AS Canceladas,
        SUM(situacaonfe = 'Rejeitada') AS Rejeitadas
        FROM converse_nfesbling
        WHERE
        emissao BETWEEN DATE(:dinicial) AND DATE(:dfinal)
        GROUP BY MONTH(emissao)
        ORDER BY DATE(emissao) ASC";

$res = dbf($sql,array(':dinicial'=>$dataInicial,':dfinal'=>$dataFinal),'fetch');




for ($i = 0; $i < count($res); $i++)
{
  $dataRow            = $res[$i];
  $dt_emissao         = $dataRow['emissao'];
  //$dt_emissao         = $dataRow['MONTH(emissao)'];
  $nfe_autorizadas    = $dataRow['Autorizadas'];
  $nfe_emiDanfe       = $dataRow['EmitidasDanfe'];
  $nfe_canceladas     = $dataRow['Canceladas'];
  $nfe_rejeitadas     = $dataRow['Rejeitadas'];

  $tot_vendas         = $nfe_autorizadas+$nfe_emiDanfe;
  $vals[$dt_emissao]  = $tot_vendas;
}

function mesPT($str){
  $str = str_replace('January','Jan',$str);
  $str = str_replace('February','Fev',$str);
  $str = str_replace('March','Mar',$str);
  $str = str_replace('April','Abr',$str);
  $str = str_replace('May','Mai',$str);
  $str = str_replace('June','Jun',$str);
  $str = str_replace('July','Jul',$str);
  $str = str_replace('August','Ago',$str);
  $str = str_replace('Septemper','Set',$str);
  $str = str_replace('October','Out',$str);
  $str = str_replace('November','Nov',$str);
  $str = str_replace('December','Dez',$str);
  return $str;
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
      //$ds = getWeekday($key);
      //$dti = swdate($key)."($ds)";

      $time=strtotime($key);
      $month=date("F",$time);
      $year=date("Y",$time);

      $mes = mesPT("$month/$year");
      //echo '{ y: '.'0'.' , label: "Dia '.swdate($key)."($ds)".'" },'."\n";
      echo "['$mes',  $val,      0],\n";
      }
      ?>
    ]);

    var options = {
      title: 'Volume de vendas',
      hAxis: {title: 'Vendas mensais',  titleTextStyle: {color: '#333'}},
      vAxis: {minValue: 0}
    };

    var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }
</script>
