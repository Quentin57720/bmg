<?php

/**
 * Contrôleur secondaire chargé de la gestion des Clients
 * @package default (mission 4)
 */
require_once 'modele/ClientDal.class.php';
require_once 'include/_reference.lib.php';

// variables pour la gestion des messages
$titrePage = 'Gestion des clients';

// variables pour la gestion des erreurs
$tabErreurs = array();
$hasErrors = false;

// récupération de l'action à effectuer
if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = 'listerClients';
}
// variables pour la gestion des messages
$msg = '';    // message passé à la vue v_afficherMessage
$lien = '';   // message passé à la vue v_afficherErreurs
// charger la vue en fonction du choix de l'utilisateur
switch ($action) {
    case 'consulterClient' : {
            if (isset($_GET["id"])) {
                $intID = intval(htmlentities($_GET["id"]));
                // récupération des valeurs dans la base
                try {
                    $leClient = ClientDal::loadClientById($intID);
                    if ($leClient == NULL) {
                        $tabErreurs[] = "Ce client n'existe pas !";
                        $hasErrors = true;
                    }
                } catch (PDOException $e) {
                    $tabErreurs[] = $e->getMessage();
                    $hasErrors = true;
                }
            } else {
                // pas d'id dans l'url ni clic sur Valider : c'est anormal
                $tabErreurs[] = "Aucun client n'a été transmis pour consultation !";
                $hasErrors = true;
            }
            if ($hasErrors) {
                $msg = "Une erreur s'est produite :";
                include 'vues/_v_afficherErreurs.php';
            } else {
                include 'vues/v_consulterClient.php';
            }
        } break;
    case 'ajouterClient' : {
            // traitement de l'option : saisie ou validation ?
            if (isset($_GET["option"])) {
                $option = htmlentities($_GET["option"]);
            } else {
                $option = 'saisirClient';
            }

            $leClient = new Client();

            switch ($option) {
                case 'saisirClient' : {
                        include 'vues/v_ajouterClient.php';
                    } break;
                case 'validerClient' : {
                    // si on a cliqué sur Valider
                    if (isset($_POST["cmdValider"])) {
                        // récupération des valeurs saisies
                        if (!empty($_POST["txtNom"]) &&
                          !empty($_POST["txtPrenom"]) &&
                          !empty($_POST["txtCP"]) &&
                          !empty($_POST["txtVille"]) &&
                          !empty($_POST["dateInscr"])
                      ) {
                            $leClient->setNom(ucfirst($_POST["txtNom"]));
                            $leClient->setPrenom(ucfirst($_POST["txtPrenom"]));
                            $leClient->setCodePost(ucfirst($_POST["txtCP"]));
                            $leClient->setVille(ucfirst($_POST["txtVille"]));
                            $leClient->setDateInscr(ucfirst($_POST["dateInscr"]));
                        } else {
                            // zone obligatoire
                            $tabErreurs[] = "Le nom, prénom, code postal, ville, date d'inscription doivent être renseignés !";
                            $hasErrors = true;
                        }
                        // Je ne veux continuer que si le nom a bien été saisi dans le formulaire
                        if (!$hasErrors) {
                            // récupération des autres données du formulaire
                            if (!empty($_POST["txtRue"])) {
                                $leClient->setRue(ucfirst($_POST["txtRue"]));
                            }
                            if (!empty($_POST["txtMel"])) {
                                $leClient->setMel(ucfirst($_POST["txtMel"]));
                            }
                            if (!empty($_POST["txtEtat"])) {
                                $leClient->setEtatClient(ucfirst($_POST["txtEtat"]));
                            }
                            if (!empty($_POST["txtMontant"])) {
                                $leClient->setMontantCompte(ucfirst($_POST["txtMontant"]));
                            }
                            if (!empty($_POST["txtLogin"])) {
                                $leClient->setLogin(ucfirst($_POST["txtLogin"]));
                            }
                            if (!empty($_POST["txtMdp"])) {
                                $leClient->setPassword(ucfirst($_POST["txtMdp"]));
                            }
                            if (!empty($_POST["txtCaution"])) {
                                $leClient->setCaution(ucfirst($_POST["txtCaution"]));
                            }
                            try {
                                // ajout dans la base de données
                                $res = ClientDal::addClient($leClient->getNom(),
                                                            $leClient->getPrenom(),
                                                            $leClient->getRue(),
                                                            $leClient->getCodePost(),
                                                            $leClient->getVille(),
                                                            $leClient->getDateInscr(),
                                                            $leClient->getMel(),
                                                            $leClient->getEtatClient(),
                                                            $leClient->getMontantCompte(),
                                                            $leClient->getLogin(),
                                                            $leClient->getPassword(),
                                                            $leClient->getCaution(),
                                                            "");
                                if ($res > 0) {
                                    $msg = 'Le client '
                                            . $leClient->getNom() . ' '
                                            . $leClient->getPrenom() . ' a été ajouté';
                                    // récupération du numéro (auto-incrément)
                                    $leClient->setId(ClientDal::getMaxId()) ;
                                    include 'vues/v_consulterClient.php';
                                } else {
                                    $tabErreurs[] = "Une erreur s'est produite dans l'opération d'ajout";
                                    $hasErrors = true;
                                }
                            } catch (PDOException $e) {
                                $tabErreurs[] = "Une exception PDO a été levée !";
                                $hasErrors = true;
                            }
                        }
                    }
                    else {
                        // pas de clic sur Valider : c'est anormal
                        $tabErreurs[] = "Accès non autorisé !";
                        $hasErrors = true;
                    }
                } break;
            }
            if ($hasErrors) {
                $msg = "L'opération d'ajout n'a pas pu être menée à terme en raison des erreurs suivantes :";
                $lien = '<a href="index.php?uc=gererClients&action=ajouterClient">Retour à la saisie</a>';
                include 'vues/_v_afficherErreurs.php';
            }
        } break;
    case 'modifierClient' : {
            // traitement de l'option : saisie ou validation ?
            if (isset($_GET["option"])) {
                $option = htmlentities($_GET["option"]);
            } else {
                $option = 'saisirClient';
            }
            // récupération de l'identifiant / en Post ou en Get
            if (isset($_REQUEST["id"])) {
                $intID = intval(htmlentities($_GET["id"]));
                // récupération des données dans la base
                $leClient = ClientDal::loadClientById($intID);
                if ($leClient == NULL) {
                    $tabErreurs[] = "Ce Client n'existe pas !";
                    $hasErrors = true;
                }
            } else {
                // pas d'id dans l'url : c'est anormal
                $tabErreurs[] = "Aucun identifiant de client n'a été transmis pour modification !";
                $hasErrors = true;
            }
            // On ne rentre dans le switch que si :
            // l'id est transmis et
            // l'id de l'Client existe
            if (!$hasErrors) {
                switch ($option) {
                    case 'saisirClient' : {
                            include 'vues/v_modifierClient.php';
                        } break;
                    case 'validerClient' : {
                      if (isset($_POST["cmdValider"])) {
                          // récupération des valeurs saisies
                          if (!empty($_POST["txtNom"]) &&
                            !empty($_POST["txtPrenom"]) &&
                            !empty($_POST["txtCP"]) &&
                            !empty($_POST["txtVille"]) &&
                            !empty($_POST["dateInscr"])
                        ) {
                              $leClient->setNom(ucfirst($_POST["txtNom"]));
                              $leClient->setPrenom(ucfirst($_POST["txtPrenom"]));
                              $leClient->setCodePost(ucfirst($_POST["txtCP"]));
                              $leClient->setVille(ucfirst($_POST["txtVille"]));
                              $leClient->setDateInscr(ucfirst($_POST["dateInscr"]));
                          } else {
                              // zone obligatoire
                              $tabErreurs[] = "Le nom, prénom, code postal, ville, date d'inscription doivent être renseignés !";
                              $hasErrors = true;
                          }
                          // Je ne veux continuer que si le nom a bien été saisi dans le formulaire
                          if (!$hasErrors) {
                              // récupération des autres données du formulaire
                              if (!empty($_POST["txtRue"])) {
                                  $leClient->setRue(ucfirst($_POST["txtRue"]));
                              }
                              if (!empty($_POST["txtMel"])) {
                                  $leClient->setMel(ucfirst($_POST["txtMel"]));
                              }
                              if (!empty($_POST["txtEtat"])) {
                                  $leClient->setEtatClient(ucfirst($_POST["txtEtat"]));
                              }
                              if (!empty($_POST["txtMontant"])) {
                                  $leClient->setMontantCompte(ucfirst($_POST["txtMontant"]));
                              }
                              if (!empty($_POST["txtLogin"])) {
                                  $leClient->setLogin(ucfirst($_POST["txtLogin"]));
                              }
                              if (!empty($_POST["txtMdp"])) {
                                  $leClient->setPassword(ucfirst($_POST["txtMdp"]));
                              }
                              if (!empty($_POST["txtCaution"])) {
                                  $leClient->setCaution(ucfirst($_POST["txtCaution"]));
                              }
                              try {
                                    $res = ClientDal::setClient($leClient);
                                    if ($res > 0) {
                                        $msg = 'Le client '
                                                . $leClient->getNom() . ' '
                                                . $leClient->getPrenom() . ' a été modifié';
                                        include 'vues/v_consulterClient.php';
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
                $lien = '<a href="index.php?uc=gererClients">Retour à la saisie</a>';
                include 'vues/_v_afficherErreurs.php';
            }
        } break;
    case 'supprimerClient' : {
            // récupération de l'identifiant du Client passé dans l'URL
            if (isset($_GET["id"])) {
                $intID = intval(htmlentities($_GET["id"]));
                // appel de la méthode du modèle
                $leClient = ClientDal::loadClientById($intID);
                if ($leClient == NULL) {
                    $tabErreurs[] = "Ce Client n'existe pas !";
                    $hasErrors = true;
                } else {
                    // rechercher des prêts de ce Client
                    if (ClientDal::countPretEnCours($intID) > 0) {
                        // il y a des ouvrages référencés par cet Client, suppression impossible
                        $tabErreurs[] = "Il existe des prêts qui sont associés à ce Client, suppression impossible !";
                        $hasErrors = true;
                    }
                }
            } else {
                // pas d'id dans l'url ni clic sur Valider : c'est anormal
                $tabErreurs[] = "Aucun Client n'a été transmis pour suppression !";
                $hasErrors = true;
            }
            if (!$hasErrors) {
                $res = ClientDal::delClient($leClient->getId()); // $res contient le nombre de lignes affectées
                if ($res > 0) {
                    $msg = 'Le client ' . $leClient->getNom() . ' ' . $leClient->getPrenom() . ' a été supprimé';
                    include 'vues/_v_afficherMessage.php';
                    // affichage de la liste des Clients
                    $lesClients = ClientDal::loadClients(1);
                    // afficher le nombre d'Clients
                    $nbClients = count($lesClients);
                    include 'vues/v_listeClients.php';
                } else {
                    $tabErreurs[] = 'Une erreur s\'est produite dans l\'opération de suppression !';
                    $hasErrors = true;
                }
            }
            // affichage des erreurs
            if ($hasErrors) {
                $msg = "L'opération de suppression n'a pas pu être menée à terme en raison des erreurs suivantes :";
                $lien = '<a href="index.php?uc=gererClients">Retour à la saisie</a>';
                include 'vues/_v_afficherErreurs.php';
            }

        } break;
    case 'listerClients' : {
            // récupérer les Clients
            $lesClients = ClientDal::loadClients(1);
            // afficher le nombre d'Clients
            $nbClients = count($lesClients);
            include 'vues/v_listeClients.php';
        } break;
}