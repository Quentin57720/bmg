<?php

require_once 'modele/GenreDal.class.php';
require_once 'modele/ClientDal.class.php';
require_once 'modele/OuvrageDal.class.php';
require_once 'modele/AuteurDal.class.php';
require_once 'modele/PretDal.class.php';
require_once 'include/_reference.lib.php';

if (!(isset($_REQUEST['action']))) {
    $action = 'listerPrets';
} else {
    $action = $_REQUEST['action'];
}

// variables pour al gestion des messages
$msg = '';      // message passé à la vue v_afficherMessage
$lien = '';     // message passé à la vue v_afficherErreurs
// variables pour la gestion des messages
$titrePage = 'Gestion des prêt';
// variables pour la gestion des erreurs
$tabErreurs = array();
$hasErrors = false;

$strClient = '';
$strOuvrage = '';

switch ($action) {
    case'listerPrets' : {
            // récupérer les auteurs
            $lesPrets = PretDal::loadPrets(1);
            // afficher le nombre d'auteurs
            $nbPrets = count($lesPrets);
            include ('vues/v_listerPrets.php');
        }
        break;

    case'ajouterPret' : {
            // traitement de l'option : saisie ou validation ?
            if (isset($_GET["option"])) {
                $option = htmlentities($_GET["option"]);
            } else {
                $option = 'saisirPret';
            }
            switch ($option) {
                case 'saisirPret' : {
                        $lesClients = ClientDal::loadClients(0);
                        $lesOuvrages = OuvrageDal::loadOuvrages(0);
                        include 'vues/v_ajouterPret.php';
                    } break;
                case 'validerPret' : {
                        if (isset($_POST["cmdValider"])) {
                            // récupération des valeurs saisies
                            if (!empty($_POST["cbxClients"])) {
                                $strClient = ucfirst($_POST["cbxClients"]);
                            }
                            if (!empty($_POST["cbxOuvrages"])) {
                                $strOuvrage = ucfirst($_POST["cbxOuvrages"]);
                            }
                            if (!empty($_POST["txtDate"])) {
                                $strDate_emprunt = ucfirst($_POST["txtDate"]);
                            }
                            // test zones obligatoires
                            if (!empty($strClient) and ! empty($strOuvrage) and ! empty($strDate_emprunt)) {
                                // tests de cohérence
                                // test de la date d'acquisition
                                $dateEmprunt = new DateTime($strDate_emprunt);
                                $curDate = new DateTime(date('Y-m-d'));
                                if ($dateEmprunt > $curDate) {
                                    // la date d'acquisition est postérieure à la date du jour
                                    $tabErreurs[] = 'La date d\'emprunt doit être antérieure ou égale à la date du jour';
                                    $hasErrors = true;
                                }
                            } else {
                                if (empty($strDate_emprunt)) {
                                    $tabErreurs[] = "La date d'emprunt doit être renseignée !";
                                }
                                $hasErrors = true;
                            }
                            if (!$hasErrors) {
                                try {
                    
                                    $res = PretDal::addPret($strClient, $strOuvrage, $strDate_emprunt, NULL);

                                    if ($res > 0) {
                                        $msg = '<span class="info">Le pret de l\'ouvrage  '
                                                 . ' a été ajouté</span>';
                                        // recuperation du numero
                                        $intID = PretDal::getMaxId();

                                        $lePret = PretDal::loadPretByID($intID);
                                        
                                        if ($lePret) {
                                            include 'vues/v_consulterPret.php';
                                        } else {
                                            $tabErreurs[] = "Ce pret n'existe pas !";
                                            $hasErrors = true;
                                        }
                                    } else {
                                        $tabErreurs[] = "Une erreur s'est produite dans l'operation d'ajout !";
                                        $hasErrors = true;
                                    }
                                } catch (Exception $ex) {
                                    $tabErreurs[] = "Une exception PDO a été levée !";
                                    $hasErrors = true;
                                }
                            } else {
                                $msg = "L'opération d'ajout n'a pas pu être menée à terme en raison des erreurs suivantes :";
                                $lien = '<a href="index.php?uc=gererPrets&action=ajouterPret">Retour à la saisie</a>';
                                include ('vues/_v_afficherErreurs.php');
                            }
                        }
                    }
                    break;
            }
        }
        break;

    case'consulterPret' : {
            // récupération du code
            if (isset($_GET["id"])) {
                $intID = intval(htmlentities($_GET["id"]));
                // appel de la méthode du modèle
                try {
                    $lePret = PretDal::loadPretByID($intID);
                    if ($lePret == NULL) {
                        $tabErreurs[] = 'Cet pret n\'existe pas !';
                        $hasErrors = true;
                    }
                } catch (Exception $e) {
                    $tabErreurs[] = $e->getMessage();
                    $hasErrors = true;
                }
            } else {
                //pas d'id dans l'url ni clic sur Valider : c'est anormal
                $tabErreurs[] = "Aucun pret n'a été transmis pour consultation !";
                $hasErrors = true;
            }

            if ($hasErrors) {
                $msg = "Une erreur s'est produite :";
                include 'vues/_v_afficherErreurs.php';
            } else {
                include 'vues/v_consulterPret.php';
            }
        }
        break;
//
    case'supprimerPret' : {
            // récupération de l'identifiant du Client passé dans l'URL
            if (isset($_GET["id"])) {
                $intID = intval(htmlentities($_GET["id"]));
                // appel de la méthode du modèle
                $lePret = PretDal::loadPretById($intID);
                if ($lePret == NULL) {
                    $tabErreurs[] = "Ce pret n'existe pas !";
                    $hasErrors = true;
                }
            } else {
                // pas d'id dans l'url ni clic sur Valider : c'est anormal
                $tabErreurs[] = "Aucun pret n'a été transmis pour suppression !";
                $hasErrors = true;
            }
            if (!$hasErrors) {
                $res = PretDal::delPret($lePret->getId()); // $res contient le nombre de lignes affectées
                if ($res > 0) {
                    $msg = 'Le pret ' . $lePret->getId(). ' a été supprimé';
                    include 'vues/_v_afficherMessage.php';
                    // affichage de la liste des Clients
                    $lesPrets = PretDal::loadPrets(1);
                    // afficher le nombre d'Clients
                    $nbPrets = count($lesPrets);
                    include 'vues/v_listerPrets.php';
                } else {
                    $tabErreurs[] = 'Une erreur s\'est produite dans l\'opération de suppression !';
                    $hasErrors = true;
                }
            }
            // affichage des erreurs
            if ($hasErrors) {
                $msg = "L'opération de suppression n'a pas pu être menée à terme en raison des erreurs suivantes :";
                $lien = '<a href="index.php?uc=gererPrets">Retour à la saisie</a>';
                include 'vues/_v_afficherErreurs.php';
            }
        }
        break;

    case 'modifierPret' : {
            // traitement de l'option : saisie ou validation ?
            if (isset($_GET["option"])) {
                $option = htmlentities($_GET["option"]);
            } else {
                $option = 'saisirPret';
            }
            // récupération de l'identifiant / en Post ou en Get
            if (isset($_REQUEST["id"])) {
                $intID = intval(htmlentities($_GET["id"]));
                // récupération des données dans la base
                $lePret = PretDal::loadPretById($intID);
                $leClient = ClientDal::loadClientById(intval($lePret->getClient()))->getId();
                $leOuvrage = OuvrageDal::loadOuvrageById(intval($lePret->getOuvrage()))->getNum();
                if ($lePret == NULL) {
                    $tabErreurs[] = "Ce pret n'existe pas !";
                    $hasErrors = true;
                }
            } else {
                // pas d'id dans l'url : c'est anormal
                $tabErreurs[] = "Aucun identifiant de pret n'a été transmis pour modification !";
                $hasErrors = true;
            }
            // On ne rentre dans le switch que si :
            // l'id est transmis et
            // l'id de pret existe
            if (!$hasErrors) {
                switch ($option) {
                    case 'saisirPret' : {
                            $lesClients = ClientDal::loadClients(0);
                            $lesOuvrages = OuvrageDal::loadOuvrages(0);
                           
                            include 'vues/v_modifierPret.php';
                        } break;
                    case 'validerPret' : {
                        // récupération des valeurs saisies
                            if (!empty($_POST["cbxClients"])) {
                                $strClient = ucfirst($_POST["cbxClients"]);
                            }
                            if (!empty($_POST["cbxOuvrages"])) {
                                $strOuvrage = ucfirst($_POST["cbxOuvrages"]);
                            }
                            if (!empty($_POST["txtDate"])) {
                                $strDate_emprunt = ucfirst($_POST["txtDate"]);
                            }
                            if (!empty($_POST["txtDateRet"])) {
                                $strDate_retour = ucfirst($_POST["txtDateRet"]);
                            }
                      if (isset($_POST["cmdValider"])) {
                          // récupération des valeurs saisies
                          if (!empty($strClient) and ! empty($strOuvrage) and ! empty($strDate_emprunt)) {
                              // tests de cohérence
                                // test de la date d'acquisition
                                $dateEmprunt = new DateTime($strDate_emprunt);
                               
                                $curDate = new DateTime(date('Y-m-d'));
                                
                                //var_dump($dateRetour);
                                if ($dateEmprunt > $curDate) {
                                    // la date d'acquisition est postérieure à la date du jour
                                    $tabErreurs[] = 'La date d\'emprunt doit être antérieure ou égale à la date du jour';
                                    $hasErrors = true;
                                }
                                /*
                                if ($dateRetour < $dateEmprunt) {
                                    // la date d'acquisition est postérieure à la date du jour
                                    $tabErreurs[] = 'La date de retour doit être superieur ou égale à la date du d\'emprunt';
                                    $hasErrors = true;
                                }
                            
                                 */
                              $lePret->setClient($strClient);
                              $lePret->setOuvrage($strOuvrage);
                              $lePret->setDateEmp($strDate_emprunt);
                          } else {
                              if (empty($strDate_emprunt)) {
                                    $tabErreurs[] = "La date d'emprunt doit être renseignée !";
                                }
                              $hasErrors = true;
                          }
                          // Je ne veux continuer que si le nom a bien été saisi dans le formulaire
                          if (!$hasErrors) {
                              // récupération des autres données du formulaire
                              if (!empty($strDate_retour)) {
                                   $dateRetour = new DateTime($strDate_retour);
                                   $lePret->setDateRet($strDate_retour);
                              }
                              
                              $lePret = new Pret($intID, $strClient, $strOuvrage, $strDate_emprunt, $strDate_retour, NULL);
                              try {
                                    $res = PretDal::setPret($lePret);
                                    
                                    if ($res > 0) {
                                        $msg = 'Le pret '
                                                . $lePret->getId(). ' a été modifié';
                                        $lePret = PretDal::loadPretByID($intID);
                                        if($lePret){
                                             include 'vues/v_consulterPret.php';
                                        }
                                    } else {
                                        $tabErreurs[] = 'Une erreur s\'est produite lors de l\'opération de mise à jour !';
                                        $hasErrors = true;
                                    }
                                } catch (PDOException $e) {
                                    $tabErreurs[] = 'Une exception a été levée !';
                                    $hasErrors = true;
                                }
                            }
                        } else {
                            // pas de clic sur Valider : c'est anormal
                            $tabErreurs[] = "Accès non autorisé !";
                            $hasErrors = true;
                        }
                    }
                }
            }
            // affichage des erreurs
            if ($hasErrors) {
                $msg = "L'opération de modification n'a pas pu être menée à terme en raison des erreurs suivantes :";
                $lien = '<a href="index.php?uc=gererPrets">Retour à la saisie</a>';
                include 'vues/_v_afficherErreurs.php';
            }
        } break;

    default : include 'vues/_v_home.php';
}
?> 