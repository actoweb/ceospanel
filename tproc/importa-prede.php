<?php
include_once('config.all.php');

$row = 1;
if (($handle = fopen("fevereiro-2022.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        //echo "<p> $num campos na linha $row: <br /></p>\n";
        $row++;

        //echo "<h2>+++Data(  $data[0]  )</h2>";

        $dataVenda          = swdata($data[0]);
        $valorOriginal      = real2float($data[2]);
        $numParcelas        = $data[4];
        $modalidade         = $data[5];
        $tipo               = $data[6];
        $bandeira           = $data[7];
        $tarifa_percentual  = real2float($data[8]);
        $tarifa_valor       = real2float($data[12]);
        $valorLiquido       = real2float($data[13]);
        $numeroPedido       = $data[26];
        $cancelada          = $data[28];
        if(strlen($data[29])>1){
        $dataCancelamento   = swdata($data[29]);
        }else{
        $dataCancelamento   = '';
        }
        $cartao_tipo        = $data[35];

        //$chk = selectDB('*','relatorio_rede',array('numeroPedido'=>$numeroPedido));
        //print_r($chk);
        //if($chk==0){

        if($dataVenda!='')          {$arrr['dataVenda']=$dataVenda;}
        if($valorOriginal!='')      {$arrr['valorOriginal']=$valorOriginal;}
        if($numParcelas!='')        {$arrr['numParcelas']=$numParcelas;}
        if($modalidade!='')         {$arrr['modalidade']=$modalidade;}
        if($tipo!='')               {$arrr['tipo']=$tipo;}
        if($bandeira!='')           {$arrr['bandeira']=$bandeira;}
        if($tarifa_percentual!='')  {$arrr['tarifa_percentual']=$tarifa_percentual;}
        if($tarifa_valor!='')       {$arrr['tarifa_valor']=$tarifa_valor;}
        if($valorLiquido!='')       {$arrr['valorLiquido']=$valorLiquido;}
        if($numeroPedido!='')       {$arrr['numeroPedido']=$numeroPedido;}
        if($cancelada!='')          {$arrr['cancelada_na_loja']=$cancelada;}
        if($dataCancelamento!='')   {$arrr['dataCancelamento']=$dataCancelamento;}
        if($cartao_tipo!='')        {$arrr['cartao_tipo']=$cartao_tipo;}


        foreach($arrr as $key => $val){
          $caddata[$key] = $val;
        }

        $ins = insertDB('relatorio_rede',$caddata);
        echo "new reg: $ins<br />\n";

        //}

    }
    fclose($handle);
}



?>
