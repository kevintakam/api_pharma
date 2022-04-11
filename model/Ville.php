<?php
require_once '../framework.php';
class Ville{
    private $connexion;
    private $table = "ville";

    public $id_vil;
    public $nom_vil;
    public $id_reg;
    

    /**
     * Pays.php constructor.
     * @param $db
     */
    public function __construct($db)
    {
        $this->connexion = $db;
    }

    /**
     * on recupere tous les pays dans la bd
     * @return array|null
     */
    public function lire(){
          $sql = "SELECT * FROM  ville";
        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query;
        
    }

    public function lireUn(){
        $data  = R::getRow("SELECT * FROM ".$this->table ."WHERE id_vil =" .$this->id);
    }

    /**
     * creation d'une ville
     */
    public function creer(){
        //requete
        $sql = "INSERT INTO ville (nom_vil,id_reg)VALUES(:nom_vil,:id_reg)";
        //preparation de la requete
        $requete = $this->connexion->prepare($sql);
        $requete -> bindParam(':nom_vil',$this->nom_vil);
        $requete -> bindParam(':id_reg',$this->id_reg);
        $result= $requete->execute();
                   if($result){
                    return true;
                   }
                   else{
                    return false;
                   }
    }

    /**
     * modifier un ville
     * @return bool
     */
    public function supprimer(){
        // On écrit la requête
        $sql = "DELETE FROM " . $this->table . " WHERE id_vil = ?";

        // On prépare la requête
        $query = $this->connexion->prepare( $sql );

        // On sécurise les données
        $this->id_ville=htmlspecialchars(strip_tags($this->id_ville));

        // On attache l'id
        $query->bindParam(1, $this->id_ville);

        // On exécute la requête
        if($query->execute()){
            return true;
        }

        return false;
    }


    public function modifier(){
     
    }


}