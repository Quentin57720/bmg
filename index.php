<?php
	/**
	 * Page d'accueil de l'application CAG

	 * Point d'entrée unique de l'application
	 * @author
	 * @package default
	 */

	// inclure les bibliothèques de fonctions
	require_once 'include/_config.inc.php';
        require_once 'include/_metier.lib.php';
        require_once 'include/_forms.lib.php';

	session_start(); // début de session
	// on simule un utilisateur connecté (en phase de test)
	$_SESSION['id'] = 9999;
	$_SESSION['nom'] = 'Dupont';
	$_SESSION['prenom'] = 'Jean';
	include("vues/_v_header.php") ;
	include("vues/_v_menu.php") ;

        // Récupère l'identifiant de la page passée par l'URL.
        // Si non défini, on considère que la page demandée est la page d'accueil
        if(!isset($_REQUEST['uc'])) {
            $uc = 'home';
        }
         else
        {
            $uc = $_REQUEST['uc'];
        }

        // variables pour la gestion des messages
        $msg = '';    // message passé à la vue v_afficherMessage
        $lien = '';   // message passé à la vue v_afficherErreurs

        switch ($uc) {
           case 'gererGenres' :
                include 'controleurs/c_gererGenres.php'; break;
            case 'gererAuteurs' :
                include 'controleurs/c_gererAuteurs.php'; break;
            case 'gererOuvrages' :
                include'controleurs/c_gererOuvrages.php'; break;
            case 'gererClients' :
                include'controleurs/c_gererClients.php'; break;
            case 'gererPrets' :
                include'controleurs/c_gererPrets.php'; break;
            case 'gererRecherches' :
                include'controleurs/c_gererRecherches.php'; break;
            default : include 'vues/_v_home.php'; break;
        }
	include("vues/_v_footer.php") ;
