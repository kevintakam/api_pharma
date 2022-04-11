<?php

// header requis
header("Access-Control-Allow-Orign: * "); // permet d'autoriser ou interdit l'access à l'api en fonction de l'origine de l'utilisateur
header("Content-Type: application/json; charset=utf-8"); //le contenu de la reponse json pour repondre à la concrete de la norme REST permettant de repondre à n'importe quel type d'appareil
header("Access-Control-Allow-Methods: GET"); // methode accepte pour la requete en question
header("Access-Control-Max-Age:3600");//  dure de vie de la requete
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); //  les headers autorisés au niveau de la requete de l'utilisateur

// on verifie que la méthode utilisée est correcte
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    // On inclut les fichiers de configuration et d'accès aux données
    include_once '../config/Database.php';
    include_once '../model/Commune.php';

    //on instancie la base de données
    $database = new Database();
    $db = $database->getConnection();

    //  on instancie les pays
    $commune = new Commune($db);

    //On recupere les données
    $stmt = $commune->lire();

    // On verifie si on a au moins un pays
    if($stmt->rowCount() >0){
        // on initialise les tableaux associatif
        $tb_commune =[];
        $tb_commune['commune'] = [];

        // on parcourt les pays
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){// fetch est mieux que fetch_all pour les api il a été trouvé
            extract($row);

            $com = [
                "id_commune" =>  $id_commune,
                "nom_commune" => $nom_commune,
                "id_vil" => $id_vil
                
            ];
            $tb_commune['commune'][] = $com;
        }
        // on envoie le code reponse 200 ok
        http_response_code(200);

        // on encode en json et on envoie
        echo json_encode($tb_commune);
    }



}else{
    // gestion des erreurs
    http_response_code(405); // La méthode HTTP utilisée n'est pas traitable par l'API
    echo json_encode(["message" => "la methode n'est pas autorisé"]);
}
