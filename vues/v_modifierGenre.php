        <div id="content">
            <h2>Gestion des genres</h2>
            <div id="object-list">
                        <form action="index.php?uc=gererGenres&action=modifierGenre&option=validerGenre"  method="post">
                            <div class="corps-form">
                                <fieldset>
                                    <legend>Modifier un genre</legend>
                                    <table>
                                        <tr>
                                            <td>
                                                <label for="txtCode">
                                                    Code :
                                                </label>
                                            </td>
                                            <td>
                                                <input 
                                                    type="text" id="txtCode" 
                                                    name="id"
                                                    size="3" maxlength="3"
                                                    readonly="readonly"
                                                    value="<?php echo $leGenre->getCode() ?>"
                                                />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top">
                                                <label for="txtLibelle">
                                                    Libellé :
                                                </label>
                                            </td>
                                            <td>
                                                <input 
                                                    type="text" id="txtLibelle" 
                                                    name="txtLibelle"
                                                    size="50" maxlength="50"
                                                    value="<?php echo $leGenre->getLibelle()?>"
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