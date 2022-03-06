<?php
$produtoSKU_pai = getVar('topprod');
?>
<div class="card" style="min-width:600px;">
<div class="card-header">
<h4>Ítens relacionados - <?php echo $produtoSKU_pai;?></h4>
</div>
<div class="card-body">

<?php
$nomeProdutoFilter = trim(base64_decode(getVar('dpn')));
//echo $nomeProdutoFilter;
?>


<table class="table table-bordered table-hover">
<thead>
<tr><th>SKU</th><th>Descrição</th><th>Vendas</th></tr>
</thead>
<?php

$produtoSKU_pai = getVar('topprod');
$sku_di         = getVar('di');
$sku_df         = getVar('df');
//echo 'TOP 20 PRODUTOS :'.$produtoSKU_pai . " $sku_di $sku_df";

$res = topProdutos($sku_di,$sku_df);

//echo json_encode($res);
$filtro = array();
$filtroQt = array();
$filtroNm = array();
$somaItem = 0;
for ($i = 0; $i < count($res); $i++)
{
  $drow       = $res[$i];
  $skuItem    = $drow['sku'];
  $produto    = $drow['produto'];
  $vendas     = $drow['vendas'];
  $sku_limpa  = limpaSku($skuItem);
  if(strstr($skuItem,$produtoSKU_pai)){
  $somaItem +=$vendas;
  echo '<tr><td class="cell-noBreak"><small>'.$skuItem.'</small></td><td class="cell-noBreak"><small>'.$produto.'</small></td><td align="right">'.$vendas.'</td></tr>'."\n";
  }
}

echo '<tr><td colspan="2" align="right">Total</td><td align="right">'.$somaItem.'</td></tr>';
?>



</table>

<?php //echo json_encode($res);?>

</div>
</div>

