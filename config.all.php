<?php
session_start();
/*
define('DBHOST','localhost');
define('DBNAME','nfeconverse');
define('DBUSER','root');
define('DBPWD','32125');
*/

define('DBHOST','localhost');
define('DBNAME','ufowayco_ceos_laccord');
define('DBUSER','ufowayco_ceos_laccord');
define('DBPWD','Nv32125//*+');

include_once('functions/functions.all.php');
include_once('functions/functions.html.php');
include_once('functions/functions.db.v3.php');
include_once('functions/functions.mod.php');
include_once('functions/functions.jadlog-api.php');
$app_url    = urlPath();
$app_title  = 'UFO-LOG';


if(getVar('opt')==''||getVar('opt')=='home'){

    $_page = 'home';

}else{

  if(file_exists('app/pages/'.getVar('opt').".page.php")){
    $_page = getVar('opt');
  }else{
    $_page = '404';
  }

}



?>
