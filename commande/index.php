<?php

// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



// On vérifie que la méthode utilisée est correcte
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $C = new Commande();
    
    if(isset($_GET['nombre']) && isset($_GET['nom'])) {
        echo $C->nombre_commande();
    }
    if(isset($_GET['traite']) && isset($_GET['nom'])) {
        echo $C->nombre_commande_traite();
    }
    if(isset($_GET['nom']) && isset($_GET['byjson'])) {
        echo  $C->nombre_commande_par( $_GET['nom']);
    }
    # retourne toutes les regions en chaine JSON pour client(s)
    try {
        if(isset($_GET['toutescom']) && isset($_GET['byjson'])) {
            echo $C->lire_tout_json();
        }
    }catch (Exception $e){
        echo $e->getMessage();
    }


    if(isset($_GET['id']) && isset($_GET['byjson'])) {
        echo  $C->lire_par_id((int) $_GET['id']);
    }elseif (isset($_GET['id'])){
        echo json_encode(["message" => "parametres incorrects"]);
    }

    if(isset($_GET['tel']) && isset($_GET['byjson'])) {
        echo  $C->lire_par_tel((int) $_GET['tel']);
    }elseif (isset($_GET['tel'])){
        echo json_encode(["message" => "parametres incorrects"]);
    }
    if(isset($_GET['commune']) && isset($_GET['byjson'])) {
        echo  $C->lire_par_commune( $_GET['commune']);
    }elseif (isset($_GET['commune'])){
        echo json_encode(["message" => "parametres incorrects"]);
    }
    if(isset($_GET['date_com']) && isset($_GET['byjson'])) {
        echo  $C->lire_par_date_com($_GET['date_com']);
    }elseif (isset($_GET['date_com'])){
        echo json_encode(["message" => "parametres incorrects"]);
    }

    if(isset($_GET['date_com_traite']) && isset($_GET['byjson'])) {
        echo  $C->lire_par_date_com_traite($_GET['date_com_traite']);
    }elseif (isset($_GET['date_com_traite'])){
        echo json_encode(["message" => "parametres incorrects"]);
    }

    if(isset($_GET['email']) && isset($_GET['byjson'])) {
        echo  $C->lire_par_email($_GET['email']);
    }elseif (isset($_GET['email'])){
        echo json_encode(["message" => "parametres incorrects"]);
    }

    if(isset($_GET['ville']) && isset($_GET['byjson'])) {
        echo  $C->lire_par_ville($_GET['ville']);
    }elseif (isset($_GET['ville'])){
        echo json_encode(["message" => "parametres incorrects"]);
    }

    if(isset($_GET['region']) && isset($_GET['byjson'])) {
        echo  $C->lire_par_region( $_GET['region']);
    }elseif (isset($_GET['region'])){
        echo json_encode(["message" => "parametres incorrects"]);
    }

    if(isset($_GET['pays']) && isset($_GET['byjson'])) {
        echo  $C->lire_par_pays($_GET['pays']);     
       
        }
        
        if(isset($_GET['id'])&&isset($_GET['idpat'])&&isset($_GET['ref'])&&isset($_GET['statut'])){
           if(isset($_GET['note']) )
               $C->setNote($_GET["note"]);
           if( isset($_GET['ordonnance']))
               $C->setOrdonnance($_GET['ordonnance']);
           if(isset($_GET['livre']))
               $C->setLivre($_GET['livre']);
            $C->setIdPat((int) $_GET['idpat']);
            $C->setRef(trim($_GET['ref']));
            $C->setStatus(trim($_GET['statut']));
            if (isset($_GET['ordonnance'])) {
                $C->setOrdonnance(trim($_GET['ordonnance']));
            }
       
            $C->setLivre((int) $_GET['livre']);
            echo $C->maj((int) $_GET['id']);
        
    }elseif (isset($_GET['pays'])){
        echo json_encode(["message" => "parametres incorrects"]);
    }
    
    


    # SUPPRIMER COMMANDE
    if(isset($_GET['identifiant']) && isset($_GET['supprimer'])) {
        echo $C->supprimer((int) $_GET['identifiant']);
    }elseif (isset($_GET['identifiant']) || isset($_GET['supprimer'])){
        echo json_encode(["message" => "parametres incorrects"]);
    }
}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}

