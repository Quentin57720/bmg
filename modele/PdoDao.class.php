<?php

/*
 * PHP - Bibliothèques de fonctions
 * Fonctions génériques d'accès aux données
*/

class PdoDao extends PDO {        
    
    /**
     * Constructeur hérité de PDO
    */				
    public function __construct() {
        parent::__construct(
            DSN,
            DB_USER,
            DB_PWD,
            array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
            )
        );
        try {
            parent::setAttribute(
                PDO::ATTR_ERRMODE, 
                PDO::ERRMODE_EXCEPTION
            );            
            parent::setAttribute(
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,
                true
            );
        }
        catch (Exception $e) {
            return $e;
        }	
    }
   
    /**
     * Fonction qui renvoie un tableau de valeurs correspondant au résultat
     * de l'exécution d'une requête préparée SQL avec des paramètres anonymes
     * @param $sql (la requête SQL à exécuter)
     * @param $params : un tableau de paramètres contenant les valeurs 
     * @param $style : 0 == both, 1 == objet
     * @return un tableau associatif ou "objet" suivant le paramètre style
    */   
    public function getRows($sql, $params, $style) {
        try {
            $res = $this->prepare($sql);
            $res->execute($params);
        }
        catch (PDOException $e) {
            return $e;
        }
        if ($res) {
            if ($style) {
                return $res->fetchAll(PDO::FETCH_CLASS, 'ArrayObject');
            }
            else {
                return $res->fetchAll();
            }
        }
        else {
            return NULL;
        }
    }
    
    /**
     * Fonction qui exécute une requête action préparée 
     * avec des paramètres anonymes
     * @param $sql : la requête SQL à exécuter
     * @param $params : un tableau de paramètres contenant les valeurs 
     * à substituer dans la requête
     * @return un entier désignant le nombre de lignes affectées par
     * l'exécution de la requête
    */       
    public function execSQL($sql, $params) {        
        try {
            $res = $this->prepare($sql);
            $res->execute($params);
            $nb = $res->rowCount();
        }
        catch (PDOException $e) {
            return $e;
        }
        return $nb;	
    }    
	
    /**
     * Fonction qui exécute une requête préparée 
     * avec des paramètres anonymes et qui récupère une seule valeur
     * @param $sql : la requête SQL à exécuter
     * La requête ne doit renvoyer qu'une colonne et une ligne
     * @param $params : un tableau de paramètres contenant les valeurs 
     * à substituer dans la requête
     * @return la valeur récupérée par l'exécution de la requête
    */ 
    public function getValue($sql, $params) {
        try {
            $res = $this->prepare($sql);			
            $res->execute($params);
            if ($res) {
                $ligne = $res->fetchAll(PDO::FETCH_COLUMN, 0);
                if (count($ligne) > 0) {
                    $value = $ligne[0];
                }
                else {
                    $value = NULL;
                }
                $res->closeCursor();
                unset($res);
            }
            else {
                $value = NULL;
            }
        }
        catch (PDOException $e) {
            return $e;
        }		
        return $value;
    }

}