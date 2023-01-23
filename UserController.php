<?php

class UserController {

    public function __construct(private UserRepository $repository)
    {
        
    }

    public function proccesRequest(string $method, $id)
    {
   //     var_dump($method, $id);
       // echo "exet";
        if($id)
        {
            echo "exet2";
            $this->processResorceRequest($method, $id);
        }
        else{
            
            $this->processCollectionRequest($method);
        }

    }
    public function processResorceRequest(string $method,string $id):void
    {

    }

    public function processCollectionRequest(string $method):void
    {
        var_dump($method,'test');
        switch($method){
            case "GET":
                echo json_encode($this->repository->FindAll());
                break;

            case "POST":
                echo "here t post";
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