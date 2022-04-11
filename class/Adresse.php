<?php

class Adresse{
    
    private $_id;
    private $_email;
    private $_quartier;
    private $_lieu_dit;
    private $_id_commune;
    private $_id_pat;
    private  $_type_a;
    const T_ADRESSE='adresse';
    const ADRESSE_CREATED = 101;
    const ADRESSE_EXISTED = 102;
    const ADRESSE_FAILURE = 103;
    
    
    #SETTERS
    public function set_email(string $email){$this->_email = trim($email);}
    public function set_quartier(string $quartier){$this->_quartier = trim($quartier); }
    public function set_lieu_dit(string $lieudit){ $this->_lieu_dit =trim($lieudit); }
    public function set_id_commune(int $idcom){$this->_id_commune =  (int) $idcom;}
    public function set_type_a(int $typea){$this->_type_a =  (int) $typea;}
    public function set_id_pat(int $idpat){$this->_id_pat = (int) $idpat;}
    
    #GETTERS
    public function get_id(){return  (int) $this->_id;}
    public  function get_email(){return $this->_email;}
    public  function get_quartier(){return $this->_quartier;}
    public function get_lieu_dit(){ return $this->_lieu_dit;}
    public function get_type_a(){ return $this->_type_a;}
    public function get_id_commune(){ return $this->_id_commune;}
    public function get_id_pat(){ return $this->_id_pat;}
    
    
    
    #PARTIE PRIVEE
      private function lireadrparcom(string $nomcom= NULL, int $idcom =NULL, string $email = NULL){
          if(is_null($nomcom)&& is_null($idcom))
                    return R::getAll("select * from adresse_commune");
         if(!is_null($nomcom))
                    return R::getAll("select * from adresse_commune where nomcommune = ?", [trim($nomcom)]);
         if(!is_null($idcom))
                    return R::getAll("select * from adresse_commune where id_commune = ?", [(int) $idcom]);
       
      }
      
    /**
     * retourne un objet adresse
     * @param mixed $array
     * @return Adresse
     */
    
    private function objectify($array){
            $adresse= new Adresse();
            if(array_key_exists('id', $array)){
                $adresse->_id = (int) $array['id'];            
            }
            if(array_key_exists('email', $array) && strcmp($array['email'], '')!==0){
                $adresse->_email = trim($array['email']); 
            }
            if(array_key_exists('quartier', $array) && strcmp($array['quartier'], '') !==0){
                
                $adresse->_quartier= trim($array['quartier']);
            }
            if(array_key_exists('lieu_dit', $array) && strcmp($array['lieu_dit'], '') !==0){
                
                $adresse->_quartier= trim($array['quartier']);
            }
            if(array_key_exists('id_commune', $array)){
                $adresse->_id_commune = (int) $array['id_commune'];
            }
                    return $adresse;
            
        }
    /**
     * creation de la graine
     * @param mixed $graine
     * @param Adresse $adresse
     * @return NULL|$graine;
     */
    private function beanify($graine , Adresse $adresse) {
            if(! $adresse instanceof Adresse)
               return  NULL;
            
               if($adresse->_id != NULL)
                   $graine->id =  (int) $adresse->_id;
                   
                   $graine->email = trim ($adresse->_email);
                   $graine->quartier = trim($adresse->_quartier);
                   $graine->lieu_dit = trim ($adresse->_lieu_dit);
                   $graine->id_commune =(int) $adresse->_id_commune;
                   $graine->type_a =  (int) $adresse->_type_a;
                   $graine->id_pat =   (int) $adresse->_id_pat;
                   
                   return $graine;
           
    }
    /**
     *
     * @param mixed $bean
     * @return array|NULL
     */
    private static function bean_export($beans) {
            if(is_array($beans)) {
                return array_map(function ($beans) {return $beans->export();}, $beans);
            } else {
                return (!is_null($beans)) ? $beans->export() : NULL;
            }
    }
    /**
     * verifie si une email existe dej�
     * @param string $email
     * @return boolean
     */
    private function exist(string $email = NULL){
            if(!is_null($email))
            return $this->bean_export(R::findOne(Adresse::T_ADRESSE, 'email = ?', [trim($email)])) != NULL;
    }
    /**
     * retourner les adresses
     * @param int $id
     * @param string $email
     * @return array|NULL|
     */
    private static function lire(int $id =NULL , string $email = NULL, int $id_pat = null){
        try {
            if(is_null($id) && is_null($email) && is_null($id_pat))
             return  Adresse::bean_export(R::findAll(Adresse::T_ADRESSE));
             if(!is_null($id))
                 return R::getAll('Select * from '.Adresse::T_ADRESSE.' where id = ?' , [ (int) $id]);
            if(!is_null($id_pat))
                return R::getAll('Select * from '.Adresse::T_ADRESSE.' where id_pat = ?' , [ (int) $id_pat]);

             if(!is_null($email))
                 return   Adresse::bean_export(R::findOne(Adresse::T_ADRESSE, 'email = ?' , [trim($email)]));
        } catch (Exception $e) {
            return $e->getMessage();
        }
       
    }
    /**
     * 
     * @return boolean
     */
    private  function create(){
        try {
            if($this->exist($this->_email))
              return self::ADRESSE_EXISTED;
         
                $graine = R::dispense(Adresse::T_ADRESSE);
                $graine =$this->beanify($graine, $this);
                
                if($graine != NULL)
                   R::store($graine);
                return self::ADRESSE_CREATED;
        } catch (Exception $e) {
            return self::ADRESSE_FAILURE;
        }
        
    }
    
    /**
     * 
     * @param int $id
     * @return boolean
     */
    private function delete(int $id){
        try {
            $bean = R::findOne(Adresse::T_ADRESSE,'id = ?', [(int) $id]);            
            if($bean !=NULL)
                R::trash($bean); 
            return true;
        } catch (Exception $e) {
                return false;
        }
       
    }
    /**
     * modifier une adresse
     * @param int $id
     * @return number|string|boolean
     */
    private function update(int $id)
    {
        try {
            $bean = R::findOne(Adresse::T_ADRESSE,'id = ?',[(int)$id]);
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
    
    
                       #PARTIE PUBLIC
    
    public function lire_tout(){
         return  $this->lire();
    }
    /**
     * retourne l'adresse sous forme json pour le client
     * @return NULL|string
     */
    public  function lire_tout_json(){
         $adresse = $this->lire();
         return !is_null($adresse) ? json_encode($adresse) : NULL;
    }
    public static function lire_par_id(int $id){
        $adr = Adresse::lire($id);
        $t=array();
        if(!empty($adr)){
            //$t['vilreg']=array();
            foreach ($adr as $v){
                $tb=[
                    "id" =>  (int) $v['id'],
                    "email" => $v['email'],
                    "quartier" => $v['quartier'],
                    "lieu" => $v['lieu_dit'],
                    "type" => (int) $v['type_a'],
                    "commune" =>Commune::lire_par_id((int) $v['id_commune'])
                ];
                $t[]=$tb;
            }
        }else{
            return json_encode(["status" => "0", "reponse"=>"aucune ville n'a ete enregistrer pour cette region"]);
        }
        return $t;
    }
    public static function lire_par_pat(int $id_pat){
        $adr = Adresse::lire(null, null, $id_pat);
        $t=array();
        if(!empty($adr)){
            //$t['vilreg']=array();
            foreach ($adr as $v){
                $tb=[
                    "id" =>  (int) $v['id'],
                    "email" => $v['email'],
                    "quartier" => $v['quartier'],
                    "lieu" => $v['lieu_dit'],
                    "type" => (int) $v['type_a'],
                    "commune" =>Commune::lire_par_id((int) $v['id_commune'])
                ];
                $t[]=$tb;
            }
        }else{
            return ["status" => (int) 0, "reponse"=>"aucune adresse n'a été enregistrer pour ce patient"];
        }
        return $t;
    }
    public function lire_tout_objet(){
         $adresse=$this->lire();
         return !is_null($adresse) ? array_map(function($adresse){return $this->objectify($adresse);}, $adresse) : NULL;
    }
    public function lire_par_email($email){
         return json_encode ($this->lire(NULL, $email));
       
    }
    public function nouveau() {
        $p = $this->create();
        $message = array();
        if ($p == self::ADRESSE_CREATED) {
            $message['statut'] = 1;
            $message['response'] = "Enregistrement reussi";
            http_response_code(201);
            return json_encode($message);
            
        } elseif ($p == self::ADRESSE_EXISTED) {
            $message['statut'] = 0;
            $message['response'] = "adresse existant";
            http_response_code(200);
            return json_encode($message);
            
        } elseif ($p == self::ADRESSE_FAILURE) {
            $message['statut'] = 0;
            $message['response'] = "Une erreur s'est produite";
            http_response_code(405);
            return json_encode($message);
            
        }
    }
    public function supprimer(int $id){
        return $this->delete($id) ? json_encode(['status' => 1, 'response' => 'OK']) : json_encode(['status' => 0, 'response' => 'Not deleted']);
    }
    public function maj(int $id)
    {
        return $this->update($id) ? json_encode(['status' => 1, 'response' => 'Modification reussi']) : json_encode(['status' => 0, 'response' => 'Echec de modification']);
    }
    //lire toutes les adresses
    public function lire_adr_com_json(){
        $adrcom = $this->lireadrparcom();
        $t=array();
        if(!empty($adrcom)){
            $t['adresse']=array();
            foreach ($adrcom as $v){
                $tb=[
                    "identifiant" =>  (int) $v['id'],
                    "email" => $v['email'],
                    "quartier" => $v['quartier'],
                    "lieu_dit" => $v['lieu_dit'],
                    "commune" => $v['commune'],
                    "ville" => $v['ville'],
                    "region" => $v['region'],
                    "pays" => $v['pays']
                ];
                $t['adresse'][]=$tb;
            }
        }else{
            return json_encode(["status" => "0", "reponse"=>"aucune adresse n'a ete enregistrer pour cette commune"]);
        }
        return json_encode($t);
        
    }
    /**lire toutes les adresses d'une commune 
     * 
     * @param string $nomcom
     * @return string
     */
    public function lire_adr_par_com_json(string $nomcom){
        $com = $this->lireadrparcom($nomcom);
        $t=array();
        if(!empty($com)){
            $t['adresse']=array();
            foreach ($com as $v){
                $tb=[
                    "identifiant" =>  (int) $v['id'],
                    "email" => $v['email'],
                    "quartier" => $v['quartier'],
                    "lieu_dit" => $v['lieu_dit'],
                    "commune" => $v['commune'],
                    "ville" => $v['ville'],
                    "region" => $v['region'],
                    "pays" => $v['pays']
                ];
                $t['adresse'][]=$tb;
            }
        }else{
            return  json_encode(["status" => "0" , "response" => "Aucune adresse n'a ete enregistrer dans cette commune"]);
        }
        return json_encode($t);
    }
    
    
    public function lire_adr_par_com_id(int $idcom){
        $com = $this->lireadrparcom(NULL,$idcom);
        $t=array();
        if(!empty($com)){
            $t['adresse']=array();
            foreach ($com as $v){
                $tb=[
                    "identifiant" =>  (int) $v['id'],
                    "email" => $v['email'],
                    "quartier" => $v['quartier'],
                    "lieu_dit" => $v['lieu_dit'],
                    "commune" => $v['commune'],
                    "ville" => $v['ville'],
                    "region" => $v['region'],
                    "pays" => $v['pays']
                ];
                $t['adresse'][]=$tb;
            }
        }else{
            return  json_encode(["status" => "0" , "response" => "Aucune adresse n'a ete enregistrer dans cette region"]);
        }
        return json_encode($t);
    }
    
    
}
