<?php

/**
 * Contrôleur secondaire chargé de la gestion des auteurs
 * @package default (mission 4)
 */
require_once 'modele/AuteurDal.class.php';
require_once 'include/_reference.lib.php';

// variables pour la gestion des messages
$titrePage = 'Gestion des auteurs';

// variables pour la gestion des erreurs
$tabErreurs = array();
$hasErrors = false;

// récupération de l'action à effectuer
if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = 'listerAuteurs';
}
// variables pour la gestion des messages
$msg = '';    // message passé à la vue v_afficherMessage
$lien = '';   // message passé à la vue v_afficherErreurs
// charger la vue en fonction du choix de l'utilisateur
switch ($action) {
    case 'consulterAuteur' : {
            if (isset($_GET["id"])) {
                $intID = intval(htmlentities($_GET["id"]));
                // récupération des valeurs dans la base
                try {
                    $lAuteur = AuteurDal::loadAuteurById($intID);
                    if ($lAuteur == NULL) {
                        $tabErreurs[] = "Cet auteur n'existe pas !";
                        $hasErrors = true;
                    }
                } catch (PDOException $e) {
                    $tabErreurs[] = $e->getMessage();
                    $hasErrors = true;
                }
            } else {
                // pas d'id dans l'url ni clic sur Valider : c'est anormal
                $tabErreurs[] = "Aucun auteur n'a été transmis pour consultation !";
                $hasErrors = true;
            }
            if ($hasErrors) {
                $msg = "Une erreur s'est produite :";
                include 'vues/_v_afficherErreurs.php';
            } else {
                include 'vues/v_consulterAuteur.php';
            }
        } break;
    case 'ajouterAuteur' : {
            // traitement de l'option : saisie ou validation ?
            if (isset($_GET["option"])) {
                $option = htmlentities($_GET["option"]);
            } else {
                $option = 'saisirAuteur';
            }
            
            $lAuteur = new Auteur();
            
            switch ($option) {
                case 'saisirAuteur' : {
                        include 'vues/v_ajouterAuteur.php';
                    } break;
                case 'validerAuteur' : {
                    // si on a cliqué sur Valider
                    if (isset($_POST["cmdValider"])) {
                        // récupération des valeurs saisies
                        if (!empty($_POST["txtNom"])) {
                            $lAuteur->setNom(ucfirst($_POST["txtNom"]));
                        } else {
                            // zone obligatoire
                            $tabErreurs[] = "Le nom doit être renseigné !";
                            $hasErrors = true;
                        }
                        // Je ne veux continuer que si le nom a bien été saisi dans le formulaire
                        if (!$hasErrors) {
                            // récupération des autres données du formulaire
                            if (!empty($_POST["txtPrenom"])) {
                                $lAuteur->setPrenom(ucfirst($_POST["txtPrenom"]));
                            }
                            if (!empty($_POST["txtAlias"])) {
                                $lAuteur->setAlias(ucfirst($_POST["txtAlias"]));
                            }
                            if (!empty($_POST["txtNotes"])) {
                                $lAuteur->setNotes(ucfirst($_POST["txtNotes"]));
                            }
                            try {
                                // ajout dans la base de données
                                $res = AuteurDal::addAuteur($lAuteur->getNom(), $lAuteur->getPrenom(), $lAuteur->getAlias(), $lAuteur->getNotes());
                                if ($res > 0) {
                                    $msg = 'L\'auteur '
                                            . $lAuteur->getNom() . ' '
                                            . $lAuteur->getPrenom() . ' a été ajouté';
                                    // récupération du numéro (auto-incrément)
                                    $lAuteur->setId(AuteurDal::getMaxId()) ;
                                    include 'vues/v_consulterAuteur.php';
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
                $lien = '<a href="index.php?uc=gererAuteurs&action=ajouterAuteur">Retour à la saisie</a>';
                include 'vues/_v_afficherErreurs.php';
            }
        } break;
    case 'modifierAuteur' : {
            // traitement de l'option : saisie ou validation ?
            if (isset($_GET["option"])) {
                $option = htmlentities($_GET["option"]);
            } else {
                $option = 'saisirAuteur';
            }
            // récupération de l'identifiant / en Post ou en Get
            if (isset($_REQUEST["id"])) {
                $intID = intval(htmlentities($_GET["id"]));
                // récupération des données dans la base
                $lAuteur = AuteurDal::loadAuteurById($intID);
                if ($lAuteur == NULL) {
                    $tabErreurs[] = "Cet auteur n'existe pas !";
                    $hasErrors = true;
                }
            } else {
                // pas d'id dans l'url : c'est anormal
                $tabErreurs[] = "Aucun identifiant d'auteur n'a été transmis pour modification !";
                $hasErrors = true;
            }
            // On ne rentre dans le switch que si :
            // l'id est transmis et
            // l'id de l'auteur existe
            if (!$hasErrors) {
                switch ($option) {
                    case 'saisirAuteur' : {
                            include 'vues/v_modifierAuteur.php';
                        } break;
                    case 'validerAuteur' : {
                        // si on a cliqué sur Valider
                        if (isset($_POST["cmdValider"])) {
                            // mémoriser les données pour les réafficher dans le formulaire
                            // récupération des valeurs saisies
                            if (!empty($_POST["txtNom"])) {
                                $lAuteur->setNom(ucfirst($_POST["txtNom"]));
                            } else {
                                // zone obligatoire
                                $tabErreurs[] = "Le nom doit être renseigné !";
                                $hasErrors = true;
                            }
                            // Je ne veux continuer que si le nom a bien été saisi dans le formulaire
                            if (!$hasErrors) {
                                // récupération des autres données du formulaire
                                if (!empty($_POST["txtPrenom"])) {
                                    $lAuteur->setPrenom(ucfirst($_POST["txtPrenom"]));
                                }
                                if (!empty($_POST["txtAlias"])) {
                                    $lAuteur->setAlias(ucfirst($_POST["txtAlias"]));
                                }
                                if (!empty($_POST["txtNotes"])) {
                                    $lAuteur->setNotes(ucfirst($_POST["txtNotes"]));
                                }
                                // mise à jour dans la base de données
                                try {

                                    $res = AuteurDal::setAuteur($lAuteur);
                                    echo $res;
                                    if ($res > 0) {
                                        $msg = 'L\'auteur '
                                                . $lAuteur->getNom() . ' '
                                                . $lAuteur->getPrenom() . ' a été modifié';
                                        include 'vues/v_consulterAuteur.php';
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
                $lien = '<a href="index.php?uc=gererAuteurs">Retour à la saisie</a>';
                include 'vues/_v_afficherErreurs.php';
            }
        } break;
    case 'supprimerAuteur' : {
            // récupération de l'identifiant du auteur passé dans l'URL
            if (isset($_GET["id"])) {
                $intID = intval(htmlentities($_GET["id"]));
                // appel de la méthode du modèle
                $lAuteur = AuteurDal::loadAuteurById($intID);
                if ($lAuteur == NULL) {
                    $tabErreurs[] = "Cet auteur n'existe pas !";
                    $hasErrors = true;
                } else {
                    // rechercher des ouvrages de cet auteur
                    if (AuteurDal::countOuvragesAuteur($intID) > 0) {
                        // il y a des ouvrages référencés par cet auteur, suppression impossible
                        $tabErreurs[] = "Il existe des ouvrages qui référencent cet auteur, suppression impossible !";
                        $hasErrors = true;
                    }
                }
            } else {
                // pas d'id dans l'url ni clic sur Valider : c'est anormal
                $tabErreurs[] = "Aucun auteur n'a été transmis pour suppression !";
                $hasErrors = true;
            }
            if (!$hasErrors) {
                $res = AuteurDal::delAuteur($lAuteur->getId()); // $res contient le nombre de lignes affectées
                if ($res > 0) {
                    $msg = 'L\'auteur ' . $lAuteur->getNom() . ' ' . $lAuteur->getPrenom() . ' a été supprimé';
                    include 'vues/_v_afficherMessage.php';
                    // affichage de la liste des auteurs
                    $lesAuteurs = AuteurDal::loadAuteurs(1);
                    // afficher le nombre d'auteurs
                    $nbAuteurs = count($lesAuteurs);
                    include 'vues/v_listeAuteurs.php';
                } else {
                    $tabErreurs[] = 'Une erreur s\'est produite dans l\'opération de suppression !';
                    $hasErrors = true;
                }
            }
            // affichage des erreurs
            if ($hasErrors) {
                $msg = "L'opération de suppression n'a pas pu être menée à terme en raison des erreurs suivantes :";
                $lien = '<a href="index.php?uc=gererAuteurs">Retour à la saisie</a>';
                include 'vues/_v_afficherErreurs.php';
            }
            
        } break;
    case 'listerAuteurs' : {
            // récupérer les auteurs
            $lesAuteurs = AuteurDal::loadAuteurs(1);
            // afficher le nombre d'auteurs
            $nbAuteurs = count($lesAuteurs);
            include 'vues/v_listeAuteurs.php';
        } break;
}

