<?php


class Commune{

    private $_id;
    private $_nom;
    private $_id_vil;

    const T_COMMUNE='ville_commune';
    const T_COM = 'commune';
    public function __construct(){}
    function __destruct(){}

    /**
     * @return mixed
     */
    public function getId()
    {
        return (int) $this->_id;
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
    public function getIdVil()
    {
        return (int) $this->_id_vil;
    }

    /**
     * @param mixed $nom
     */
    public function setNom(string $nom)
    {
        $this->_nom = trim($nom);
    }

    /**
     * @param mixed $id_vil
     */
    public function setIdVil(int $id_vil)
    {
        $this->_id_vil = (int) $id_vil;
    }

    /**
     * @param array $array
     * @return Commune
     */
    private function objectify(array $array) {
        $comune = new Commune();
        if(array_key_exists('id', $array))
            $this->_id = (int) $array['id'];
        if(array_key_exists('nom', $array ) && strcmp($array['nom'], '') !== 0)
            $this->_nom = trim($array['nom']);
        if(array_key_exists('id_vil', $array))
            $this->_id_vil = (int) $array['id_vil'];
        return $comune;
    }

    /**
     * @param $graine
     * @param Commune $commune
     * @return null
     */
    private function beanify($graine, Commune $commune){
        if(!$commune instanceof Commune)
            return null;
        if($this->_id != null)
             $graine->id = (int) $commune->_id;
        $graine->nom = trim($commune->_nom);
        $graine->id_vil = (int) $commune->_id_vil;

        return $graine;
    }

    /**
     * @param string|null $nom
     * @param int|null $id_vil
     * @return bool
     */
    private function exist(string $nom = null, int $id_vil = null){
        if(!is_null($nom) && !is_null($id_vil))
            return $this->bean_export(R::findOne(Commune::T_COM, 'nom = ? AND id_vil = ? ', [(string) $nom,(int) $id_vil])) != null;
    }

    private function lire(int $id =NULL, int $idvil = null){
        try {
            if(is_null($id) && is_null($idvil)){
               return R::getAll('SELECT * from '.Commune::T_COMMUNE);
            }

            if(!is_null($id)){
                return R::getAll('select * from '.Commune::T_COMMUNE.' where idCommune = ?', [(int) $id]);
            }

            if(!is_null($idvil)){
                return R::getAll('select * from '.Commune::T_COMMUNE.' where idVille = ?', [(int) $idvil]);
            }

        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    private function create(){
        try {
            if($this->exist($this->_nom, $this->_id_vil))
                return false;
            $graine = R::dispense(Commune::T_COM);
            $graine = $this->beanify($graine, $this);

            if($graine != NULL)
                return R::store($graine) != NULL;

        }catch (Exception $e){
            return FALSE;
        }
    }

    private function delete(int $id){
        try {
            $bean = R::findOne(Commune::T_COM, 'id = ?', [(int) $id]);
            if($bean != NULL) {
                R::trash($bean);
                return TRUE;
            }
        } catch (Exception $e) {
            return FALSE;
        }
        return FALSE;
    }

    private function update(int $id){
        try {
            $bean = R::findOne(Commune::T_COM, 'id = ?', [(int) $id]);
            if ($bean != null){
                if($this->exist($this->_nom, $this->_id_vil))
                    return false;
                $bean = $this->beanify($bean, $this);
                if ($bean != NULL)
                    return R::store($bean);
                return true;
            }
            return false;

        }catch (Exception $e){
            echo $e->getMessage();
            return false;
        }
    }

    private function bean_export($beans) {
        if(is_array($beans)) {
            return array_map(function ($beans) {return $beans->export();}, $beans);
        } else {
            return (!is_null($beans)) ? $beans->export() : NULL;
        }
    }

    #PARTIE PUBLIC

    /**
     * retourne toutes les communes
     * @return array|NULL
     */
    public function lire_tout(){return $this->lire();}


    public function lire_tout_objet(){
        $commune = $this->lire();
        return !is_null($commune) ? array_map(function($commune){return $this->objectify($commune);}, $commune) : NULL;
    }

    public function lire_commune_par_ville_json(int $id_ville){
        $commune = $this->lire(null, $id_ville);
        $t = array();
        if (!empty($commune)) {
            
            foreach ($commune as $row) {
                $s = [
                    "identifiant" => (int)$row['idCommune'],
                    "commune" => $row['nomCommune'],
                    "ville" => $row['nomville']
                ];
                $t[] = $s;
            }
        }else{
            return json_encode(['status' => 0, 'response' => 'Aucune commune n\'a été enregistré pour cette ville']);

        }
        return  json_encode($t) ;
    }

    public function lire_tout_json() {
        $commune = $this->lire();
        $t = array();
        if (!empty($commune)) {
            $t["commune"] = array();
            foreach ($commune as $row) {
                $s = [
                    "identifiant" => (int)$row['idCommune'],
                    "commune" => $row['nomCommune'],
                    "ville" => $row['nomville']
                ];
                $t["commune"][] = $s;
            }
        }else{
            return json_encode(['status' => 0, 'response' => 'Aucune commune n\'a été enregistré pour cette ville']);

        }
        return  json_encode($t);
    }

    public static function lire_par_id(int $id) {
        $commune = Commune::lire($id);
        if (!empty($commune)) {
           /// $t["commune"] = array();
            foreach ($commune as $row) {
                
                    $s["id"] = (int)$row['idCommune'];
                    $s["commune"] = $row['nomCommune'];
                    $s["ville"] = Ville::lire_par_id($row['idVille']);
                $t = $s;
            }
        }else{
            return json_encode(['status' => 0, 'response' => 'Aucune commune n\'existe avec cet ID']);

        }
        return  $t;

    }

    public function nouveau() {
        return $this->create() ? json_encode(['status' => 1, 'response' => 'Ajout reussi']) : json_encode(['status' => 0, 'response' => 'Echec de l\' ajout']);
    }
    public function supprimer(int $id) {
        return $this->delete($id) ? json_encode(['status' => 1, 'response' => 'Suppression reussi']) : json_encode(['status' => 0, 'response' => 'Echec de supresion']);
    }
    public function maj(int $id)
    {
        return $this->update($id) ? json_encode(['status' => 1, 'response' => 'Modification reussi']) : json_encode(['status' => 0, 'response' => 'Echec de modification']);
    }

}
