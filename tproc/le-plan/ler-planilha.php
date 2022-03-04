<?php

$sl[]=0;
$sl[]=2;
$sl[]=4;
$sl[]=5;
$sl[]=6;
$sl[]=7;
$sl[]=8;
$sl[]=12;
$sl[]=13;
$sl[]=26;
$sl[]=28;
$sl[]=29;
$sl[]=35;/*
*/
function real2float($string=''){
$string = str_replace('.','',$string);
$string = str_replace(',','.',$string);
$string = str_replace('%','',$string);
$string = str_ireplace('r$','',$string);
return $string;
}

function swdate($str){
  if(strstr($str,'/')){$d=explode('/',$str);return "$d[2]-$d[1]-$d[0]";}
  if(strstr($str,'-')){$d=explode('-',$str);return "$d[2]/$d[1]/$d[0]";}
}


$row = 1;
if (($handle = fopen("outubro-2021.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        //echo "<p> $num campos na linha $row: <br /></p>\n";
        $row++;

        $dataVenda          = swdate($data[0]);
        $valorOriginal      = real2float($data[2]);
        $numParcelas        = $data[4];
        $modalidade         = $data[5];
        $tipo               = $data[6];
        $bandeira           = $data[7];
        $tarifa_percentual  = real2float($data[8]);
        $tarifa_valor       = real2float($data[12]);
        $valorLiquido       = real2float($data[13]);
        $numeroPedido       = $data[26];
        $cancelada          = $data[28];
        $dataCancelamento   = swdate($data[29]);
        $cartao_tipo        = $data[35];


    }
    fclose($handle);
}


/*

$f = file('outubro-2021.csv');

echo '<table>';

$td='';

for ($i = 0; $i < count($f); $i++)
{

  echo "<tr>";

  $handle = $f[$i];
  $data   = fgetcsv($handle, 1000, ",");

  $td .= "<td>".$data[0 ]."</td>";
  $td .= "<td>".$data[2 ]."</td>";
  $td .= "<td>".$data[4 ]."</td>";
  $td .= "<td>".$data[5 ]."</td>";
  $td .= "<td>".$data[6 ]."</td>";
  $td .= "<td>".$data[7 ]."</td>";
  $td .= "<td>".$data[8 ]."</td>";
  $td .= "<td>".$data[12]."</td>";
  $td .= "<td>".$data[13]."</td>";
  $td .= "<td>".$data[26]."</td>";
  $td .= "<td>".$data[28]."</td>";
  $td .= "<td>".$data[29]."</td>";
  $td .= "<td>".$data[35]."</td>";

  echo $td;

  echo "</tr>";

}



echo '</table>';
*/

?>
