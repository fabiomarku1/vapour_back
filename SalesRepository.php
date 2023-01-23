<?php
class SalesRepository implements IRepositoryBase{

    private $tableName;
    private PDO $connection;
    public function __construct(Database $database,$table)
    {
        $this->connection = $database->getConnection();
        $this->tableName = $table;
    }
    
	/**
	 * @param mixed $request
	 * @return mixed
	 */
	public function Create($request) {

        $date =new DateTime("now");
      //  $result = $date->format('YYYY-MM-DD hh:mm:ss');
        $sql = "INSERT INTO $this->tableName (Amount,UserId) VALUES (:Amount,:UserId)";
        
        $stmt = $this->connection->prepare($sql);
        
        $stmt->bindValue(":Amount",$request["Amount"],PDO::PARAM_INT);
        $stmt->bindValue(":UserId",$request["UserId"],PDO::PARAM_INT);
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
        $sql = "select * from user";
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
	}
	
	/**
	 *
	 * @param mixed $request
	 * @return mixed
	 */
	public function Delete($request) {
	}
}