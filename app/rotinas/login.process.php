<?php
$request_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$_SESSION['request_url'] = $request_url;

//caso usuario e senha informado entao executa a rotina de login
if (postVar('username') != '' && postVar('usrpwd') != '') {

  $res = autenticaUser(trim(postVar('username')), md5(trim(postVar('usrpwd'))));

  if (count($res) == 0) {
    $login_status = 'error';
  } else {
    //caso dados do usuario OK entao autentica
    for ($i = 0; $i < count($res); $i++) {

      if (postVar('username') == $res[0]['email']) {
        $_SESSION['usrCeos']  = $res[0]['email'];
        $_SESSION['usrLevel'] = $res[0]['nivel'];
        $login_status         = true;
        $req_url              = $app_url;
        if(sessionVar('request_url')!=$app_url){
          $req_url = sessionVar('request_url');
        }
        header("location:$req_url");
      }
    }
  }
} //caso erro no login ou entao apenas nao atenticado exibe o form de login