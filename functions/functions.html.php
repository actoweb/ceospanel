<?php

function mkSw($uid='',$enable=true){
  if($enable==false){$btstats = ' disabled'; $msgStats = ' msgRowOff';}else{$msgStats = '';}
  $tag = '<div class="custom-control custom-switch">';
  $tag .= '<input'.$btstats.' type="checkbox" class="custom-control-input" id="customSwitch'.$uid.'">';
  $tag .= '<label class="custom-control-label'.$msgStats.'" for="customSwitch'.$uid.'"></label>';
  $tag .= '</div>';
  return $tag;
}


function mkCkb($uid='',$uidItem='',$enabled=true){
  if($enabled==false){$btstats = ' disabled'; $msgStats = 'msgRowOff';}else{$btstats = '';$msgStats = '';}
  $tag = '<input'.$btstats.' type="checkbox" id="mck_'.$uid.'" name="mck_'.$uid.'" class="big-checkbox bigcheckbox_'.$uid.'" data-order="'.$uid.'" />';
  return $tag;
}


//retorna quantos produtos estão inseridos no pedido
function getListaPedidos($uidped){

  $res =  dbf('SELECT * FROM pedidos_itens WHERE pedido_id = :pedido_id',array(
          ':pedido_id'=>$uidped),'num');
  return $res;

}


function btnRowPicker($args=array()){

$item_order_id  = $args['orderId'];
$barcode_item   = $args['barcodeItem'];
$total_item     = $args['totalItemPedido'];
$id_pedido      = $args['idPedido'];
$id_tem_pedido  = $args['idItemPedido'];
$titulo_item    = $args['tituloItem'];
$maxcx          = $args['maxcx'];

?>

<tr id="<?php echo $item_order_id;?>" class="rowIPD">
<td width="50" class="hoverBlue">
  <?php echo mkCkb($item_order_id, '');?>
</td>
<td width="50">
  <a class="btn btn-outline-primary btnCx confirmaFecharCaixa" id="btnBox-<?php echo $item_order_id;?>" href="#" role="button btn-sm"><i class="bi bi-box"></i></a>
</td>
<td width="100" class="displayNone"> <!-- DNONE displayNone -->
<input type="hidden" id="pdt-barcode-<?php echo $item_order_id;?>" name="pdt-barcode-<?php echo $item_order_id;?>" class="form-control campo-barreader" value="<?php echo $barcode_item;?>" />
<input type="hidden" id="prod-id-<?php echo $item_order_id;?>" name="prod-id-<?php echo $item_order_id;?>" class="form-control campo-barreader" value="<?php echo $id_tem_pedido;?>" />
<input type="text" id="max-cx-<?php echo $item_order_id;?>" name="max-cx-<?php echo $item_order_id;?>" class="form-control campo-barreader" value="<?php echo $maxcx;?>" />
<input type="text" id="max-vcx-<?php echo $item_order_id;?>" name="max-vcx-<?php echo $item_order_id;?>" class="form-control campo-barreader" placeholder="cv" value="0" />
<input readonly disabled type="text" id="tot-<?php echo $item_order_id;?>" name="tot-<?php echo $item_order_id;?>" class="form-control campo-barreader" value="<?php echo $total_item;?>" data-qtdtotal="<?php echo $total_item;?>" title="Qtd deste item"></td>
<td width="100" class="" style="padding:10px 0px 0px 0px!important;line-height:40px!important;font-size:16pt!important"> <!-- DNONE displayNone -->
  <input readonly disabled class="form-control campo-barreader" type="text" id="lido-<?php echo $item_order_id;?>" name="lido-<?php echo $item_order_id;?>" value="0" style="font-size:16pt!important;background:inherit!important;border:none!important;width:40px!important;margin-top:5px!important;padding:0px!important;margin:0px!important;text-align:right!important;float:left;" title="Qtd ja lida">/<?php echo $total_item;?>
</td>
<td width="100" class="displayNone"> <!-- DNONE displayNone -->
  <input readonly disabled class="form-control campo-barreader" type="text" id="caixas-<?php echo $item_order_id;?>" name="caixas-<?php echo $item_order_id;?>" value="0" title="Qtd nesta caixa">
</td>
<td class="displayNone">
  <a id="btn-etiquetas-<?php echo $item_order_id;?>" class="btn btn-outline-primary btnCx" href="#" role="button btn-sm" data-idPedido="<?php echo $id_pedido;?>" data-idItem="<?php echo $id_tem_pedido;?>">Etiquetas <i class="bi bi-collection"></i></a>
</td>
<td>
  <h5 id="descProd-<?php echo $item_order_id;?>" class="titItemPickRow"><?php echo $titulo_item;?></h5>
</td>
</tr>


<?php
}



?>
