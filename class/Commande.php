<?php


class Commande
{
    private $_ref;
    private $_id;
    private $_id_pat;
    private $_id_gest;
    private $_statut;
    private $_ordonnance;
    private $_note;
    private $_livre;
    private $_date_com;
    private $_date_com_traite;
    private $_motif;

    const T_COM = 'commande';
    const V_COM = 'commande_patient';
  
    /**
     * @return mixed
     */
    public function getRef()
    {
        return (string) $this->_ref;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return (int) $this->_id;
    }
    public function getMotif()
    {
        return (string) $this->_motif;
    }
    /**
     * @return mixed
     */
    public function getIdPat()
    {
        return (int) $this->_id_pat;
    }

    /**
     * @return mixed
     */
    public function getIdGest()
    {
        return (int) $this->_id_gest;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return (string) $this->_statut;
    }

    /**
     * @return mixed
     */
    public function getOrdonnance()
    {
        return (string) $this->_ordonnance;
    }

    /**
     * @return mixed
     */
    public function getNote()
    {
        return (string) $this->_note;
    }

    /**
     * @return mixed
     */
    public function getLivre()
    {
        return $this->_livre;
    }

    /**
     * @return mixed
     */
    public function getDateCom()
    {
        return  $this->_date_com;
    }

    /**
     * @return mixed
     */
    public function getDateComTraite()
    {
        return $this->_date_com_traite;
    }

    /**
     * @param mixed $ref
     */
    public function setRef(string $ref)
    {
        $this->_ref = htmlspecialchars(trim($ref));
    }

    /**
     * @param mixed $id_pat
     */
    public function setIdPat(int $id_pat)
    {
        $this->_id_pat = $id_pat;
    }

    /**
     * @param mixed $id_gest
     */
    public function setIdGest(int $id_gest)
    {
        $this->_id_gest = $id_gest;
    }

    /**
     * @param mixed $status
     */
    public function setStatus(string $status)
    {
        $this->_statut = (string) $status;
    }
    public function setMotif(string $motif)
    {
        $this->_motif = (string) $motif;
    }

    /**
     * @param mixed $ordonnance
     */
    public function setOrdonnance(string $ordonnance)
    {
        $this->_ordonnance = (string) $ordonnance;
    }

    /**
     * @param string $note
     */
    public function setNote(string $note)
    {
        $this->_note = (string) $note;
    }

    /**
     * @param mixed $livre
     */
    public function setLivre(int $livre)
    {
        $this->_livre = (int) $livre;
    }

    /**
     * @param mixed $date_com
     */
    public function setDateCom($date_com)
    {
        $this->_date_com = $date_com;
    }

    /**
     * @param mixed $date_com_traite
     */
    public function setDateComTraite($datecomtraite)
    {
        $this->_date_com_traite = $datecomtraite;
    }

    # PARTIE PRIVEE

    private function objectify(array $array)
    {
        $commande = new Commande();
        if (array_key_exists('id', $array))
            $this->_id = (int)$array['id'];
        if (array_key_exists('idpat', $array))
            $this->_id_pat = (int)($array['idpat']);
        if (array_key_exists('idgest', $array))
            $this->_id_gest = (int)$array['idgest'];
        if (array_key_exists('reference', $array) && strcmp($array['reference'], '') !== 0)
            $this->_ref = trim($array['reference']);
        if (array_key_exists('statut', $array) && strcmp($array['statut'], '') !== 0)
            $this->_statut = trim($array['statut']);
        if (array_key_exists('ordonnance', $array) && strcmp($array['ordonnance'], '') !== 0)
            $this->_ordonnance = trim($array['ordonnance']);
        if (array_key_exists('note', $array) && strcmp($array['note'], '') !== 0)
            $this->_note = trim($array['note']);
            if (array_key_exists('motif', $array) && strcmp($array['motif'], '') !== 0)
                $this->_motif = trim($array['motif']);
        if (array_key_exists('livre', $array))
            $this->_livre = (int)$array['livre'];
        if (array_key_exists('datecommandetraite', $array))
            $this->_date_com_traite = $array['datecommandetraite'];
        return $commande;
    }

    private function beanify($graine, Commande $commande)
    {
        if (!$commande instanceof Commande)
            return null;

        if ($commande->_id != null)
            $graine->id = (int)$commande->_id;
        if ($commande->_ref != NULL)
             $graine->ref_com = trim($commande->_ref);
        if ($commande->_id_pat != NULL)
            $graine->id_pat = (int)$commande->_id_pat;
        if ($commande->_id_gest != null)
            $graine->id_gest = (int)$commande->_id_gest;
        $graine->livre = (int)$commande->_livre;
        if ($commande->_statut != null)
            $graine->statut = trim($commande->_statut);
        if ($commande->_ordonnance != NULL)
            $graine->ordonnance = trim($commande->_ordonnance);
        if ($commande->_note != NULL)
            $graine->note = htmlspecialchars(strip_tags(trim($commande->_note)));
        if ($commande->_date_com_traite != null)
            $graine->date_com_traite = new DateTime('now');
        return $graine;
    }

    private function exist(string $ref = null)
    {
        if (!is_null($ref))
            return $this->bean_export(R::findOne(Commande::T_COM, 'ref_com = ? ', [(string) $ref])) != null;
    }

    private static function lire(int $id = NULL, string $ref = null, string $date_com = null, string $date_com_traite = null, int $tel = null, string  $email = null, string  $commune = null, string $ville = null, string $region = null, string $pays =  null, int $idpat = null)
    {
        try {
            if (is_null($id)  && is_null($ref) && is_null($date_com) && is_null($date_com_traite) && is_null($tel) && is_null($email) && is_null($commune) && is_null($ville) && is_null($region) && is_null($pays) && is_null($idpat)) {
                return R::getAll('select * from '. Commande::V_COM);
            }
            if (!is_null($id)) {
                return R::getAll('select * from '. Commande::V_COM.' where id = ?', [(int) $id]);
            }
            if (!is_null($ref)) {
                return R::getAll('select * from '. Commande::V_COM.' where ref_com = ?', [(string) $ref]);
            }
            if (!is_null($date_com)) {
                return R::getAll('select * from '. Commande::V_COM.' where date_com = ?', [ $date_com]);
            }
            if (!is_null($date_com_traite)) {
                return R::getAll('select * from '. Commande::V_COM.' where date_com_traite = ?', [ $date_com_traite]);
            }
            if (!is_null($tel)) {
                return R::getAll('select * from '. Commande::V_COM.' where telephone = ?', [(int) $tel]);
            }
            if (!is_null($email)) {
                return R::getAll('select * from '. Commande::V_COM.' where email LIKE :email', [':email' => (string) $email]);
            }
            if (!is_null($commune)) {
                return R::getAll('select * from '. Commande::V_COM.' where commune LIKE :commune', [':commune' => (string) $commune]);
            }
            if (!is_null($ville)) {
                return R::getAll('select * from '. Commande::V_COM.' where ville LIKE :ville', [':ville' => (string) $ville]);
            }
            if (!is_null($region)) {
                return R::getAll('select * from '. Commande::V_COM.' where region LIKE :region', [':region'  => (string) $region]);
            }
            if (!is_null($pays)) {
                return R::getAll('select * from '. Commande::V_COM.' where pays LIKE :pays', [':pays' => (string) $pays]);
            }
            if (!is_null($idpat)) {
                return R::getAll('select * from '. Commande::T_COM.' where id_pat = ? ', [(int) $idpat]);
            }
        }
        catch
        (Exception $e){
            return $e->getMessage();
        }
    }

    private function create()
    {
        try {
            if ($this->exist($this->_ref))
                return false;
            $graine = R::dispense(Commande::T_COM);
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
            $bean = R::findOne(Commande::T_COM, 'id = ?', [(int)$id]);
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
            $bean = R::findOne(Commande::T_COM,'id = ?',[(int)$id]);
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

    private function bean_export($beans)
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

    public function lire_tout_objet()
    {
        $region = $this->lire();
        return !is_null($region) ? array_map(function ($region) {
            return $this->objectify($region);
        }, $region) : NULL;
    }

    public function lire_tout_json()
    {
        $commande = $this->lire();
        $t = array();
        if (!empty($commande)) {
            $t["commande"] = array();
            foreach ($commande as $row) {
                $s = [
                    "id" => (int)$row['id'],
                    "reference" => $row['ref_com'],
                    "datecommande" => $row['date_com'],
                    "statut" => $row['statut'],
                    "motif" => $row['motif'],
                    "ordonnance" => $row['ordonnance'],
                    "note" => $row['note'],
                    "livre" => (int) $row['livre'],
                    "datecommandetraite" => $row['date_com_traite'],
                    "nompatient" => $row['nom_patient'],
                    "prenompatient" => $row['prenom_patient'],
                    "telephone" => (int) $row['telephone'],
                    "email" => $row['email'],
                    "quartier" => $row['quartier'],
                    "lieudit" => $row['lieu_dit'],
                    "typeadresse" => $row['type_adr'],
                    "commune" => $row['commune'],
                    "ville" => $row['ville'],
                    "region" => $row['region'],
                    "pays" => $row['pays']
                ];
                $t["commande"][] = $s;
            }
        }else{
            return json_encode(['status' => 0, 'response' => 'Aucune commande n\'a été enregistré ']);

        }
        return  json_encode($t);
    }

    public static function lire_par_id_pat(int $id){
        $commande = self::lire(null, null, null, null, null, null, null, null, null, null, $id);
        $t = array();
        if (!empty($commande)) {
            //$t["commande"] = array();
            foreach ($commande as $row) {
                $s = [
                    "id" => (int)$row['id'],
                    "reference" => $row['ref_com'],
                    "datecommande" => $row['date_com'],
                    "statut" => $row['statut'],
                    "motif" => $row['motif'],
                    "ordonnance" => $row['ordonnance'],
                    "note" => $row['note'],
                    "livre" => (int) $row['livre'],
                    "datecommandetraite" => $row['date_com_traite']
                    ];
                $t[] = $s;
            }
        }else{
            return [];

        }
        return  $t;
    }

    public function lire_par_id(int $id)
    {
        $commande = $this->lire($id);
        $t = array();
        if (!empty($commande)) {
            $t["commande"] = array();
            foreach ($commande as $row) {
                $s = [
                    "id" => (int)$row['id'],
                    "reference" => $row['ref_com'],
                    "datecommande" => $row['date_com'],
                    "statut" => $row['statut'],
                    "motif" => $row['motif'],
                    "ordonnance" => $row['ordonnance'],
                    "note" => $row['note'],
                    "livre" => (int) $row['livre'],
                    "datecommandetraite" => $row['date_com_traite'],
                    "nompatient" => $row['nom_patient'],
                    "prenompatient" => $row['prenom_patient'],
                    "telephone" => (int) $row['telephone'],
                    "email" => $row['email'],
                    "quartier" => $row['quartier'],
                    "lieudit" => $row['lieu_dit'],
                    "typeadresse" => $row['type_adr'],
                    "commune" => $row['commune'],
                    "ville" => $row['ville'],
                    "region" => $row['region'],
                    "pays" => $row['pays']
                ];
                $t["commande"][] = $s;
            }
        }else{
            return json_encode(['status' => 0, 'response' => 'Aucune commande n\'existe avec cet ID']);

        }
        return  json_encode($t);
    }

    public function lire_par_ref(string $ref)
    {
        $commande = $this->lire(null, $ref);
        $t = array();
        if (!empty($commande)) {
            $t["commande"] = array();
            foreach ($commande as $row) {
                $s = [
                    "id" => (int)$row['id'],
                    "reference" => $row['ref_com'],
                    "date_com" => $row['date_com'],
                    "statut" => $row['statut'],
                    "motif" => $row['motif'],
                    "ordonnance" => $row['ordonnance'],
                    "note" => $row['note'],
                    "livre" => (int) $row['livre'],
                    "datecommandetraite" => $row['date_com_traite'],
                    "nompatient" => $row['nom_patient'],
                    "prenom_patient" => $row['prenom_patient'],
                    "telephone" => (int) $row['telephone'],
                    "email" => $row['email'],
                    "quartier" => $row['quartier'],
                    "lieudit" => $row['lieu_dit'],
                    "typeadresse" => $row['type_adr'],
                    "commune" => $row['commune'],
                    "ville" => $row['ville'],
                    "region" => $row['region'],
                    "pays" => $row['pays']
                ];
                $t["commande"][] = $s;
            }
        }else{
            return json_encode(['status' => 0, 'response' => 'Aucune commande n\'existe avec cette reference']);

        }
        return  json_encode($t);
    }

    public function lire_par_date_com(string $date)
    {
        $commande = $this->lire(null, null, $date);
        $t = array();
        if (!empty($commande)) {
            $t["commande"] = array();
            foreach ($commande as $row) {
                $s = [
                    "id" => (int)$row['id'],
                    "reference" => $row['ref_com'],
                    "datecommande" => $row['date_com'],
                    "statut" => $row['statut'],
                    "motif" => $row['motif'],
                    "ordonnance" => $row['ordonnance'],
                    "note" => $row['note'],
                    "livre" => (int) $row['livre'],
                    "datecommandetraite" => $row['date_com_traite'],
                    "nompatient" => $row['nom_patient'],
                    "prenompatient" => $row['prenom_patient'],
                    "telephone" => (int) $row['telephone'],
                    "email" => $row['email'],
                    "quartier" => $row['quartier'],
                    "lieudit" => $row['lieu_dit'],
                    "typeadresse" => $row['type_adr'],
                    "commune" => $row['commune'],
                    "ville" => $row['ville'],
                    "region" => $row['region'],
                    "pays" => $row['pays']
                ];
                $t["commande"][] = $s;
            }
        }else{
            return json_encode(['status' => 0, 'response' => 'Aucune commande n\'existe avec cette date']);

        }
        return  json_encode($t);
    }
    public function lire_par_date_com_traite(string $date)
    {
        $commande = $this->lire(null, null, null, $date);
        $t = array();
        if (!empty($commande)) {
            $t["commande"] = array();
            foreach ($commande as $row) {
                $s = [
                    "id" => (int)$row['id'],
                    "reference" => $row['ref_com'],
                    "datecommande" => $row['date_com'],
                    "statut" => $row['statut'],
                    "motif" => $row['motif'],
                    "ordonnance" => $row['ordonnance'],
                    "note" => $row['note'],
                    "livre" => (int) $row['livre'],
                    "datecommandetraite" => $row['date_com_traite'],
                    "nompatient" => $row['nom_patient'],
                    "prenompatient" => $row['prenom_patient'],
                    "telephone" => (int) $row['telephone'],
                    "email" => $row['email'],
                    "quartier" => $row['quartier'],
                    "lieudit" => $row['lieu_dit'],
                    "typeadresse" => $row['type_adr'],
                    "commune" => $row['commune'],
                    "ville" => $row['ville'],
                    "region" => $row['region'],
                    "pays" => $row['pays']
                ];
                $t["commande"][] = $s;
            }
        }else{
            return json_encode(['status' => 0, 'response' => 'Aucune commande n\'existe avec cette date de traitement']);

        }
        return  json_encode($t);
    }

    public function lire_par_tel(int $tel)
    {
        $commande = $this->lire(null, null, null, null,$tel);
        $t = array();
        if (!empty($commande)) {
            $t["commande"] = array();
            foreach ($commande as $row) {
                $s = [
                    "id" => (int)$row['id'],
                    "reference" => $row['ref_com'],
                    "datecom" => $row['date_com'],
                    "statut" => $row['statut'],
                    "motif" => $row['motif'],
                    "ordonnance" => $row['ordonnance'],
                    "note" => $row['note'],
                    "livre" => (int) $row['livre'],
                    "datecomtraite" => $row['date_com_traite'],
                    "nompatient" => $row['nom_patient'],
                    "prenompatient" => $row['prenom_patient'],
                    "telephone" => (int) $row['telephone'],
                    "email" => $row['email'],
                    "quartier" => $row['quartier'],
                    "lieudit" => $row['lieu_dit'],
                    "typeadresse" => $row['type_adr'],
                    "commune" => $row['commune'],
                    "ville" => $row['ville'],
                    "region" => $row['region'],
                    "pays" => $row['pays']
                ];
                $t["commande"][] = $s;
            }
        }else{
            return json_encode(['status' => 0, 'response' => 'Aucune commande n\'existe avec ce tel']);

        }
        return  json_encode($t);
    }

    public function lire_par_email(string $email)
    {
        $commande = $this->lire(null, null, null, null, null, $email);
        $t = array();
        if (!empty($commande)) {
            $t["commande"] = array();
            foreach ($commande as $row) {
                $s = [
                    "id" => (int)$row['id'],
                    "reference" => $row['ref_com'],
                    "datecommande" => $row['date_com'],
                    "statut" => $row['statut'],
                    "motif" => $row['motif'],
                    "ordonnance" => $row['ordonnance'],
                    "note" => $row['note'],
                    "livre" => (int) $row['livre'],
                    "datecommandetraite" => $row['date_com_traite'],
                    "nompatient" => $row['nom_patient'],
                    "prenompatient" => $row['prenom_patient'],
                    "telephone" => (int) $row['telephone'],
                    "email" => $row['email'],
                    "quartier" => $row['quartier'],
                    "lieudit" => $row['lieu_dit'],
                    "typeadresse" => $row['type_adr'],
                    "commune" => $row['commune'],
                    "ville" => $row['ville'],
                    "region" => $row['region'],
                    "pays" => $row['pays']
                ];
                $t["commande"][] = $s;
            }
        }else{
            return json_encode(['status' => 0, 'response' => 'Aucune commande n\'existe avec cet email']);

        }
        return  json_encode($t);
    }

    public function lire_par_commune(string $commune)
    {
        $commande = $this->lire(null, null, null, null, null, null, $commune);
        $t = array();
        if (!empty($commande)) {
            $t["commande"] = array();
            foreach ($commande as $row) {
                $s = [
                    "id" => (int)$row['id'],
                    "reference" => $row['ref_com'],
                    "datecommande" => $row['date_com'],
                    "statut" => $row['statut'],
                    "motif" => $row['motif'],
                    "ordonnance" => $row['ordonnance'],
                    "note" => $row['note'],
                    "livre" => (int) $row['livre'],
                    "datecommandetraite" => $row['date_com_traite'],
                    "nompatient" => $row['nom_patient'],
                    "prenompatient" => $row['prenom_patient'],
                    "telephone" => (int) $row['telephone'],
                    "email" => $row['email'],
                    "quartier" => $row['quartier'],
                    "lieudit" => $row['lieu_dit'],
                    "typeadresse" => $row['type_adr'],
                    "commune" => $row['commune'],
                    "ville" => $row['ville'],
                    "region" => $row['region'],
                    "pays" => $row['pays']
                ];
                $t["commande"][] = $s;
            }
        }else{
            return json_encode(['status' => 0, 'response' => 'Aucune commande n\'existe pour cette commune']);

        }
        return  json_encode($t);
    }

    public function lire_par_ville(string $ville)
    {
        $commande = $this->lire(null, null, null, null,null, null, null, $ville);
        $t = array();
        if (!empty($commande)) {
            $t["commande"] = array();
            foreach ($commande as $row) {
                $s = [
                    "id" => (int)$row['id'],
                    "reference" => $row['ref_com'],
                    "datecommande" => $row['date_com'],
                    "statut" => $row['statut'],
                    "motif" => $row['motif'],
                    "ordonnance" => $row['ordonnance'],
                    "note" => $row['note'],
                    "livre" => (int) $row['livre'],
                    "datecommandetraite" => $row['date_com_traite'],
                    "nompatient" => $row['nom_patient'],
                    "prenompatient" => $row['prenom_patient'],
                    "telephone" => (int) $row['telephone'],
                    "email" => $row['email'],
                    "quartier" => $row['quartier'],
                    "lieudit" => $row['lieu_dit'],
                    "typeadresse" => $row['type_adr'],
                    "commune" => $row['commune'],
                    "ville" => $row['ville'],
                    "region" => $row['region'],
                    "pays" => $row['pays']
                ];
                $t["commande"][] = $s;
            }
        }else{
            return json_encode(['status' => 0, 'response' => 'Aucune commande n\'existe pour cette ville']);

        }
        return  json_encode($t);
    }

    public function lire_par_region(string $region)
    {
        $commande = $this->lire(null, null, null, null, null, null, null, null, $region);
        $t = array();
        if (!empty($commande)) {
            $t["commande"] = array();
            foreach ($commande as $row) {
                $s = [
                    "id" => (int)$row['id'],
                    "reference" => $row['ref_com'],
                    "datecommande" => $row['date_com'],
                    "statut" => $row['statut'],
                    "motif" => $row['motif'],
                    "ordonnance" => $row['ordonnance'],
                    "note" => $row['note'],
                    "livre" => (int) $row['livre'],
                    "datecommandetraite" => $row['date_com_traite'],
                    "nompatient" => $row['nom_patient'],
                    "prenompatient" => $row['prenom_patient'],
                    "telephone" => (int) $row['telephone'],
                    "email" => $row['email'],
                    "quartier" => $row['quartier'],
                    "lieudit" => $row['lieu_dit'],
                    "type_adresse" => $row['type_adr'],
                    "commune" => $row['commune'],
                    "ville" => $row['ville'],
                    "region" => $row['region'],
                    "pays" => $row['pays']
                ];
                $t["commande"][] = $s;
            }
        }else{
            return json_encode(['status' => 0, 'response' => 'Aucune commande n\'existe pour cette region']);

        }
        return  json_encode($t);
    }

    public function lire_par_pays(string $pays)
    {
        $commande = $this->lire(null, null, null, null, null, null, null, null, null, $pays);
        $t = array();
        if (!empty($commande)) {
            $t["commande"] = array();
            foreach ($commande as $row) {
                $s = [
                    "id" => (int)$row['id'],
                    "reference" => $row['ref_com'],
                    "datecommande" => $row['date_com'],
                    "statut" => $row['statut'],
                    "motif" => $row['motif'],
                    "ordonnance" => $row['ordonnance'],
                    "note" => $row['note'],
                    "livre" => (int) $row['livre'],
                    "datecommandetraite" => $row['date_com_traite'],
                    "nompatient" => $row['nom_patient'],
                    "prenompatient" => $row['prenom_patient'],
                    "telephone" => (int) $row['telephone'],
                    "email" => $row['email'],
                    "quartier" => $row['quartier'],
                    "lieudit" => $row['lieu_dit'],
                    "typeadresse" => $row['type_adr'],
                    "commune" => $row['commune'],
                    "ville" => $row['ville'],
                    "region" => $row['region'],
                    "pays" => $row['pays']
                ];
                $t["commande"][] = $s;
            }
        }else{
            return json_encode(['status' => 0, 'response' => 'Aucune commande n\'existe pour ce pays']);

        }
        return  json_encode($t);
    }

    public function nouveau()
    {
        return $this->create() ? json_encode(['status' => 1, 'response' => 'Ajout reussi']) : json_encode(['status' => 0, 'response' => 'Echec de l\' ajout']);
    }
    public function supprimer(int $id)
    {
        return $this->delete($id) ? json_encode(['status' => 1, 'response' => 'Suppression reussi']) : json_encode(['status' => 0, 'response' => 'Echec de suppression']);
    }
    public function maj(int $id)
    {
        return $this->update($id) ? json_encode(['status' => 1, 'response' => 'Modification reussi']) : json_encode(['status' => 0, 'response' => 'Echec de modification']);
    }
    
   public function nombre_commande(){  
       $nombre = R::count(Commande::T_COM,'statut = ?',['en cours']);
       return $nombre;      
    }
    public function nombre_commande_traite(){
        
        $nombre = R::count(Commande::T_COM,'statut != ?',['en cours']);
        return $nombre;
        
    }
    public function nombre_commande_par( string $nom){
        
        $nombre = R::count(Commande::V_COM,'nom_patient= ?',[ trim($nom)]);
        return $nombre;
        
    }

}