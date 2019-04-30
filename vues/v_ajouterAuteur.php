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
        <?php
        if(empty($intID)){
        ?>
            <form action="index.php?uc=gererAuteurs&action=ajouterAuteur&option=validerAuteur" method="post">
        <?php
        } else {
        ?>
            <form action="index.php?uc=gererOuvrages&action=ajouterAuteur&option=validerAuteur&id=<?php echo $intID ?>" method="post">
        <?php
        }
        ?>
            <div class="corps-form">
                <fieldset>
                    <legend>Ajouter un auteur</legend>
                    <table>
                         <?php
                        if(!empty($intID))
                        {
                            ?>
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
                                    value="<?php echo $intID ?>"
                                    />
                            </td>
                        </tr>     
                            <?php
                        }             
                        ?>
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
                                    cols="80">                                        
                                </textarea>
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
