<?php 

namespace Source\Controlers;

use Source\Models\Validations;
use Source\Models\User_Model;

require_once('../../vendor/autoload.php');
require_once('../config.php');

//$_SERVER -> informações das requisições

switch($_SERVER['REQUEST_METHOD']){
    
    case 'POST':
        // validar os dados do post
        $data =  json_decode(file_get_contents('php://input'),false);
        if(!$data){
            Validations::setHeaderResponse("400 Bad request","Nenhum dado foi informado.");
            exit;
        }

        $errors = Validations::validateFormCad($data);
        if($errors !== TRUE){
            Validations::setHeaderResponse("400 Bad request","Há campos inválidos no formulário.",$errors);
            exit;
        }

        $user = new User_Model();
        $user->nome_usuario  = $data->nome_usuario;
        $user->email_usuario = $data->email_usuario;
        $user->usuario = $data->usuario;
        $user->senha  = $data->senha;
        $user->save();
        if($user->fail())
            Validations::setHeaderResponse("500 Internal Server Error",$user->fail()->getMessage());
        else{
            Validations::setHeaderResponse("201 Created","Usuário criado com sucesso.");
        }
        break;
    default:
        // O metodo usado não é autorizado
        Validations::setHeaderResponse("401 Unauthorized","Método não previsto na API.");

}
