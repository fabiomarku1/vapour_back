<?php
include("../vapour_back/IRepositoryBase.php");
class ProductRepository implements IRepositoryBase
{
    private PDO $connection;
    public function __construct(Database $database)
    {
        $this->connection = $database->getConnection();
    }


    /**
     * @param mixed $request
     * @return mixed
     */
    public function Create($data)
    {
       
        $sql = "INSERT INTO Product (name,price,quantity,description,publishDate,categoryId) 
        VALUES (:Name,:Price,:Quantity,:Description,:PublishDate,:CategoryId)";

        $stmt = $this->connection->prepare($sql);
        
        $stmt->bindValue(":Name", $data["Name"], PDO::PARAM_STR);
        $stmt->bindValue(":Price", $data["Price"], PDO::PARAM_INT);
        $stmt->bindValue(":Quantity", $data["Description"], PDO::PARAM_INT);
        $stmt->bindValue(":Description", $data["Description"], PDO::PARAM_STR);
        $stmt->bindValue(":PublishDate", date('Y-m-d H:i:s'));//fixxxxxxxx
        $stmt->bindValue(":CategoryId", $data["CategoryId"], PDO::PARAM_INT);
        //add more properites for binding

       
        $stmt->execute();
        return true;
    }

    function saveImage($productId,$imageData) {
        $product=$this->FindById($productId);
      
      var_dump($imageData);
        $filename = $product["Name"].time().".png"; // use a timestamp for the filename to avoid collisions
        
        $filePath ="C:/XAMP/htdocs/vapour_back/images/products/".$filename;
        $product["Image"]=$filePath;

        if (file_put_contents($filePath, $imageData)) //success
        {
            $sql = "UPDATE Product SET Image=(:filePath) WHERE Id=(:Id)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(":filePath", $filePath, PDO::PARAM_STR);
            $stmt->bindValue(":Id", $product["Id"], PDO::PARAM_INT);
            $stmt->execute();

          $response = array("status" => "success", "message" => "Image saved successfully.");
          echo json_encode($response);
        } else {
          // Return an error response
          $response = array("status" => "error", "message" => "Failed to save image.");
          echo json_encode($response);
        }
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
    public function FindAll()
    {
        $sql = "select * from Product";
        $stmt = $this->connection->query($sql);
        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
    public function Update(int $id, $request)
    {

    }

    /**
     *
     * @param int $id
     * @return mixed
     */
    public function Delete(int $id)
    {
        $sql = "DELETE from Product where Id=$id";
        $stmt = $this->connection->query($sql);
        $stmt->execute();
        return true;
    }


    private function mapData($existing, $request)
    {
        foreach ($request as $key => $val) {
            $existing[$key] = $val;
            //   var_dump("key=$key", "  value=$val");
        }
        return $existing;
    }
}

?>