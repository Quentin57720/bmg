<?php
/**
 * Page de gestion des auteurs

 * @author
 * @package default
*/
?>
<div id="content">
    <h2>Recherche d'ouvrages</h2>
    <a href="index.php?uc=gererRecherches&action=rechercheOuvrages&option=saisirRecherche" title="Rechercher">
        Nouvelle recherche
    </a>
    <div class="corps-form">
        <!--- afficher la liste des ouvrages -->
        <fieldset>
            <legend>Ouvrages</legend>
            <div id="object-list">
                <?php
                echo '<span>' . $nbOuvrages . ' ouvrage(s) trouvé(s)'
                . '</span><br /><br />';
                // afficher un tableau des ouvrages
                if ($nbOuvrages > 0) {
                    // création du tableau
                    echo '<table>';
                    // affichage de l'entête du tableau
                    echo '<tr>'
                    . '<th>Titre</th>'
                    . '<th>Description</th>'
                    . '<th>Auteur(s)</th>'
                    . '<th>Couverture</th>'
                    . '</tr>';
                    // affichage des lignes du tableau
                    $n = 0;
                    foreach($books ['items'] as $unOuvrage) {
                        if (($n % 2) == 1) {
                            echo '<tr class="impair">';
                        } else {
                            echo '<tr class="pair">';
                        }
                        // afficher la colonne 1 dans un hyperlien
                        echo '<td><a href="'. $unOuvrage['volumeInfo']['infoLink'] . '">' . $unOuvrage['volumeInfo']['title'] . '</a></td>';

                        if (empty($unOuvrage['volumeInfo']['description'])) {
                            echo '<td class="erreur"> Aucune description disponible. </td>';
                        } else {
                            echo '<td>' . $unOuvrage ['volumeInfo']['description'] . '</td>';
                        }
                        if (empty($unOuvrage ['volumeInfo']['authors'])) {
                            echo '<td class="erreur"> Aucun auteur disponible. </td>';
                        } else {
                            echo '<td>';
                            $lesAuteurs = $unOuvrage ['volumeInfo']['authors'];
                            foreach ($lesAuteurs as $unAuteur){
                                echo $unAuteur;
                            };
                            echo '</td>';
                        }
                        
                        //echo '<td>' . $unOuvrage ['volumeInfo']['authors'][0] .'</td>';
                        echo '<td> <img src='. $unOuvrage ['volumeInfo']['imageLinks']['smallThumbnail'] .'> </td>';
                        echo '</tr>';
                        $n++;
                    }
                    echo '</table>';
                } else {
                    echo "Aucun ouvrage trouvé !";
                }
                ?>
            </div>
        </fieldset>
    </div>
</div>
