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
                                 $V = new Ville();
                                    if (isset($request['nom']) && isset($request['id_reg'])){ 
                                                 $V->set_nom(trim($request['nom']));
                                                 $V->set_id_reg((int) $request ['id_reg']);
                                                 echo  $V->nouveau();
                                    }else{
                                        $message= array();
                                        $message['statut'] = 0;
                                        $message['response'] = "Parametre incorrect";
                                        http_response_code(201);
                                        echo json_encode($message);
                                      }
                        }else{
                            echo Controller::response([
                                'message' => 'ok'
                            ], 1);
                        }
           }else {
                    echo  json_encode(["erreur 202"  => "la methode utilisee est non autorisee "]);
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
