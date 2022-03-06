<?php

include_once('config.all.php');




function autenticaUser($u='',$p=''){
  $res = false;
  if($u!=''&&$p!=''){
    $res = selectDB2('*','usuarios',array('email'=>$u,'senha'=>$p),false);
  }
  return $res;
}



$auth = autenticaUser('roberto.rsc@gmail.com',md5('321254'));

if(count($auth)==0){
  echo 'Nenhum usuario localizado com os dados informados';
}else{

  if(is_array($auth)){
      if(count($auth)>0){
        for ($i = 0; $i < count($auth); $i++)
        {
          echo "Nome: ".$auth[$i]['nome']." <br />";
          echo "Email: ".$auth[$i]['email']." <br />";
        }
      }
  }

}
