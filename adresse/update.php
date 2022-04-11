<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On vérifie que la méthode utilisée est correcte
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST)) {
        try {
            @require '../pharma.conf.php'; # Configurations

            $request = json_decode(file_get_contents('php://input'), TRUE);

            $A = new Adresse();
            if (isset($request['id']) && isset($request['email']) && isset($request['quartier'])&& isset($request['lieu_dit']) && isset($request['id_commune']) && isset($request['id_pat']) && isset($request['type_a'])){
                $A->set_email((string) $request['email']);
                $A->set_id_commune((int) $request['id_commune']);
                $A->set_lieu_dit( (string) $request['lieu_dit']);
                $A->set_quartier( (string) $request['quartier']);
                $A->set_id_pat(  (int) $request['id_pat']);
                $A->set_type_a( (int) $request['type_a']);
                echo $A->maj((int) $request['id']);
            }else{
                echo json_encode(["statut" => 0, "response" => "Rempli tous les champs"]);
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La methode n'est pas autorisee"]);
}


