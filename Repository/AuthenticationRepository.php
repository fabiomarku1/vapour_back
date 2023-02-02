<?php
include("../testPhp/vendor/autoload.php");
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthenticationReposiory{

    protected $key = "mySecretKEy";

    public function authenticate($name,$surname)
    {
        try{
            $issueDate = time();
            $expiration=time()*7200;
            $payload = [
                'iss' => 'http://localhost/testPhp',
                'aud' => 'http://localhost',
                'iat' => $issueDate,
                'nbf' => $expiration,
                'Name'=>"Fabio",
                "Surname"=>"Marku"
            ];

            $jwt = JWT::encode($payload, $this->key, 'HS256');

            return $jwt;
            // $decoded = JWT::decode($jwt, new Key($this->key, 'HS256'));
            
            // print_r($decoded);
            
            // $decoded_array = (array) $decoded;

            // JWT::$leeway = 60; // $leeway in seconds
            // $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        }catch(PDOException $e)
        {
            echo $e->getMessage();
        }

    }


}


?>