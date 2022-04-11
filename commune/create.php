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
                    if(isset($_POST)) {
                         $request = json_decode(file_get_contents('php://input'), TRUE);
                           $C = new Commune();
                            $C->setNom(strtolower(trim($request['nom'])));
                            $C->setIdVil((int)$request['identifiantVille']);
                                echo $C->nouveau();
                                    }else{
                                            echo Controller::response([
                                                'message' => 'ok'
                                            ], 1);
                                        }
                                }else{
                                    // On gère l'erreur
                                    http_response_code(405);
                                    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
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
