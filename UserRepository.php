<?php

class UserRepository{

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

    public function Create(array $data)
    {
        $sql = "INSERT INTO user (name,surname,age) VALUES (:name,:surname,:age)";
        
        $stmt = $this->connection->prepare($sql);
        
        $stmt->bindValue(":name",$data["name"],PDO::PARAM_STR);
        $stmt->bindValue(":surname",$data["surname"],PDO::PARAM_STR);
        $stmt->bindValue(":age",$data["age"],PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }
}
