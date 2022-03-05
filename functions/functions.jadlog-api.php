<?php

function getStatsJadLog($dados){
  $results=array();
  $track=array();
  for ($i = 0; $i < count($dados); $i++)
  {
    $consulta = isSet($dados[$i]['df']) ? $dados[$i]['df'] : '';
    $track    = isSet($dados[$i]['tracking']) ? $dados[$i]['tracking'] : '';
    $nDanfe   = isSet($consulta['danfe']) ? $consulta['danfe'] : '';
    $rcb['nome']='';
    $rcb['data']='';
    if(isSet($track['recebedor'])){
      $rcb    = $track['recebedor'];
    }else{$track = array('recebedor'=>'');}

    $evt      = arrayVar($track,'eventos');

    $results[$nDanfe]['danfe']          = $nDanfe;
    $results[$nDanfe]['tpDocumento']    = arrayVar($consulta,'tpDocumento');
    $results[$nDanfe]['cnpjRemetente']  = arrayVar($consulta,'cnpjRemetente');
    $results[$nDanfe]['codigo']         = arrayVar($track,'codigo');
    $results[$nDanfe]['shipmentId']     = arrayVar($track,'shipmentId');
    $results[$nDanfe]['dacte']          = arrayVar($track,'dacte');
    $results[$nDanfe]['dtEmissao']      = arrayVar($track,'dtEmissao');
    $results[$nDanfe]['status']         = arrayVar($track,'status');
    $results[$nDanfe]['valor']          = arrayVar($track,'valor');
    $results[$nDanfe]['peso']           = arrayVar($track,'peso');
    $results[$nDanfe]['recebedor']      = arrayVar($rcb,'nome');
    $results[$nDanfe]['datarcbto']      = arrayVar($rcb,'data');

    if(is_array($evt)){
      for ($x = 0; $x < count($evt); $x++)
      {
        $ev = $evt[$x];
        $results[$nDanfe]['eventos'][$x]['data']    = $ev['data'];
        $results[$nDanfe]['eventos'][$x]['status']  = $ev['status'];
        $results[$nDanfe]['eventos'][$x]['unidade'] = $ev['unidade'];
      }
    }
  }
  return $results;
}


function selectNFEs(){
//~ $se = dbf("SELECT * FROM converse_nfesbling
      //~ WHERE xmlnota LIKE :transportadora
      //~ AND (situacaonfe != 'Cancelada' AND situacaonfe != 'Pendente')
      //~ ORDER BY emissao DESC",
      //~ array(':transportadora'=>'%E-COMMERCE-LOG%'),'fetch');

$se = dbf("SELECT * FROM bs_notas
      WHERE nfe_xml_nota LIKE :transportadora
      AND (nfe_situacao != 'Cancelada' AND nfe_situacao != 'Pendente')
      ORDER BY nfe_dataEmissao DESC",
      array(':transportadora'=>'%E-COMMERCE-LOG%'),'fetch');

$tag='';
for ($i = 0; $i < count($se); $i++)
{
  $line = $se[$i];
  $tag .= '<option value="'.$line['nfe_chaveAcesso'].'">NFe: '.$line['nfe_numero'].' ('.$line['nfe_situacao'].')</option>'."\n";
}
return $tag;
}

?>
