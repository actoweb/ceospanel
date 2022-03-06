<?php

function autenticaUser($u='',$p=''){
  $res = false;
  if($u!=''&&$p!=''){
    $res = selectDB2('*','usuarios',array('email'=>$u,'senha'=>$p),false);
  }
  return $res;
}
