<?php

// solicite les services de la classe PdoDao
require_once('PdoDao.class.php');

class OuvrageDal {

    /**
     * charge un tableau de genre
     * @param $style : 0 == tableau assoc, 1 == objet
     * @return un objet de la classe PDOStatement
     */
    public static function loadOuvrages($style) {
        // instanciation d'un objet PdoDao
        $cnx = new PdoDao();
        $qry = 'SELECT no_ouvrage as ID, '
                . 'titre, '
                . 'code_genre, '
                . 'lib_genre, '
                . 'auteur, '
                . 'salle, '
                . 'rayon, '
                . 'dernier_pret, '
                . 'disponibilite '
                . 'FROM v_ouvrages '
                . 'ORDER BY titre;';
        
        $tab = $cnx->getRows($qry, array(), $style);
        if (is_a($tab, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        // dans le cas où on attend un tableau d'objets
        if ($style == 1) {
            // retourner un tableau d'objets
            $res = array();
            foreach ($tab as $ligne) {
                $unGenre = new Genre($ligne->code_genre, $ligne->lib_genre);
                $unOuvrage = new Ouvrage(
                        $ligne->ID, 
                        $ligne->titre, 
                        $ligne->salle, 
                        $ligne->rayon, 
                        $unGenre
                );
                $unOuvrage->setAuteur($ligne->auteur);
                $unOuvrage->setDisponibilite($ligne->disponibilite);
                $unOuvrage->setDernier_pret($ligne->dernier_pret);

                array_push($res, $unOuvrage); // identique à $res[] = unOuvrage;
            }
            return $res;
        }
        return $tab;
    }

    /**
     * charge un objet de la classe Ouvrage à partir de son code
     * @param  $id : le code de l'ouvrage
     * @return  un objet de la classe ouvrage
     */
    public static function loadOuvrageByID($id) {
        $cnx = new PdoDao();
        // requête
        $qry = 'SELECT no_ouvrage as ID, '
                . 'titre, '
                . 'salle, '
                . 'rayon, '
                . 'code_genre, '
                . 'acquisition, '
                . 'lib_genre, '
                . 'dernier_pret, '
                . 'disponibilite, '
                . 'auteur '
                . 'FROM v_ouvrages '
                . 'WHERE no_ouvrage = ?';
        $res = $cnx->getRows($qry, array($id), 1);
        if (is_a($res, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        if (!empty($res)) {
            $res = $res[0];
            $unGenre = new Genre($res->code_genre, $res->lib_genre);
            $unOuvrage = new Ouvrage(
                    $res->ID, 
                    $res->titre, 
                    $res->salle, 
                    $res->rayon, 
                    $unGenre,
                    $res->acquisition
            );
            $unOuvrage->setAuteur($res->auteur);
            $unOuvrage->setDisponibilite($res->disponibilite);
            $unOuvrage->setDernier_pret($res->dernier_pret);
            
            return $unOuvrage;
        } else {
            return NULL;
        }
    }

    /**
     * ajoute un genre
     * @param   string  $code : le code du genre à ajouter
     * @param   string  $libelle : le libellé du genre à ajouter
     * @return  le nombre de lignes affectées
     */
    public static function addOuvrage($strTitre,
                                    $intSalle,
                                    $strRayon,
                                    $strGenre,
                                    $strDate_acquisition) {
        $cnx = new PdoDao();
        $qry = 'INSERT INTO ouvrage(titre, salle, rayon, code_genre, date_acquisition) '
                . 'VALUES (?,?,?,?,?)';
        
        $res = $cnx->execSQL($qry, array(// nb de lignes affectées
            $strTitre,
            $intSalle,
            $strRayon,
            $strGenre,
            $strDate_acquisition)
        );
        if (is_a($res, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }

    /**
     * calcule le nombre d'ouvrages pour un genre
     * @param type $code : le code du genre
     * @return le nombre d'ouvrages du genre
     */
    public static function countOuvragesGenre($code) {
        $cnx = new PdoDao();
        $qry = 'SELECT COUNT(*) FROM ouvrage WHERE code_genre = ?';
        $res = $cnx->getValue($qry, array($code));
        if (is_a($res, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
    /**
     * calcule le nombre d'auteurs liés à un ouvrage
     * @param type $id : l'id de l'ouvrage
     * @return le nombre d'auteurs pour un ouvrage
     */
    public static function countAuteursOuvrage($id) {
        $cnx = new PdoDao();
        $qry = 'SELECT COUNT(*) FROM auteur_ouvrage WHERE no_ouvrage = ?';
        $res = $cnx->getValue($qry, array($id));
        if (is_a($res, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }

        
     /**
     * supprime un ouvrage
     * @param   int $code : le code de l'ouvrage à supprimer
     * @return le nombre de lignes affectées
     */
    public static function delOuvrage($id) {
        $cnx = new PdoDao();
        $qry = 'DELETE FROM ouvrage WHERE no_ouvrage = ?';
        $res = $cnx->execSQL($qry, array($id));
        if (is_a($res, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
    /**
     * supprime un genre
     * @param   int $code : le code du genre à supprimer
     * @return le nombre de lignes affectées
     */
    public static function setGenre($unGenre) {
        $cnx = new PdoDao();
        $qry = 'UPDATE genre SET lib_genre = ? WHERE code_genre = ?';
        $res = $cnx->execSQL($qry, array($unGenre->getLibelle(),$unGenre->getCode()));
        if (is_a($res, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }

    /**
     * modifie un ouvrage
     * @param   Ouvrage $unOuvrage
     * @return le nombre de lignes affectées
     */
    public static function setOuvrage($unOuvrage) {
        $cnx = new PdoDao();
        $qry = 'UPDATE ouvrage SET titre = ?,'
                . 'salle = ?,'
                . 'rayon = ?,'
                . 'code_genre = ?,'
                . 'date_acquisition= ? '
                . 'WHERE no_ouvrage = ?';
        $res = $cnx->execSQL($qry, array(
                $unOuvrage->getTitre(),
                $unOuvrage->getSalle(),
                $unOuvrage->getRayon(),
                $unOuvrage->getCode_genre()->getCode(),
                $unOuvrage->getAcquisition()->format('Y-m-d'),
                $unOuvrage->getNum()
                ));
        if (is_a($res, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
    
    /**
     * récupère l'ID du dernier ouvrage ajouté dans la base de données
     */
    public static function getMaxId() {
        $cnx = new PdoDao();
        $qry = "SELECT MAX(no_ouvrage) FROM ouvrage";
        $intID = $cnx->getValue($qry, array());
        return $intID;
    }
}

?>