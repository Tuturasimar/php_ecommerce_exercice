<?php

require_once './inc/init.inc.php';


if(isConnected() && isset($_GET['id']))
{
$data = getProductById($_GET['id']);

$url = mb_substr($data['photo'],strpos($data['photo'],"inc"),null,'UTF-8');

$title = "Fiche Produit";

require_once './inc/haut.inc.php';
?>
<h1 class="text-center my-2">Fiche de l'article n°<?=$data['id_produit']?> / <?= $data['reference'] ?></h1>
<div class="d-inline-flex w-100 justify-content-around my-4 align-items-center row boxProduct">
    <div class="col-md-6 px-4 text-center">
        <h2><?= $data['titre'] ?> -
            <?= ($data['public'] == "m") ? 'Homme' : (($data['public'] == "f") ? 'Femme' : 'Mixte') ?></h2>
        <p><?= "<br>". $data['description']?></p>
        <p>Couleur : <?=$data['couleur'] ?></p>
        <p>Taille : <?=$data['taille'] ?></p>
        <p>Prix : <?=$data['prix'] ?> €</p>
        <p>Stock : <?=$data['stock'] ?></p>
    </div>
    <div class="col-md-6 d-flex justify-content-center"><img class="imgDetail" src="<?=$url?>" alt=""></div>


</div>
<div class="d-flex justify-content-center my-4">
    <?php if(isAdmin()) {  ?>
    <a href="admin/form_article.php?action=modif&id=<?=$data['id_produit']?>"><button
            class="btn btn-primary mx-auto">Modifier l'article</button></a>
    <?php  } else {   ?>
    <a href="panier.php?action=ajout&id=<?=$data['id_produit']?>"><button class="btn btn-primary mx-auto">Ajouter au panier</button></a>

</div>

<?php } ?>
<?php 

} else {
    header('location:connexion.php');
}


?>
<?php
require_once './inc/bas.inc.php';