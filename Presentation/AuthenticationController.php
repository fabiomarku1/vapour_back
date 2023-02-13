<?php
include("../testPhp/Repository/AuthenticationRepository.php");
class AuthenticationController
{
    public function __construct(private RepositoryManager $repositoryManager)
    {

    }

    public function proccesRequest(string $method, $ControllerName)
    {
        $this->processCollectionRequest($method, $ControllerName);
    }


    public function processCollectionRequest(string $method, $controllerName): void
    {     
        switch ($method) {
            case "POST" && $controllerName == "login": //get all
                $data = (array) json_decode(file_get_contents("php://input"), true);

                $result = $this->repositoryManager->authenticationRepository->Login($data);
                echo json_encode(
                    [
                        "token" => $result
                    ]
                );
                break;


            case "POST" && $controllerName == "register":
                $data = (array) json_decode(file_get_contents("php://input"), true);
                $result = $this->repositoryManager->authenticationRepository->Register($data);
                echo json_encode(
                    [
                        "message" => "Login response",
                        "response" => $result
                    ]
                );
                break;
        }
    }




}