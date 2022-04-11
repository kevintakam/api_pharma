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
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                 if (isset($_POST)){
                    $request = json_decode(file_get_contents('php://input'), TRUE);
                    $C = new Commande();
                    if(isset($_POST['id_pat']) && isset ($_POST['ref'])  && isset($_POST['livre'])) {
                        $C->setIdPat((int)$_POST['id_pat']);
                        $C->setRef(trim($_POST['ref']));
                        if (isset($_POST['statut']))
                            $C->setStatus(trim($_POST['statut']));
                            //$C->setStatus(trim(isset($request['statut'])));
              
                        $C->setLivre((int)$_POST['livre']);
                        if (isset($_POST['ordonnance'])) {
                            $C->setOrdonnance(trim($_POST['ordonnance']));
                            }
                            if (isset($_POST['note'])) {
                                $C->setNote(trim($_POST['note']));
                            }
                            if(isset($_POST['date_traite'])) {
                                $C->setDateComTraite(trim($_POST['date_traite']));
                            }
                            echo $C->nouveau();
                         } else {
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
