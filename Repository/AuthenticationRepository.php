<?php
include("../testPhp/vendor/autoload.php");
include("../testPhp/Utility.php");
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthenticationReposiory
{
    protected $key = "secretKEy";
    private PDO $connection;
    public function __construct(Database $database)
    {
        $this->connection = $database->getConnection();
    }

    public function Login($data)
    {
        $email = $data["Email"];
        $password=$data["Password"];

       $user=$this->FindUserByEmail($email);

       if($this->VerifyPassword($password,$user["Password_Hash"]))
       {
        return $this->GetToken($user);

       }
       else{
        throw new BadRequestException("You are not Allowed");
       }
     

    }

    public function Register($request)
    {
        if($request["Password"]!=$request["ConfirmPassword"])
        throw new BadRequestException("password doesnt match !");

        $user=$this->FindAndCheckIfExistUserByEmail($request["Email"]);
        if($user)
            throw new BadRequestException("User already exists");

        //$this->validate($request);
        $salt = $this->CreatePassword($request["Password"]);
       // var_dump($salt, gettype($salt));


        $sql = "INSERT INTO user (email,dateCreated,password_hash) VALUES (:Email,:DateCreated,:Password_Hash)";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":Email", $request["Email"]);
        $stmt->bindValue(":DateCreated", date('Y-m-d H:i:s'));
        $stmt->bindValue(":Password_Hash", $salt, PDO::PARAM_STR);



        $stmt->execute();
        return true;
    }

    public function GetToken($data)
    {
        $name = $data["Name"];
        $surname = $data["Surname"];

        try {
            $issueDate = time();
            $expiration = time() * 7200;
            $payload = [
                'iss' => 'http://localhost/testPhp',
                'aud' => 'http://localhost',
                'iat' => $issueDate,
                'nbf' => $expiration,
                'Id'=>$data["Id"],
                'Name' => $name,
                "Surname" => $surname,
                "Age"=>$data["Age"],
                "Email"=>$data["Email"],
                "DateCreated"=>$data["DateCreated"],
                "Role"=>$data["Role"]
            ];

            $jwt = JWT::encode($payload, $this->key, 'HS256');

            $this->SaveToken($data["Id"],$jwt);
            return $jwt;
            // $decoded = JWT::decode($jwt, new Key($this->key, 'HS256'));

            // print_r($decoded);

            // $decoded_array = (array) $decoded;

            // JWT::$leeway = 60; // $leeway in seconds
            // $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public function FindUserByEmail($email)
    {
        $sql = "SELECT * FROM User where Email='$email'";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
     
        return $data == false ? throw new NotFoundException("User with Email =$email doesnt exists") : $data;
    }


    public function FindAndCheckIfExistUserByEmail($email)
    {
        $sql = "SELECT * FROM User where Email='$email'";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
     
        return $data == false ? false : $data;
    }
    public function SaveToken($userId,$token)
    {
        $sql = "UPDATE User SET refresh_token='$token' where Id=$userId";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    private function CreatePassword(string $password)
    {
        Utility::$KEY;
        $passwordSalt = Utility::$KEY . $password;
        $passwordHash = hash("sha512", $passwordSalt);

        return $passwordHash;
    }

    private function VerifyPassword($password,$hash):bool
    {
       $existingPassword=$this->CreatePassword($password);
        return $existingPassword==$hash ? true :false;        
    }

}


?>