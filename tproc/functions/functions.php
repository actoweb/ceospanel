<?php 
function fl($string='',$minsize=0,$maxsize=0,$direction='left',$leads=''){
  if($leads==' '){$leads="|";}
  if($string!=''){
    $size = strlen($string);  
    if($direction=='left'){
    $string = str_pad($string, $minsize, $leads, STR_PAD_LEFT);
    }
    if($direction=='right'){
    $string = str_pad($string, $minsize , $leads);
    }
    $string = str_replace('|','&nbsp;',$string);
  }
  return $string;
}

function cp_alfa($string='',$max=0){
  if($max>0){$string = substr($string, 0, $max);}
  $string = fl($string,$max,$max,'right',$leads=' ');
  return $string;
}

function cp_num($string='',$max=0){
  if($max>0){$string = substr($string, 0, $max);}
  $string = fl($string,$max,$max,'left',$leads='0');
  return $string;
}

function cp_data($string='',$max=0){
  $string = str_replace('/','',$string);
  $string = str_replace('-','',$string);
  $string = str_replace('','',$string);
  $string = trim($string);
  if($max>0){$string = substr($string, 0, $max);}
  $string = fl($string,$max,$max,'left',$leads='');
  return $string;
}

function cp_dataHora($string='',$max=0){
  $string = str_replace('/','',$string);
  $string = str_replace('-','',$string);
  $string = str_replace(':','',$string);
  $string = str_replace(' ','',$string);
  $string = trim($string);
  if($max>0){$string = substr($string, 0, $max);}
  $string = fl($string,$max,$max,'left',$leads='');
  return $string;
}


function cp_deci($string='',$max=0){
  
  $string = str_replace('.','',$string);
  $string = str_replace(',','',$string);
  $string = str_replace(' ','',$string);
  $string = trim($string);
  if($max>0){$string = substr($string, 0, $max);}
  if($string!=''){
    $string = fl($string,$max,$max,'left',$leads='0');
  }
  
  return $string;
}



?>
