<?php

class Pays {
    
    private $_id;
    private $_nom;
    private $_indicatif;
    private $_pattern;
    
    const T_PAYS = 'pays';
    const PAYS_CREATED = 101;
    const PAYS_EXISTED = 102;
    const PAYS_FAILURE = 103;


    public function __construct(){}
    function __destruct(){}
    
    # SETTERS
    public function set_nom(string $nom) {$this->_nom = trim($nom);}
    public function set_indicatif(int $indicatif) {$this->_indicatif = (int) $indicatif;}
    public function set_pattern(string $pattern) {$this->_pattern = trim($pattern);}
    
    # GETTERS
    public function get_id() {return (int) $this->_id;}
    public function get_nom(){return $this->_nom;}
    public function get_indicatif(){return (int) $this->_indicatif;}
    public function get_pattern(){return $this->_pattern;}
    
    
    # PARTIE PRIVE
    
    /**
     * Retourne un objet pays
     * @param array $array
     * @return Pays
     */
    private function objectify(array $array) {
        $pays = new Pays();

        if(array_key_exists('id', $array))
            $pays->_id = (int) $array['id'];

        if(array_key_exists('nom', $array) && strcmp($array['nom'], '')!==0)
            $pays->_nom = trim($array['nom']);

        if(array_key_exists('indicatif', $array))
            $pays->_indicatif = (int) $array['indicatif'];

        if(array_key_exists('pattern', $array) && strcmp($array['pattern'], '')!==0)
            $pays->_pattern = trim($array['pattern']);

        return $pays;
    }
    
    /**
     * Creation d'une graine
     * @param mixed $graine
     * @param Pays $pays
     * @return NULL|string
     */
    private function beanify($graine, Pays $pays) {

        if(!$pays instanceof Pays)
            return NULL;

        if($pays->_id != NULL)
            $graine->id = (int) $pays->_id;

        $graine->nom = trim($pays->_nom);
        $graine->indicatif = (int) $pays->_indicatif;
        if ($pays->_pattern != null)
            $graine->pattern = $pays->_pattern;
        return $graine;
    }
    
    /**
     * VERIFIE QU'UN PAYS EXISTE DANS LA TABLE
     * @param int $indicatif
     * @param string $nom
     * @return boolean
     */
    private function exist(int $indicatif = NULL, string $nom = NULL) {
        if($indicatif != NULL)
            return $this->bean_export(R::findOne(Pays::T_PAYS, 'indicatif = ?', [(int) $indicatif])) != NULL;
            
        if(!is_null($nom))
            return $this->bean_export(R::findOne(Pays::T_PAYS, 'nom = ?', [trim($nom)])) != NULL;
    }
    
    
    /**
     * Lire la table Pays
     * @param int $id identifiant du pays
     * @param int $indicatif Indicatif du pays
     * @param string $nom Nom du pays
     * @return array|NULL
     */
    private function lire(int $id = NULL, int $indicatif = NULL, string $nom = NULL) {
        try {
            if(is_null($id) && is_null($indicatif) && is_null($nom))
                 return $this->bean_export(R::findAll(Pays::T_PAYS));
                
            if($id != NULL)
                return $this->bean_export(R::findOne(Pays::T_PAYS, 'id = ?', [(int) $id]));
                    
            if($indicatif != NULL) {
                return $this->bean_export(R::findOne(Pays::T_PAYS, 'indicatif = ?', [(int)$indicatif]));
             }
                        
            if(!is_null($nom))
                return $this->bean_export(R::findOne(Pays::T_PAYS, 'nom = ?', [trim($nom)]));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * Export un tableau ou objet Bean
     * @param mixed $bean
     * @return NULL
     */
    private static function bean_export($beans) {
        if(is_array($beans)) {
            return array_map(function ($beans) {return $beans->export();}, $beans);
        } else {
            return (!is_null($beans)) ? $beans->export() : NULL;
        }
    }
    
    /**
     * Creer un pays dans la table
     * @return boolean
     */
    public function create() {
        try {
            if($this->exist($this->_indicatif) || $this->exist(NULL, $this->_nom))
                return self::PAYS_EXISTED;

            $graine = R::dispense(Pays::T_PAYS);
            $graine = $this->beanify($graine, $this);

            if($graine != NULL)
                R::store($graine);
            return self::PAYS_CREATED;

        } catch (Exception $e) {
            return self::PAYS_FAILURE;
        }
    }


    /**
     * Supprimer Pays
     * @param int $id
     * @return boolean
     */
    private function delete(int $id) {
        try {
            $bean = R::findOne(Pays::T_PAYS, 'id = ?', [(int) $id]);
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
            $bean = R::findOne(Pays::T_PAYS,'id = ?',[(int)$id]);
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
    
    # PARTIE PUBLIQUE
    
    /**
     * Retourne tous les pays sous forme de tableau
     * @return array|NULL
     */
    public function lire_tout() {return $this->lire();}
    
    /**
     * Retoune tous les pays sous forme de tableau d'objets Pays
     * @return array
     */
    public function lire_tout_objets() {
        $pays = $this->lire();
        return !is_null($pays) ? array_map(function($pays){return $this->objectify($pays);}, $pays) : NULL;
    }
    
    /**
     * retourne tous les pays sous forme de chaine JSON pour echange avec clients 
     * @return string
     */
    public function lire_tout_json() {
        $pays = $this->lire();
        $t = array();
        //$t["pays"] = array();
        foreach ($pays as $row){
            $s = [
                "id" => (int) $row['id'],
                "nom" => $row['nom'],
                "indicatif" => (int) $row['indicatif'],
                "pattern" => $row['pattern'],
                "region" => Region::lire_region_par_pays_json((int) $row['id'])
            ];
            $t[] = $s;
        }
        return !is_null($t) ? $t : ['statut' => (int) 0, 'response' => 'pas de pays enregistrer'];
    }

    /**
     * Lire un pays par ID et retourner l'objet
     */
    public function lire_par_id(int $id) {
        return $this->objectify($this->lire($id));
    }
    
    public function lire_par_indicatif(int $indicatif) {
        return json_encode($this->lire(NULL, $indicatif));
    }
    
    public function lire_par_nom($nom) {
        return json_encode($this->lire(NULL, NULL, $nom));
    }
    
    /**
     * Nouveau Pays
     * @return string
     */
    
    public function supprimer(int $id) {
        return $this->delete($id) ? json_encode(['status' => 1, 'response' => 'OK']) : json_encode(['status' => 0, 'response' => 'Not deleted']);
    }
    public function maj(int $id)
    {
        return $this->update($id) ? json_encode(['status' => 1, 'response' => 'Modification reussi']) : json_encode(['status' => 0, 'response' => 'Echec de modification']);
    }
    public function nouveau() {
        $p = $this->create();
        $message = array();
        if ($p == self::PAYS_CREATED) {
            $message['statut'] = 1;
            $message['response'] = "Enregistrement reussi";
            http_response_code(201);
            return json_encode($message);
            
        } elseif ($p == self::PAYS_EXISTED) {
            $message['statut'] = 0;
            $message['response'] = "Patient existant";
            http_response_code(200);
            return json_encode($message);
            
        } elseif ($p == self::PAYS_FAILURE) {
            $message['statut'] = 0;
            $message['response'] = "Une erreur s'est produite";
            http_response_code(405);
            return json_encode($message);
            
        }
    }

    public static function getById(int $id){
            $data = Pays::bean_export(R::findOne(Pays::T_PAYS, 'id = ?', [(int) $id]));
            $s = array();
            $t=[
            'id' => (int) $data['id'],
            'nom' => $data['nom'],
            'indicatif' => (int) $data['indicatif'],
            'pattern' => $data['pattern']
            ];
            $s=$t;
            return $s;
    }






}

