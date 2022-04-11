<?php
require_once '../framework.php';
class Pays{
    private $connexion;
    private $table = "pays";
    

    public $id_pays;
    public $nom_pays;
    public $indicatif;
    public $pattern;

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
        $sql = "SELECT * FROM ".$this->table;
        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query;
    }

    public function lireUn(){
        $data  = R::getRow("SELECT * FROM ".$this->table ."WHERE id_pays =" .$this->id);
    }

    /**
     * creation d'un pays
     */
    public function creer(){
        // on utilise la table pays
        $sql = "INSERT INTO pays(nom_pays,indicatif,pattern) VALUES(:nom_pays,:indicatif,:pattern)";
        $requete = $this->connexion->prepare($sql);
        $requete->bindParam(':nom_pays',$this->nom_pays);
        $requete->bindParam(':indicatif',$this->indicatif);
           $requete->bindParam(':pattern',$this->pattern);
        
          $result=$requete->execute();
          if($result){
            return true;
          }
          else{
            return false;
          }

        // securisation pour enviter les failles xss
      //  $pays->nom_pays = htmlspecialchars(strip_tags($this->nom_pays)) ;
        //$pays->indicatif = htmlspecialchars(strip_tags($this->indicatif));
        //$pays->pattern = htmlspecialchars(strip_tags($this->pattern));
        // sauvegarde dans la table pays
        
    }

    /**
     * modifier un pays
     * @return bool
     */
    public function supprimer(){
        // On écrit la requête
        $sql = "DELETE FROM " . $this->table . " WHERE id_pays = ?";

        // On prépare la requête
        $query = $this->connexion->prepare( $sql );

        // On sécurise les données
        $this->id_pays=htmlspecialchars(strip_tags($this->id_pays));

        // On attache l'id
        $query->bindParam(1, $this->id_pays);

        // On exécute la requête
        if($query->execute()){
            return true;
        }

        return false;
    }


    public function modifier(){

    }


}