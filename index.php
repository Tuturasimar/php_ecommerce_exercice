<?php

require_once './inc/init.inc.php';

$title = "Accueil";

require_once './inc/haut.inc.php';?>

<?php
if(!empty($_SESSION['user'])){
    if (isAdmin()) {
        header('location:'. RACINE_SITE.'admin/gestion_boutique.php');
    } else {
        header('location:'. RACINE_SITE.'boutique.php');
    }
} else {
    header('location:'. RACINE_SITE.'connexion.php');
}

?>


<?php require_once './inc/bas.inc.php';