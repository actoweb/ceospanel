<?php
$hoje = (string) date('Y-m-d');

if(postVar('datainicial')==''){$dataInicial = '2021-10-29';}else{$dataInicial = swdata(postVar('datainicial'));}
if(postVar('datafinal')=='')  {$dataFinal = date('Y-m-d');}else{$dataFinal = swdata(postVar('datafinal'));}


//~ $dataInicial = '2021-10-29';
//~ $dataFinal = $hoje;

/* ????????????????????????
/* ????????????????????????
/* ????????????????????????
/* ????????????????????????
/* ????????????????????????
/* ????????????????????????
if(postVar('datainicial')==''){
  $date         = (string) date('Y-m-d');
  $dataInicial  = date('Y-m-d', strtotime($hoje . ' -10 days'));
  $dataFinal    = date('Y-m-d');
}else{
  $dataInicial  = swdata(postVar('datainicial'));
  $dataFinal    = swdata(postVar('datafinal'));
}
*/

if(postVar('periodo')=='all' && (postVar('datainicial')=='' || postVar('datafinal')=='')){
  $dataInicial  = '2021-10-29';
  $dataFinal    = date('Y-m-d');
}elseif(postVar('periodo')=='7' && (postVar('datainicial')=='' || postVar('datafinal')=='')){
  $dataInicial  = date('Y-m-d', strtotime($hoje . ' -6 days'));
  $dataFinal    = date('Y-m-d');
}elseif(postVar('periodo')=='15' && (postVar('datainicial')=='' || postVar('datafinal')=='')){
  $dataInicial  = date('Y-m-d', strtotime($hoje . ' -14 days'));
  $dataFinal    = date('Y-m-d');
}elseif(postVar('periodo')=='30' && (postVar('datainicial')=='' || postVar('datafinal')=='')){
  $dataInicial  = date('Y-m-d', strtotime($hoje . ' -29 days'));
  $dataFinal    = date('Y-m-d');
}elseif(postVar('periodo')=='H' && (postVar('datainicial')=='' || postVar('datafinal')=='')){
  $dataInicial  = date('Y-m-d');
  $dataFinal    = date('Y-m-d');
}elseif(postVar('periodo')=='O' && (postVar('datainicial')=='' || postVar('datafinal')=='')){
  $dataInicial  = date('Y-m-d', strtotime($hoje . ' -1 days'));
  $dataFinal    = date('Y-m-d', strtotime($hoje . ' -1 days'));
}

$fgrafico='gsemanal-graficos-vendas-periodo.grafico.php';
if(getVar('visao')=='mensal'){$fgrafico='gmes-graficos-vendas-periodo.grafico.php';}
if(getVar('visao')=='semanal'){$fgrafico='gsemanal-graficos-vendas-periodo.grafico.php';}
if(getVar('visao')=='diaria'){$fgrafico='g-graficos-vendas-periodo.grafico.php';}





//?opt=vendas&view=vendas-periodo&grafico=bars
if(!isSet($_POST['datainicial']) && (getVar('opt')=='vendas' && getVar('view')=='vendas-periodo')){
  include_once('app/pages/views/vendas/graficos/'.$fgrafico);
}

if(postVar('showgraph')=='bar-graph-vendas-periodo'){
  //include_once('app/pages/views/vendas/graficos/gsemanal-graficos-vendas-periodo.grafico.php');
  include_once('app/pages/views/vendas/graficos/'.$fgrafico);
}
?>
