<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= RACINE_SITE; ?>inc/css/style.css">

    <title><?= $title ?></title>
</head>

<body class="d-flex flex-column h-100">
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?= RACINE_SITE; ?>">Mon Site</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <?php if(!isConnected()){ ?>
                        <li class="nav-item">
                            <a class="nav-link <?php if($title == 'Inscription') echo 'active'?>"
                                href="inscription.php">Inscription</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if($title == 'Connexion') echo 'active'?> "
                                href="connexion.php">Connexion</a>
                        </li>
                        <?php  } else {  ?>
                        <li class="nav-item">
                            <a class="nav-link <?php if($title == 'Profil') echo 'active'?> "
                                href="<?= RACINE_SITE; ?>profil.php?id=<?= $_SESSION['user']['id_membre'] ?>">Profil</a>
                        </li>
                        <li class="nav-item">
                            <?php 
                                if (!isAdmin()) {
                            ?>
                            <a class="nav-link <?php if($title == 'Boutique') echo 'active'?>"
                                href="boutique.php">Boutique</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if($title == 'Panier') echo 'active'?>"
                                href="panier.php">Panier</a>
                        </li>
                        <?php } else {    ?>
                        <li class="nav-item">
                            <a class="nav-link <?php if($title == 'Gestion Boutique') echo 'active'?>"
                                href="<?= RACINE_SITE; ?>admin/gestion_boutique.php">Gestion Boutique</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if($title == 'Gestion Commande') echo 'active'?> "
                                href="<?= RACINE_SITE; ?>admin/gestion_commande.php">Gestion Commandes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if($title == 'Gestion Membre') echo 'active'?>"
                                href="<?= RACINE_SITE; ?>admin/gestion_membre.php">Gestion Membres</a>
                        </li>
                        <?php }   ?>

                        <li class="nav-item">
                            <a class="nav-link"
                                href="<?= RACINE_SITE; ?>connexion.php?action=deconnexion">Déconnexion</a>
                        </li>
                        <?php   }  ?>
                    </ul>

                </div>
            </div>
        </nav>
    </header>

    <main class="flex-shrink-0">
        <div class="container <?= $title == "Gestion Boutique" ? "containerWidth" : "" ?>">
            <div class="row mt-3">
                <div class="col">
                    <?php

                    echo showMessages();
                    unset ($_SESSION['messages']);

                    ?>
                </div>
            </div>