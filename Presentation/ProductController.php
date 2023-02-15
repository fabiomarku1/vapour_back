<?php

class ProductController {

    public function __construct(private RepositoryManager $repositoryManager)
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
    public function processResorceRequest(string $method, string $id): void
    {

        switch ($method) {
            case "GET": //ok
                echo json_encode($this->repositoryManager->productRepository->FindById($id));
                break;

            case "PUT": //ok
                $data = (array) json_decode(file_get_contents("php://input"), true);
              //  $result = $this->repository->Update($id,$data);
                echo json_encode($result = $this->repositoryManager->productRepository->Update($id,$data));
                break;

            case "DELETE"://ok
                echo json_encode($this->repositoryManager->productRepository->Delete($id));      
         }
    }

    public function processCollectionRequest(string $method):void
    {
        switch($method){
            case "GET":
                echo json_encode($this->repositoryManager->productRepository->FindAll());
                break;

            case "POST":
                $data =(array)json_decode( file_get_contents("php://input"),true);
                var_dump($data);

                $resp= $this->repositoryManager->productRepository->Create($data);
                echo json_encode(
                    [
                        "message" => "Product created",
                        "response" => $resp
                    ]
                );
                break;
        }
    }



}