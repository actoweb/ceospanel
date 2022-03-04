<?php
include_once('config.all.php');

/*
 * 1 listo todas as notas ja registradas e vou anotar na tabela reg_vendas
 * id
 * origem
 * numeroPedidoLoja (necessario para a REDE)
 * numero_nfe
 * chave_nfe
 * data_emissao
 * valor
 * meio_pgto
 *
 * assim terei o total de vendas da forma que for necessario
 * */

//$nfes = selectDB('*','converse_nfesbling','','ORDER BY emissao ASC');


$sql = "SELECT  JSON_EXTRACT(corponota,'$.notafiscal.loja') AS  loja,
                JSON_EXTRACT(corponota,'$.notafiscal.numeroPedidoLoja') AS  pedidoLoja,
                JSON_EXTRACT(corponota,'$.notafiscal.valorNota') AS  valor,
                notanumero AS nota,
                chavenota AS chave,
                emissao AS data,
                situacaonfe AS situacao
                FROM converse_nfesbling
                ORDER BY emissao ASC";

$nfes = dbf($sql,'','fetch');

//var_dump($nfes);

$c=1;
for ($i = 0; $i < count($nfes); $i++)
{
  $drow = $nfes[$i];

  $loja     = $drow['loja'];
  $pedLoja  = str_replace('"','',$drow['pedidoLoja']);
  $nota     = $drow['nota'];
  $chave    = $drow['chave'];
  $emissao  = $drow['data'];
  $valor    = $drow['valor'];
  $situacao = $drow['situacao'];

  if($situacao=='Autorizada' || $situacao=='Emitida DANFE'){


  //consulto dados extras na tabela da redecard
  //$rede = selectDB('*','relatorio_rede',array('numeroPedido'=>$pedLoja));
  $cnfPed='';
  $q      = "SELECT * FROM relatorio_rede WHERE numero_pedido = '$pedLoja'";
  $rd     = dbf_o($q,'fetch');
  $cnfPed = $rd['numero_pedido'];


  echo "<hr />\n";
  echo "<br />($c) - LOJA($loja)<br />\n";
  if($pedLoja==$cnfPed){echo '<h3 style="color:red;">';}
  echo "<b>PEDLOJA([$pedLoja] ($cnfPed)</b><br />\n";
  if($pedLoja==$cnfPed){echo '</h3>';}
  echo "Nfe($nota)<br />\n";
  echo "Chave($chave)<br />\n";
  echo "Emissao($emissao)<br />\n";
  echo "Valor R$( $valor )<br />\n";
  echo "Situacao($situacao)<hr />\n";
  $c++;

  }
}





?>
