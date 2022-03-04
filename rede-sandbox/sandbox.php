<?php

if(isSet($_GET['get'])&&$_GET['get']=='vendas'){


  function getVendas(){


  $url = "https://rl7-sandbox-api.useredecloud.com.br/merchant-statement/v1/sales?parentCompanyNumber=22523510&subsidiaries=22523510&startDate=2022-02-10&endDate=2022-02-28";

  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

  $headers = array(
     "Accept: */*",
     "Authorization: Bearer 67491cf0-cc60-44f7-89cd-997ddf8e1dd2",
  );
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  //for debug only!
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

  $resp = curl_exec($curl);
  curl_close($curl);
  //var_dump($resp);
  return $resp;


  }


  //$res = json_decode(getVendas(),true);
  $res = getVendas();
  echo $res;


}else{



  $url = "https://rl7-sandbox-api.useredecloud.com.br/oauth/token";

  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

  $headers = array(
     "Authorization: Basic NWViMjk5NTItMWI4NC00MzlmLTlmNDEtZTNjNmQ3YTcwYjhjOkliNmR3Tkk3Sk4=",
     "Content-Type: application/x-www-form-urlencoded",
  );
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

  $data = "grant_type=password&username=ti@laccord.com.br&password=y?9oy_jx-KQ_";

  curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

  //for debug only!
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

  $resp = curl_exec($curl);
  curl_close($curl);
  var_dump($resp);




}

?>
