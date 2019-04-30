<?php

// sollicite les services de la classe PdoDao
require_once ('PdoDao.class.php');

class AuteurDal {

    /**
     * charge un tableau de genres
     * @param  $style : 0 == tableau assoc, 1 == objet
     * @return  un objet de la classe PDOStatement
     */
    public static function loadAuteurs($style) {
        // instanciation d'un objet PdoDao
        $cnx = new PdoDao(); 
        $qry = "SELECT id_auteur as ID, "
                ." nom AS Nom "
                ."FROM v_auteurs ";
        
        $tab = $cnx->getRows($qry, array(), $style);
        if (is_a($tab, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        // dans le cas où on attend un tableau d'objets
        if ($style == 1) {
            // retourner un tableau d'objets
            $res = array();
            foreach ($tab as $ligne) {
                $unAuteur = new Auteur(
                        $ligne->ID, $ligne->Nom
                );
                array_push($res, $unAuteur); // identique à $res[] = $unAuteur;
            }
            return $res;
        }
        return $tab;
    }
    
    

    /**
     * ajoute un auteur
     * @param   string  $strNom : le nom de l'auteur à ajouter
     * @param   string  $strPrenom : le prénom de l'auteur à ajouter
     * @param   string  $strAlias : l'alias de l'auteur à ajouter
     * @param   string  $strNotes : les notes concernant l'auteur à ajouter
     * @return  le nombre de lignes affectées
     */
    public static function addAuteur($strNom,$strPrenom,$strAlias,$strNotes) {
        $cnx = new PdoDao();
        $qry = "INSERT INTO auteur (nom_auteur, prenom_auteur, alias, notes) VALUES (?,?,?,?)";
        $res = $cnx->execSQL($qry, array(
            $strNom,
            $strPrenom,
            $strAlias,
            $strNotes
            )
        );
        if (is_a($res, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
    /**
     * ajoute un auteur pour un ouvrage
     * @param   int  $idAuteur : l'id de l'auteur à ajouter
     * @param   int  $idOuvrage : l'id de l'ouvrage à ajouter
     * @return  le nombre de lignes affectées
     */
    public static function addAuteurOuvrage($idOuvrage, $idAuteur) {
        $cnx = new PdoDao();
        $qry = "INSERT INTO auteur_ouvrage (no_ouvrage, id_auteur) VALUES (?,?)";
        $res = $cnx->execSQL($qry, array(
            $idOuvrage,
            $idAuteur
            )
        );
        if (is_a($res, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
    /**
     * Récupère l'ID du dernier auteur ajouté dans la base de données
     */
    public static function getMaxId()  {
        $cnx = new PdoDao();
        $qry = "SELECT MAX(id_auteur) FROM auteur";
        $intID = $cnx->getValue($qry, array());
        return $intID;
    }

    /**
     * charge un objet de la classe Auteur à partir de son ID
     * @param  $id : l'ID de l'auteur
     * @return  un objet de la classe Auteur
     */
    public static function loadAuteurById($id) {
        $cnx = new PdoDao();
        // requête
        $qry = "SELECT nom_auteur, prenom_auteur, alias, notes "
                ."FROM auteur "
                ."WHERE id_auteur = ?";
        $res = $cnx->getRows($qry, array($id), 1);
        if (is_a($res, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        if (!empty($res)) {
            // l'auteur existe
            return new Auteur($id,$res[0]->nom_auteur, $res[0]->prenom_auteur, $res[0]->alias, $res[0]->notes);
        } else {
            return NULL;
        }
    }
    
   /**
    * calcule le nombre d'ouvrages pour un auteur
    * @param type $id : l'ID de l'auteur
    * @return le nombre d'ouvrages de l'auteur
    */ 
    public static function countOuvragesAuteur($id){
        $cnx = new PdoDao();
        $qry = 'SELECT COUNT(*) FROM auteur_ouvrage WHERE id_auteur = ?';
        $res = $cnx->getValue($qry,array($id));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
    /**
     * supprime un genre
     * @param   int $id : l'ID de l'auteur à supprimer
     * @return le nombre de lignes affectées
    */      
    public static function delAuteur($id) {
        $cnx = new PdoDao();
        $qry = 'DELETE FROM auteur WHERE id_auteur = ?';
        $res = $cnx->execSQL($qry,array($id));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
     /**
     * modifie un genre
     * @param   Auteur $unAuteur
     * @return  le nombre de lignes affectées
    */      
    public static function setAuteur($unAuteur) {
        $cnx = new PdoDao();
        $qry = "UPDATE auteur SET nom_auteur = ?,"
                            ."prenom_auteur = ?,"
                            ."alias = ?,"
                            ."notes = ? "
                            ."WHERE id_auteur = ?";
        $res = $cnx->execSQL($qry,array(
                            $unAuteur->getNom(),
                            $unAuteur->getPrenom(),
                            $unAuteur->getAlias(),
                            $unAuteur->getNotes(),
                            $unAuteur->getId(),
                           ));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
}
 