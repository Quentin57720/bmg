<?php
/** 
 * Page de gestion des clients

 * @client
 * @package default
*/
?>
<div id="content">
    <h2>Gestion des prets</h2>
    <a href="index.php?uc=gererPrets&action=ajouterPret" title="Ajouter">
        Ajouter un pret
    </a>
    <div class="corps-form">
        <!--- afficher la liste des auteurs -->
        <fieldset>	
            <legend>Prets</legend>
            <div id="object-list">
                <?php
                echo '<span>'.$nbPrets.' pret(s) trouvé(s)'
                        . '</span><br /><br />';
                // afficher un tableau des auteurs
                if ($nbPrets > 0) {
                    // création du tableau
                    echo '<table>';
                    // affichage de l'entete du tableau 
                    echo '<tr>';
                    echo '<th>ID</th>';
                    echo '<th>Client</th>';
                    echo '<th>Ouvrage</th>';
                    echo '<th>Date emprunt</th>';
                    echo '<th>Date retour</th>';
                    echo '<th>Penalité</th>';
                    echo '</tr>';
                    // affichage des lignes du tableau
                    $n = 0;
                    foreach($lesPrets as $unPret) {
                        if (($n % 2) == 1) {
                            echo '<tr class="impair">';
                        }
                        else {
                            echo '<tr class="pair">';
                        }
                        // afficher la colonne 1 dans un hyperlien
                        echo '<td><a href="index.php?uc=gererPrets&action=consulterPret&id='
                            .$unPret->getID().'">'.$unPret->getID().'</a></td>';
                        // afficher les colonnes suivantes
                        
                        echo '<td>'.$unPret->getNom().' '.$unPret->getPrenom().'</td>';
                        echo '<td>'.$unPret->getTitre().'</td>';
                        echo '<td>'.$unPret->getDateEmp().'</td>';
                        echo '<td>'.$unPret->getDateRet().'</td>';
                        if($unPret->getPenalite() == NULL ){
                            echo '<td>Aucune</td>';
                        }
                        else
                        {
                            echo '<td>'.$unPret->getPenalite().'</td>';
                        }              
                        echo '</tr>';
                        $n++;
                    }
                    echo '</table>';
                }
                else {			
                    echo "Aucun pret trouvé !";
                }		
                ?>
            </div>
        </fieldset>
    </div>
</div>          
