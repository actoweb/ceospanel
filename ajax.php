<?php
include_once('config.all.php');
include_once('functions/functions.all.php');

if(getVar('topprod')!=''){

include_once('app/pages/views/vendas/top-prod.php');

}elseif(getVar('v')=='table' && getVar('grid')!=''){

include_once('app/pages/views/vendas/wbox-grid.php');

}

//consulta frete na jadlog
if(postVar('optdo')=='getFreteStatus'){
  //rotinas para obter o status do frete na jadlog
  include_once('app/pages/views/fretes/status-frete-jadlog.php');
}


?>
