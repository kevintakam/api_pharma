<?php


class Patient
{
    private $_id;
    private $_nom;
    private $_prenom;
    private $_tel;
    private $idpat;
    const T_PATIENT = 'patient';
    const V_PAT = 'info_patient';
    const PATIENT_CREATED = 101;
    const PATIENT_EXISTED = 102;
    const PATIENT_FAILURE = 103;
    const PATIENT_AUTHENTICATED =201;
    const PATIENT_NOT_FOUND = 202;
    
    public function __construct()
    {
    }

    function __destruct()
    {
    }

    #GETTERS

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->_nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->_prenom;
    }

    /**
     * @return mixed
     */
    public function getTel()
    {
        return $this->_tel;
    }

    #SETTERS

    /**
     * @param mixed $nom
     */
    public function setNom(string $nom)
    {
        $this->_nom = htmlspecialchars(strip_tags(trim($nom)));
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom(string $prenom)
    {
        $this->_prenom = htmlspecialchars(strip_tags(trim($prenom)));
    }

    /**
     * @param mixed $tel
     */
    public function setTel(int $tel)
    {
        $this->_tel = (int)$tel;
    }

    # PARTIE PRIVEE

    /**
     * @param array $array
     * @return Patient
     */
    private function objectify(array $array)
    {
        $patient = new Patient();

        if (array_key_exists('id', $array))
            $patient->_id = (int)$array['id'];

        if (array_key_exists('nom', $array) && strcmp($array['nom'], '') !== 0)
            $patient->_nom = trim($array['nom']);

        if (array_key_exists('prenom', $array) && strcmp($array['prenom'], '') !== 0)
            $patient->_prenom = trim($array['prenom']);

        if (array_key_exists('tel', $array))
            $patient->_tel = (int)$array['tel'];

        return $patient;
    }

    /**
     * @param $graine
     * @param Patient $patient
     * @return null
     */
    private function beanify($graine, Patient $patient)
    {

        if (!$patient instanceof Patient)
            return NULL;

        if ($patient->_id != NULL)
            $graine->id = (int)$patient->_id;
        $graine->nom = trim($patient->_nom);
        if($patient->_prenom != NULL)
            $graine->prenom = trim($patient->_prenom);
        $graine->tel = (int) $patient->_tel;
        return $graine;
    }
    /**
     * 
     * @paraù $adr
     * @return string
     */
                    private function userLogin($adr){
                    if ($this->exist((int) $adr)){
                        return self::PATIENT_AUTHENTICATED;
                    }elseif ($this->existEmail($adr)){
                        return self::PATIENT_AUTHENTICATED;
                    }else{
                        return self::PATIENT_NOT_FOUND;
                    }
                }
    /**
     * 
     * @param mixed $adr
     * @return string
     */
            public function login($adr){
                
                $p = $this->userLogin($adr);
                $message = array();
                if ($p == self::PATIENT_AUTHENTICATED){
                    $message['statut'] = 1;
                    $message['response'] = 'authentification sucess';
                    if(is_numeric($adr)){
                        $message['patient'] = $this->lire_par_tel((int)$adr);
                    }else{
                        $message['patient'] = $this->lire_par_email((string)$adr);
                    }
                    
                    http_response_code(200);
                    return json_encode($message);
                    
                }elseif ($p == self::PATIENT_NOT_FOUND){
                    $message['statut'] = 0;
                    $message['response'] = 'Echec de l\' authentification';
                    $message['patient'] = null;
                    http_response_code(404);
                    return json_encode($message);
                }
            }
            
            /**
             * @param int|null $tel
             * @return bool
             */
            private function existEmail(string $email = NULL)
            {
                if ($email != NULL)
                    return $this->bean_export(R::findOne('adresse', 'email = ?', [(string)$email])) != NULL;
            }
         

    /**
     * @param int|null $tel
     * @return bool
     */
    private function exist(int $tel = NULL)
    {
        if ($tel != NULL)
            return $this->bean_export(R::findOne(Patient::T_PATIENT, 'tel = ?', [(int)$tel])) != NULL;
    }
    private function rech_patient( int $id =null ,int $tel = null, string $email = null,string $nom = null){
        if($id != null)
            $patient = $this->lire($id);
        if($tel != null)
            $patient = $this->lire(null, $tel);
        if($email != null)
            $patient = $this->lire(null, null, $email);
        if($nom != null)
           $patient = $this->lire(null, null, null,$nom);
             $t = array();
           foreach ($patient as $row){
              
               $s["id"] = (int) $row['id'];
               $s["nom"] = $row['nom'];
               $s["prenom"] =  $row['prenom'];
               $s["telephone"] = (int) $row['telephone'];
               $s["adresse"]   = Adresse::lire_par_pat((int) $row['id']);
               $s["commande"] = Commande::lire_par_id_pat((int) $row['id']);         
               $t[]=$s;
           }
           return $t;
                    
    }

    private function patient(int $id = null,int $tel = null, string $email = null,string $nom = null){
        if(is_null($id) && is_null($tel) && is_null($email) && is_null($nom))
            $patient = $this->lire();
        $t = array();
        foreach ($patient as $row){
            
                $s["id"] = (int) $row['id'];
                $s["nom"] = $row['nom'];
                $s["prenom"] =  $row['prenom'];
                $s["telephone"] = (int) $row['telephone'];
                $s["adresse"]   = Adresse::lire_par_pat((int) $row['id']);
                $s["commande"] = Commande::lire_par_id_pat((int) $row['id']);
            
           $t[]=$s;
        }
        return $t;
    }

    /**
     * @param int|null $id
     * @param int|null $tel
     * @param string|null $nom
     * @return array|mixed|string|null
     */
    private function lire(int $id = NULL, int $tel = NULL, string $email = NULL,string $nom = NULL)
    {
        try {
            if (is_null($id) && is_null($tel) && is_null($email) && is_null($nom))
                return R::getAll('select * from '.Patient::V_PAT);
            if ($id != NULL)
                return R::getAll('select * from '.Patient::V_PAT.' Where id = ? ', [(int)$id]);
            if ($tel != NULL)
                return R::getAll('select * from '.Patient::V_PAT.' Where telephone = ? ', [(int)$tel]);
            if (!is_null($email)) {
                return R::getAll('select * from '. Patient::V_PAT.' where email = ? ', [trim($email)]);
            }
            if (!is_null($nom)) {
                return R::getAll('select * from '. Patient::V_PAT.' where nom = ?', [trim($nom)]);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param $beans
     * @return array|mixed|null
     */
    private function bean_export($beans) {
        if(is_array($beans)) {
            return array_map(function ($beans) {return $beans->export();}, $beans);
        } else {
            return (!is_null($beans)) ? $beans->export() : NULL;
        }
    }

    /**
     * @return bool
     */
    private function create() {
        try {
            if($this->exist($this->_tel)){
                return self::PATIENT_EXISTED;
            }
                

            $graine = R::dispense(Patient::T_PATIENT);
            $graine = $this->beanify($graine, $this);

            if($graine != NULL){
              $this->idpat = R::store($graine);
            return self::PATIENT_CREATED;
            }
                

        } catch (Exception $e) {
            return self::PATIENT_FAILURE;
        }
    }

    /**
     * @param int $id
     * @return bool
     */
    private function delete(int $id) {
        try {
            $bean = R::findOne(Patient::T_PATIENT, 'id = ?', [(int) $id]);
            if($bean != NULL) {
                R::trash($bean);
                return TRUE;
            }
        } catch (Exception $e) {
            return FALSE;
        }
        return FALSE;
    }

    private function update(int $id)
    {
        try {
            $bean = R::findOne(Patient::T_PATIENT,'id = ?',[(int)$id]);
            if ($bean != null) {
                if ($this->exist($this->_tel))
                    return false;
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


    # PARTIE PUBLIQUE

    /**
     * Retourne tous les patient sous forme de tableau
     * @return array|NULL
     */
    public function lire_tout() {return $this->lire();}

    /**
     * Retoune tous les patient sous forme de tableau d'objets Patient
     * @return array
     */
    public function lire_tout_objets() {
        $patient = $this->lire();
        return !is_null($patient) ? array_map(function($patient){return $this->objectify($patient);}, $patient) : NULL;
    }

    /**
     * retourne tous les patients sous forme de chaine JSON pour echange avec clients
     * @return string
     */
    public function lire_tout_json() {
        $t = $this->patient();
        return !is_null($t) ? json_encode($t) : json_encode(['statut' => (int) 0, 'response' => 'pas de patient enregistrer']);

    }

    public function lire_par_id(int $id){
        $t = $this->rech_patient($id);
        return !is_null($t) ? json_encode($t) : json_encode(['statut' => (int) 0, 'response' => 'pas de patient enregistrer avec cet id']);

    }


    /**
     * @param int $tel
     * @return false|string
     */
    public function lire_par_tel(int $tel) {
        $t = $this->rech_patient(null, $tel);
        return !is_null($t) ? json_encode($t) : json_encode(['statut' => (int) 0, 'response' => 'pas de patient enregistrer avec ce numero']);
        

    }

    /**
     * @param $nom
     * @return false|string
     */
    public function lire_par_email(string $email) {
        $t = $this->rech_patient(null, null, $email);
        return !is_null($t) ? $t : ['statut' => (int) 0, 'response' => 'pas de patient enregistrer avec cet email'];

    }
    
    public function lire_par_nom(string $nom) {
        $t = $this->rech_patient(null, null, null,$nom);
        return !is_null($t) ? json_encode($t) : json_encode(['statut' => (int) 0, 'response' => 'pas de patient enregistrer avec ce nom']);
        
    }

    /**
     * Nouveau Patient
     * @return string
     */
    public function nouveau() {
        $p = $this->create();
        $message = array();
        if ($p == self::PATIENT_CREATED) {
            $message['statut'] = 1;
            $message['response'] = "Enregistrement reussi";
            http_response_code(201);
            return json_encode($message);
           
        } elseif ($p == self::PATIENT_EXISTED) {
            $message['statut'] = 0;
            $message['response'] = "Patient existant";
            http_response_code(200);
            return json_encode($message);
            
        } elseif ($p == self::PATIENT_FAILURE) {
            $message['statut'] = 0;
            $message['response'] = "Une erreur s'est produite";
            http_response_code(405);
            return json_encode($message);
            
        }
    }

    /**
     * @param int $id
     * @return false|string
     */
    public function supprimer(int $id) {
        return $this->delete($id) ? json_encode(['status' => 1, 'response' => 'OK']) : json_encode(['status' => 0, 'response' => 'Not deleted']);
    }

    /**
     * @param int $id
     * @return false|string
     */
    public function maj(int $id)
    {
        return $this->update($id) ? json_encode(['status' => 1, 'response' => 'Modification reussi']) : json_encode(['status' => 0, 'response' => 'Echec de modification']);
    }
    public function nombre_patient(){
        
        $nombre = R::count(Patient::V_PAT);
        return $nombre;
        
    }
}