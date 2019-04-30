<?php
// ----------------------------------------------------------------------------------------
/* BMG
 * 
*/
// ----------------------------------------------------------------------------------------

/**
 * paramètres de configuration de l'appplication
 */

// gestion d'erreur 
ini_set('error_reporting', E_ALL);      // en phase de développement
//ini_set('error_reporting', 0);        // en phase de production 

// constantes pour l'accès à la base de données

// Serveur MySql
define('DB_SERVER', 'localhost');
// Nom de la base de données
define('DB_DATABASE', 'bmg');
// Nom d'utilisateur pour se connecter à la base de données
define('DB_USER', 'root');
// Mot de passe pour se connecter à la base de données
define('DB_PWD', '');

// La dsn en entier
define('DSN', 'mysql:dbname='.DB_DATABASE.';host='.DB_SERVER);

// PDO
define ('PDO_EXCEPTION_VALUE',-99);

// constantes utilisées par l'application
define ('ERROR', 0);
define ('WARNING', 1);
define ('INFO', 2);
define ('SUCCESS', 2);

define ('PATH_TO_IMG', 'img/couvertures/');  // chemin d'accès aux images de couverture des ouvrages
define ('DEFAULT_IMG', '0.jpg');             // couverture par défaut
define ('NOT_FOUND_IMAGE', 'img/0.jpg');     // chemin d'accès vers l'image par défaut