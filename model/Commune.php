<?php
require_once '../framework.php';
class Commune{
    private $connexion;
    private $table = "commune";

    public $id_commune;
    public $nom_com;
    public $id_vil;
    

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
          $sql = "SELECT * FROM  commune";
        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query;
        
    }

    public function lireUn(){
        $data  = R::getRow("SELECT * FROM ".$this->table ."WHERE id_commune =" .$this->id);
    }

    /**
     * creation d'un pays
     */
    public function creer(){
        // on utilise la table pays
        //requete
       $sql= ("INSERT INTO commune (nom_commune,id_vil) VALUES (:nom_com,:id_vil)");
       //on prepare la requete
       $requete = $this->connexion->prepare($sql);
       $requete -> bindParam(':nom_com',$this->nom_com);
       $requete -> bindParam(':id_vil',$this->id_vil);
       $result=$requete->execute();
          if($result){
            return true;
          }
          else{
            return false;
          }

    }

    /**
     * modifier un pays
     * @return bool
     */
    public function supprimer(){
        // On écrit la requête
        $sql = "DELETE FROM " . $this->table . " WHERE id_vil = ?";

        // On prépare la requête
        $query = $this->connexion->prepare( $sql );

        // On sécurise les données
        $this->id_commune=htmlspecialchars(strip_tags($this->id_commune));

        // On attache l'id
        $query->bindParam(1, $this->id_commune);

        // On exécute la requête
        if($query->execute()){
            return true;
        }

        return false;
    }


    public function modifier(){
     
    }


}