<?php

function getStatsJadLog($dados){
  $results=array();
  for ($i = 0; $i < count($dados); $i++)
  {
    $consulta = $dados[$i]['df'];
    $track    = $dados[$i]['tracking'];
    $nDanfe   = $consulta['danfe'];
    $rcb['nome']='';
    $rcb['data']='';
    if(isSet($track['recebedor'])){
      $rcb    = $track['recebedor'];
    }else{$track['recebedor']='';}
    $evt      = $track['eventos'];

    $results[$nDanfe]['danfe']          = $nDanfe;
    $results[$nDanfe]['tpDocumento']    = $consulta['tpDocumento'];
    $results[$nDanfe]['cnpjRemetente']  = $consulta['cnpjRemetente'];
    $results[$nDanfe]['codigo']         = $track['codigo'];
    $results[$nDanfe]['shipmentId']     = $track['shipmentId'];
    $results[$nDanfe]['dacte']          = $track['dacte'];
    $results[$nDanfe]['dtEmissao']      = $track['dtEmissao'];
    $results[$nDanfe]['status']         = $track['status'];
    $results[$nDanfe]['valor']          = $track['valor'];
    $results[$nDanfe]['peso']           = $track['peso'];
    $results[$nDanfe]['recebedor']      = $rcb['nome'];
    $results[$nDanfe]['datarcbto']      = $rcb['data'];

    for ($x = 0; $x < count($evt); $x++)
    {
      $ev = $evt[$x];
      $results[$nDanfe]['eventos'][$x]['data']    = $ev['data'];
      $results[$nDanfe]['eventos'][$x]['status']  = $ev['status'];
      $results[$nDanfe]['eventos'][$x]['unidade'] = $ev['unidade'];
    }
  }
  return $results;
}


function selectNFEs(){
$se = dbf("SELECT * FROM converse_nfesbling
      WHERE xmlnota LIKE :transportadora
      AND (situacaonfe != 'Cancelada' AND situacaonfe != 'Pendente')
      ORDER BY emissao DESC",
      array(':transportadora'=>'%E-COMMERCE-LOG%'),'fetch');

$tag='';
for ($i = 0; $i < count($se); $i++)
{
  $line = $se[$i];
  $tag .= '<option value="'.$line['chavenota'].'">NFe: '.$line['notanumero'].' ('.$line['situacaonfe'].')</option>'."\n";
}
return $tag;
}

?>
