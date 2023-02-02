<?php
declare(strict_types=1);


include("../testPhp/Presentation/SalesController.php");
include("../testPhp/Presentation/UserController.php");
include("../testPhp/Presentation/AuthenticationController.php");

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


if($parts[2]=="Sales")
{
    var_dump("gegegegeg");
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
    $userRepository = new UserRepository($database);
    $authRepository = new AuthenticationReposiory();
    $authController =new AuthenticationController($authRepository,$userRepository);
    $authController->proccesRequest($_SERVER["REQUEST_METHOD"], $id);
}
else
{
    http_response_code(404);
    exit; 
}











?>