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
    case 'GET':
        header("http/1.1 200 ok");
        $users =  new User_Model();

        if($users->find()->Count()>0){
            $listUsers = array();
            foreach($users->find()->fetch(true) as $user){
                // Tratamento do dados vindo do banco...
                array_push($listUsers,$user->data());
            }
            echo json_encode(array('response'=>$listUsers));
        }else{
            echo json_encode(array('response'=>'Não há usuários localizados.'));
        }

        break; 
    case 'PUT':
        $userId = filter_input(INPUT_GET,'id');
        if(!$userId){
            Validations::setHeaderResponse("400 Bad Request","id não informado");
            exit;
        }

        $data = json_decode(file_get_contents('php://input'),false);
        if(!$data){
            Validations::setHeaderResponse("400 Bad request","Nenhum dado foi informado.");
            exit;
        }
        $errors = Validations::validateFormCad($data);
        if($errors !== TRUE){
            Validations::setHeaderResponse("400 Bad request","Há campos inválidos no formulário.",$errors);
            exit;
        }

        if(!(new User_Model())->findById($userId)){
            Validations::setHeaderResponse("204 No Content","Nenhum usuário encontrado com esse id.");
            exit;
        }
        
        $data = json_decode(file_get_contents('php://input'),false);
        if(!$data){
            Validations::setHeaderResponse("400 Bad request","Nenhum dado foi informado.");
            exit;
        }
        $errors = Validations::validateFormCad($data);
        if($errors !== TRUE){
            Validations::setHeaderResponse("400 Bad request","Há campos inválidos no formulário.",$errors);
            exit;
        }

        $user =  (new User_Model())->findById($userId);
        $user->nome_usuario  = $data->nome_usuario;
        $user->email_usuario = $data->email_usuario;
        $user->usuario = $data->usuario;
        $user->senha  = $data->senha;
        
        $user->save();
        if ($user->fail()) {
            Validations::setHeaderResponse("500 Internal Server Error", $user->fail()->getMessage());
            exit;
        }
        else
            Validations::setHeaderResponse("201 Created","Usuário atualizado com sucesso.");
        
        break;
        case 'DELETE':
            $userId = filter_input(INPUT_GET,'id');
            if(!$userId){
                Validations::setHeaderResponse("400 Bad Request","id não informado");
                exit;
            }
            $user = (new User_Model())->findById($userId);
            if(!$user){
                Validations::setHeaderResponse("204 No Content","Nenhum usuário encontrado com esse id.");
                exit;
            }
             $valid = $user->destroy();
             if($user->fail()){
                Validations::setHeaderResponse("500 Internal Server Error",$user->fail()->getMessage());
                exit;
             }
            $valid ? Validations::setHeaderResponse("200 Ok","Usuário removido com sucesso."):
                     Validations::setHeaderResponse("200 Ok","Nenhum usuário pode removido.");
            break;
    default:
        // O metodo usado não é autorizado
        Validations::setHeaderResponse("401 Unauthorized","Método não previsto na API.");

}
