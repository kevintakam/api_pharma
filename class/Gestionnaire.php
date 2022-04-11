<?php


class Gestionnaire
{
    private $_id;
    private $_nom_uti;
    private $_mdp;
    private $_id_pat;

    const V_GESTIONNAIRE = 'patient_gest';
    const T_GEST = 'gestionnaire';

    #GETTERS

    /**
     * @return int
     */
    public function getId()
    {
        return (int) $this->_id;
    }

    /**
     * @return string
     */
    public function getNomUti()
    {
        return (string) $this->_nom_uti;
    }

    /**
     * @return mixed
     */
    public function getMdp()
    {
        return $this->_mdp;
    }

    /**
     * @return int
     */
    public function getIdPat()
    {
        return (int) $this->_id_pat;
    }

    #SETTERS

    /**
     * @param string $nom_uti
     */
    public function setNomUti(string $nom_uti)
    {
        $this->_nom_uti = (string) $nom_uti;
    }

    /**
     * @param string $mdp
     */
    public function setMdp(string $mdp)
    {
        $this->_mdp = md5($mdp);
    }

    /**
     * @param int $id_pat
     */
    public function setIdPat(int $id_pat)
    {
        $this->_id_pat = (int) $id_pat;
    }

    private function objectify(array $array) {
        $gest = new Gestionnaire();

        if(array_key_exists('id', $array))
            $gest->_id = (int) $array['id'];

        if(array_key_exists('login', $array) && strcmp($array['login'], '')!==0)
            $gest->_nom_uti = trim($array['login']);

        if(array_key_exists('password', $array) && strcmp($array['password'], '')!==0)
            $gest->_mdp = trim($array['password']);

        if(array_key_exists('id_pat', $array))
            $gest->_id_pat = (int) $array['id_pat'];

        return $gest;
    }

    private function beanify($graine, Gestionnaire $gestionnaire) {

        if(!$gestionnaire instanceof Gestionnaire)
            return NULL;

        if($gestionnaire->_id != NULL)
            $graine->id = (int) $gestionnaire->_id;

        $graine->login = trim($gestionnaire->_nom_uti);
        $graine->password = trim($gestionnaire->_mdp);
        $graine->id_pat = (int) $gestionnaire->_id_pat;

        return $graine;
    }

    private function exist(int $id_pat = NULL, string $nom = NULL) {
        if($id_pat != NULL && is_null($nom))
            return $this->bean_export(R::findOne(Gestionnaire::T_GEST, 'id_pat = ? AND login = ?', [(int) $id_pat, (string) strtolower($nom)])) != NULL;
        }

    private function lire(int $id = NULL, string $nom = null)
    {
        try {
            if (is_null($id) && is_null($nom)) {
                return R::getAll('select * from '.Gestionnaire::V_GESTIONNAIRE);
            }
            if (!is_null($id)) {
                return R::getAll('select * from '.Gestionnaire::V_GESTIONNAIRE.' where id_patient = ?', [(int) $id]);
            }
            if (!is_null($nom)) {
                return R::getAll('select * from '.Gestionnaire::V_GESTIONNAIRE.' where login = ?', [(string) $nom]);
            }

        }
        catch
        (Exception $e){
            return $e->getMessage();
        }
    }

    private function bean_export($beans) {
        if(is_array($beans)) {
            return array_map(function ($beans) {return $beans->export();}, $beans);
        } else {
            return (!is_null($beans)) ? $beans->export() : NULL;
        }
    }

    private function create() {
        try {
            if($this->exist($this->_id_pat) && $this->exist(NULL, $this->_nom_uti))
                return FALSE;

            $graine = R::dispense(Gestionnaire::T_GEST);
            $graine = $this->beanify($graine, $this);

            if($graine != NULL)
                return R::store($graine) != NULL;

        } catch (Exception $e) {
            return FALSE;
        }
    }

    private function delete(int $id) {
        try {
            $bean = R::findOne(Gestionnaire::T_GEST, 'id = ?', [(int) $id]);
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
            $bean = R::findOne(Gestionnaire::T_GEST,'id = ?',[(int)$id]);
            if ($bean != null) {
                if ($this->exist($this->_id_pat, $this->_nom_uti))
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


    public function lire_tout() {return $this->lire();}



    public function lire_tout_objet()
    {
        $gest = $this->lire();
        return !is_null($gest) ? array_map(function ($gest) {
            return $this->objectify($gest);
        }, $gest) : NULL;
    }

    public function lire_tout_json() {
        $gest = $this->lire();
        $t = array();
        $t["gest"] = array();
        foreach ($gest as $row){
            $s = [
                "identifiant" => (int) $row['id_gest'],
                "login" => $row['login'],
                "password" => $row['pass']
                
            ];
            $t["gest"][] = $s;
        }
        return !is_null($t) ? json_encode($t) : json_encode(['statut' => (int) 0, 'response' => 'pas de gestionaire enregistrer']);
    }

    public function lire_par_id(int $id)
    {
        $gest = $this->lire($id);
        $t = array();
        $t["gest"] = array();
        foreach ($gest as $row){
            $s = [
                "identifiant" => (int) $row['id_gest'],
                "login" => $row['login'],
                "password" => $row['pass']
            ];
            $t["gest"][] = $s;
        }
        return !is_null($t) ? json_encode($t) : json_encode(['statut' => (int) 0, 'response' => 'pas de gestionaire enregistrer avec cette ID']);

    }
    public function lire_par_nom(string $nom)
    {
        $gest = $this->lire(null, $nom);
        $t = array();
        $t["gest"] = array();
        foreach ($gest as $row){
            $s = [
                "identifiant" => (int) $row['id_gest'],
                "login" => $row['login'],
                "password" => $row['pass']
                
            ];
            $t["gest"][] = $s;
        }
        return !is_null($t) ? json_encode($t) : json_encode(['statut' => (int) 0, 'response' => 'pas de gestionaire enregistrer avec cette ID']);

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
    public function nombre_Gestionnaire(){
        
        $nombre = R::count(Gestionnaire::T_GEST);
        return $nombre;
        
    }


}