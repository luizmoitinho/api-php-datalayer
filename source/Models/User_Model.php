<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class User_Model extends DataLayer{


    public function __construct(){
        //string "TABLE_NAME", array ["REQUIRED_FIELD_1", "REQUIRED_FIELD_2"], string "PRIMARY_KEY", bool "TIMESTAMPS"
        parent::__construct('tb_usuario',array('nome_usuario','email_usuario','usuario','senha'),'id_usuario',false);
    }
}