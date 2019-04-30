<div id="content">
    <h2>Gestion des prets</h2>
    <div id="object-list">          
        <form action="index.php?uc=gererPrets&action=ajouterPret&option=validerPret" method="post">
            <div class="corps-form">
                <fieldset>
                    <legend>Ajouter un pret</legend>
                    <table>
                        <tr>
                            <td>
                                <label for="cbxClients">
                                    Client :
                                </label>
                            </td>
                            <td>
                                <?php
                                    afficherListe($lesClients, "cbxClients", $strClient, "");
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
                                    afficherListe($lesOuvrages, "cbxOuvrages", $strOuvrage, "");
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
                                        if (!empty($strDate_emprunt)) {
                                            echo ' value="'.$strDate_emprunt.'"';
                                        }
                                        else {
                                            echo ' value="'.date('Y-m-d').'"';
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
                           value="Ajouter"
                    />
                </p> 
            </div>
        </form>
    </div>
</div>       