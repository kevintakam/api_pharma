<?php

class Commentaire
{
    private  $_id;
    private  $_id_pat;
    private  $_id_gest;
    private  $_id_com;
    private  $_titre;
    private  $_contenu;
    private  $_type;
    const T_COMMENTAIRE="commentaire";
    public function __construct(){}
    function __destruct(){}
    #SETTERS
    public function set_id_pat(int $idpat){$this->_id_pat= (int) $idpat;}
    public function set_id_gest(int $idgest){$this->_id_gest= (int) $idgest;}
    public function set_id_com(int $idcom){$this->_id_com= (int) $idcom;}
    public function set_titre(string $titre){$this->_titre= trim($titre);}
    public  function set_date(string $date){$this->_date_cmt = trim($date);}
    public function set_contenu(string $contenu){$this->_contenu= trim($contenu);}
    public function set_type(int $type){$this->_type = (int) $type;}
    
    #GETTERS
    public  function get_id(){return  (int) $this->_id;}
    public  function get_id_pat(){return  (int) $this->_id_pat;}
    public  function get_id_gest(){return  (int)$this->_id_gest;}
    public  function get_id_com(){return  (int)$this->_id_com;}
    public  function get_date(){return  $this->_date_cmt;}
    public  function get_titre(){return  $this->_titre;}
    public  function get_contenu(){return  $this->_contenu;}
    public  function get_type(){return (int) $this->_type;}
    
    
    #PARTIE PRIVATE
    /**
     * retourne les commentaires
     * @param string $login
     * @param int $idpat
     * @param int $idgest
     * @param int $idcom
     * @param string $refcom
     * @return array|NULL|
     */
    private function lire_com_par(string $login = NULL, int $idpat = NULL, int $idgest = NULL , string $refcom = NULL, int $type = NULL){
        if(is_null($login) && is_null($idpat) && is_null($idgest) && is_null($refcom) && is_null($type))
                return R::getAll("select * from commentaire_pat_gest");
        if(!is_null($login))
                return R::getAll("select * from commentaire_pat_gest where login= ?", [trim($login)]);
        if(!is_null($idpat))
                return R::getAll("select * from commentaire_pat_gest where idpat = ?", [(int) $idpat]);
        if(!is_null($idgest))
                return R::getAll("select * from commentaire_pat_gest where idgest = ?", [(int) $idgest]);
        if(!is_null($refcom))
                return R::getAll("select * from commentaire_pat_gest where ref_commande= ?", [trim($refcom)]);
        if(!is_null($type))
                return R::getAll("select * from commentaire_pat_gest where type= ?", [(int) $type]);
    }
    
    /**
     * creation objet commentaire
     * @param array $array
     * @return Commentaire
     */
    private function objectify(array $array){
        $commentaire= new Commentaire();
            if (array_key_exists('id', $array))
                $this->_id = (int) $array['id'];
            if (array_key_exists('id_pat', $array))
                $this->_id_pat = (int) $array['id_pat'];
            if (array_key_exists('id_gest', $array))
                $this->_id_gest = (int) $array['id_gest'];
            if (array_key_exists('id_com', $array))
                $this->_id_com = (int) $array['id_com'];
            if(array_key_exists('date_cmt', $array))
                $this->_date_cmt = $array['date_cmt'];           
            if(array_key_exists('titre', $array) && strcmp($array['titre'] , '')!==0)
                $this->_titre = trim($array['titre']);
            if(array_key_exists('contenu', $array) && strcmp($array['contenu'] , '')!==0)
                $this->_contenu = trim($array['contenu']);
            if (array_key_exists('type', $array))
                    $this->_type = (int) $array['type'];
            
                    return $commentaire;
    }
        /**
         * creation d'un bean
         * @param mixed $graine
         * @param Commentaire $commentaire
         * @return NULL|$graine
         */
        private function beanify($graine , Commentaire $commentaire){
                     if(! $commentaire instanceof Commentaire)
                         return NULL;
                      if($commentaire->_id != NULL)
                          $graine->id =  (int) $commentaire->_id;
                          if($commentaire->_id_pat != NULL)
                            {$graine->id_pat =  (int) $commentaire->_id_pat;}
                          if($commentaire->_id_gest != NULL)
                            {$graine->id_gest =  (int) $commentaire->_id_gest;}
                     $graine->id_com  =    (int) $commentaire->_id_com;
                     $graine->titre =   trim ($commentaire->_titre);
                     $graine->contenu= trim ($commentaire->_contenu);
                     $graine->type= trim ($commentaire->_type);
                 
                    return $graine;
        }
        
        private function update(int $id)
        {
            try {
                $bean = R::findOne(Commentaire::T_COMMENTAIRE,'id = ?',[(int)$id]);
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
     * creation d'un commentaire
     * @return boolean
     */
    private  function create(){
        try {    
               
                $graine = R::dispense(Commentaire::T_COMMENTAIRE);
                $graine =$this->beanify($graine, $this); 
              if($graine != NULL)
                    return  R::store($graine) != NULL;
        } catch (Exception $e) {
            return FALSE;
        }
        
    }
    /**
     * supprimer un commentaire
     * @param int $id
     * @return boolean
     */
    private function delete(int $id){
        try {    
            $bean = R::findOne(Commentaire::T_COMMENTAIRE,'id = ?', [(int) $id]);
            if($bean !=NULL)
                R::trash($bean);
                return TRUE;
        } catch (Exception $e) {
            return FALSE;
        }
        
    }
    
    
    
    #PARTIE PUBLIQUE
       
        /**
         * 
         * @return NULL|array
         */
        public function lire_tout_objets() {
            $commentaire = $this->lire();
            return !is_null($commentaire) ? array_map(function($commentaire){return $this->objectify($commentaire);}, $commentaire) : NULL;
        }
        
        /**
         * retourne toutes les villes sous forme de chaine JSON pour echange avec clients
         * @return string
         */
        public function lire_tout_json() {
            $commentaire = $this->lire_com_par();
            $t=array();
            if(!empty($commentaire)){
                $t['commentaire']=array();
                foreach ($commentaire as $c){
                    $tb=[
                        "id" =>  (int) $c['id'],
                        "reference" => $c["ref_commande"],
                        "patient" => $c["nom"],
                        "gestionnaire" => $c["login"],
                        "titre" => $c["titre"],
                        "contenu" =>$c["contenu"],
                        "date commentaire" => $c["date_cmt"],
                        "type" => $c["type"]
                    ];
                    $t['commentaire'][]=$tb;
                }
            }else{
                return  json_encode(["status" => "0" , "response" => "Aucun commentaire n'a ete enregistrer pour cette commande"]);
            }
            return json_encode($t);
            
        }
        /**
         * 
         * @param string $login
         * @return string
         */
        public function lire_commentaire_par_com(string $login){
            $cmt = $this->lire_com_par($login);
            $t=array();
            if(!empty($cmt)){
                $t['commentaire']=array();
                foreach ($cmt as $c){
                    $tb=[
                        "id" =>  (int) $c['id'],
                        "reference" => $c["ref_commande"],
                        "patient" => $c["nom"],
                        "gestionnaire" => $c["login"],
                        "titre" => $c["titre"],
                        "contenu" =>$c["contenu"],
                        "date commentaire" => $c["date_cmt"],
                        "type" => $c["type"]
                    ];
                    $t['commentaire'][]=$tb;
                }
            }else{
                return  json_encode(["status" => "0" , "response" => "Aucun commentaire n'a ete enregistrer pour cette commande"]);
            }
            return json_encode($t);
        }
        
        /**
         * retourne les nouveaux commentaires
         * @param int $type
         * @return string
         */
        public function lire_commentaire_par_type(int $type){
            $cmt = $this->lire_com_par(NULL,NULL,NULL,NULL,$type);
            $t=array();
            if(!empty($cmt)){
                $t['commentaire']=array();
                foreach ($cmt as $c){
                    $tb=[
                        "id" =>  (int) $c['id'],
                        "reference" => $c["ref_commande"],
                        "patient" => $c["nom"],
                        "gestionnaire" => $c["login"],
                        "titre" => $c["titre"],
                        "contenu" =>$c["contenu"],
                        "date commentaire" => $c["date_cmt"],
                        "type" => $c["type"]
                    ];
                    $t['commentaire'][]=$tb;
                }
            }else{
                return  json_encode(["status" => "0" , "response" => "Aucun commentaire n'a ete enregistrer pour cette commande"]);
            }
            return json_encode($t);
        }
        public function lire_commentaire_par_refcom(string $refcom){
            $cmt = $this->lire_com_par(NULL,NULL,NULL,$refcom);
            $t=array();
            if(!empty($cmt)){
                $t['commentaire']=array();
                foreach ($cmt as $c){
                    $tb=[
                        "id" =>  (int) $c['id'],
                        "reference" => $c["ref_commande"],
                        "patient" => $c["nom"],
                        "gestionnaire" => $c["login"],
                        "titre" => $c["titre"],
                        "contenu" =>$c["contenu"],
                        "date commentaire" => $c["date_cmt"],
                        "type" => $c["type"]
                    ];
                    $t['commentaire'][]=$tb;
                }
            }else{
                $tb=[];
                return  $t['commentaire'][]=$tb;
            }
            return json_encode($t);
        }
        
        public function nouveau(){
            
            return $this->create() ? json_encode(['status' => 1, 'response' => 'OK']) : json_encode(['status' => 0, 'response' => 'Not registered']);
        }
            /**
             * pour effectuer la suppression d un commentaire
             * @param int $id
             * @return string
             */
        public function supprimer(int $id){
            
            return $this->delete($id) ? json_encode(['status' => 1, 'response' => 'OK']) : json_encode(['status' => 0, 'response' => 'Not deleted']);
        }
        
        public function maj(int $id)
        {
            return $this->update($id) ? json_encode(['status' => 1, 'response' => 'Modification reussi']) : json_encode(['status' => 0, 'response' => 'Echec de modification']);
        }
        public function nombre_commentaire_par(){
            
            $nombre = R::count(Commentaire::T_COMMENTAIRE,'type = ?',['0']);
            return $nombre;
            
        }
        
    }
