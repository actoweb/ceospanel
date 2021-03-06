<?php


$n_pedido = $_POST['numeroPedido'];

$url = 'https://laccord.layer.core.dcg.com.br/v1/Sales/API.svc/web/GetOrderByNumber';
//$url = 'https://laccord.layer.core.dcg.com.br/v1/Sales/API.svc/web/UpdateOrder';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Content-Type: application/json',
  'Accept: application/json',
  'Authorization: Basic aW50ZWdyYWNhby5taWxsZW5uaXVtOmludEBnckBjYW8xMjM=')
);
//curl_setopt($ch, CURLOPT_POSTFIELDS, '{"OrderNumber": "01002","WorkflowType": "Canceled"}');
//curl_setopt($ch, CURLOPT_POSTFIELDS, '{"OrderNumber": "01002","WorkflowType": "Delivered"}');
//curl_setopt($ch, CURLOPT_POSTFIELDS, '01002');
curl_setopt($ch, CURLOPT_POSTFIELDS, "$n_pedido");

# Return response instead of printing.
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
# Send request.
$result = curl_exec($ch);
curl_close($ch);

//echo $result;

$dadosPedido = json_decode($result,true);


$infoDate   = $dadosPedido['AcquiredDate'];
$infoPag    = $dadosPedido['PaymentMethods'];
$statusPed  = $dadosPedido['OrderStatusID'];
$dtCancel   = $dadosPedido['CancelledDate'];

/*
 * status = 6 //cancelado
 * status = 7 //aprovado (enviado)??
 * status = 4 //pagamento aprovado
 *
 *
 * */

$qtdPgtos       = $dadosPedido['PaymentMethods'];//total
$total          = $dadosPedido['PaymentMethods'][0]['Amount'];//total
$total2         = $dadosPedido['PaymentMethods'][1]['Amount'];//total
$vlr_parcelas   = $dadosPedido['PaymentMethods'][0]['InstallmentAmount'];//valor parcela
$num_parcelas   = $dadosPedido['PaymentMethods'][0]['Installments'];//numero parcela
$orderID        = $dadosPedido['PaymentMethods'][0]['OrderID'];//OrderID
$pgto_metodo    = $dadosPedido['PaymentMethods'][0]['OrderPaymentMethodID'];//metodo de pgto
$pgto_info      = $dadosPedido['PaymentMethods'][0]['PaymentInfo']['Alias'];//metodo de pgto
$dt_pgto        = $dadosPedido['PaymentMethods'][0]['PaymentDate'];//data do pagamento

$status_label   ='';


//if($dtCancel!=''){$status_label = "PEDIDO CANCELADO EM: ".swdatetime( epoch2Date($dtCancel) );}
//if($dtCancel!=''){$status_label = "EM: ".swdatetime( epoch2Date($dtCancel) );}
$status_label = "EM: ".swdatetime( epoch2Date($dtCancel) );


if($statusPed=='7'){

  $status_label = "PAGAMENTO APROVADO EM: ".swdatetime( epoch2Date($dt_pgto) );

}
if($statusPed=='4'){

  //if($dtCancel!=''){$status_label = "PEDIDO CANCELADO EM: ".swdatetime( epoch2Date($dtCancel) );}
  $status_label = "PAGAMENTO APROVADO";

}
if($statusPed=='5'){

  //if($dtCancel!=''){$status_label = "PEDIDO CANCELADO EM: ".swdatetime( epoch2Date($dtCancel) );}
  $status_label = "PEDIDO ENTREGUE";

}
if($statusPed=='6'){

  //if($dtCancel!=''){$status_label = "PEDIDO CANCELADO EM: ".swdatetime( epoch2Date($dtCancel) );}
  $status_label = "PEDIDO CANCELADO";

}


function genParcelasBling($num=''){
  if($num!=''){
    if($num==1)  {$num = '30';}
    if($num==2)  {$num = '30 60';}
    if($num==3)  {$num = '30 60 90';}
    if($num==4)  {$num = '30 60 90 120';}
    if($num==5)  {$num = '30 60 90 120 150';}
    if($num==6)  {$num = '30 60 90 120 150 180';}
    if($num==7)  {$num = '30 60 90 120 150 180 210';}
    if($num==8)  {$num = '30 60 90 120 150 180 210 240';}
    if($num==9)  {$num = '30 60 90 120 150 180 210 240 270';}
    if($num==10) {$num = '30 60 90 120 150 180 210 240 270 300';}
  }
  return $num;
}


function tipoPgtoPlataforma($str=''){
  if($str!=''){
    if($str=='GIFTCERTIFICATE') {$str='VALE COMPRAS';}
    if($str=='BANRISUL')        {$str='PIX';}
    if($str=='MASTER')          {$str='CART??O CRED. MASTER';}
    if($str=='VISA')            {$str='CART??O CRED. VISA';}
    if($str=='ELO')             {$str='CART??O CRED. ELO';}
    if($str=='HIPERCARD')       {$str='CART??O CRED. HIPERCARD';}
    if($str=='DINERS')          {$str='CART??O CRED. DINERS';}
    if($str=='AMEX')            {$str='CART??O CRED. AMEX';}
  }
  return $str;
}

function epoch2Date($str){
  $str = str_replace("/Date(",'',$str);
  $str = str_replace(")/",'',$str);
  $str = date("Y-m-d H:i:s", substr($str, 0, 10));
  return $str;
}

$dataPedido = (string) $infoDate;

$meiosPgto['PIX'] = 'assets/images/pix.png';
$meiosPgto['CART??O CRED. ELO'] = 'assets/images/cielo.png';
$meiosPgto['CART??O CRED. MASTER'] = 'assets/images/master.png';
$meiosPgto['CART??O CRED. VISA'] = 'assets/images/visa.png';
$meiosPgto['CART??O CRED. HIPERCARD'] = 'assets/images/hipercard.png';



$_np=1;
echo '<table class="table table-bordered">';
echo '<tr><td colspan="6"><h4>'.$dadosPedido['CustomerName'].'</h4></td></tr>';
echo '<tr><td colspan="6"><h5>Data Pedido: '.swdatetime( epoch2Date($dataPedido) ).'</h5></td></tr>';
echo '<tr><td colspan="6"><b>'.$status_label.' - Status('.$statusPed.')</b></td></tr>';
$mmpag='';
for ($i = 0; $i < count($qtdPgtos); $i++)
{
  $ipag       = $infoPag[$i];
  $meio_pgto  = tipoPgtoPlataforma($ipag['PaymentInfo']['Alias']);
  $mmpag      = $mmpag.",$meio_pgto";

  $iconePgto='';
  if(arrayVar($meiosPgto,$meio_pgto)){
    $iconePgto = '<img src="'.arrayVar($meiosPgto,$meio_pgto).'" style="width:40px;heignt:auto;">';
  }


  echo '<tr>';
    echo '<td>Ped: ('.$_POST['numeroPedido'].')</td>';
    echo '<td>PGTO('.$_np.')</td>';
    echo '<td>'.$ipag['Installments'].' X R$ '.moeda($ipag['InstallmentAmount']).'</td>';
    echo '<td>Tot: R$ '.moeda($ipag['Amount']).'</td>';
    echo '<td><small>('.$ipag['OrderPaymentMethodID'].')</small> '.$iconePgto."<small>$meio_pgto</small>".'</td>';
    echo '<td>'.$ipag['OrderID'].'</td>';
  echo '</tr>';
$_np++;
}
if(!strstr($mmpag,'PIX')){
  echo '<tr><td colspan="6">Parcelas Bling: ('.$meio_pgto.') <input onclick="this.select();" type="text" class="form-control mb-2" id="tfield" name="tfield" value="'.genParcelasBling($ipag['Installments']).'"></td></tr>';
}
echo '</table>';


?>
