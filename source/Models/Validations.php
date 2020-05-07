<?php

namespace Source\Models;

final class Validations{

    public static function validationString(string $string){
        return strlen($string) >= 3 && !is_numeric($string);
    }

    public static function validateEmail(String $email){
        return filter_var($email,FILTER_VALIDATE_EMAIL);
    }

    public static function validateInteger(string $integer){
        return filter_var($integer,FILTER_VALIDATE_INT);
    }


    public static function validateFormCad($data){
        $errors =  array();
        if(!Validations::validationString($data->nome_usuario)){
            array_push($errors,"Nome");
        }
        if(!Validations::validateEmail($data->email_usuario)){
            array_push($errors,"E-mail");
        }
        if(!Validations::validationString($data->usuario)){
            array_push($errors,"Usuário");
        }
        if(!Validations::validationString($data->senha)){
            array_push($errors,"Senha");
        }

        return count($errors) > 0 ? $errors:TRUE;
    }

    
    public static function setHeaderResponse(string $header,string $response,$fields = null){
        header("http/1.1".$header);
        if($fields)
            echo json_encode( array('reponse'=>$response,'fields'=>$fields));
        else
            echo json_encode( array('reponse'=>$response));


    }

}
