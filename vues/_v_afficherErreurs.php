<div id="content">
    <h2><?php echo $titrePage ?></h2>
    <?php
    // affichage du lien de retour
    if (strlen($lien) > 0) {
        echo $lien;
    }
    ?>
    <br /><br />
    <span class="info">
        <?php 
        if (strlen($msg) > 0) {
            echo $msg;
        }
        ?></span>
    <?php
    // affichage des erreurs   
    foreach ($tabErreurs as $erreur) {
        echo '<span class="erreur">'.$erreur.'</span>';
    }
    ?>
</div>
