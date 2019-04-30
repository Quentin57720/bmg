<?php
/** 
 * Page de gestion des auteurs

 * @author 
 * @package default
*/
?>
<div id="content">
    <h2>Gestion des auteurs</h2>
    <a href="index.php?uc=gererAuteurs&action=ajouterAuteur" title="Ajouter">
        Ajouter un auteur
    </a>
    <div class="corps-form">
        <!--- afficher la liste des auteurs -->
        <fieldset>	
            <legend>Auteurs</legend>
            <div id="object-list">
                <?php
                echo '<span>'.$nbAuteurs.' auteur(s) trouvé(s)'
                        . '</span><br /><br />';
                // afficher un tableau des auteurs
                if ($nbAuteurs > 0) {
                    // création du tableau
                    echo '<table>';
                    // affichage de l'entete du tableau 
                    echo '<tr><th>ID</th><th>Nom</th></tr>';
                    // affichage des lignes du tableau
                    $n = 0;
                    foreach($lesAuteurs as $unAuteur) {
                        if (($n % 2) == 1) {
                            echo '<tr class="impair">';
                        }
                        else {
                            echo '<tr class="pair">';
                        }
                        // afficher la colonne 1 dans un hyperlien
                        echo '<td><a href="index.php?uc=gererAuteurs&action=consulterAuteur&id='
                            .$unAuteur->getID().'">'.$unAuteur->getID().'</a></td>';
                        // afficher les colonnes suivantes
                        echo '<td>'.$unAuteur->getNom().'</td>';
                        echo '</tr>';
                        $n++;
                    }
                    echo '</table>';
                }
                else {			
                    echo "Aucun auteur trouvé !";
                }		
                ?>
            </div>
        </fieldset>
    </div>
</div>          
