<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
if($_SERVER['REQUEST_METHOD'] == 'GET'){
$A = new Adresse();
//lire toutes les adresses
if(isset($_GET['toutesadresses']) && isset($_GET['byjson'])) {  
    echo  $A->lire_adr_com_json();
}
//lire par email
if(isset($_GET['email']) && isset($_GET['byjson'])){
    echo $A->lire_par_email((string) $_GET['email']);
}
//lire tous les objets
if(isset($_GET['objet'])){
  $objet= $A->lire_tout_objet();
  if($objet instanceof Adresse)
    echo  $objet->get_email();
    echo  $objet->get_id_commune();
}
if(isset($_GET['identifiant']) && isset($_GET['nom'])){
    $adresse=$A->lire_par_id( (int) $_GET['identifiant']);
    echo json_encode($adresse);
}
//supprimer une adresse
if(isset($_GET['identifiant']) && isset($_GET['supprimer'])){
    echo $A->supprimer((int) $_GET['identifiant']);   
}


if(isset($_GET['adresse']) && $_GET['byjson'])
    echo $A->lire_adr_par_com_json();
//lire toutes les adresses d'une commune
    if(isset($_GET['nomcom']) && isset($_GET['byjson'])) {
        echo  $A->lire_adr_par_com_json((string) $_GET['nomcom']);
    }
    //lire toutes les adresses d'une commune
    if(isset($_GET['idcom']) && isset($_GET['byjson'])) {
        echo  $A->lire_adr_par_com_id((string) $_GET['idcom']);
    }
}else{
    echo json_encode(["erreur 202"=>"la methode  est non autorise"]);
}