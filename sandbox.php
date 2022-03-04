<?php
include_once('config.all.php');


function getFrete($danfe=''){
  $dados='';
  if($danfe!=''){
    $token  = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJqdGkiOjEwODQ2MCwiZHQiOiIyMDIxMDgwOCJ9.32z_38T1YzqyooKc6K19Ix47umBHwQb7_66PMyvRFcQ';
    $apiUrl = 'https://www.jadlog.com.br/embarcador/api/tracking/consultar';


    $data_string = '{"consulta":[{"df":{"danfe":"'.$danfe.'","cnpjRemetente":"41747186000124","tpDocumento":2}}]}';
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Authorization: Bearer ' . $token,
      'Content-Length: ' . strlen($data_string))
    );

    $result = curl_exec($ch);
    $result = json_decode($result, true);

    //array com resuldados da pesquisa
    $dados = $result['consulta'];
    //print_r($dados);
  }
  return $dados;
}



$t = dbf('SELECT * FROM vendas','','fetch','ufowayco_blingsinc');

$fretesAtualizados=0;
for ($i = 0; $i < count($t); $i++)
{
  $d      = $t[$i];
  $chave  = $d['chave_nfe'];
  $numnfe = $d['num_nfe'];
  //echo "Consultando: chave ($d[chave])<br />\n";
  $res    = getFrete($chave);

  $valorFrete   = $res[0]['tracking']['valor'];
  $statusFrete  = $res[0]['tracking']['status'];

  if($valorFrete!='' || $statusFrete!=''){

  $upd = dbf('UPDATE vendas SET
              vlr_frete_efetivo = :vlr_frete_efetivo,
              status_entrega    = :status_entrega',array(
              ':vlr_frete_efetivo'=>$valorFrete,
              ':status_entrega'=>$statusFrete),'','ufowayco_blingsinc');
  $fretesAtualizados++;
  $valorFrete='';
  $statusFrete='';

  echo "ATUALIZADO: Frete Nota: $numnfe | $statusFrete ($chave)<br />\n";
  }else{
  echo "nao atualizado: $statusFrete ($chave)<br />\n";
  }

  if($i<30){

    ob_flush();
    flush();
    sleep(1);

  }

}

echo "Total de fretes atualizados: $fretesAtualizados<br />\n";


?>
