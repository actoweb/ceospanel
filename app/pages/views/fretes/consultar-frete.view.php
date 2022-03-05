<div class="card">
  <div class="card-header">
    Consultar Frete por NFe
  </div>
  <div class="card-body">
    <h5 class="card-title">NFE's Disponíveis para Consulta</h5>



      <form>
        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="danfe">Selecionar nota</label>

            <select id="danfe" name="danfe" class="form-control">
              <option value="">Notas...</option>
              <?php echo selectNFEs();?>
            </select>

          </div>
        </div>
        <input type="hidden" id="do" name="do" value="getFreteStatus" />
        <button type="button" class="btn btn-primary btconsulta">Consultar</button>
      </form>

  <div id="resultados">
    <hr />
    Resultados:
  </div>

  </div>
  <div class="card-footer text-muted">
  <small><b>UFO WAY LABS - TI TEAM</b></small>
  </div>

</div>




<?php

    $danfe  = postVar('df');
    if(strlen($danfe)>3){
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

    $sts   = $xxx['eventos'];
    for ($k = 0; $k < count($sts); $k++)
    {
      $li=$sts[$k];
      echo "<b>DATA:</b> $li[data]<br />\n";
      echo "<b>STATUS:</b> $li[status]<br />\n";
      echo "<b>UNIDADE:</b> $li[unidade]<br />\n";
      echo "<hr />\n";
    }





}else{

  echo "<hr />\n";

}
?>
