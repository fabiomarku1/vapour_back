<?php
declare(strict_types=1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); 

include("../vapour_back/Presentation/SalesController.php");
include("../vapour_back/Presentation/UserController.php");
include("../vapour_back/Presentation/AuthenticationController.php");
include("../vapour_back/Repository/RepositoryManager.php");
include("../vapour_back/Presentation/ProductController.php");
include("../vapour_back/Repository/ProductRepository.php");
spl_autoload_register(function ($class) {
    require __DIR__ . "/$class.php";
});

set_exception_handler("ErrorHandler::handleException");

header("Content-type: application/json; charset=UTF-8");

$parts = explode("/", $_SERVER["REQUEST_URI"]);

// if($parts[2]!="User") #hereeeeeeeeeeeeeeeee for the api name http://localhost:80/web/User
// {
//     http_response_code(404);
//     exit;
// }

$id = $parts[3] ?? null;
$database = new Database("localhost","web" ,"root","");
$database->getConnection();

$repositoryManager=new RepositoryManager($database);

if($parts[2]=="Sales")
{
    $salesRepo = new SalesRepository($database);
    $saleController = new SalesController($salesRepo);
    $saleController->proccesRequest($_SERVER["REQUEST_METHOD"], $id);
}
else if($parts[2]=="User")
{
$repository = new UserRepository($database);
$controller = new UserController($repository);
$controller->proccesRequest($_SERVER["REQUEST_METHOD"], $id); 
}
else if($parts[2]=="Auth")
{
    $authController =new AuthenticationController($repositoryManager);
    $authController->proccesRequest($_SERVER["REQUEST_METHOD"], $id);
}
else if ($parts[2]=="Product")
{
    $productController=new ProductController($repositoryManager);
    $productController->proccesRequest($_SERVER["REQUEST_METHOD"], $id);
}
else
{
    http_response_code(404);
    exit; 
}











?>