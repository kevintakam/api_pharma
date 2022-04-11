<?php


class Region
{

    private $_id;
    private $_nom;
    private $_id_pays;

    const T_REGION = 'pays_region';
    const T_REG= 'region';

    # GETTERS
    public function getId()
    {
        return (int)$this->_id;
    }

    public function getNom()
    {
        return $this->_nom;
    }

    public function getIdPays()
    {
        return (int)$this->_id_pays;
    }

    #SETTERS
    public function setNom(string $nom)
    {
        $this->_nom = (string)$nom;
    }

    public function setIdPays(int $id_pays)
    {
        $this->_id_pays = (int)$id_pays;
    }


    #PARTIE PRIVEE

    /**
     * retourne un objet pays
     * @param array $array
     * @return Region
     */
    private function objectify(array $array)
    {
        $region = new Region();
        if (array_key_exists('id', $array))
            $this->_id = (int)$array['id'];
        if (array_key_exists('nom', $array) && strcmp($array['nom'], '') !== 0)
            $this->_nom = trim($array['nom']);
        if (array_key_exists('id_pays', $array))
            $this->_id_pays = (int)$array['id_pays'];
        return $region;
    }

    /**
     * creation d'une graine
     * @param $graine
     * @param Region $region
     * @return null | string
     */
    private function beanify($graine, Region $region)
    {
        if (!$region instanceof Region)
            return null;

        if ($region->_id != null)
            $graine->id = (int)$region->_id;
        $graine->nom = trim($region->_nom);
        $graine->id_pays = (int) $region->_id_pays;

        return $graine;
    }

    /**
     * verifie si un pays n'a pas deux region de même nom
     * @param string|null $nom
     * @param int|null $id_pays
     * @return bool
     */
    private function exist(string $nom = null, int $id_pays = null)
    {
        if (!is_null($nom) && !is_null($id_pays))
            return $this->bean_export(R::findOne(Region::T_REG, 'nom = ? AND id_pays = ? ', [(string)$nom, (int)$id_pays])) != null;
    }

    /**
     * lire la table region
     * @param int|null $id
     * @param int|null $id_pays
     * @return array|NULL
     */
    private static function lire(int $id = NULL, int $id_pays = null)
    {
        try {
            if (is_null($id) && is_null($id_pays)) {
                return R::getAll('select * from '.Region::T_REGION);
            }
            if (!is_null($id)) {
                return R::getAll('select * from '.Region::T_REGION.' where idregion = ?', [(int) $id]);
            }
            if (!is_null($id_pays)) {
                return R::getAll('select * from '.Region::T_REG.' where id_pays = ?', [(int) $id_pays]);
            }

            }
        catch
            (Exception $e){
                return $e->getMessage();
            }
    }

    /**
     * creation d'une region
     * @return bool
     */
    private function create()
    {
        try {
            if ($this->exist($this->_nom, $this->_id_pays))
                return false;
            $graine = R::dispense(Region::T_REG);
            $graine = $this->beanify($graine, $this);
            if ($graine != NULL)
                return R::store($graine) != NULL;

        } catch (Exception $e) {
            return FALSE;
        }
    }

    private function delete(int $id)
    {
        try {
            $bean = R::findOne(Region::T_REG, 'id = ?', [(int)$id]);
            if ($bean != NULL) {
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
            $bean = R::findOne(Region::T_REG,'id = ?',[(int)$id]);
            if ($bean != null) {
                if ($this->exist($this->_nom, $this->_id_pays))
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

    /**
     * Export un tableau ou objet Bean
     * @param mixed $bean
     * @return NULL
     */
    private static function bean_export($beans)
    {
        if (is_array($beans)) {
            return array_map(function ($beans) {
                return $beans->export();
            }, $beans);
        } else {
            return (!is_null($beans)) ? $beans->export() : NULL;
        }
    }

    #PARTIE PUBLIC

    /**
     * retourne toutes les regions
     * @return array|NULL
     */
    public function lire_tout()
    {
        return $this->lire();
    }

    /**
     * Retoune toutes les regions sous forme de tableau d'objets Region
     * @return array|Region[]|null
     */
    public function lire_tout_objet()
    {
        $region = $this->lire();
        return !is_null($region) ? array_map(function ($region) {
            return $this->objectify($region);
        }, $region) : NULL;
    }

    /**
     * lire tou
     * @param int $id_pays
     * @return false|string
     */
    public static function lire_region_par_pays_json(int $id_pays)
    {
        $region = Region::lire(null, $id_pays);
        
        if (!empty($region)) {
            //$t["region"] = array();
            foreach ($region as $row) 
                 
                    $s["id"] = (int)$row['id'];
                    $s["nom"] = $row['nom'];
                    $s["ville"] = Ville::lire_vil_par_reg_json_id((int)$row['idville']);
                    //"pays" => Pays::getById($row['idpays'])
                
                $t = $s;
            
        }else{
            return ['status' => 0, 'response' => 'Aucune region n\'a été enregistré pour ce pays'];

        }
        return  $t ;
    }

   



    /**
     * retourne toutes les regions sous forme de chaine JSON pour echange avec clients
     * @return false|string|null
     */
    public static function lire_tout_json()
    {
        $region = self::lire();
        
        if (!empty($region)) {
            
            foreach ($region as $row) {
               
                   $s["id"] = (int)$row['idregion'];
                    $s["region"] = $row['nomregion'];
                    $s["pays"] =  Pays::getById($row['idpays']);
                
                $t = $s;
            }
        }else{
            return json_encode(['status' => 0, 'response' => 'Aucune region n\'a été enregistré pour ce pays']);

        }
        return  json_encode($t);
    }

    public  function lire_par_id(int $id)
    {
        $region = Region::lire($id);
        $t = array();
        if (!empty($region)) {
            
            foreach ($region as $row) {
                
                   $s["id"] =(int)$row['idregion'];
                    $s["nom"] = $row['nomregion'];
                    $s["pays"] = Pays::getById($row['idpays']);
                
                $t = $s;
            }
        }else{
            return json_encode(['status' => 0, 'response' => 'Aucune region n\'existe avec cet ID']);

        }
        return  $t;
    }

    public function nouveau()
    {
        return $this->create() ? json_encode(['status' => 1, 'response' => 'Ajout reussi']) : json_encode(['status' => 0, 'response' => 'Echec de l\' ajout']);
    }
    public function supprimer(int $id)
    {
        return $this->delete($id) ? json_encode(['status' => 1, 'response' => 'Suppression reussi']) : json_encode(['status' => 0, 'response' => 'Echec de supresion']);
    }
    public function maj(int $id)
    {
        return $this->update($id) ? json_encode(['status' => 1, 'response' => 'Modification reussi']) : json_encode(['status' => 0, 'response' => 'Echec de modification']);
    }



    public static function getById(int $id){
        $data = Region::bean_export(R::findOne(Region::T_REG, 'id = ?', [(int) $id]));
        return $data;
    }





}
