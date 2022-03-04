<?php
/*
pontos de venda sandbox
13381369
22523510






*/

define('REDECRED','NWViMjk5NTItMWI4NC00MzlmLTlmNDEtZTNjNmQ3YTcwYjhjOkliNmR3Tkk3Sk4=');


function reqRede($endPoint='',$credenciais,$campos=array()){
  $ch   = curl_init($endPoint);
  curl_setopt($ch, CURLOPT_URL, $endPoint);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/x-www-form-urlencoded',
    'Accept: application/json',
    'Authorization: '.$credenciais)
  );
  //curl_setopt($ch, CURLOPT_POSTFIELDS, '{"grant_type": "password","username": "ti@laccord.com.br"},"password": "y?9oy_jx-KQ_"}');
  curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
  $result = curl_exec($ch);
  curl_close($ch);
  return $result;
}

//endPoint sandbox TMP
$endPoint     = 'https://rl7-sandbox-api.useredecloud.com.br/oauth/token';
$postFields   = array('grant_type'=>'password','username'=>'ti@laccord.com.br','password'=>'y?9oy_jx-KQ_');




//realiza a conexao inicial e obtem access token e refresh token
$credenciais  = 'Basic NWViMjk5NTItMWI4NC00MzlmLTlmNDEtZTNjNmQ3YTcwYjhjOkliNmR3Tkk3Sk4=';
$resRede      = reqRede($endPoint,$credenciais,$postFields);


var_dump($resRede);


echo '<hr />';
echo $resRede;
echo '<hr />';

//~ $array_rede = json_decode($resRede,true);
//~ echo 'Access Token: '.$array_rede.['access_token']."<br />";
//~ echo 'Token Type: '.$array_rede.['token_type']."<br />";
//~ echo 'Refresh Token: '.$array_rede.['refresh_token']."<br />";
//~ echo 'Expire in: '.$array_rede.['expire_in']."<br />";
//~ echo 'Scope: '.$array_rede.['scope']."<br />";


//~ //consulta lista de vendas do periodo
//~ $endPoint_vendas    = $endPoint;

//~ $credenciais_vendas = 'Bearer '.$array_rede.['access_token'];

$postFields_vendas = array(
                          'parentCompanyNumber'=>'22523510',
                          'subsidiaries'=>'22523510',
                          'startDate'=>'2022-01-01',
                          'endDate'=>'2022-02-01'
                          );

//~ $resVendasRede      = reqRede($endPoint_vendas,$credenciais_vendas,$postFields_vendas);


//~ echo '<table border="1">'."\n";
//~ echo '<thead><tr><th scope="col">CHAVE</th><th scope="col">VALOR</th></tr></thead><tbody>'."\n";
//~ echo '<tr><td colspan="2"><center><b>DADOS DAS VENDAS</b></center></td></tr>'."\n";

//~ array_walk_recursive($resVendasRede, function ($item, $key) {

      //~ echo '<tr>';
      //~ echo '<td width="300">'.$key.'</td>';
      //~ echo '<td width="300" style="overflow:hidden;word-wrap:break-word;">'.$item.'</td>';
      //~ echo '</tr>'."\n";

  //~ });

//~ echo '<tbody></table>';







?>
