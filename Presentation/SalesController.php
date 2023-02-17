<?php
include("../vapour_back/DTO/SaleUpdateDTO.php");
class SalesController
{

    public function __construct(private SalesRepository $repository)
    {

    }

    public function proccesRequest(string $method, $id)
    {
        if ($id) {
            $this->processResorceRequest($method, $id);
        } else {
            $this->processCollectionRequest($method);
        }
    }
    public function processResorceRequest(string $method, string $id): void
    {
        switch ($method) {
            case "GET": //ok
                echo json_encode($this->repository->FindById($id));
                break;

            case "PUT":
                $data = (array)json_decode(file_get_contents("php://input"), true);

                
                $existing = $this->repository->FindById($id);
              
                if($existing ==null)
                {
                    echo "its null";
                    exit;
                }
                
                //mapping from existing to the new one
                foreach($data as $key=>$val)
                {
                    $existing[$key] = $data[$key];
                }

              //  $request=new SalesUpdateDTO($existing);
               
           //     var_dump(json_encode($existing));
                exit;

                $update = $this->repository->Update($data);
                echo json_encode(
                    [
                        "message" => "Sales updated",
                        "response" => $update
                    ]
                );
                break;

            case "DELETE":
                $delete = $this->repository->Delete($id);
                echo json_encode(
                    [
                        "message" => "Sales deleted",
                        "response" => $delete
                    ]
                );
                break;
        }
    }

    public function processCollectionRequest(string $method): void
    {
        switch ($method) {
            case "GET": //get all
                echo json_encode($this->repository->FindAll());
                break;

            case "POST":
                $data = (array)json_decode(file_get_contents("php://input"), true);
                $resp = $this->repository->Create($data);
                echo json_encode(
                    [
                        "message" => "Sales created",
                        "response" => $resp
                    ]
                );
                break;
        }
    }



    public function Map()
    {

    }
}
