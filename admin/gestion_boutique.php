<?php

require_once '../inc/init.inc.php';

if(isAdmin()){

    if(isset($_GET['action']) && $_GET['action'] == 'delete'){
        deleteProduct($_GET['id']);
        addMessage('Produit n°'.$_GET['id'].' supprimé avec succès !','info');
        header('location:gestion_boutique.php');
       exit();
    }

$title = "Gestion Boutique";

$data = getAllProduct();
$fields = getProductFields();

require_once '../inc/haut.inc.php';?>

<div class="row text-center justify-content-center">
    <h2 class="text-center my-2">Gestion de la boutique</h2>
    <a class="text-decoration-none text-light my-2 col-2 p-0" href="./form_article.php?action=add"><button class="btn btn-primary col-12">Nouvel
            article</button></a>
</div>
<div class="table-responsive">
<table class="table table-bordered text-center my-4" style="table-layout:auto;">
    <thead>
        <tr>
            <?php foreach($fields as $index => $field):?>
            <th >
                <?=($field['Field'])?>
            </th>
            <?php endforeach?>
            <th>Voir</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($data as $dataProduit): ?>
            
        <tr >
            <td class="align-middle"><?= implode('</td><td class="align-middle">',$dataProduit)?></td>
            <td class="align-middle"><a style="text-decoration:none" href="<?= RACINE_SITE; ?>fiche_produit.php?id=<?=  $dataProduit['id_produit']  ?>">🔎</a></td>
            <td class="align-middle"><a style="text-decoration:none" href="form_article.php?action=modif&id=<?=  $dataProduit['id_produit']  ?>">✎</a></td>
            <td class="align-middle"><a style="text-decoration:none" href="?action=delete&id=<?=  $dataProduit['id_produit']  ?>">🗑</a></td>
        </tr>

        <?php endforeach ?>
    </tbody>
</table>
</div>

<?php


?>


<?php

} else {
    header('location:/site/');
}
require_once '../inc/bas.inc.php';