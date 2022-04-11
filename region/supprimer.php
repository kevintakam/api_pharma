<?php

// header requis
header("Access-Control-Allow-Orign: * "); // permet d'autoriser ou interdit l'access à l'api en fonction de l'origine de l'utilisateur
header("Content-Type: application/json; charset=utf-8"); //le contenu de la reponse json pour repondre à la concrete de la norme REST permettant de repondre à n'importe quel type d'appareil
header("Access-Control-Allow-Methods: DELETE"); // methode accepte pour la requete en question
header("Access-Control-Max-Age:3600");//  dure de vie de la requete
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); //  les headers autorisés au niveau de la requete de l'utilisateur

// on verifie que la méthode utilisée est correcte
if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    // On inclut les fichiers de configuration et d'accès aux données
    include_once '../config/Database.php';
    include_once '../model/Region.php';

    //on instancie la base de données
    $database = new Database();
    $db = $database->getConnection();

    //  on instancie les pays
    $region = new Region($db);
    $donnees = json_decode(file_get_contents("php://input"));

    if(!empty($donnees->id_region)){
        $region->id_reg = $donnees->id_region;

        if($pays->supprimer()){
            // Ici la suppression a fonctionné
            // On envoie un code 200
            http_response_code(200);
            echo json_encode(["message" => "La suppression a été effectuée"]);
        }else{
            // Ici la création n'a pas fonctionné
            // On envoie un code 503
            http_response_code(503);
            echo json_encode(["message" => "La suppression n'a pas été effectuée"]);
        }
    }
}else{
    // gestion des erreurs
    http_response_code(405); // La méthode HTTP utilisée n'est pas traitable par l'API
    echo json_encode(["message" => "la methode n'est pas autorisé"]);
}
