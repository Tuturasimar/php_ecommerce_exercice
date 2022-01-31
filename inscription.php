<?php

require_once 'inc/init.inc.php';


if(!empty($_POST))
{
    $err = 0;

    if(empty($_POST['pseudo']))
    {
        $err++;
        addMessage('Merci de saisir un pseudo','danger');
    } else {
        $pseudo = getUserByPseudo($_POST['pseudo']);
        if($pseudo)
        {
            $err++;
            addMessage('Pseudo indisponible, merci d\'en choisir un autre','danger');
        }
    }

    if(empty($_POST['mdp']))
    {
        $err++;
        addMessage('Merci de saisir un mot de passe','danger');
    }
    if(empty($_POST['nom']))
    {
        $err++;
        addMessage('Merci de renseigner un nom','danger');
    }
    if(empty($_POST['prenom']))
    {
        $err++;
        addMessage('Merci de renseigner un prenom','danger');
    }
    if(empty($_POST['email']))
    {
        $err++;
        addMessage('Merci de renseigner un email','danger');
    } else {
        if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
        {
            $err++;
            addMessage('Adresse mail invalide','danger');
        }
    }
    if(empty($_POST['adresse']))
    {
        $err++;
        addMessage('Merci de renseigner une adresse','danger');
    }
    if(empty($_POST['ville']))
    {
        $err++;
        addMessage('Merci de renseigner une ville','danger');
    }
    if(empty($_POST['cp']))
    {
        $err++;
        addMessage('Merci de renseigner un code postal','danger');
    }

    if($err == 0)
    {
           
            sql("INSERT INTO membre (pseudo,mdp,nom,prenom,email,civilite,ville,code_postal,adresse,statut) 
            VALUES (:pseudo,:mdp,:nom,:prenom,:email,:civilite,:ville,:code_postal,:adresse,:statut)", array(
                'pseudo' => $_POST['pseudo'],
                'mdp' => password_hash($_POST['mdp'],PASSWORD_DEFAULT),
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'email' => $_POST['email'],
                'civilite' => $_POST['civilite'],
                'ville' => $_POST['ville'],
                'code_postal' => $_POST['cp'],
                'adresse' => $_POST['adresse'],
                'statut' => '0'
            ));

        addMessage('Inscription réussie','success');

        $user = getUserByPseudo($_POST['pseudo']);
        $_SESSION['user'] = $user;
        header('location:/site/');
        exit();
    }



}

if(!isConnected()){



?>

<?php
$title = "Inscription";

require_once './inc/haut.inc.php';?>

<div class="row my-4">
    <h1 class="text-center">Inscription</h1>
    <hr>
    <form method="post">
        <div class="mb-3"> 
            <label for="pseudo">Pseudo</label>

            <input type="text" id="pseudo" name="pseudo" placeholder="Nom d'utilisateur" class="form-control"
                value="<?= $_POST['pseudo'] ?? '' ?>">
        </div>
        <div class="mb-3">
            <label for="password">Mot de passe</label>

            <input type="password" id="mdp" name="mdp" placeholder="Mot de passe" class="form-control">
        </div>
        <div class="mb-3 form-check form-check-inline ">
            <input class="form-check-input" type="radio" id="m" name="civilite" class="form-control" value="m" checked>
            <label for="m">Monsieur</label>
        </div>
        <div class="mb-3 form-check form-check-inline">
            <input class="form-check-input" type="radio" id="f" name="civilite" class="form-control" value="f">
            <label for="f">Madame</label>
        </div>
        <div class="mb-3">
            <label for="nom">Nom</label>

            <input type="text" id="nom" name="nom" placeholder="Watson" class="form-control"
                value="<?= $_POST['nom'] ?? '' ?>">
        </div>
        <div class="mb-3">
            <label for="prenom">Prenom</label>

            <input type="text" id="prenom" name="prenom" placeholder="Bobby" class="form-control"
                value="<?= $_POST['prenom'] ?? '' ?>">
        </div>
        
        <div class="mb-3">
            <label for="email">Email</label>

            <input type="email" id="email" name="email" placeholder="bobby.watson@gmail.com" class="form-control"
                value="<?= $_POST['email'] ?? '' ?>">
        </div>
        <div class="mb-3">
            <label for="adresse">Adresse</label>

            <input type="text" id="adresse" name="adresse" placeholder="6, rue de la Boustifaille" class="form-control"
                value="<?= $_POST['adresse'] ?? '' ?>">
        </div>
        <div class="mb-3">
            <label for="ville">Ville</label>

            <input type="text" id="ville" name="ville" placeholder="Paris" class="form-control"
                value="<?= $_POST['ville'] ?? '' ?>">
        </div>
        <div class="mb-3">
            <label for="cp">Code postal</label>
            <input type="number" id="cp" name="cp" placeholder="75000" class="form-control"
                value="<?= $_POST['cp'] ?? '' ?>">
        </div>
        <div>
            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </div>
    </form>
    <p class="mt-4">
        Déjà un compte ? Connectez vous en <a href="connexion.php">cliquant ici</a>
    </p>
</div>



<?php
} else {
    header('location:/site/');
}

require_once './inc/bas.inc.php';