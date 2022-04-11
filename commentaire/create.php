<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
//on verifie que la methode utilise est correcte
@require '../pharma.conf.php'; # Configurations
try {
    if (Controller::connect()) { 
                      if($_SERVER['REQUEST_METHOD'] == 'POST'){
                        if(isset($_POST)) {   
                            $request = json_decode(file_get_contents('php://input'), TRUE);
                                $C= new Commentaire();
                                $C->set_id_pat( (int) $request['id_pat']);
                                 $C->set_id_gest( (int) $request['id_gest']);
                                 $C->set_id_com( (int) $request['id_com']);
                                 $C->set_titre(trim($request['titre']));
                                 $C->set_contenu( trim($request['contenu']));
                                echo  $C->nouveau();  
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

