<?php

// sollicite les services de la classe PdoDao
require_once ('PdoDao.class.php');

class ClientDal {

    /**
     * charge un tableau de genres
     * @param  $style : 0 == tableau assoc, 1 == objet
     * @return  un objet de la classe PDOStatement
     */
    public static function loadClients($style) {
        // instanciation d'un objet PdoDao
        $cnx = new PdoDao();
        $qry = "SELECT no_client as ID, "
                . "nom_client as Nom, "
                . "prenom, "
                . "rue_client, "
                . "code_post, "
                . "ville, "
                . "date_inscr, "
                . "mel, "
                . "etat_client, "
                . "montant_compte "
                . "FROM client ";

        $tab = $cnx->getRows($qry, array(), $style);
        if (is_a($tab, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        // dans le cas où on attend un tableau d'objets
        if ($style == 1) {
            // retourner un tableau d'objets
            $res = array();
            foreach ($tab as $ligne) {
                $unClient = new Client(
                        $ligne->ID,
                        $ligne->Nom,
                        $ligne->prenom,
                        $ligne->rue_client,
                        $ligne->code_post,
                        $ligne->ville,
                        $ligne->date_inscr,
                        $ligne->mel,
                        $ligne->etat_client,
                        $ligne->montant_compte
                );
                array_push($res, $unClient); // identique à $res[] = $unClient;
            }
            return $res;
        }
        return $tab;
    }



    /**
     * ajoute un client
     * @param   string  $strNom : le nom de l'client à ajouter
     * @param   string  $strPrenom : le prénom de l'client à ajouter
     * @param   string  $strAlias : l'alias de l'client à ajouter
     * @param   string  $strNotes : les notes concernant l'client à ajouter
     * @return  le nombre de lignes affectées
     */
    public static function addClient($Nom, $Prenom, $Rue, $CodePost, $Ville, $DateInscr, $Mel, $EtatClient, $MontantCompte, $Login, $Password, $Caution, $CautionEncaissee) {
        $cnx = new PdoDao();
        $qry = "INSERT INTO client(nom_client, prenom, rue_client, code_post, ville, date_inscr, mel, etat_client, montant_compte, login, password, caution, caution_encaissee) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $res = $cnx->execSQL($qry, array($Nom, $Prenom, $Rue, $CodePost, $Ville, $DateInscr, $Mel, $EtatClient, $MontantCompte, $Login, $Password, $Caution, $CautionEncaissee)
        );
        if (is_a($res, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }


    /**
     * Récupère l'ID du dernier client ajouté dans la base de données
     */
    public static function getMaxId()  {
        $cnx = new PdoDao();
        $qry = "SELECT MAX(no_client) FROM client";
        $intID = $cnx->getValue($qry, array());
        return $intID;
    }

    /**
     * charge un objet de la classe Client à partir de son ID
     * @param  $id : l'ID de l'client
     * @return  un objet de la classe Client
     */
    public static function loadClientById($id) {
        $cnx = new PdoDao();
        // requête
        $qry =  "SELECT no_client as ID, "
                . "nom_client as Nom, "
                . "prenom, "
                . "rue_client, "
                . "code_post, "
                . "ville, "
                . "date_inscr, "
                . "login, "
                . "password, "
                . "mel, "
                . "etat_client, "
                . "caution, "
                . "caution_encaissee, "
                . "montant_compte "
                . "FROM client "
                . "WHERE no_client = ?";
        $res = $cnx->getRows($qry, array($id), 1);
        if (is_a($res, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        if (!empty($res)) {
            // l'client existe
            return new Client($id,
              $res[0]->Nom,
              $res[0]->prenom,
              $res[0]->rue_client,
              $res[0]->code_post,
              $res[0]->ville,
              $res[0]->date_inscr,
              $res[0]->mel,
              $res[0]->etat_client,
              $res[0]->montant_compte,
              $res[0]->login,
              $res[0]->password,
              $res[0]->caution,
              $res[0]->caution_encaissee);
        } else {
            return NULL;
        }
    }

   /**
    * calcule le nombre d'ouvrages pour un client
    * @param type $id : l'ID de l'client
    * @return le nombre d'ouvrages de l'client
    */
    public static function countOuvragesClient($id){
        $cnx = new PdoDao();
        $qry = 'SELECT COUNT(*) FROM client_ouvrage WHERE id_client = ?';
        $res = $cnx->getValue($qry,array($id));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }

    /**
     * calcule le nombre de prets en cours
     * @param type $id : l'ID de l'client
     * @return le nombre d'ouvrages de l'client
     */
     public static function countPretEnCours($id){
         $cnx = new PdoDao();
         $qry = 'SELECT COUNT(*) FROM pret WHERE no_client = ?';
         $res = $cnx->getValue($qry,array($id));
         if (is_a($res,'PDOException')) {
             return PDO_EXCEPTION_VALUE;
         }
         return $res;
     }

    /**
     * supprime un client
     * @param   int $id : l'ID de l'client à supprimer
     * @return le nombre de lignes affectées
    */
    public static function delClient($id) {
        $cnx = new PdoDao();
        $qry = 'DELETE FROM client WHERE no_client = ?';
        $res = $cnx->execSQL($qry,array($id));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }

     /**
     * modifie un genre
     * @param   Client $unClient
     * @return  le nombre de lignes affectées
    */
    public static function setClient($unClient) {
        $cnx = new PdoDao();
        $qry = "UPDATE client SET nom_client = ?,"
                                ."prenom = ?,"
                                ."rue_client = ?,"
                                ."code_post = ?,"
                                ."ville = ?,"
                                ."date_inscr = ?,"
                                ."mel = ?,"
                                ."etat_client = ?,"
                                ."montant_compte = ?,"
                                ."login = ?,"
                                ."password = ?,"
                                ."caution = ?"
                                ." WHERE no_client = ?";
        $res = $cnx->execSQL($qry,array(
                            $unClient->getNom(),
                            $unClient->getPrenom(),
                            $unClient->getRue(),
                            $unClient->getCodePost(),
                            $unClient->getVille(),
                            $unClient->getDateInscr(),
                            $unClient->getMel(),
                            $unClient->getEtatClient(),
                            $unClient->getMontantCompte(),
                            $unClient->getLogin(),
                            $unClient->getPassword(),
                            $unClient->getCaution(),
                            $unClient->getId()
                           ));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
}