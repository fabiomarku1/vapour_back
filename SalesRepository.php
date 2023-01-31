<?php

use PSpell\Dictionary;

class SalesRepository implements IRepositoryBase{

    private $tableName="Sales";
    private PDO $connection;
    public function __construct(Database $database)
    {
        $this->connection = $database->getConnection();
    }
    
	public function Create($request) {
		$date = date ('Y-m-d H:i:s');
        $sql = "INSERT INTO $this->tableName (Amount,UserId,DateCreated) VALUES (:Amount,:UserId,:DateCreated)";

        $stmt = $this->connection->prepare($sql);
		
		$bool["an"]=$stmt->bindValue(":Amount",$request["amount"],PDO::PARAM_INT);
       	$bool["userId"]= $stmt->bindValue(":UserId",$request["userId"],PDO::PARAM_INT);
		
		$stmt->bindValue(":DateCreated", $date, PDO::PARAM_STR);

		foreach($bool as $key=>$val)
		{
			if($val!=true)
			{
				throw new Exception("error at $key");

			}
		}

        $stmt->execute();
        return true;
	}
	
	/**
	 *
	 * @param mixed $id
	 * @return mixed
	 */
	public function FindById($id) {
        $sql = "SELECT * FROM $this->tableName WHERE Id=$id";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
   
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //var_dump($row);
       return $row;
	}
	
	/**
	 * @return mixed
	 */
	    public function FindAll():array{
        $sql = "select * from $this->tableName";
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
	 * @param mixed $request
	 * @return mixed
	 */
	public function Update($request) {

		$amount=$request["Amount"];
		$userId=$request["UserId"];
		$id = $request["id"];
		$sql="UPDATE $this->tableName 	SET Amount=$amount, UserId=$userId where Id=$id";

		$stmt = $this->connection->query($sql);
		$stmt->execute();
		return true;
	}
	
	/**
	 *
	 * @param mixed $request
	 * @return mixed
	 */
	public function Delete($id) {
		$sql="DELETE from $this->tableName where Id=$id";
		$stmt = $this->connection->query($sql);
		$stmt->execute();
		return true;
	}


	public function Update2(SalesUpdateDTO $request) {
		// $amount=$request["Amount"];
		// $userId=$request["UserId"];
		// $id = $request["id"];
		$sql="UPDATE $this->tableName 	SET Amount=$request->Amount, UserId=$request->UserId where Id=$request->Id";

		$stmt = $this->connection->query($sql);
		$stmt->execute();
		return true;
	}
}

?>