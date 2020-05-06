<?php

namespace Source\Models;

final class Validations{

    public static function validationString(string $string){
        return strlen($string) >= 3 && is_numeric($string);
    }

    public static function validateEmail(String $email){
        return filter_var($email,FILTER_VALIDATE_EMAIL);
    }

    public static function validateInteger(string $integer){
        return filter_var($integer,FILTER_VALIDATE_INT);
    }


}
