<?php

// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



// On vérifie que la méthode utilisée est correcte
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $G = new Gestionnaire();

    # retourne toutes les regions en chaine JSON pour client(s)
    try {
        if(isset($_GET['nombre']) && isset($_GET['nom'])) {
            echo $G->nombre_Gestionnaire();
        }
        if(isset($_GET['tousgest']) && isset($_GET['byjson'])) {
            echo $G->lire_tout_json();
        }
    }catch (Exception $e){
        echo $e->getMessage();
    }


    if(isset($_GET['gest']) && isset($_GET['nom'])) {
        $gest  =  $G->lire_par_id((int) $_GET['gest']);
        echo $gest;
    }

    if(isset($_GET['nomgest']) && isset($_GET['nom'])) {
        $gest  =  $G->lire_par_nom((string) $_GET['nomgest']);
        echo $gest;
    }

    # SUPPRIMER REGION
    if(isset($_GET['identifiant']) && isset($_GET['supprimer'])) {
        echo $G->supprimer((int) $_GET['identifiant']);
    }elseif (isset($_GET['identifiant']) || isset($_GET['supprimer'])){
        echo json_encode(["message" => "parametres incorrects"]);
    }
}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}


