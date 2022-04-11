<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
//on verifie que la methode utilise est correcte
if($_SERVER['REQUEST_METHOD'] == 'POST'){
if(isset($_POST)) {
    try {
        @require '../pharma.conf.php'; # Configurations
        
        $request = json_decode(file_get_contents('php://input'), TRUE);
        
        $A = new Adresse();
        if (isset($request['email']) && isset($request['quartier'])&&isset($request['lieu_dit'])&&isset($request['id_commune']) && isset($request['id_pat'])){ 
          $A->set_email (trim($request['email']));
          $A->set_quartier (trim($request['quartier']));
          $A->set_lieu_dit(trim($request['lieu_dit']));
          $A->set_id_commune((int) $request['id_commune']);
          $A->set_id_pat(  (int) $request['id_pat']);
          $A->set_type_a((int) $request['type_a']);
          
        echo  $A->nouveau(); 
    }else{
        $message= array();
        $message['statut'] = 0;
        $message['response'] = "Parametre incorrect";
        http_response_code(201);
        echo json_encode($message);
    }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
}else {
    echo  json_encode(["erreur 202"  => "la methode utilisee est non autorisee "]);
}