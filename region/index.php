<?php

// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



// On vérifie que la méthode utilisée est correcte
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $R = new Region();
    $P = new Pays();

    # retourne toutes les regions en chaine JSON pour client(s)
     try {
         if(isset($_GET['toutesreg']) && isset($_GET['byjson'])) {
             echo $R->lire_tout_json();
         }
     }catch (Exception $e){
         echo $e->getMessage();
     }


     if(isset($_GET['pays']) && isset($_GET['byjson'])) {
         echo  json_encode($R->lire_region_par_pays_json((int) $_GET['pays']));
     }

   


     if(isset($_GET['region']) && isset($_GET['nom'])) {
         $region =  $R->lire_par_id((int) $_GET['region']);
         echo json_encode($region);
     }
     
     if (isset($_GET['nom']) && isset($_GET['id_pays'])) {
         $R->setNom($_GET['nom']);
         $R->setIdPays((int) $_GET['id_pays']);
         echo $R->nouveau();
     }

     # SUPPRIMER REGION
     if(isset($_GET['identifiant']) && isset($_GET['supprimer'])) {
         echo $R->supprimer((int) $_GET['identifiant']);
     }
 }else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}

