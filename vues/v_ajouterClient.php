<?php
/**
 * Page de gestion des clients

  * @author
  * @package default
 */
?>
<div id="content">
    <h2>Gestion des clients</h2>
    <div id="object-list">
        <form action="index.php?uc=gererClients&action=ajouterClient&option=validerClient" method="post">
            <div class="corps-form">
                <fieldset>
                    <legend>Ajouter un client</legend>
                    <table>
                        <tr>
                            <td>
                                <label for="txtNom">
                                    Nom :
                                </label>
                            </td>
                            <td>
                                <input
                                    type="text" id="txtNom"
                                    name="txtNom"
                                    size="50" maxlength="50"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtPrenom">
                                    Prénom :
                                </label>
                            </td>
                            <td>
                                <input
                                    type="text" id="txtPrenom"
                                    name="txtPrenom"
                                    size="50" maxlength="50"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtRue">
                                    Rue :
                                </label>
                            </td>
                            <td>
                                <input
                                    type="text" id="txtRue"
                                    name="txtRue"
                                    size="50" maxlength="50"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtCP">
                                    Code postal :
                                </label>
                            </td>
                            <td>
                                <input
                                    type="text" id="txtCP"
                                    name="txtCP"
                                    size="15" maxlength="5"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtVille">
                                    Ville :
                                </label>
                            </td>
                            <td>
                                <input
                                    type="text" id="txtVille"
                                    name="txtVille"
                                    size="50" maxlength="50"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="dateInscr">
                                    Date d'inscription :
                                </label>
                            </td>
                            <td>
                                <input
                                    type="date" id="dateInscr"
                                    name="dateInscr"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtMel">
                                    Mel :
                                </label>
                            </td>
                            <td>
                                <input
                                    type="text" id="txtMel"
                                    name="txtMel"
                                    size="50" maxlength="128"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtEtat">
                                    Etat du client :
                                </label>
                            </td>
                            <td>
                                <input
                                    type="text" id="txtEtat"
                                    name="txtEtat"
                                    size="15" maxlength="1"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtCaution">
                                    Caution :
                                </label>
                            </td>
                            <td>
                              &nbsp&nbsp&nbsp&nbsp&nbsp
                                <input
                                    type="number" step="1"
                                    id="txtCaution" name="txtCaution"
                                    min="0,00" max="1000,00"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtMontant">
                                    Montant du compte :
                                </label>
                            </td>
                            <td>
                              &nbsp&nbsp&nbsp&nbsp&nbsp
                                <input
                                    type="number" step="1"
                                    id="txtMontant" name="txtMontant"
                                    min="0,00" max="1000,00"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtLogin">
                                    Login :
                                </label>
                            </td>
                            <td>
                                <input
                                    type="text" id="txtLogin"
                                    name="txtLogin"
                                    size="50" maxlength="50"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtMdp">
                                    Mot de passe :
                                </label>
                            </td>
                            <td>
                                <input
                                    type="password" id="txtMdp"
                                    name="txtMdp"
                                    size="50" maxlength="10"
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
