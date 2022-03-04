<?php

define('DBHOST','localhost');
define('DBNAME','ufolog');
define('DBUSER','root');
define('DBPWD','32125');


/*
 * funcao pre historica REFATORADA dbf(str1,array,str2);
 * recebe
 * str1 a query a ser executada
 * array() campos para o prepare do PDO
 * str2 tipo de retorno esperado (fetch,num)
 * */
function dbf($query='',$args=array(),$ret=''){
  $results=false;
    if($query!=''){
    $hostname = DBHOST;
    $username = DBUSER;
    $password = DBPWD;
    $dbname   = DBNAME;
    try {
        $conn     = new PDO("mysql:dbname=$dbname;host=$hostname",$username,$password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt     = $conn->prepare($query);

        //BINDPARAMS
        if(is_array($args)&&count($args)>0){
          foreach ($args as $key => &$value) {
            $valor = $value;
            $stmt->bindParam( $key , $value);
          }
        }
        //EXECUTE QUERY
        $stmt->execute();
          if(strstr(strtoupper($query),'INSERT')){$results  = $conn->lastInsertId();}//ultimo ID inserido
          if(strstr(strtoupper($query),'UPDATE')){$results  = $stmt->rowCount();}//ultimo ID inserido
          if(strstr(strtoupper($query),'DELETE')){$results  = $stmt->rowCount();}//ultimo ID inserido
          if($ret=='fetch'){$results  = $stmt->fetchAll(PDO::FETCH_ASSOC);}
          if($ret=='num'){$results  = $stmt->rowCount();}//numero de linhas afetadas
    } catch (PDOException $e) {
    $results = 'ERROR:'.$e->getMessage();
    return $results;
    }
  }
  return $results;
}

/*

$add_clone_serv = dbf('INSERT INTO servicos (
                      id_empresa,id_categoria,modalidade_servico,nome_servico,desc_servico,nomeplano_servico,preco_servico,status_servico
                      ) VALUES (
                      :id_empresa,:id_categoria,:modalidade_servico,:nome_servico,:desc_servico,:nomeplano_servico,:preco_servico,:status_servico
                      )',array(
                      ':id_empresa'=>$idEMPRESA,
                      ':id_categoria'=>$clone_id_categoria,
                      ':modalidade_servico'=>$clone_modalidade_servico,
                      ':nome_servico'=>$clone_nome_servico,
                      ':desc_servico'=>$clone_desc_servico,
                      ':nomeplano_servico'=>$clone_nomeplano_servico,
                      ':preco_servico'=>$clone_preco_servico,
                      ':status_servico'=>$clone_status_servico));



*/

?>
