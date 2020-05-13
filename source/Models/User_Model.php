<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;
use CoffeeCode\DataLayer\Connect;
class User_Model extends DataLayer{


    public function __construct(){
        //string "TABLE_NAME", array ["REQUIRED_FIELD_1", "REQUIRED_FIELD_2"], string "PRIMARY_KEY", bool "TIMESTAMPS"
        parent::__construct('tb_usuario',array('nome_usuario','email_usuario','usuario','senha'),'id_usuario',false);
    }

    public function authenticationUser($userName,$password){
        $connect = Connect::getInstance();
        $error = Connect::getError();
        if ($error) {
            echo $error->getMessage();
            exit;
        }

        $sql = $connect->prepare("SELECT id_usuario,nome_usuario,email_usuario FROM tb_usuario 
                                WHERE (usuario =  ? AND senha = ?)");

        $sql->execute(array($userName,$password));
        $res =  $sql->fetch();
        if($res)
            return $res;
        else
            return false;
    }

}