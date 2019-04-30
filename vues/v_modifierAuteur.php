<?php
/** 
 * Page de gestion des auteurs

  * @author 
  * @package default
 */
?>
<div id="content">
    <h2>Gestion des auteurs</h2>
    <div id="object-list">
        <form action="index.php?uc=gererAuteurs&action=modifierAuteur&option=validerAuteur&id=<?php echo $lAuteur->getId() ?>" method="post">
            <div class="corps-form">
                <fieldset>
                    <legend>Modifier un auteur</legend>
                    <table>
                        <tr>
                            <td>
                                <label for="txtID">
                                    ID :
                                </label>
                            </td>
                            <td>
                                <input 
                                    type="text" id="txtID" 
                                    name="txtID"
                                    size="5"
                                    readonly="readonly"
                                    value="<?php echo $lAuteur->getId() ?>"
                                />
                            </td>
                        </tr>                                        
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
                                    size="50" maxlength="128"
                                    value="<?php echo $lAuteur->getNom() ?>"
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
                                    size="50" maxlength="128"
                                    value="<?php echo $lAuteur->getPrenom() ?>"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtAlias">
                                    Alias :
                                </label>
                            </td>
                            <td>
                                <input 
                                    type="text" id="txtAlias" 
                                    name="txtAlias"
                                    size="50" maxlength="128"
                                    value="<?php echo $lAuteur->getAlias() ?>"
                                />
                            </td>
                        </tr>                                        
                        <tr>
                            <td valign="top">
                                <label for="txtNotes">
                                    Notes :
                                </label>
                            </td>
                            <td>
                                <textarea id="txtNotes" 
                                    name="txtNotes" 
                                    rows="20" 
                                    cols="80"><?php echo $lAuteur->getNotes() ?></textarea>                                                
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
