<?php

// sollicite les services de la classe PdoDao
require_once ('PdoDao.class.php');

class GenreDal {

    /**
     * charge un tableau de genres
     * @param  $style : 0 == tableau assoc, 1 == objet
     * @return  un objet de la classe PDOStatement
     */
    public static function loadGenres($style) {
        // instanciation d'un objet PdoDao
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM genre';
        $tab = $cnx->getRows($qry, array(), $style);
        if (is_a($tab, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        // dans le cas où on attend un tableau d'objets
        if ($style == 1) {
            // retourner un tableau d'objets
            $res = array();
            foreach ($tab as $ligne) {
                $unGenre = new Genre(
                        $ligne->code_genre, $ligne->lib_genre
                );
                array_push($res, $unGenre); // identique à $res[] = $unGenre;
            }
            return $res;
        }
        return $tab;
    }

    /**
     * ajoute un genre
     * @param   string  $code : le code du genre à ajouter
     * @param   string  $libelle : le libellé du genre à ajouter
     * @return  le nombre de lignes affectées
     */
    public static function addGenre($code, $libelle) {
        $cnx = new PdoDao();
        $qry = 'INSERT INTO genre VALUES (?,?)';
        $res = $cnx->execSQL($qry, array(
            $code,
            $libelle
                )
        );
        if (is_a($res, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }

    /**
     * charge un objet de la classe Genre à partir de son code
     * @param  $id : le code du genre
     * @return  un objet de la classe Genre
     */
    public static function loadGenreByID($id) {
        $cnx = new PdoDao();
        // requête
        $qry = 'SELECT code_genre, lib_genre FROM genre WHERE code_genre = ?';
        $res = $cnx->getRows($qry, array($id), 1);
        if (is_a($res, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        if (!empty($res)) {
            // le genre existe
            $code = $res[0]->code_genre;
            $libelle = $res[0]->lib_genre;
            return new Genre($code, $libelle);
        } else {
            return NULL;
        }
    }
    
   /**
    * calcule le nombre d'ouvrages pour un genre
    * @param type $code : le code du genre
    * @return le nombre d'ouvrages du genre
    */ 
    public static function countOuvragesGenre($code){
        $cnx = new PdoDao();
        $qry = 'SELECT COUNT(*) FROM ouvrage WHERE code_genre = ?';
        $res = $cnx->getValue($qry,array($code));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
    /**
     * supprime un genre
     * @param   int $code : le code du genre à supprimer
     * @return le nombre de lignes affectées
    */      
    public static function delGenre($code) {
        $cnx = new PdoDao();
        $qry = 'DELETE FROM genre WHERE code_genre = ?';
        $res = $cnx->execSQL($qry,array($code));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
     /**
     * modifie un genre
     * @param   int     $code
     * @param   string  $libelle
     * @return  le nombre de lignes affectées
    */      
    public static function setGenre($unGenre) {
        $cnx = new PdoDao();
        $qry = 'UPDATE genre SET lib_genre = ? WHERE code_genre = ?';
        $res = $cnx->execSQL($qry,array(
                $unGenre->getLibelle(),
                $unGenre->getCode()
            ));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    

}
 