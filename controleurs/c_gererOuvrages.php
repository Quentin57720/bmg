<?php

require_once 'modele/GenreDal.class.php';
require_once 'modele/OuvrageDal.class.php';
require_once 'modele/AuteurDal.class.php';
require_once 'include/_reference.lib.php';

if (!(isset($_REQUEST['action']))) {
    $action = 'listerOuvrages';
} else {
    $action = $_REQUEST['action'];
}

// variables pour al gestion des messages
$msg = '';      // message passé à la vue v_afficherMessage
$lien = '';     // message passé à la vue v_afficherErreurs
// variables pour la gestion des messages
$titrePage = 'Gestion des ourvages';
// variables pour la gestion des erreurs
$tabErreurs = array();
$hasErrors = false;
// initialisation des variables
$strNum = '';
$strTitre = '';
$strGenre = '';
$strAuteur = '';
$intSalle = '1';
$strRayon = '';
$strDernier_pret = '';
$strDisponibilite = '';
$strDate_acquisition = '';

switch ($action) {
    case'listerOuvrages' : {
            // récupérer les auteurs
            $lesOuvrages = OuvrageDal::loadOuvrages(1);
            // afficher le nombre d'auteurs
            $nbOuvrages = count($lesOuvrages);
            include ('vues/v_listerOuvrages.php');
        }
        break;

    case'ajouterOuvrage' : {
            // traitement de l'option : saisie ou validation ?
            if (isset($_GET["option"])) {
                $option = htmlentities($_GET["option"]);
            } else {
                $option = 'saisirOuvrage';
            }
            switch ($option) {
                case 'saisirOuvrage' : {
                        $lesGenres = GenreDal::loadGenres(0);
                        include 'vues/v_ajouterOuvrage.php';
                    } break;
                case 'validerOuvrage' : {
                        if (isset($_POST["cmdValider"])) {
                            // récupération des valeurs saisies
                            if (!empty($_POST["txtTitre"])) {
                                $strTitre = ucfirst($_POST["txtTitre"]);
                            }
                            $intSalle = $_POST["rbnSalle"];
                            if (!empty($_POST["txtRayon"])) {
                                $strRayon = ucfirst($_POST["txtRayon"]);
                            }
                            $strGenre = $_POST["cbxGenres"];
                            if (!empty($_POST["txtRayon"])) {
                                $strDate_acquisition = $_POST["txtDate"];
                            }
                            // test zones obligatoires
                            if (!empty($strTitre) and ! empty($strRayon) and ! empty($strDate_acquisition)) {
                                // tests de cohérence
                                // test de la date d'acquisition
                                $dateAcquisition = new DateTime($strDate_acquisition);
                                $curDate = new DateTime(date('Y-m-d'));
                                if ($dateAcquisition > $curDate) {
                                    // la date d'acquisition est postérieure à la date du jour
                                    $tabErreurs[] = 'La date d\'acquisition doit être antérieure ou égale à la date du jour';
                                    $hasErrors = true;
                                }
                                // contrôle du rayon
                                if (!rayonValide($strRayon)) {
                                    $tabErreurs[] = 'Le rayon n\'est pas valide, il doit comporter une lettre et un chiffre !';
                                    $hasErrors = true;
                                }
                            } else {
                                if (empty($strTitre)) {
                                    $tabErreurs[] = "Le titre doit être renseigné !";
                                }
                                if (empty($strRayon)) {
                                    $tabErreurs[] = "Le rayon doit être renseigné !";
                                }
                                if (empty($strDate)) {
                                    $tabErreurs[] = "La date d'acquisition doit être renseignée !";
                                }
                                $hasErrors = true;
                            }
                            if (!$hasErrors) {
                                try {
                                    $res = OuvrageDal::addOuvrage($strTitre, $intSalle, $strRayon, $strGenre, $strDate_acquisition);

                                    if ($res > 0) {
                                        $msg = '<span class="info">L\'ouvrage '
                                                . $strTitre . ' a été ajouté</span>';
                                        // recuperation du numero
                                        $intID = OuvrageDal::getMaxId();

                                        $leOuvrage = OuvrageDal::loadOuvrageByID($intID);

                                        if ($leOuvrage) {
                                            include 'vues/v_consulterOuvrage.php';
                                        } else {
                                            $tabErreurs[] = "Cet ouvrage n'existe pas !";
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
                                $lien = '<a href="index.php?uc=gererOuvrages&action=ajouterOuvrage">Retour à la saisie</a>';
                                include ('vues/_v_afficherErreurs.php');
                            }
                        }
                    }
                    break;
            }
        }
        break;

    case'consulterOuvrage' : {
            // récupération du code
            if (isset($_GET["id"])) {
                $intID = intval(htmlentities($_GET["id"]));
                // appel de la méthode du modèle
                try {
                    $leOuvrage = OuvrageDal::loadOuvrageByID($intID);
                    if ($leOuvrage == NULL) {
                        $tabErreurs[] = 'Cette ouvrage n\'existe pas !';
                        $hasErrors = true;
                    }
                } catch (Exception $e) {
                    $tabErreurs[] = $e->getMessage();
                    $hasErrors = true;
                }
            } else {
                //pas d'id dans l'url ni clic sur Valider : c'est anormal
                $tabErreurs[] = "Aucun ouvrage n'a été transmis pour consultation !";
                $hasErrors = true;
            }

            if ($hasErrors) {
                $msg = "Une erreur s'est produite :";
                include 'vues/_v_afficherErreurs.php';
            } else {
                include 'vues/v_consulterOuvrage.php';
            }
        }
        break;
//
    case'supprimerOuvrage' : {
            // récupération du code
            if (isset($_GET["id"])) {
                $id = intval(htmlentities($_GET["id"]));
                // appel de la méthode du modèle
                $leOuvrage = OuvrageDal::loadOuvrageByID($id);
                if ($leOuvrage == NULL) {
                    $tabErreurs[] = 'Cet ouvrage n\'existe pas !';
                    $hasErrors = true;
                }
            } else {
                //pas d'id dans l'url : c'est normal
                $tabErreurs[] = "Aucun identifiant d'ouvrage n'a été transmis pour suppression !";
                $hasErrors = true;
            }

            if (!$hasErrors) {
                try {
                    $nbAuteursOuvrage = OuvrageDal::countAuteursOuvrage($id);
                    if ($nbAuteursOuvrage == 0) {
                        try {
                            $res = OuvrageDal::delOuvrage($id);
                            if ($res > 0) {
                                $msg = 'L\'ouvrage ' . $leOuvrage->getTitre() . ' a été supprimé';
                                include 'vues/_v_afficherMessage.php';
                                $lesOuvrages = OuvrageDal::loadOuvrages(1);
                                // afficher le nombre d'auteurs
                                $nbOuvrages = count($lesOuvrages);
                                include ('vues/v_listerOuvrages.php');
                            }
                        } catch (PDOException $e) {
                            $tabErreurs[] = "Une exception PDO a été levée !";
                            $hasErrors = true;
                        }
                    } else {
                        $tabErreurs[] = "Cet ouvrage est lié à des auteurs, suppression impossible !";
                        $hasErrors = true;
                    }
                } catch (PDOException $e) {
                    $tabErreurs[] = $e->getMessage();
                    $hasErrors = true;
                }
            }
            if ($hasErrors) {
                $msg = "Une erreur s'est produite :";
                include 'vues/_v_afficherErreurs.php';
            }
        }
        break;

    case'modifierOuvrage' : {
            // initialisation des variables
            $tabErreurs = array();
            $hasErrors = false;
            // initialisation des variables
            $strTitre = '';
            $intSalle = 1;
            $strRayon = '';
            $strGenre = '';
            $strDate_acquisition = '';

            $poids_max = 512000; // Poids max de l'image en octets (1Ko = 1024 octets)
            $repertoire = PATH_TO_IMG . '/'; // Repertoire d'upload
            //
            // traitement de l'option ; saisie ou validation ?
            if (isset($_GET["option"])) {
                $option = htmlentities($_GET["option"]);
            } else {
                $option = 'saisirOuvrage';
            }

            // recuperation de l'identifiant / en post ou en Get
            if (isset($_GET["id"])) {
                $intID = intval(htmlentities($_GET["id"]));
                $leOuvrage = OuvrageDal::loadOuvrageByID($intID);
                if ($leOuvrage == NULL) {
                    $tabErreurs[] = 'Cet ouvrage n\'existe pas !';
                    $hasErrors = true;
                }
            } else {
                //pas d'id dans l'url ni clic sur Valider : c'est anormal
                $tabErreurs[] = "Aucun identifiant d'ouvrage n'a été transmis pour modification !";
                $hasErrors = true;
            }

            if (!$hasErrors) {
                switch ($option) {
                    case 'saisirOuvrage' : {
                            $lesGenres = GenreDal::loadGenres(0);
                            include 'vues/v_modifierOuvrage.php';
                        } break;
                    case 'validerOuvrage' : {
                            if (isset($_POST["cmdValider"])) {
                                $intID = intval($_POST["txtID"]);
                                if (!empty($_POST["txtTitre"])) {
                                    $strTitre = ucfirst($_POST["txtTitre"]);
                                }

                                $intSalle = $_POST["rbnSalle"];
                                if (!empty($_POST["txtRayon"])) {
                                    $strRayon = ucfirst($_POST["txtRayon"]);
                                }

                                $strGenre = $_POST["cbxGenres"];
                                $leGenre = GenreDal::loadGenreByID($strGenre);
                                if (!empty($_POST["txtRayon"])) {
                                    $strDate = $_POST["txtDate"];
                                }

                                if ((!empty($_FILES['fichier']['name']))) {
                                    // On vérifit le type du fichier
                                    if ($_FILES['fichier']['type'] != 'image/png' && $_FILES['fichier']['type'] != 'image/jpeg' && $_FILES['fichier']['type'] != 'image/jpg' && $_FILES['fichier']['type'] != 'image/gif') {

                                        $erreur = 'Le fichier doit être au format *.jpeg, *.gif ou *.png .';
                                    }

                                    // On vérifit le poids de l'image
                                    elseif ($_FILES['fichier']['size'] > $poids_max) {
                                        $erreur = 'L\'image doit être inférieur à ' . $poids_max / 1024 . 'Ko.';
                                    }

                                    // On vérifit si le répertoire d'upload existe
                                    elseif (!file_exists($repertoire)) {
                                        $erreur = 'Erreur, le dossier d\'upload n\'existe pas.';
                                    }

                                    // Si il y a une erreur on l'affiche sinon on peut uploader
                                    if (isset($erreur)) {
                                        echo '' . $erreur . '<br><a href="javascript:history.back(1)">Retour</a><br><br>';
                                    } else {
                                        $nom_fichier = $intID . '.jpg';

                                        // On upload le fichier sur le serveur.
                                        if (move_uploaded_file($_FILES['fichier']['tmp_name'], $repertoire . $nom_fichier)) {
                                            $url = PATH_TO_IMG . '' . $nom_fichier . '';
                                            //echo 'Votre image à été uploadée sur le serveur avec succes!<br>Voici le lien: <input type="text" value="' . $url . '" size="60">';
                                        } else {
                                            echo 'L\'image n\'a pas pu être uploadée sur le serveur.';
                                        }
                                    }
                                }

                                if (!empty($strTitre) and ! empty($strRayon) and ! empty($strDate)) {
                                    $dateAcquisition = new DateTime($strDate);
                                    $curDate = new DateTime(date('Y-m-d'));
                                    if ($dateAcquisition > $curDate) {
                                        $tabErreurs[] = 'La date d\'acquisition doit être antérieure ou égale à la date du jour';
                                        $hasErrors = true;
                                    }

                                    if (!rayonValide($strRayon)) {
                                        $tabErreurs[] = 'Le rayon n\'est pas valide, il doit comporter une lettre et un chiffre !';
                                        $hasErrors = true;
                                    }
                                } else {
                                    if (empty($strTitre)) {
                                        $tabErreurs[] = "Le titre doit être renseigné !";
                                    }
                                    if (empty($strRayon)) {
                                        $tabErreurs[] = "Le rayon doit être renseigné !";
                                    }
                                    if (empty($strDate)) {
                                        $tabErreurs[] = "La date d'acquisition doit être renseigné !";
                                    }
                                    $hasErrors = true;
                                }
                                if (!$hasErrors) {
                                    $leOuvrage = new Ouvrage($intID, $strTitre, $intSalle, $strRayon, $leGenre, $dateAcquisition);
                                    try {
                                        $res = OuvrageDal::setOuvrage($leOuvrage);
                                        if ($res > 0 or (!empty($_FILES['fichier']) && ($_FILES['fichier']['type'] == 'image/png' or $_FILES['fichier']['type'] == 'image/jpeg' or $_FILES['fichier']['type'] == 'image/jpg' or $_FILES['fichier']['type'] == 'image/gif'))) {
                                            $msg = '<span class="info">L\'ouvrage ' . $strTitre . ' a été modifié</span>';
                                            $leOuvrage = OuvrageDal::loadOuvrageByID($intID);
                                            if ($leOuvrage) {
                                                include 'vues/v_consulterOuvrage.php';
                                            }
                                        } else {
                                            $tabErreurs[] = "Une erreur s\'est produite lors de l'operation de mise à jour !";
                                            $hasErrors = true;
                                        }
                                    } catch (PDOException $e) {
                                        $tabErreurs[] = "Une exception a été levée !";
                                        $hasErrors = true;
                                    }
                                }
                            } else {
                                $tabErreurs[] = "Accès interdit !";
                                $hasErrors = true;
                            }
                        }
                        break;
                }
            }
            if ($hasErrors) {
                $msg = "Une erreur s'est produite :";
                include 'vues/_v_afficherErreurs.php';
            }
        }
        break;

        case 'ajouterAuteur' : {
            // traitement de l'option : saisie ou validation ?
            if (isset($_GET["option"])) {
                $option = htmlentities($_GET["option"]);
            } else {
                $option = 'saisirAuteur';
            }
            if (isset($_GET["id"])) {
                $intID = intval(htmlentities($_GET["id"]));
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
                                $chips = AuteurDal::addAuteurOuvrage($intID, AuteurDal::getMaxId());
                                if ($res > 0) {
                                    $msg = 'L\'auteur '
                                            . $lAuteur->getNom() . ' '
                                            . $lAuteur->getPrenom() . ' a été ajouté';
                                    if($chips > 0){
                                        echo '<br\>L\'auteur a été associé à l\'ouvrage<br\><br\>'; 
                                    }
                                    
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



    default : include 'vues/_v_home.php';
}
?> 