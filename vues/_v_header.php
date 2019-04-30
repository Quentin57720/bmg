<!DOCTYPE html>
<html>
    <head>
        <title>BMG - Municipale de Groville</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="styles/screen.css" />
    </head>
    <body>
	<header id="main-header">
            <hr />
            <div>
                <span class="titre-entete">
                    Bibliothèque municipale de Groville
                </span>
            </div>
            <hr />
            <div id="infos-util">
                <?php echo 'Connecté : '
                    .$_SESSION['prenom']." "
                    .$_SESSION['nom'];
                ?>
            </div>            
        </header>