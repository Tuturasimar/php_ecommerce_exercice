<?php

require_once 'inc/init.inc.php';

if (isConnected() && isset($_GET['id'])){

$data = getUserById($_GET['id']);

$orders = getOrderByMemberId($_GET['id']);

$title = "Profil";

require_once './inc/haut.inc.php';?>

<h1 class="text-center my-2">Profil de <?= $data['pseudo']?></h1>
<div class="card mt-4"
    style="height:400px;min-width: 40vh; margin: 0 auto; padding:20px; background : linear-gradient(lightsteelblue,white); border: 0px">
    <div class="card-body d-flex flex-column justify-content-between">
        <ul style="list-style : none; padding:0">
            <li>
                <ul style="list-style : none; padding:0"
                    class="list-group list-group-horizontal d-flex justify-content-between  my-2">
                    <li>Nom : </li>
                    <li><?= $data['nom'] ?></li>
                </ul>
            </li>
            <li>
                <ul style="list-style : none; padding:0"
                    class="list-group list-group-horizontal d-flex justify-content-between my-2">
                    <li>Prénom : </li>
                    <li><?= $data['prenom'] ?></li>
                </ul>
            </li>
            <li>
                <ul style="list-style : none; padding:0"
                    class="list-group list-group-horizontal d-flex justify-content-between my-2">
                    <li>Email : </li>
                    <li><?= $data['email'] ?></li>
                </ul>
            </li>
            <li>
                <ul style="list-style : none; padding:0"
                    class="list-group list-group-horizontal d-flex justify-content-between my-2">
                    <li>Civilité : </li>
                    <li><?= $data['civilite'] == "m" ? "Homme" : "Femme" ?></li>
                </ul>
            </li>
            <li>
                <ul style="list-style : none; padding:0"
                    class="list-group list-group-horizontal d-flex justify-content-between my-2">
                    <li>Adresse : </li>
                    <li><?= $data['adresse'] ?></li>
                </ul>
            </li>
            <li>
                <ul style="list-style : none; padding:0"
                    class="list-group list-group-horizontal d-flex justify-content-between my-2">
                    <li>Ville : </li>
                    <li><?= $data['ville'] ?></li>
                </ul>
            </li>
            <li>
                <ul style="list-style : none; padding:0"
                    class="list-group list-group-horizontal d-flex justify-content-between my-2">
                    <li>Code Postal : </li>
                    <li><?= $data['code_postal'] ?></li>
                </ul>
            </li>
            <li>
                <ul style="list-style : none; padding:0"
                    class="list-group list-group-horizontal d-flex justify-content-between my-2">
                    <li>Statut du compte : </li>
                    <li><?= $data['statut'] == 0 ? "Client" : "Administrateur" ?></li>
                </ul>
            </li>
        </ul>
    </div>
</div>

<?php if(!isAdmin()) {  ?>

<h2 class="text-center">Récapitulatif des commandes</h2>
<hr>

<?php

    if(!empty($orders)){
        foreach($orders as $order){
           $details = getOrderDetails($order['id_commande']);
           
           ?>
<div class="my-3">     
<h3>Numéro de Commande : <?= $order['id_commande'] ?> -- Statut : <?= $order['etat']?></h3>
<p>Réalisée le <?= $order['date_fr'] ?></p>
</div> 
<h4>Détail de la commande :</h4>

    

    <?php
            foreach($details as $detail){ ?>
    <div class="row mx-auto justify-content-center my-3 text-center">
        <div class="col-4">x<?= $detail['quantite'] ?> - <?= $detail['titre'] ?></div>
        <div class="col-4"><?= sprintf('%.2f',$detail['prix'])  ?> €</div>
    </div>

    <?php
            }
            ?>
<p class="text-center text-uppercase">Prix total : <?= sprintf('%.2f',$order['montant']) ?> €</p>
<hr>
<?php
        }
    }
   
    
}
?>


<?php
} else {
    header('location:connexion.php');
}

require_once './inc/bas.inc.php';