<div class="card-header"style="min-width:600px;">
<h4>Ítens relacionados</h4>
</div>
<div class="card-body">

<?php
//echo getVar('grid');
$di = getVar('di');
$df = getVar('df');

if(getVar('grid')=='total-de-pedidos'){
  $dt_table_res = listaTodosPedidos($di,$df);
  //print_r($dt_table);
}
if(getVar('grid')=='notas-emitidas'){
  $dt_table_res = totalBrutoDeNotas_noPeriodo($di,$df);
}
if(getVar('grid')=='notas-de-devolucao'){
  $dt_table_res = totalDeNotasDevolucoes_noPeriodo($di,$df);
}
if(getVar('grid')=='trocas-estimadas'){
  $dt_table_res = totalDeTrocas_noPeriodo($di,$df);
}
if(getVar('grid')=='bonificacoes'){
  $dt_table_res = totalDeBonificacoes_noPeriodo($di,$df);
}

if(isSet($dt_table_res)){
  $dt_table = $dt_table_res['resData'];
  //print_r();
  //echo '<textarea>'.json_encode($td_table).'</textarea>';
}

function chgAc($str){
$str = preg_replace('/\s+/', '_', $str);
return $str;
}

/* removido para fora do if(count)*/
$table        = '';
$tableHeader  = '<table id="table" data-toggle="table">';
/* removido para fora do if(count)*/


if(count($dt_table)>0){
  $somax=0;
  //$table = '<table class="table table-bordered table-hover">';
  //////$table  = '<table id="table" data-toggle="table">';
  //$table  = '<table id="exampletb" class="display" style="width:100%">';
  //////$table .= '<tbody>';



  if(getVar('grid')=='total-de-pedidos'){
    $tds['dataPedido']      = 'Data';
    $tds['numeroPedido']    = 'NumPed';
    $tds['numeroLoja']      = 'Loja';
    $tds['Nfe']             = 'NFE';
    $tds['cliente']         = 'Cliente';
    $tds['CepCliente']      = 'CEP';
    $tds['ufCliente']       = 'UF';
    $tds['emailCliente']    = 'Email';
    $tds['situacao']        = 'Situacao';
    $tds['valorPedido']     = 'Valor';
  }

  if(getVar('grid')=='notas-emitidas'){
    $tds['nfe_dataEmissao']       = 'Data';
    $tds['nfe_numeroPedidoLoja']  = 'NumPed';
    $tds['nfe_numero']            = 'NFE';
    $tds['nfe_cfops']             = 'CFOP';
    $tds['nfe_nome']              = 'Cliente';
    $tds['nfe_cep']               = 'CEP';
    $tds['nfe_uf']                = 'UF';
    $tds['nfe_email']             = 'Email';
    $tds['nfe_valorNota']         = 'Valor';
  }

  if(getVar('grid')=='notas-de-devolucao'){
    $tds['nfe_dataEmissao']       = 'Data';
    $tds['nfe_numeroPedidoLoja']  = 'NumPed';
    $tds['nfe_numero']            = 'NFE';
    $tds['nfe_nome']              = 'Cliente';
    $tds['nfe_cep']               = 'CEP';
    $tds['nfe_uf']                = 'UF';
    $tds['nfe_email']             = 'Email';
    $tds['nfe_valorNota']         = 'Valor';
  }

  if(getVar('grid')=='trocas-estimadas'){
    $tds['nfe_dataEmissao']   = 'Data';
    $tds['nfe_numero']        = 'NFE';
    $tds['nfe_cfops']         = 'CFOP';
    $tds['nfe_nome']          = 'Cliente';
    $tds['nfe_uf']            = 'UF';
    $tds['nfe_email']         = 'Email';
    $tds['ObsNota']           = 'Obs';
    $tds['nfe_valorNota']     = 'Valor';

    $ignoreTH[]='nfe_linkPDF';
    $ignoreTH[]='ObsInterna';
  }

  if(getVar('grid')=='bonificacoes'){
    $tds['nfe_dataEmissao']       = 'Data';
    $tds['nfe_cfops']             = 'CFOP';
    $tds['nfe_numeroPedidoLoja']  = 'NumPed';
    $tds['nfe_numero']            = 'NFE';
    $tds['nfe_nome']              = 'Cliente';
    $tds['nfe_cep']               = 'CEP';
    $tds['nfe_uf']                = 'UF';
    $tds['nfe_email']             = 'Email';
    $tds['nfe_valorNota']         = 'Valor';
  }


  $table .= '<thead>';
  $table .= '<tr>';

  $ignoreTH =array();
  foreach($tds as $key => $value){
    if(!in_array($key,$ignoreTH)){
      $table .= '<th>'.$value.'</th>';
    }
  }

  $table .= '</tr>';
  $table .= '</thead>'."\n";


  for ($i = 0; $i < count($dt_table); $i++)
  {
    $drow = $dt_table[$i];
    $table .= '<tr>';

    foreach($tds as $keydata => $valuedata){
      if($keydata=='nfe_dataEmissao'){
        $table .= '<td class="cell-noBreak">'.swdatetime($drow[$keydata],false).'</td>';
      }elseif($keydata=='dataPedido'){
        $table .= '<td class="cell-noBreak">'.swdate($drow[$keydata]).'</td>';
      }elseif($keydata=='nfe_numero'){
        $table .= '<td class="cell-noBreak"><a href="'.$drow['nfe_linkPDF'].'" target="_nfe">'.str_pad($drow['nfe_numero'], 6, '0', STR_PAD_LEFT).'</a></td>';
      }elseif($keydata=='valorPedido'||$keydata=='nfe_valorNota'){
        $somax += $drow[$keydata];
        $table .= '<td align="right" style="text-align:right;">'.number_format($drow[$keydata],2,',','.').'</td>';
      }elseif($keydata=='nfe_email'||$keydata=='emailCliente'){
        $table .= '<td align="left" class="cell-noBreak">'.strtolower($drow[$keydata]).'</td>';
      }
      elseif($keydata=='nfe_uf'||$keydata=='ufCliente'){
        $table .= '<td align="left" class="cell-noBreak">'.strtoupper($drow[$keydata]).'</td>';
      }
      elseif($keydata=='ObsNota'){
        $_OBS = strtolower($drow['ObsNota']).' - '.strtolower($drow['ObsInterna']);
        if(strlen($_OBS)>3){$notaObs="<i class=\"bi bi-chat-left-dots-fill\" style=\"font-size:18pt;\" title=\"$_OBS\"></i>";}else{$notaObs='';}
        $table .= '<td align="left" class="cell-noBreak">'.$notaObs.'</td>';
      }
      else{
        $table .= '<td class="cell-noBreak">'.ucwords(strtolower(Utf8_ansi($drow[$keydata]))).'</td>';
      }
    }

    $table .= '</tr>'."\n";

  }

  $table .= '<tr><td colspan="'.(count($tds)-1).'" align="right">Total </td><td align="right">'.number_format($somax,2,',','.').'</td></tr>';


}

  /* removido para fora do if(count)*/
  //$table .= '</tbody>';
  $table .= '</table>';
  echo $tableHeader.$table;
  /* removido para fora do if(count)*/

?>


</div>
</div>
</div>
