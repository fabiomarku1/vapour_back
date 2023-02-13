<?php

use function PHPSTORM_META\type;

 include("../testPhp/Exceptions/NotFoundException.php");
 include("../testPhp/Exceptions/BadRequestException.php");
class UserRepository implements IRepositoryBase{

    private PDO $connection;
    public function __construct(Database $database)
    {
        $this->connection = $database->getConnection();
    }

    public function FindAll():array{
        $sql = "select * from user";

        $stmt = $this->connection->query($sql);

        $data = [];

        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $data[] = $row;
        }
        return $data;
    }

    public function Create($data): bool
    {
        var_dump($data);
        $this->validate($data);


        $salt=$this->CreatePassword("Passowrd");

        var_dump($salt, gettype($salt));


        $sql = "INSERT INTO user (name,surname,age,dateCreated,password_hash) VALUES (:Name,:Surname,:Age,:DateCreated,:Password_Hash)";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":Name", $data["Name"], PDO::PARAM_STR);
        $stmt->bindValue(":Surname", $data["Surname"], PDO::PARAM_STR);
        $stmt->bindValue(":Age", $data["Age"], PDO::PARAM_INT);
        $stmt->bindValue(":DateCreated", date ('Y-m-d H:i:s'));


        $stmt->bindValue(":Password_Hash",$salt, PDO::PARAM_STR);
      
       // $stmt->bindValue(":Password_Hash",$salt);

        //add more properites for binding

        $stmt->execute();
        return true;
    }

    public function FindUserByEmail($email)
    {
        $sql = "SELECT * FROM User where Email=$email";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
     
        return $data == false ? throw new NotFoundException("User with Email =$email doesnt exists") : $data;
    }




	/**
	 * @param mixed $id
	 * @return mixed
	 */
	public function FindById($id) {
        $sql = "SELECT * FROM User where Id=$id";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
     
        return $data == false ? throw new NotFoundException("User with id $id doesnt exists") : $data;
	}
	
	/**
	 * @param mixed $request
	 * @return mixed
	 */
	public function Update(int $id,$request) {

        $existing=$this->FindById($id);
     //   var_dump($existing);
          $mapped= $this->mapData($existing, $request);
       // var_dump("after:::::",$mapped);

        $this->validate($request);

      #  $sql = "INSERT INTO user (name,surname,age) VALUES (:name,:surname,:age)";
        $sql = "UPDATE User 
                SET Name=(:Name) , Surname=(:Surname) , Age=(:Age)
                 Where Id=$id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":Name", $request["Name"], PDO::PARAM_STR);
        $stmt->bindValue(":Surname", $request["Surname"], PDO::PARAM_STR);
        $stmt->bindValue(":Age", $request["Age"], PDO::PARAM_INT);

        $stmt->execute();
        return true;
	}

	/**
	 *
	 * @param mixed $request
	 * @return mixed
	 */
	public function Delete($id) {
        $existing=$this->FindById($id);

        $sql = "DELETE FROM User where Id=$id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        return true;
	}


    private function validate($requestArray):array
    {
        $clean = array();

        if(!isset($requestArray["Name"]))
        {
            throw new BadRequestException("the name is  required");
        }
        if (!isset($requestArray["Surname"]))
        throw new BadRequestException("the surnamename is  required");
        
        if(!isset($requestArray["Age"]))
        throw new BadRequestException("the age is required too");
    

        foreach($requestArray as $key=>$val)
        {
            $clean[$key] = $val;
        }

        return $clean;
    }

    private function mapData($existing,$request){    
        foreach($request as $key=>$val)
        {
            $existing[$key] = $val;
         //   var_dump("key=$key", "  value=$val");
        }
        return $existing;
    }

    private function CreatePassword(string $password)
    {
        include_once("../testPhp/Utility.php");
        Utility::$KEY;
        $passwordSalt = Utility::$KEY . $password;
        $passwordHash = hash("sha512", $passwordSalt);

        return $passwordHash;
    }



	
}
