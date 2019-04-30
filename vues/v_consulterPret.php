<div id="content">
    <h2>Gestion des prets</h2>
    
    <?php
    if (strlen($msg) > 0){
        echo '<span class="info">'.$msg.'</span>';
    }
    ?>
    
    <div id="object-list">          
        <div class="corps-form">
            <fieldset>
                <legend>Consulter un pret</legend>                        
                <div id="breadcrumb">
                    <a href="index.php?uc=gererPrets&action=ajouterPret">Ajouter</a>&nbsp;
                    <a href="index.php?uc=gererPrets&action=modifierPret&option=saisirPret&id=<?php echo $lePret->getId() ?>">Modifier</a>&nbsp;
                    <a href="index.php?uc=gererPrets&action=supprimerPret&id=<?php echo $lePret->getId() ?>">Supprimer</a>&nbsp;
                </div>
                <table>
                    <tr>
                        <td class="h-entete">
                            Id :
                        </td>
                        <td class="h-valeur">
                            <?php echo $lePret->getId() ?>
                        </td>
                        <td class="h-valeur" rowspan="8">
                            <?php echo couvertureOuvrage($lePret->getOuvrage(), $lePret->getTitre()) ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Client :
                        </td>
                        <td class="h-valeur">
                            <?php echo $lePret->getNom().' '.$lePret->getPrenom() ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Ouvrage :
                        </td>
                        <td class="h-valeur">
                            <?php echo $lePret->getTitre() ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Date d'emprunt :
                        </td>
                        <td class="h-valeur">
                            <?php echo $lePret->getDateEmp() ?>
                        </td>
                    </tr>                  
                    <tr>
                        <td class="h-entete">
                            Date de retour :
                        </td>
                        <td class="h-valeur">
                            <?php echo $lePret->getDateRet() ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Penalite :
                        </td>
                        <td class="h-valeur">
                            <?php 
                                if($lePret->getPenalite() == NULL ){
                                    echo 'Aucune';
                                }
                                else
                                {
                                    echo $lePret->getPenalite();
                                }        
                            ?>
                        </td>
                        
                        
                    </tr>      
                </table>
            </fieldset>                    
        </div>
    </div>
</div>