<?php
/** 
 * Page d'ajout d'un genre

  * @author 
  * @package default
 */

?><div id="content">
    <h2>Gestion des genres</h2>
    <div id="object-list">
        <?php
            // initialisation des variables
            $strCode = '';
            $strLibelle = '';
            // variables pour la gestion des erreurs
            $tabErreurs = array(); 
            $hasErrors = false;
            $afficherForm = true;
            // connexion à la base de données
 //           $cnx = connectDB();                    
//            // tests de gestion du formulaire
//            if (isset($_POST["cmdValider"])) {
//                // récupération du libellé
//                if (!empty($_POST["txtLibelle"])) {
//                    $strLibelle = ucfirst(htmlentities($_POST["txtLibelle"]));
//                }
//                if (!empty($_POST["txtCode"])) {
//                    $strCode = strtoupper(htmlentities($_POST["txtCode"]));
//                }
//                // test zones obligatoires
//                if (!empty($strCode) and !empty($strLibelle)) {
//                    // les zones obligatoires sont présentes
//                    // tests de cohérence 
//                    // contrôle d'existence d'un genre avec le même code
//                    $strSQL = "SELECT COUNT(*) FROM genre WHERE code_genre = '".$strCode."'";
//                    $res = getRows($cnx, $strSQL);
//                    $doublon = $res->fetchColumn(0);
//                    if ($doublon) {
//                        // signaler l'erreur
//                        $tabErreurs["Erreur"] = 'Il existe déjà un genre avec ce code !';
//                        $tabErreurs["Genre"] = $strCode;
//                        $hasErrors = true;
//                    }
//                }
//                else {
//                    // une ou plusieurs valeurs n'ont pas été saisies
//                    if (empty($strCode)) {                                
//                        $tabErreurs["Code"] = "Le code doit être renseigné !";
//                    }
//                    if (empty($strLibelle)) {
//                        $tabErreurs["Libellé"] = "Le libellé doit être renseigné !";
//                    }
//                    $hasErrors = true;
//                }
//                if (!$hasErrors) {
//                    // ajout dans la base de données
//                    $strSQL = "INSERT INTO genre VALUES ('"
//                            .$strCode."','".$strLibelle."')";
//                    try {
//                        $res = execSQL($cnx, $strSQL);
//                        if ($res) {                                    
//                            echo '<span class="info">Le genre '
//                                .$strCode.'-'
//                                .$strLibelle.' a été ajouté</span>';
//                                $afficherForm = false;
//                        }
//                        else {
//                            $tabErreurs["Erreur"] = 'Une erreur s\'est produite dans l\'opération d\'ajout !';
//                            $tabErreurs["Code"] = $strCode;
//                            $tabErreurs["Libellé"] = $strLibelle;
//                            $hasErrors = true;
//                        }
//                    }
//                    catch (PDOException $e) {
//                        $tabErreurs["Erreur"] = 'Une exception PDO a été levée !';
//                        $hasErrors = true;
//                    }
//                }
//            }
            // affichage des erreurs
            if ($hasErrors) {
                foreach ($tabErreurs as $code => $libelle) {
                    echo '<span class="erreur">'.$code.' : '.$libelle.'</span>';
                }
            }
            // affichage du formulaire
            if ($afficherForm) {
                ?>                    
                <form action="index.php?uc=gererGenres&action=ajouterGenre&option=validerGenre" method="post">
                    <div class="corps-form">
                        <fieldset>
                            <legend>Ajouter un genre</legend>
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
                                            name="txtCode"
                                            size="3" maxlength="3"
                                            <?php
                                                if (!empty($strCode)) {
                                                    echo ' value="'.$strCode.'"';
                                                }
                                            ?>
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
                                            <?php
                                                if (!empty($strLibelle)) {
                                                    echo ' value="'.$strLibelle.'"';
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
            <?php 
            }           
        ?>
    </div>
</div>          
      