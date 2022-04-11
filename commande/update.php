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

            $C = new Commande();

            if (isset($request['id'])  && isset ($request['ref'])  && isset($request['statut'])){
                $C->setIdPat((int)$request['id_pat']);
                $C->setRef(trim($request['ref']));
                $C->setStatus(trim($request['statut']));
                $C->setLivre((int)$request['livre']);
                if (isset($request['ordonnance'])) {
                    $C->setOrdonnance(trim($request['ordonnance']));
                }
                if (isset($request['note'])) {
                    $C->setNote(trim($request['note']));
                }
                echo $C->maj((int) $request['id']);
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
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
