<div id="content">
    <h2>Gestion des genres</h2>
    <a href="index.php?uc=gererGenres&action=ajouterGenre" title="Ajouter">
        Ajouter un genre
    </a>
    <div class="corps-form">
        <!--- afficher la liste des genres -->
        <fieldset>	
            <legend>Genres</legend>
            <div id="object-list">
                <?php
                echo '<span>'.$nbGenres.' genre(s) trouvé(s)'
                        . '</span><br /><br />';
                // afficher un tableau des genres
                if ($nbGenres > 0) {
                    // création du tableau
                    echo '<table>';
                    // affichage de l'entete du tableau 
                    echo '<tr>';
                    // création entete tableau avec noms de colonnes  
                    echo '<th>Code</th>';
                    echo '<th>Libellé</th>';
                    echo '</tr>';
                    // affichage des lignes du tableau
                    $n = 0;
                    foreach($lesGenres as $unGenre)  {                                                            
                        if (($n % 2) == 1) {
                            echo '<tr class="impair">';
                        }
                        else {
                            echo '<tr class="pair">';
                        }
                        // afficher la colonne 1 dans un hyperlien
                        echo '<td><a href="index.php?uc=gererGenres&action=consulterGenre&id='
                            .$unGenre->getCode().'">'.$unGenre->getCode().'</a></td>';
                        // afficher les colonnes suivantes
                        echo '<td>'.$unGenre->getLibelle().'</td>';
                        echo '</tr>';
                        $n++;
                    }
                    echo '</table>';
                }
                else {			
                    echo "Aucun genre trouvé !";
                }	
                ?>
            </div>
        </fieldset>
    </div>
</div>          
       