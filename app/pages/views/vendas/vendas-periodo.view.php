<?php
$di = postVar('datainicial');
$df = postVar('datafinal');
$pe = postVar('periodo');
if($di!=''&&$df!=''){$pe='';}
if($pe!=''){$di='';$df='';}
?>

<form method="post" action="?opt=vendas&view=vendas-periodo&visao=<?php echo getVar('visao');?>&grafico=bars">
  <input type="hidden" id="showgraph" name="showgraph" value="bar-graph-vendas-periodo" />
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="inputEmail4">Intervalo</label>

      <select id="periodo" name="periodo" class="form-control" <?php if(getVar('visao')=='semanal'||getVar('visao')=='diaria'){echo '';}else{echo ' disabled';}?>>
        <option value=""<?php echo selselr('',$pe);?>>Selecione</option>
        <option value="7"<?php echo selselr('7',$pe);?>>Últimos 7 dias</option>
        <option value="15"<?php echo selselr('15',$pe);?>>Últimos 15 dias</option>
        <option value="30"<?php echo selselr('30',$pe);?>>Últimos 30 dias</option>
        <option value="all"<?php echo selselr('all',$pe);?>>Período completo</option>
      </select>
    </div>
    <div class="form-group col-md-4">
      <label for="datainicial">Data Inicial</label>
      <input type="text" class="form-control" id="datainicial" name="datainicial" value="<?php echo $di;?>">
    </div>
    <div class="form-group col-md-4">
      <label for="datafinal">Data Final</label>
      <input type="text" class="form-control" id="datafinal" name="datafinal" value="<?php echo $df;?>">
    </div>

  </div>
<button type="submit" class="btn btn-primary" id="dofilter">Filtrar</button>
</form>

<?php

if(postVar('datainicial')){
$dataInicial = date('Y-m-d', strtotime($date. ' - 7 days'));
$dataFinal = date('Y-m-d');
}
/*
 *
 *


$sql = "SELECT
        DATE(emissao),
        SUM(situacaonfe = 'Autorizada') AS Autorizadas,
        SUM(situacaonfe = 'Emitida DANFE') AS EmitidasDanfe,
        SUM(situacaonfe = 'Cancelada') AS Canceladas,
        SUM(situacaonfe = 'Rejeitada') AS Rejeitadas
        FROM converse_nfesbling
        WHERE
        emissao BETWEEN DATE(:dinicial) AND DATE(:dfinal)
        GROUP BY DATE(emissao) ORDER BY emissao DESC";

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

  //~ print_r($dataRow);
  //~ echo "<br />\n";
  //~ echo "$dt_emissao\n";
  //~ echo "<br />\n";

}



 * */


?>
<div id="chart_div" style="width: 100%; height: 500px;"></div>
<!--
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
-->


<?php

//~ if(count($trow)>0){
//~ echo 'Necessário montar tabela!'."<br />\n";

//~ print_r($trow);


//~ echo "<table>\n";


//~ for ($i = 0; $i < count($trow); $i++)
//~ {
  //~ $drow=$trow[$i];

  //~ if(isArray($drow)&&count($drow)>0){

    //~ echo "<tr>";
      //~ for ($n = 0; $n < $drow; $n++)
      //~ {
        //~ echo "<td>$drow[$n]</td>";
      //~ }
    //~ echo "</tr>";
  //~ }
//~ }

//~ echo "</table>\n";


//~ }
?>
