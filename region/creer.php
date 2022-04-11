<?php 

// header requis
header("Access-Control-Allow-Orign: * "); // permet d'autoriser ou interdit l'access à l'api en fonction de l'origine de l'utilisateur
header("Content-Type: application/json; charset=utf-8"); //le contenu de la reponse json pour repondre à la concrete de la norme REST permettant de repondre à n'importe quel type d'appareil
header("Access-Control-Allow-Methods: POST"); // methode accepte pour la requete en question
header("Access-Control-Max-Age:3600");//  dure de vie de la requete
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); //  les headers autorisés au niveau de la requete de l'utilisateur
require_once '../config/Database.php';
require_once '../model/Region.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	//on instancie la base de donnee 
 $database = new Database();
 $db= $database->getconnection();
 //on instancie la table ville
 $region = new Region($db);
 //on recupere les informations envoyes
 $donnees = json_decode(file_get_contents("php://input"));
 if (!empty($donnees->nom_reg) && !empty($donnees->id_pays)) {
        //ici on a recupere les donnees
        //  on hydrate notre objet
        $region->nom_reg = $donnees->nom_reg;
        $region->id_pays = $donnees->id_pays;
        
        if ($region->creer()) {
            // Ici la création a fonctionné
            // On envoie un code 201  La création de la ressource s'est bien passée
            http_response_code(201);
            echo json_encode(["message" => "L'ajout a été effectué"]);
        } else {
            // ici la creation n'a pas fonctionné
            // on envoie un code 503
            http_response_code(503);
            echo json_encode(["message" => "L'ajout n'a pas été effectué; Veuillez completer les informations"]);
        }
    }


}
else{
  http_response_code(405);
  echo json_encode(['message' => 'la methode n est pas autorise']);

}




 ?>