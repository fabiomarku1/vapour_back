<?php

declare(strict_types=1);

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
$database = new Database("localhost","test" ,"root","fabio123");
$database->getConnection();


if($parts[2]=="Sales")
{
    $salesRepo = new SalesRepository($database, "Sales");
    $saleController = new SalesController($salesRepo);
    $saleController->proccesRequest($_SERVER["REQUEST_METHOD"], $id);
}
else
{
    http_response_code(404);
    exit; 
}





//$repository = new UserRepository($database);

// $controller = new UserController($repository);
// $controller->proccesRequest($_SERVER["REQUEST_METHOD"], $id);





?>