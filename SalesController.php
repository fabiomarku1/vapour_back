<?php

class SalesController {

    public function __construct(private SalesRepository $repository)
    {
        
    }

    public function proccesRequest(string $method, $id)
    {
        if($id)
        {
            $this->processResorceRequest($method, $id);
        }
        else{
            $this->processCollectionRequest($method);
        }

    }
    public function processResorceRequest(string $method,string $id):void
    {
        var_dump("here at sales");
        switch($method){
            case "GET":
                echo json_encode($this->repository->FindById($id));
                break;
        }

    }

    public function processCollectionRequest(string $method):void
    {
       // var_dump($method,'test')
        switch($method){
            case "GET":
                echo json_encode($this->repository->FindAll());
                break;

            case "POST":
                $data =(array)json_decode( file_get_contents("php://input"),true);
                var_dump($data);

                $resp= $this->repository->Create($data);
                echo json_encode(
                    [
                        "message" => "User created",
                        "response" => $resp
                    ]
                );
                break;
        }
    }



}