<?php

$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "api_php";


$dbconnection = mysqli_connect($hostname, $username, $password, $dbname);

if(!$dbconnection){
    
    die("Echec de connexion" . mysqli_connect_error());
}

?>