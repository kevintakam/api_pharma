<?php
@require '../pharma.conf.php'; # Configurations
try {
if (Controller::connect()) {
  if(isset($_POST)) {    
        $request = json_decode(file_get_contents('php://input'), TRUE);
        
        $P = new Pays();
        
        if (isset($request['nom']) && isset($request['indicatif'])&& isset($request['indicatif'])){
            $P->set_nom(trim($request['nom']));
            $P->set_indicatif((int) $request ['indicatif']);
            $P->set_pattern(trim($request['pattern']));
            echo  $P->nouveau();
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