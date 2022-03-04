<div class="card">
  <div class="card-header">
    Tabela JadLog
  </div>
  <div class="card-body">

<?php

if(getVar('uf')==''){
$loadUF = 'AC';
}else{
$loadUF = getVar('uf');
}

if(getVar('tar')==''){
$loadTAR = 'CAPITAL-1';
}else{
$loadTAR = getVar('tar');
}




$res = dbf('SELECT * FROM JADLOG_FAIXACEPS
      WHERE uf = :uf AND tarifa = :tarifa',array(
      ':uf'=>$loadUF,
      ':tarifa'=>$loadTAR,
      ),'fetch');

$lineR='';
/*
$res = dbf('SELECT * FROM JADLOG_FAIXACEPS
      WHERE tarifa = :tarifa ORDER BY uf',array(
      ':tarifa'=>'INTERIOR',
      ),'fetch');
*/
echo '<center><table class="table table-bordered">';
echo '<thead>';
echo '<tr><th colspan="12"><h3><center><b>TABELA DE PREÇOS: <spam style="color:red;">('.strtoupper($loadUF).') '.$loadTAR.'</spam></b><br /><small>(Selecione um estado para visualizar a tabela)</small></center></h3>';
echo '<select class="form-control jumpUF" style="background:#678EFF;font-weight:bold;text-transform:uppercase;" name="estados-brasil">';
echo '<option value="AC"'.selselr('AC',$loadUF).'>Acre</option>';
echo '<option value="AL"'.selselr('AL',$loadUF).'>Alagoas</option>';
echo '<option value="AP"'.selselr('AP',$loadUF).'>Amapá</option>';
echo '<option value="AM"'.selselr('AM',$loadUF).'>Amazonas</option>';
echo '<option value="BA"'.selselr('BA',$loadUF).'>Bahia</option>';
echo '<option value="CE"'.selselr('CE',$loadUF).'>Ceará</option>';
echo '<option value="DF"'.selselr('DF',$loadUF).'>Distrito Federal</option>';
echo '<option value="ES"'.selselr('ES',$loadUF).'>Espírito Santo</option>';
echo '<option value="GO"'.selselr('GO',$loadUF).'>Goiás</option>';
echo '<option value="MA"'.selselr('MA',$loadUF).'>Maranhão</option>';
echo '<option value="MT"'.selselr('MT',$loadUF).'>MatoGrosso</option>';
echo '<option value="MS"'.selselr('MS',$loadUF).'>Mato Grosso do Sul</option>';
echo '<option value="MG"'.selselr('MG',$loadUF).'>Minas Gerais</option>';
echo '<option value="PA"'.selselr('PA',$loadUF).'>Pará</option>';
echo '<option value="PB"'.selselr('PB',$loadUF).'>Paraíba</option>';
echo '<option value="PR"'.selselr('PR',$loadUF).'>Paraná</option>';
echo '<option value="PE"'.selselr('PE',$loadUF).'>Pernambuco</option>';
echo '<option value="PI"'.selselr('PI',$loadUF).'>Piauí</option>';
echo '<option value="RJ"'.selselr('RJ',$loadUF).'>Rio de Janeiro</option>';
echo '<option value="RN"'.selselr('RN',$loadUF).'>Rio Grande do Norte</option>';
echo '<option value="RS"'.selselr('RS',$loadUF).'>RioGrande do Sul</option>';
echo '<option value="RO"'.selselr('RO',$loadUF).'>Rondônia</option>';
echo '<option value="RR"'.selselr('RR',$loadUF).'>Roraima</option>';
echo '<option value="SC"'.selselr('SC',$loadUF).'>Santa Catarina</option>';
echo '<option value="SP"'.selselr('SP',$loadUF).'>São Paulo</option>';
echo '<option value="SE"'.selselr('SE',$loadUF).'>Sergipe</option>';
echo '<option value="TO"'.selselr('TO',$loadUF).'>Tocantins</option>';
echo '</select>';
echo '<br /><small>SELECIONE O TIPO DA TABELA:</small><br />Tabelas: <a href="?opt=fretes&view=tabela-jadlog&tar=CAPITAL-1&uf='.$loadUF.'">CAPITAL-1</a>&nbsp|&nbsp<a href="?opt=fretes&view=tabela-jadlog&tar=CAPITAL-2&uf='.$loadUF.'">CAPITAL-2</a>&nbsp|&nbsp<a href="?opt=fretes&view=tabela-jadlog&tar=INTERIOR&uf='.$loadUF.'">INTERIOR</a><br />';
echo '</th></tr>';

$ht  = '<tr>';
$ht .= '<th>UF</th>';
$ht .= '<th>CEP INI</th>';
$ht .= '<th>CEP FIN</th>';
$ht .= '<th>0~250Gr.</th>';
$ht .= '<th>250~500Gr.</th>';
$ht .= '<th>500~750Gr.</th>';
$ht .= '<th>750~1k</th>';
$ht .= '<th>1~2k</th>';
$ht .= '<th>2~3k</th>';
$ht .= '<th>3~4k</th>';
$ht .= '<th>4~5k</th>';
$ht .= '<th>Prazo</th>';
$ht .= '</tr>';

/*
$ht = "<tr><th>Estado</th>";
$ht .= "<th>CEP Inicial</th>";
$ht .= "<th>CEP Final</th>";
$ht .= "<th>Peso Inicial</th>";
$ht .= "<th>Peso Final</th>";
$ht .= "<th>Valor</th>";
$ht .= "<th>Entrega(Dias)</th></tr>";
*/
echo $ht;




echo '</thead>';





for ($i = 0; $i < count($res); $i++)
{
  $line = $res[$i];

  $ufe =  $line['uf'];//CAPITAL-1,CAPITAL-2 ou INTERIOR
  $tar =  $line['tarifa'];//CAPITAL-1,CAPITAL-2 ou INTERIOR

  $res2 = dbf('SELECT * FROM JADLOG_TARIFAS
          WHERE
          uf = :uf AND tarifa = :tarifa',array(':uf'=>$ufe,':tarifa'=>$tar),'fetch');

  $precos   = $res2[0];
  $v250grms = $precos['250grms'];
  $v500grms = $precos['500grms'];
  $v750grms = $precos['750grms'];
  $v1k      = $precos['1k'];
  $v2k      = $precos['2k'];
  $v3k      = $precos['3k'];
  $v4k      = $precos['4k'];
  $v5k      = $precos['5k'];

  //$custo  = "0~250[$v250grms] - 250~500[$v500grms] - 500~750[$v750grms] - 750~1k[$v1k] - 1~2k[$v2k]";

  $custo  = "<td>$v250grms</td><td>$v500grms</td><td>$v750grms</td><td>$v1k</td><td>$v2k</td><td>$v3k</td><td>$v4k</td><td>$v5k</td>";
  //$custo  = "<td>0</td><td>$v2k</td>";


  $cepInicial = str_pad($line['cepinicial'], 8, "0", STR_PAD_LEFT);
  $cepFinal   = str_pad($line['cepfinal'], 8, "0", STR_PAD_LEFT);


  $tl = "<tr><td>$ufe</td>";
  $tl .= "<td>$cepInicial</td>";
  $tl .= "<td>$cepFinal</td>";
  //$tl .= "<td>0</td>";
  //$tl .= "<td>2</td>";
  $tl .= $custo;
  //$tl .= "<td>".$v2k."</td>";
  $tl .= "<td>$line[prazo]</td>";
  $tl .= "</tr>\n";

  $lineR .=  $tl;



  $trl  = "\"$ufe\",";
  $trl .= "\"'$cepInicial'\",";
  $trl .= "\"'$cepFinal'\",";
  $trl .= "\"0\",";
  $trl .= "\"2\",";
  $trl .= "\"$v2k\",";
  $trl .= "\"$v2k\",";
  $trl .= "\"".$line['prazo']."\"\n";

  $trle .= $trl;

}

echo $lineR;

echo '</table></center>';


?>
  </div>
  <div class="card-footer text-muted">
  <small><b>UFO WAY LABS - TI TEAM</b></small>
  </div>

</div>
