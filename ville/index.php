<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



// On vérifie que la méthode utilisée est correcte
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    
$V = new Ville();


# retourne tous les villes en chaine JSON pour client(s)
if(isset($_GET['toutesvilles']) && isset($_GET['byjson'])) {  
    echo $V->lire_tout_json();
}
if(isset($_GET['identifiant']) && isset($_GET['nom'])) {
    echo json_encode($V->lire_par_id((int) $_GET['identifiant']));
     
}
elseif (isset($_GET['identifiant']) && isset($_GET['nom'])){
    echo json_encode(['reponse' => 'parametre incorrect']);
}

#retourne une ville demandepar le client en json
if(isset($_GET['nom']) && isset($_GET['byjson'])) {
    echo  $V->lire_par_nom((string) $_GET['nom']);
}
//lire toutes les villes d'une region donnee
if(isset($_GET['nomreg']) && isset($_GET['byjson'])) {
    echo  $V->lire_vil_par_reg_json((string) $_GET['nomreg']);
}
//lire ville avec region
if(isset($_GET['ville']) && $_GET['byjson'])
     echo $V->lire_vil_reg_json();

if(isset($_GET['idreg']) && $_GET['byjson']){
    echo $V->lire_vil_par_reg_json_id( (int) $_GET['idreg']);         
}

# SUPPRIMER ville
if(isset($_GET['id']) && isset($_GET['supprimer'])) {
    echo $V->supprimer((int) $_GET['id']);
}
}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}