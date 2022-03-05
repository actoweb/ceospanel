<?php
/*
 * LOG: Nome anterior do arquivo res-consulta-pgto.view.php
 * alterado para coerencia: processa-consulta-plataforma-pgto.php
 *
 * */

$n_pedido = $_POST['numeroPedido'];

$url  = 'https://laccord.layer.core.dcg.com.br/v1/Sales/API.svc/web/GetOrderByNumber';
$ch   = curl_init($url);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Content-Type: application/json',
  'Accept: application/json',
  'Authorization: Basic '.TOKEN_LC)
);
curl_setopt($ch, CURLOPT_POSTFIELDS, "$n_pedido");
# Return response instead of printing.
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
# Send request.
$result = curl_exec($ch);
curl_close($ch);

//dados do pedido
$dadosPedido  = json_decode($result,true);
$infoDate     = $dadosPedido['AcquiredDate'];
$infoPag      = $dadosPedido['PaymentMethods'];
$statusPed    = $dadosPedido['OrderStatusID'];
$dtCancel     = $dadosPedido['CancelledDate'];

/*
 * status = 6 //cancelado
 * status = 7 //aprovado (enviado)??
 * status = 4 //pagamento aprovado
 *
 *
 * */

//detalhes do pedido
$qtdPgtos       = $dadosPedido['PaymentMethods'];//total
$total          = $dadosPedido['PaymentMethods'][0]['Amount'];//total
$total2         = isSet($dadosPedido['PaymentMethods'][1]['Amount']) ? $dadosPedido['PaymentMethods'][1]['Amount'] : 0; //total
$vlr_parcelas   = $dadosPedido['PaymentMethods'][0]['InstallmentAmount'];//valor parcela
$num_parcelas   = $dadosPedido['PaymentMethods'][0]['Installments'];//numero parcela
$orderID        = $dadosPedido['PaymentMethods'][0]['OrderID'];//OrderID
$pgto_metodo    = $dadosPedido['PaymentMethods'][0]['OrderPaymentMethodID'];//metodo de pgto
$pgto_info      = $dadosPedido['PaymentMethods'][0]['PaymentInfo']['Alias'];//metodo de pgto
$dt_pgto        = $dadosPedido['PaymentMethods'][0]['PaymentDate'];//data do pagamento

$status_label   ='';
$status_label = "EM: ".swdatetime( epoch2Date($dtCancel) );


if($statusPed=='7'){
  $status_label = "PAGAMENTO APROVADO EM: ".swdatetime( epoch2Date($dt_pgto) );
}
if($statusPed=='4'){
  $status_label = "PAGAMENTO APROVADO";
}
if($statusPed=='5'){
  $status_label = "PEDIDO ENTREGUE";
}
if($statusPed=='6'){
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
    if($str=='MASTER')          {$str='CARTÃO CRED. MASTER';}
    if($str=='VISA')            {$str='CARTÃO CRED. VISA';}
    if($str=='ELO')             {$str='CARTÃO CRED. ELO';}
    if($str=='HIPERCARD')       {$str='CARTÃO CRED. HIPERCARD';}
    if($str=='DINERS')          {$str='CARTÃO CRED. DINERS';}
    if($str=='AMEX')            {$str='CARTÃO CRED. AMEX';}
  }
  return $str;
}

function epoch2Date($str=''){
  if($str){
    $str = str_replace("/Date(",'',$str);
    $str = str_replace(")/",'',$str);
    logsys('Dados para data recebidos: $str('.$str.') - substr($str, 0, 10) = '.substr($str, 0, 10),false,'logs','correcoes.log.txt');

    $str = date("Y-m-d H:i:s", substr($str, 0, 10));
  }
  return $str;
}

$dataPedido = (string) $infoDate;

//ICONES DOS MEIOS PAGAMENTO
$meiosPgto['PIX']                     = 'assets/images/pix.png';
$meiosPgto['CARTÃO CRED. ELO']        = 'assets/images/cielo.png';
$meiosPgto['CARTÃO CRED. MASTER']     = 'assets/images/master.png';
$meiosPgto['CARTÃO CRED. VISA']       = 'assets/images/visa.png';
$meiosPgto['CARTÃO CRED. HIPERCARD']  = 'assets/images/hipercard.png';



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
