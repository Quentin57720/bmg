<div id="content">
    <h2>Gestion des ouvrages</h2>
    <div id="object-list">
        <form action="index.php?uc=gererOuvrages&action=modifierOuvrage&option=validerOuvrage&id=<?php echo $leOuvrage->getNum() ?>" method="post" enctype="multipart/form-data">
            <div class="corps-form">
                <fieldset>
                    <legend>Modifier un ouvrage</legend>
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
                                    value="<?php echo $leOuvrage->getNum() ?>"
                                    />
                            </td>
                        </tr>                                        
                        <tr>
                            <td>
                                <label for="txtTitre">
                                    Titre :
                                </label>
                            </td>
                            <td>
                                <input 
                                    type="text" id="txtTitre" 
                                    name="txtTitre"
                                    size="50" maxlength="128"
                                    value="<?php echo $leOuvrage->getTitre() ?>"
                                    />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="rbnSalle1">
                                    Salle :
                                </label>
                            </td>
                            <td>
                                <input 
                                    type="radio" id="rbnSalle1" 
                                    name="rbnSalle"
                                    value="1"
                                    <?php
                                    if ($leOuvrage->getSalle() == 1) {
                                        echo 'checked="checked"';
                                    }
                                    ?>
                                    />
                                <label>1</label>
                                <input 
                                    type="radio" id="rbnSalle2" 
                                    name="rbnSalle"
                                    value="2"
                                    <?php
                                    if ($leOuvrage->getSalle() == 2) {
                                        echo 'checked="checked"';
                                    }
                                    ?>
                                    />
                                <label>2</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtRayon">
                                    Rrayon :
                                </label>
                            </td>
                            <td>
                                <input 
                                    type="text" id="txtRayon" 
                                    name="txtRayon"
                                    size="2" maxlength="2"
                                    <?php
                                    if (!empty($leOuvrage->getRayon())) {
                                        echo ' value="' . $leOuvrage->getRayon() . '"';
                                    }
                                    ?>
                                    />
                            </td>
                        </tr>                                        
                        <tr>
                            <td>
                                <label for="cbxGenres">
                                    Genre :
                                </label>
                            </td>
                            <td>
                                <?php
                                afficherListe($lesGenres, "cbxGenres", $leOuvrage->getCode_genre()->getCode(), "");
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtDate">
                                    Date d'acquisition :
                                </label>
                            </td>
                            <td>
                                <input 
                                    type="date" id="txtDate" 
                                    name="txtDate"
                                    <?php
                                    if (!empty($leOuvrage->getAcquisition())) {
                                        echo ' value="' . $leOuvrage->getAcquisition() . '"';
                                    } else {
                                        echo ' value="' . date('Y-m-d') . '"';
                                    }
                                    ?>
                                    />
                            </td>      
                            <?php if (couvertureOuvrage($leOuvrage->getNum(), $leOuvrage->getTitre()) == couvertureOuvrage(DEFAULT_IMG, "Image indisponible")) { ?>
                            </tr>
                            <tr>
                                <td>
                                    <label for="lbimage">
                                        Image :
                                    </label>
                                </td>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input 
                                        type="file" id="fichier" 
                                        name="fichier"
                                        />
                                </td>
                                <?php
                            }
                            ?>

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