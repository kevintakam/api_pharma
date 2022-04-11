<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



// On vérifie que la méthode utilisée est correcte
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    
    $C = new Commentaire();
    if(isset($_GET['nombre']) && isset($_GET['nom'])) {
        echo $C->nombre_commentaire_par();
    }
    # retourne tous les villes en chaine JSON pour client(s)
    if(isset($_GET['touscommentaires']) && isset($_GET['byjson'])) {
        echo $C->lire_tout_json();
    }
    if(isset($_GET['login']) && isset($_GET['byjson'])) {
        echo  $C->lire_commentaire_par_com((string) $_GET['login']);
    }
    if(isset($_GET['refcom']) && isset($_GET['byjson'])) {
        echo  $C->lire_commentaire_par_refcom((string) $_GET['refcom']);
    }
    if(isset($_GET['type']) && isset($_GET['existe'])) {
        echo  $C->lire_commentaire_par_type( $_GET['type']);
    }
    
    if(isset($_GET['gestionnaire'])&&isset($_GET['commande'])&&isset($_GET['titre'])&&isset($_GET['contenu'])&&isset($_GET['type'])){
        $C->set_id_gest( (int) $_GET['gestionnaire'] );
        $C->set_id_com( (int) $_GET['commande']);
        $C->set_titre(trim($_GET['titre']));
        $C->set_contenu( trim($_GET['contenu']));
        $C->set_type((int)$_GET['type']);
        echo $C->nouveau();
    }
    //pour supprimer un commentaire
    if(isset($_GET['identifiant'])&&isset($_GET['supprimer'])){    
        echo $C->supprimer((int) $_GET['identifiant']);      
    }
    
}else{
    // On g�re  l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La methode n'est pas autorisee"]);
}