<?php
error_reporting(0);

header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Method:POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('function.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if($requestMethod == "POST"){

    $inputData = json_decode(file_get_contents("php://input"), true);
    if(empty($inputData)){

        $storeClient = storeClient($_POST);

    }
    else
    {
        $storeClient = storeClient($inputData);
    }
        echo $storeClient;

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