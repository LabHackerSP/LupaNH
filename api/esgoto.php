<?php

class Esgoto{

	public static function adicionar($latitude, $longitude, $esgoto, $fossa){
         try{
            require_once('bd.php');
            $sql = "insert into esgoto (latitude, longitude, esgoto, fossa) values (:latitude, :longitude, :esgoto, :fossa)";
            $p_sql = new PDO ($dados_banco['host'],$dados_banco['usuario'], $dados_banco['senha'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $p_sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $p_sql->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
            $call = $p_sql->prepare($sql);
            $call->bindValue(':latitude', $latitude);
            $call->bindValue(':longitude', $longitude);
            $call->bindValue(':esgoto', $esgoto);
            $call->bindValue(':fossa', $fossa);
            $call->execute();
            $resposta = array(
                "status" => "ok",
                "mensagem" => "Dados enviados com sucesso!"
            );
            echo json_encode($resposta);
         }catch(Exception $e){
             echo $e;
            $resposta = array(
                "status" => "erro",
                "mensagem" => "Ocorreu um erro, tente novamente em instantes!"
            );
            echo json_encode($resposta);
         }
    }
    
    public static function consultar(){
        try{
            require_once('bd.php');
            $sql = "select * from esgoto";
            $p_sql = new PDO ($dados_banco['host'],$dados_banco['usuario'], $dados_banco['senha'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $p_sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $p_sql->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
            $call = $p_sql->prepare($sql);
            $call->execute();
            $dados = array();
            while($row = $call->fetch(PDO::FETCH_ASSOC)){
                $dados[] = self::montar($row);
            }
            $resposta = array(
                "status" => "ok",
                "dados" => $dados
            );
            echo json_encode($resposta, 256);
            
        }catch (Exception $e){
            $resposta = array(
                "status" => "erro",
                "mensagem" => "Ocorreu um erro, tente novamente em instantes!"
            );
            echo json_encode($resposta);
        }
    }

    public static function montar($row){
        $denuncia = array(
            "id" => $row['id'],
            "latitude" => $row['latitude'],
            "longitude" => $row['longitude'],
            "esgoto" => $row['esgoto'],
            "fossa" => $row['fossa']
        );

        return $denuncia;
    }

}

?>