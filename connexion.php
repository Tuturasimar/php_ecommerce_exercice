<?php
require_once 'inc/init.inc.php';

if (isset($_GET['action']) && $_GET['action'] == "deconnexion")
{
    unset($_SESSION['user']);
    header('location:'.$_SERVER['PHP_SELF']);
    exit();
}

if(!empty($_POST))
{
    $err = 0;

    if(empty($_POST['pseudo']))
    {
        $err++;
        addMessage('Merci de saisir votre pseudo','danger');
    }

    if(empty($_POST['mdp']))
    {
        $err++;
        addMessage('Merci de saisir votre mot de passe','danger');
    }

    if($err == 0){
        $user = getUserByPseudo($_POST['pseudo']);
        if ($user){
            if(password_verify($_POST['mdp'], $user['mdp'])){
                $_SESSION['user'] = $user;
                addMessage('Connexion réussie','success');
                header('location:profil.php?id='.$_SESSION['user']['id_membre']);
                exit();
               
            } else {
                addMessage('Erreur sur les identifiants, veuillez réessayer','danger');
            }
        } else {
            addMessage('Erreur sur les identifiants, veuillez réessayer','danger');
        }
    }
}

if(!isConnected()){

$title = "Connexion";

require_once './inc/haut.inc.php';?>


<div class="row mt-4">
    <h1 class="text-center">Connexion</h1>
    <hr>
    <form method="post">
        <div class="mb-3">
            <label for="pseudo">Pseudo</label>
            <input type="text" id="pseudo" name="pseudo" placeholder="Pseudo" class="form-control"
                value="<?php echo isset($_POST['pseudo']) ?  $_POST['pseudo'] : '' ?>">
        </div>
        <div class="mb-3">
            <label for="mdp">Mot de passe</label>
            <input type="password" id="mdp" name="mdp" placeholder="Mot de passe" class="form-control">
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </div>
    </form>
    <p class="mt-4">
        Pas encore de compte ? Vous pouvez en créer un en <a href="inscription.php">cliquant ici</a>
    </p>
</div>

<?php
} else {
    header('location:/site/');
}

require_once './inc/bas.inc.php'; ?>