<?php
/** 
 * Page de gestion des auteurs

 * @author 
 * @package default
*/
?>
<div id="content">
    <h2>Gestion des auteurs</h2>
    <?php 
    if (strlen($msg) > 0) {
        echo '<span class="info">'.$msg.'</span>';
    }
    ?>
    <div id="object-list">
        <div class="corps-form">
            <fieldset>
                <legend>Consulter un auteur</legend>                        
                <div id="breadcrumb">
                    <a href="index.php?uc=gererAuteurs&action=ajouterAuteur">Ajouter</a>&nbsp;
                    <a href="index.php?uc=gererAuteurs&action=modifierAuteur&option=saisirAuteur&id=<?php echo $lAuteur->getId() ?>">Modifier</a>&nbsp;
                    <a href="index.php?uc=gererAuteurs&action=supprimerAuteur&id=<?php echo $lAuteur->getId() ?>">Supprimer</a>
                </div>
                <table>
                    <tr>
                        <td class="h-entete">
                            ID :
                        </td>
                        <td class="h-valeur">
                            <?php echo $lAuteur->getId() ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Nom :
                        </td>
                        <td class="h-valeur">
                            <?php echo $lAuteur->getNom() ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Prénom :
                        </td>
                        <td class="h-valeur">
                            <?php echo $lAuteur->getPrenom() ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Alias :
                        </td>
                        <td class="h-valeur">
                            <?php echo $lAuteur->getAlias() ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Notes :
                        </td>
                        <td class="h-valeur">
                            <?php echo $lAuteur->getNotes() ?>
                        </td>
                    </tr>
                </table>
            </fieldset>                    
        </div>
    </div>
</div>
