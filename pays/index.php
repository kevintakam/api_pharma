<?php

header("Content-Type: application/json; charset=UTF-8");
    $P = new Pays();
    
    # retourne tous les pays en chaine JSON pour client(s) 
    if(isset($_GET['touspays']) && isset($_GET['byjson'])) {
        echo json_encode($P->lire_tout_json());
    }
    
    if(isset($_GET['indicatif']) && isset($_GET['byjson'])) {
        echo  $P->lire_par_indicatif((int) $_GET['indicatif']);
    }
    
    
    if(isset($_GET['pays']) && isset($_GET['nom'])) {
        $pays = Pays::getById(((int) $_GET['pays']));
        echo json_encode($pays);
    }
    
    # SUPPRIMER PAYS
    if(isset($_GET['identifiant']) && isset($_GET['supprimer'])) {
        echo $P->supprimer((int) $_GET['identifiant']);
    }