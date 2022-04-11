<?php

// header requis
header("Access-Control-Allow-Orign: * "); // permet d'autoriser ou interdit l'access à l'api en fonction de l'origine de l'utilisateur
header("Content-Type: application/json; charset=utf-8"); //le contenu de la reponse json pour repondre à la concrete de la norme REST permettant de repondre à n'importe quel type d'appareil
header("Access-Control-Allow-Methods: POST"); // methode accepte pour la requete en question
header("Access-Control-Max-Age:3600");//  dure de vie de la requete
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); //  les headers autorisés au niveau de la requete de l'utilisateur

// on verifie que la méthode utilisée est correcte
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // On inclut les fichiers de configuration et d'accès aux données
    include_once '../config/Database.php';
    include_once '../model/Commune.php';

    // On instancie la base de données
    $database = new Database();
    $db = $database->getConnection();

    // On instancie les produits
    $commune = new Commune($db);

    // on recupere les informations envoyées
    $donnees = json_decode(file_get_contents("php://input"));

    if (!empty($donnees->nom_com) && !empty($donnees->id_vil)) {
        //ici on a recupere les donnees
        //  on hydrate notre objet
        $commune->nom_commune = $donnees->nom_com;
        $commune->id_vil = $donnees->id_vil;
        if ($commune->creer()) {
            // Ici la création a fonctionné
            // On envoie un code 201  La création de la ressource s'est bien passée
            http_response_code(201);
            echo json_encode(["message" => "L'ajout a été effectué"]);
        } else {
            // ici la creation n'a pas fonctionné
            // on envoie un code 503
            http_response_code(503);
            echo json_encode(["message" => "L'ajout n'a pas été effectué; Veuillez completer les informations"]);
        }
    }
}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}