<?php
    $danfe  = postVar('df');
    if(strlen($danfe)>3){
    $token  = $token_jadlog;
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



    $info  = getStatsJadLog($dados);

    $xxx   = $info[$danfe];

    $arv[] = "<b>DANFE:</b> $xxx[danfe]";
    $arv[] = "<b>TP.DOC</b> $xxx[tpDocumento]";
    $arv[] = "<b>CNPJ.REM</b> $xxx[cnpjRemetente]";
    $arv[] = "<b>CODIGO</b> $xxx[codigo]";
    $arv[] = "<b>SHIPMENTID</b> $xxx[shipmentId]";
    $arv[] = "<b>DACTE</b> $xxx[dacte]";
    $arv[] = "<b>DT.EMISSAO</b> $xxx[dtEmissao]";
    if($xxx['status']=='ENTREGUE'){
    $cstyle=' style="color:green;font-weight:600;"';
    }else{$cstyle='';}
    $arv[] = "<span".$cstyle."><b>STATUS</b> $xxx[status]</span>";
    $arv[] = "<b>VALOR</b> $xxx[valor]";
    $arv[] = "<b>PESO</b> $xxx[peso]";
    $arv[] = "<b>RECEBEDOR</b> $xxx[recebedor]";
    $arv[] = "<b>DATA.RCBTO</b> $xxx[datarcbto]";

    echo '<br />';

    for ($m = 0; $m < count($arv); $m++)
    {
      echo "$arv[$m]<br />\n";
    }

    $sts   = arrayVar($xxx,'eventos');
    if(is_array($sts)){
      for ($k = 0; $k < count($sts); $k++)
      {
        $li=$sts[$k];
        echo "<b>DATA:</b> $li[data]<br />\n";
        echo "<b>STATUS:</b> $li[status]<br />\n";
        echo "<b>UNIDADE:</b> $li[unidade]<br />\n";
        echo "<hr />\n";
      }
    }


}else{
echo "<hr />\n";
}

?>
