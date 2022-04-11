<?php

// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On vérifie que la méthode utilisée est correcte
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $P = new Patient();

    # retourne tous les patients en chaine JSON pour client(s)
    if(isset($_GET['nombre']) && isset($_GET['chiffre'])) {
        echo $P->nombre_patient();
    }
    if (isset($_GET['touspatient']) && isset($_GET['byjson'])) {
        echo $P->lire_tout_json();
    }

    if (isset($_GET['tel']) && isset($_GET['byjson'])) {
        echo $P->lire_par_tel((int)$_GET['tel']);
    }
    if(isset($_GET['email']) && isset($_GET['byjson'])) {
        $pat  =  $P->lire_par_email((string) $_GET['email']);
        echo $pat;
    }
    
    if(isset($_GET['nom']) && isset($_GET['existe'])) {
        $pat  =  $P->lire_par_nom((string) $_GET['nom']);
        echo $pat;
    }

    if(isset($_GET['pat']) && isset($_GET['byjson'])) {
        $pat  =  $P->lire_par_id((int) $_GET['pat']);
        echo $pat;
    }
    
    if(isset($_GET['adr'])){
        $pat= $P->login(trim($_GET['adr']));
        echo $pat;
    }

    # SUPPRIMER Patient
    if (isset($_GET['identifiant']) && isset($_GET['supprimer'])) {
        echo $P->supprimer((int)$_GET['identifiant']);
    }
}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}