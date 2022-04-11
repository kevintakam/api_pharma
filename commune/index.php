<?php


// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// On vérifie que la méthode utilisée est correcte
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $C = new Commune();

    # retourne toutes les regions en chaine JSON pour client(s)
    try {
        if (isset($_GET['toutescom']) && isset($_GET['byjson'])) {
            echo $C->lire_tout_json();
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }


    if (isset($_GET['ville']) && isset($_GET['byjson'])) {
        echo  $C->lire_commune_par_ville_json((int)$_GET['ville']);
    }


    if (isset($_GET['commune']) && isset($_GET['nom'])) {
        $commune = $C->lire_par_id((int)$_GET['commune']);
        echo json_encode($commune);
    }elseif (isset($_GET['commune']) || isset($_GET['nom'])){
        echo json_encode(["message" => "parametres incorrects"]);
    }

    # SUPPRIMER COMMUNE
    if (isset($_GET['identifiant']) && isset($_GET['supprimer'])) {
        echo $C->supprimer((int)$_GET['identifiant']);
    }
} else {
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}

