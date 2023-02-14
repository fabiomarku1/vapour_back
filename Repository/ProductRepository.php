<?php

class ProductRepository implements IRepositoryBase{
    private PDO $connection;
    public function __construct(Database $database,private RepositoryManager $repositoryManager)
    { 
        $this->connection = $database->getConnection();
    }


	/**
	 * @param mixed $request
	 * @return mixed
	 */
	public function Create($data)
    {
        var_dump($data);

        $sql = "INSERT INTO user () VALUES ()";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":Name", $data["Name"], PDO::PARAM_STR);
        $stmt->bindValue(":Pricate", $data["Price"], PDO::PARAM_STR);
        $stmt->bindValue(":Description", $data["Description"], PDO::PARAM_INT);
        $stmt->bindValue(":DateCreated", date ('Y-m-d H:i:s'));
        //add more properites for binding

        $stmt->execute();
        return true;
	}
	
	/**
	 *
	 * @param mixed $id
	 * @return mixed
	 */
	public function FindById($id) 
    {
        $sql = "SELECT * FROM Product where Id=$id";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
     
        return $data == false ? throw new NotFoundException("Product with id $id doesnt exists") : $data;
	}
	
	/**
	 * @return mixed
	 */
	public function FindAll() {
        $sql = "select * from Product";
        $stmt = $this->connection->query($sql);
        $data = [];
        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $data[] = $row;
        }
        return $data;
	}
	
	/**
	 *
	 * @param int $id
	 * @param mixed $request
	 * @return mixed
	 */
	public function Update(int $id, $request) {

	}
	
	/**
	 *
	 * @param int $id
	 * @return mixed
	 */
	public function Delete(int $id) {
        $sql="DELETE from Product where Id=$id";
		$stmt = $this->connection->query($sql);
		$stmt->execute();
		return true;
	}

    
    private function mapData($existing,$request){    
        foreach($request as $key=>$val)
        {
            $existing[$key] = $val;
         //   var_dump("key=$key", "  value=$val");
        }
        return $existing;
    }
}

?>