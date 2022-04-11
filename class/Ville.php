<?php

class Ville
{
     private $_id;
     private $_nom;
     private $_id_reg; 
     const T_VILLE = "ville";
     const T_VILREG = "ville_region";
     const VILLE_CREATED = 101;
     const VILLE_EXISTED = 102;
     const VILLE_FAILURE = 103;
   
     public function __construct(){}
     function __destruct(){}
         #SETTERS
         public function set_nom(string $nom){$this->_nom=trim($nom);}
         public function set_id_reg(int $idreg){$this->_id_reg = (int) $idreg;}
     
         #GETTERS
         public  function get_id(){return  (int) $this->_id;}
         public  function get_nom(){return  $this->_nom;}
         public  function get_id_reg(){return  (int)$this->_id_reg;}
         
         
         #PARIE PRIVEE
         /**
          * retourne les villes d une region par id et par nom de la region
          * @param string $nomreg
          * @param int $idreg
          * @return array|NULL
          */
         private static function lirevilparreg(string $nomreg = NULL, int $idreg =NULL){
             if(is_null($nomreg) && is_null($idreg))
                 return R::getAll("select * from ville_region");
             if(!is_null($nomreg))
             return R::getAll("select * from ville_region where nomregion = ?", [trim($nomreg)]);
             if(!is_null($idreg))
                 return R::getAll("select * from ville_region where idregion = ?", [(int) $idreg]);
         }
         /**
          * un tableau de regions et leurs villes
          * @return array|NULL|
          */
         private function lirevilreg(){    
                 return R::getAll("select * from ville_region");        
         }
         /**   
          * return un objet ville
          * @param array $array
          * @return Ville
          */
        private function objectify(array $array){
             $ville= new Ville();            
             if (array_key_exists('id', $array))
                 $this->_id = (int) $array['id'];
                 if(array_key_exists('nom', $array) && strcmp($array['nom'] , '')!==0)
                     $this->_nom = trim($array['nom']);
                     if(array_key_exists('id_reg', $array))
                         $this->_id_reg=(int) $array['id_reg'];  
                     
                         return $ville;      
         }
         /**
          * creation d'une graine 
          * @param mixed $graine      
          * @param Ville $ville
          * @return NULL|string
          */
         private static function beanify($graine , Ville $ville){
             if(! $ville instanceof Ville)
                 return NULL;
             
                 if($ville->_id != NULL)
                     $graine->id= (int) $ville->_id;
                 
                     $graine->nom = trim ($ville->_nom);
                     $graine->id_reg = (int) ($ville->_id_reg);
                     
                     return $graine;
         }
      
        /**
         * Verifier qu'une ville existe
         * @param string $nom
         * @return boolean
         */
         private function exist( string $nom = NULL, int $idreg= NULL) {     
                 if(!is_null($nom))
                     return $this->bean_export(R::findOne(Ville::T_VILLE, 'nom = ?', [trim($nom)])) != NULL;
                     
         }

           /**
            * 
            * @param int $id
            * @param string $nom
            * @param int $idreg
            * @return array|NULL
            */
                 private static function lire(int $id = NULL, string $nom = NULL) {
                     try {
                         if(is_null($id) &&  is_null($nom))
                                 return Ville::bean_export(R::findAll(Ville::T_VILLE ));
                         if(!is_null($id))
                                return R::getAll('SELECT * FROM '.Ville::T_VILREG.' where idville = ? ',  [(int) $id]);
                         if(!is_null($nom))
                                 return Ville::beanify(R::findOne(Ville::T_VILLE, 'nom = ?', [trim($nom)]));
                     } catch (Exception $e) {
                         return $e->getMessage();
                     }
                 }
                 /**
                  * 
                  * @param mixed $beans
                  * @return array|NULL
                  */
                 private function bean_export($beans) {
                     if(is_array($beans)) {
                         return array_map(function ($beans) {return $beans->export();}, $beans);
                     } else {
                         return (!is_null($beans)) ? $beans->export() : NULL;
                     }
                 }
                 /**
                  * Creer table ville
                  * @return boolean
                  */
                 private function create() {
                     try {
                         if($this->exist( $this->_nom))
                             return self::VILLE_EXISTED;
                             
                             $graine = R::dispense(Ville::T_VILLE);
                             $graine = $this->beanify($graine, $this);
                             
                             if($graine != NULL)
                                  R::store($graine);
                                 return self::VILLE_CREATED;
                                 
                     } catch (Exception $e) {
                         return self::VILLE_FAILURE;
                     }
                 }
             
                 /**
                  * Supprimer Ville
                  * @param int $id
                  * @return boolean
                  */
                 private function delete(int $id) {
                     try {
                         $bean = R::findOne(Ville::T_VILLE, 'id = ?', [ (int) $id]);
                         if($bean != NULL) {
                             R::trash($bean);
                             return TRUE;
                         }
                     } catch (Exception $e) {
                         return FALSE;
                     }
                     return FALSE;
                 }
                 /**
                  * modifier une ville
                  * @param int $id
                  * @return number|string|boolean
                  */
                 private function update(int $id)
                 {
                     try {
                         $bean = R::findOne(Ville::T_VILLE,'id = ?',[(int)$id]);
                         if ($bean != null) {
                             $bean = $this->beanify($bean, $this);
                             if ($bean != NULL)
                                 return R::store($bean);
                                 return true;
                         }
                         return false;
                         
                     } catch (Exception $e) {
                         echo $e->getMessage();
                         return false;
                     }
                 }
                 
                 
                 
         #PARTIE PUBLIQUE
          /**
           * lire toutes les villes sous forme d'objet
           * return array|NULL
           */
                 public function lire_tout(){ return $this->lire();}
                 /*
                  * lire une ville et retourner l'objet
                  */
                 public function lire_tout_objets() {
                     $ville = $this->lire();
                     return !is_null($ville) ? array_map(function($ville){return $this->objectify($ville);}, $ville) : NULL;
                 }
                 
                 /**
                  * retourne toutes les villes sous forme de chaine JSON pour echange avec clients
                  * @return string
                  */
                 public function lire_tout_json() {
                     $ville = $this->lirevilparreg();
                     
                     if(!empty($ville)){
                        
                         foreach ($ville as $v){
                             
                                 $s["id"] =  (int) $v['idville'];
                                 $s["ville"] = $v['nomville'];
                                 $s["region"] = Region::lire_par_id($v['idregion']);
                            
                             $t=$s;
                         }
                     }else{
                         return json_encode(["status" => "0", "reponse"=>"aucune ville n'a ete enregistrer pour cette region"]);
                     }
                     return json_encode($t);
                     
                 }
                 
                 /**
                  * Lire une ville par ID et retourner l'objet
                  */
                 public static function lire_par_id(int $id) {
                     $ville = Ville::lire($id);
                     if(!empty($ville)){
                       //  $t['vilreg']=array();
                         foreach ($ville as $v){
                            
                                 $s["id"] =  (int) $v['idville'];
                                 $s["nom"] = $v['nomville'];
                                 $s["region"] = Region::lire_par_id((int) $v['idregion']);                 
                             $t=$s;
                         }
                     }else{
                         return json_encode(["status" => "0", "reponse"=>"aucune ville n'a ete enregistrer pour cette region"]);
                     }
                     return $t;
                     
                 }
                 
                 
                 public function lire_par_nom(string $nom) {
                     return json_encode($this->lire(NULL, $nom));
                 }
                 
                
                 
                 /**
                  * Nouvelle ville
                  * @return string
                  */
                 public function nouveau() {
                     $p = $this->create();
                     $message = array();
                     if ($p == self::VILLE_CREATED) {
                         $message['statut'] = 1;
                         $message['response'] = "Enregistrement reussi";
                         http_response_code(201);
                         return json_encode($message);
                         
                     } elseif ($p == self::VILLE_EXISTED) {
                         $message['statut'] = 0;
                         $message['response'] = "Patient existant";
                         http_response_code(200);
                         return json_encode($message);
                         
                     } elseif ($p == self::VILLE_FAILURE) {
                         $message['statut'] = 0;
                         $message['response'] = "Une erreur s'est produite";
                         http_response_code(405);
                         return json_encode($message);
                         
                     }
                 }
                 /**
                  * supprimer une ville
                  * @param int $id
                  * @return string
                  */
                 public function supprimer(int $id) {
                     return $this->delete($id) ? json_encode(['status' => 1, 'response' => 'OK']) : json_encode(['status' => 0, 'response' => 'Not deleted']);
                 }
                 /**
                  * 
                  * @param int $id
                  * @return string
                  */
                 public function maj(int $id)
                 {
                     return $this->update($id) ? json_encode(['status' => 1, 'response' => 'Modification reussi']) : json_encode(['status' => 0, 'response' => 'Echec de modification']);
                 }
                 
                 
                 public function lire_vil_reg_json(){
                     
                     $vilreg = $this->lirevilreg();
                     $t=array();
                     if(!empty($vilreg)){
                     $t['vilreg']=array();
                     foreach ($vilreg as $v){
                         $tb=[
                             "identifiant" =>  (int) $v['idville'],
                              "ville" => $v['nomville'],
                               "region" => Region::getById($v['idregion'])
                         ];
                         
                         $t['vilreg'][]=$tb;    
                     }
                     }else{
                         return json_encode(["status" => "0", "reponse"=>"aucune ville n'a ete enregistrer pour cette region"]);
                     }
                     return json_encode($t);
                      
                 }
                 /**
                  * retourne sous format JSON les villes d'une region 
                  * @param string $nomreg
                  * @return NULL|string
                  */
                 public function lire_vil_par_reg_json(string $nomreg){
                     $ville = $this->lirevilparreg($nomreg);
                     $t=array();
                     if(!empty($ville)){
                     $t['ville']=array();
                     foreach ($ville as $v){
                       $tb=[
                           "identifiant" =>  (int) $v['idville'],
                           "ville" => $v["nomville"],
                           "region" => Region::getById($v['idregion'])
                       ];
                       $t['ville'][]=$tb;
                     }
                     }else{
                     return  json_encode(["status" => "0" , "response" => "Aucune ville n'a ete enregistrer dans cette region"]);
                     }
                     return json_encode($t);
                 }
                 /**
                  * retourne les villes d'une region sous format JSON
                  * @param int $idreg
                  * @return NULL|string
                  */
                 public static function lire_vil_par_reg_json_id(int $idreg){
                     $ville= self::lirevilparreg(NULL,$idreg);
                     $t=array();
                     if(!empty($ville)){
                         //$t['ville']=array();
                         foreach ($ville as $v){
                             $tb=[
                                 "id" =>  (int) $v['id'],
                                 "nom" => $v["nom"],
                                 "commune" => Commune::lire_commune_par_ville_json((int) $v['id'])
                                 //"region" => $v["nomregion"]
                             ];
                               $t[]=$tb;
                         }
                     }else{
                         return  ["status" => "0" , "response" => "Aucune ville n'a ete enregistrer dans cette region"];
                     }
                     return $t;
                     
                 }
                 
}
