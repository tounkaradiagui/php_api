<?php

header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Method:DELETE');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('function.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if($requestMethod == "DELETE"){
   
    $deleteCustomer = deleteClient($_GET);
    echo $deleteCustomer;

}
else{
    $data = [
        'status' => 405,
        'message' => $requestMethod. ' Méthode non autorisée !',
    ];

    header("HTTP/1.0 405 Methode non autorisée");

    echo json_encode($data);
}
?>