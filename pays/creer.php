<?php 
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//on verifie la methode utilise
if($_SERVER['REQUEST_METHOD'] == 'POST'){
 include_once '../config/Db1.php';
 include_once '../model/Pays.php';
//on instantiate la base de donnee

 $database=new Db1();
 $db= $database->getconnection();

 // on instatiate le pays
 $pays = new Pays();
  // On récupère les informations envoyées
    $donnees = json_decode(file_get_contents("php://input"));
    if(!empty($donnees->nom_pays) && !empty($donnees->indicatif) && !empty($donnees->pattern)){
$pays->nom_pays = $donnees->nom_pays;
$pays->indicatif = $donnees->indicatif;
$pays->pattern = $donnees->pattern;
if($pays->ajouterpays()){
  //ici la creation a ete effectue 
	//on envoi un code 201
	  http_response_code(201);
    echo json_encode(["message" => "L'ajout ete effectue"]);
}
else{
       //ici la creation a ete effectue 
	//on envoi un code 503
	  http_response_code(503);
    echo json_encode(["message" => "L'ajout ete effectue"]);
}

    }



}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}

 ?>