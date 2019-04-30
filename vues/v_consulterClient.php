
<?php
/**
 * Page de gestion des clients

 * @author
 * @package default
*/
?>
<div id="content">
    <h2>Gestion des clients</h2>
    <?php
    if (strlen($msg) > 0) {
        echo '<span class="info">'.$msg.'</span>';
    }
    ?>
    <div id="object-list">
        <div class="corps-form">
            <fieldset>
                <legend>Consulter un client</legend>
                <div id="breadcrumb">
                    <a href="index.php?uc=gererClients&action=ajouterClient">Ajouter</a>&nbsp;
                    <a href="index.php?uc=gererClients&action=modifierClient&option=saisirClient&id=<?php echo $leClient->getId() ?>">Modifier</a>&nbsp;
                    <a href="index.php?uc=gererClients&action=supprimerClient&id=<?php echo $leClient->getId() ?>">Supprimer</a>
                </div>
                <table>
                    <tr>
                        <td class="h-entete">
                            ID :
                        </td>
                        <td class="h-valeur">
                            <?php echo $leClient->getId() ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Nom :
                        </td>
                        <td class="h-valeur">
                            <?php echo $leClient->getNom() ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Prénom :
                        </td>
                        <td class="h-valeur">
                            <?php echo $leClient->getPrenom() ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Rue :
                        </td>
                        <td class="h-valeur">
                            <?php echo $leClient->getRue() ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Code postal :
                        </td>
                        <td class="h-valeur">
                            <?php echo $leClient->getCodePost() ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Ville :
                        </td>
                        <td class="h-valeur">
                            <?php echo $leClient->getVille() ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Date d'inscription :
                        </td>
                        <td class="h-valeur">
                            <?php echo $leClient->getDateInscr() ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Mel :
                        </td>
                        <td class="h-valeur">
                            <?php echo $leClient->getMel() ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Etat du client :
                        </td>
                        <td class="h-valeur">
                            <?php echo $leClient->getEtatClient() ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Caution :
                        </td>
                        <td class="h-valeur">
                            <?php echo $leClient->getCaution() ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Caution encaissée :
                        </td>
                        <td class="h-valeur">
                            <?php echo $leClient->getCautionEncaissee() ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Montant du compte :
                        </td>
                        <td class="h-valeur">
                            <?php echo $leClient->getMontantCompte() ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Login :
                        </td>
                        <td class="h-valeur">
                            <?php echo $leClient->getLogin() ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Mot de passe :
                        </td>
                        <td class="h-valeur">
                            <?php echo $leClient->getPassword() ?>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
    </div>
</div>
