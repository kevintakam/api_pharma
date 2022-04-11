<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
@require '../pharma.conf.php'; # Configurations
// On vérifie que la méthode utilisée est correcte
try {
      if (Controller::connect()) { 
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                  if (isset($_POST)){
                    $request = json_decode(file_get_contents('php://input'), TRUE);
                    $G = new Gestionnaire();
                    $G->setNomUti(strtolower(trim($request['login'])));
                    $G->setMdp(trim($request['mdp']));
                    $G->setIdPat((int) $request['idp']);
                  echo $G->nouveau();
                 }
                 else{
                     echo Controller::response([
                         'message' => 'ok'
                     ], 1);
                 }
                 
            }else{
                // On gère l'erreur
                http_response_code(405);
                echo json_encode(["message" => "La methode n est pas autorisee"]);
            }
      }else{
          Controller::auth();
          echo Controller::response([
              'message' => 'connection_failed'
          ]);
      }
} catch (Exception $e) {
    echo Controller::response([
        'message' => $e->getMessage()
    ]);
}