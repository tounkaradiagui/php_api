<?php

require '../inc/dbconn.php';

function getListClient(){

    global $dbconnection;

    $query = "SELECT * FROM customers";
    $query_exec = mysqli_query($dbconnection, $query);

    if($query_exec){

        if(mysqli_num_rows($query_exec) > 3)
        {
            $res = mysqli_fetch_all($query_exec, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => 'Félicitaions ! le client a été enregistré',
                'data' => $res,
            ];
        
            header("HTTP/1.0 200 Opération réussie !");
        
            return json_encode($data);
        }
        else
        {
            $data = [
                'status' => 404,
                'message' => 'Aucun client trouvé dans la base de données, Veuillez réessayer !',
            ];
        
            header("HTTP/1.0 404 Aucun client trouvé dans la base de données, Veuillez réessayer");
        
            return json_encode($data);
        }
    }
    else
    {
        $data = [
            'status' => 500,
            'message' => 'Erreur liée au serveur interne !',
        ];
    
        header("HTTP/1.0 500 Erreur liée au serveur interne");
    
        return json_encode($data);
    }

}

function error442($message){

    $data = [
        'status' => 422,
        'message' => $message
    ];

    header("HTTP/1.0 422 Entité non trouvable");

    echo json_encode($data);
    exit();
}

function storeClient($customerInput){
    global $dbconnection;

    $nom = mysqli_real_escape_string($dbconnection, $customerInput['nom']);
    $prenom = mysqli_real_escape_string($dbconnection, $customerInput['prenom']);
    $email = mysqli_real_escape_string($dbconnection, $customerInput['email']);
    $phone = mysqli_real_escape_string($dbconnection, $customerInput['phone']);

    if(empty(trim($nom)))
    {
        return error442('Entrer votre nom');
    }
    elseif(empty(trim($prenom)))
    {
        return error442('Entrer votre prenom');
        
    }
    elseif(empty(trim($email)))
    {
        return error442('Entrer votre email');
        
    }elseif(empty(trim($phone)))
    {
        return error442('Entrer votre de téléphone');

    }
    else
    {
        $query  = "INSERT INTO customers (nom, prenom,email, phone) VALUES('$nom', '$prenom', '$email', '$phone')";
        $result = mysqli_query($dbconnection, $query);

        if($result){
            $data = [
                'status' => 201,
                'message' => ' Enregistrement effectué avec succès !',
            ];
        
            header("HTTP/1.0 201 Création réussie");
        
            echo json_encode($data);
        }
        else{
            $data = [
                'status' => 500,
                'message' => 'Erreur liée au serveur interne !',
            ];
        
            header("HTTP/1.0 500 Erreur liée au serveur interne");
        
            return json_encode($data);
        }
    }
}

function getClient($customerParams){
    global $dbconnection;

    if($customerParams['id'] == NULL)
    {
        return error442("Entrer l'id du client");
    }

    $customerId = mysqli_real_escape_string($dbconnection, $customerParams['id']);
    $query = "SELECT * FROM customers WHERE id='$customerId' LIMIT 1";
    $result = mysqli_query($dbconnection, $query);

    if($result)
    {
        if(mysqli_num_rows($result) == 1)
        {
            $res = mysqli_fetch_assoc($result);
            $data = [
                'status' => 200,
                'message' => 'Félicitaions ! Client retrouver',
                'data' => $res,
            ];
        
            header("HTTP/1.0 200 Opération réussie !");
        
            return json_encode($data);
        }
        else
        {
            $data = [
                'status' => 404,
                'message' => 'Aucun client trouvé dans la base de données !',
            ];
        
            header("HTTP/1.0 404 Erreur");
        
            return json_encode($data);
        }
    }
    else
    {
        $data = [
            'status' => 500,
            'message' => 'Erreur liée au serveur interne !',
        ];
    
        header("HTTP/1.0 500 Erreur liée au serveur interne");
    
        return json_encode($data);
    }
}

function updateClient($customerInput, $customerParams){
    global $dbconnection;

    if(!isset($customerParams['id'])){
        return error442('client introuvable');
    }
    elseif($customerParams['id'] == NULL)
    {
        return error442("Entrer l'id du client");
    }

    $customerId = mysqli_real_escape_string($dbconnection, $customerParams['id']);
    $nom = mysqli_real_escape_string($dbconnection, $customerInput['nom']);
    $prenom = mysqli_real_escape_string($dbconnection, $customerInput['prenom']);
    $email = mysqli_real_escape_string($dbconnection, $customerInput['email']);
    $phone = mysqli_real_escape_string($dbconnection, $customerInput['phone']);

    if(empty(trim($nom)))
    {
        return error442('Entrer votre nom');
    }
    elseif(empty(trim($prenom)))
    {
        return error442('Entrer votre prenom');
        
    }
    elseif(empty(trim($email)))
    {
        return error442('Entrer votre email');
        
    }elseif(empty(trim($phone)))
    {
        return error442('Entrer votre de téléphone');

    }
    else
    {
        $query  = "UPDATE customers SET nom='$nom', prenom='$prenom', email='$email', phone='$phone' WHERE id='$customerId' LIMIT 1";
        $result = mysqli_query($dbconnection, $query);

        if($result){
            $data = [
                'status' => 200,
                'message' => ' Modification effectuée avec succès !',
            ];
        
            header("HTTP/1.0 200 Modification réussie");
        
            echo json_encode($data);
        }
        else{
            $data = [
                'status' => 500,
                'message' => 'Erreur liée au serveur interne !',
            ];
        
            header("HTTP/1.0 500 Erreur liée au serveur interne");
        
            return json_encode($data);
        }
    }
}

function deleteClient($customerParams){
    global $dbconnection;

    if(!isset($customerParams['id'])){
        return error442('client introuvable');
    }
    elseif($customerParams['id'] == NULL)
    {
        return error442("Entrer l'id du client");
    }

    $customerId = mysqli_real_escape_string($dbconnection, $customerParams['id']);
    $query = "DELETE FROM customers WHERE id='$customerId' LIMIT 1";

    $result = mysqli_query($dbconnection, $query);

    if($result)
    {
        $data = [
            'status' => 200,
            'message' => 'Félicitaions ! Client supprimé avec succès',
        ];
    
        header("HTTP/1.0 200 Suppression réussie !");
    
        return json_encode($data);
    }
    else
    {
        $data = [
            'status' => 404,
            'message' => 'Aucun client trouvé dans la base de données !',
        ];
    
        header("HTTP/1.0 404 Erreur");
    
        return json_encode($data);
    }
}

?>