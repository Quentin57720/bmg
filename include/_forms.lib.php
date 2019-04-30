<?php

/*
 * PHP - Bibliothèques de fonctions
 * Fonctions d'affichage de contrôles HTML
 */

/**
 * affiche une liste déroulante
 * 
 * @param $res : un objet de la classe PDOStatement
 * @param $nom : le nom (attribut name) de la liste déroulante (par défaut, l'id est identique au nom)
 * @param $selected : l'élément à sélectionner par défaut
 * @param $style : la classe CSS à appliquer à la liste
 */
function afficherListe($res, $nom, $selected, $style) {
    // vérifier le contenu du curseur
    if ($res) {
        echo '<select name="'.$nom.'" size="1" class="'.$style.'">';
        foreach ($res as $ligne) {
                echo '<option value="'.$ligne[0].'"';
                if ($ligne[0] == $selected) {
                    echo ' selected="selected"';
                }
                echo '>'.$ligne[1].'</option>';
                
                
        }
        echo '</select>';
        // fermeture du curseur
       // $res->closeCursor();
    }
}




