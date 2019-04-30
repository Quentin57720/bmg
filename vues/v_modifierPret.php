<div id="content">
    <h2>Gestion des prets</h2>
    <div id="object-list">
        <form action="index.php?uc=gererPrets&action=modifierPret&option=validerPret&id=<?php echo $lePret->getId() ?>" method="post" enctype="multipart/form-data">
            <div class="corps-form">
                <fieldset>
                    <legend>Modifier un pret</legend>
                    <table>
                        <tr>
                            <td>
                                <label for="cbxClients">
                                    Client :
                                </label>
                            </td>
                            <td>
                                <?php
                                    afficherListe($lesClients, "cbxClients", $leClient, "");
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="cbxOuvrages">
                                    Ouvrage :
                                </label>
                            </td>
                            <td>
                                <?php
                                    afficherListe($lesOuvrages, "cbxOuvrages", $leOuvrage, "");
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtDate">
                                    Date emprunt :
                                </label>
                            </td>
                            <td>
                                <input 
                                    type="date" id="txtDate" 
                                    name="txtDate" 
                                    <?php
                                        if (!empty($lePret->getDateEmp())) {
                                            echo ' value="' . $lePret->getDateEmp() . '"';
                                        } else {
                                            echo ' value="' . date('Y-m-d') . '"';
                                        }
                                    ?>
                                />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtDateRet">
                                    Date de retour :
                                </label>
                            </td>
                            <td>
                                <input 
                                    type="date" id="txtDateRet" 
                                    name="txtDateRet" 
                                    <?php
                                        if (!empty($lePret->getDateRet())) {
                                            echo ' value="' . $lePret->getDateRet() . '"';
                                        }
                                    ?>
                                />
                            </td>
                        </tr>                                    
                    </table>
                </fieldset>
            </div>
            <div class="pied-form">
                <p>
                    <input id="cmdValider" name="cmdValider"
                           type="submit"
                           value="Modifier"
                           />
                </p>
            </div>
        </form>
    </div>
</div>
