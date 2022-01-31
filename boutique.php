<?php

require_once 'inc/init.inc.php';

if(isConnected() && !isAdmin()){

    if(!empty($_POST)){
        if(!empty($_POST['categorie']) && !empty($_POST['prix']))
        {
           
            if($_POST['prix'] != 100){
                $tab = explode('-',$_POST['prix']);
                $data = getFiltersTypePrice($_POST['categorie'],$tab);
                if(!empty($data)){
                    addFilters($data);
                } else {
                addMessage('Aucun produit disponible selon ces filtres','danger');
                addFilters(getAllProduct());
                }

            } else {
            $data = getFiltersTypePrice($_POST['categorie'],$_POST['prix']);
                if(!empty($data)){
                    addFilters($data);
                } else {
                addMessage('Aucun produit disponible selon ces filtres','danger');
                addFilters(getAllProduct());
                }
            }
            
        } else if (!empty($_POST['categorie'])) {

            addFilters(getFiltersType($_POST['categorie']));
        } else if (!empty($_POST['prix'])) {

            if($_POST['prix'] != 100){
                $tab = explode('-',$_POST['prix']);
                 $data = getFiltersPrice($tab);
                if(!empty($data)){
                    addFilters($data);
                } else {
                addMessage('Aucun produit disponible selon ce filtre 1','danger');
                addFilters(getAllProduct());
                }
            } else {
            $data = getFiltersPrice($_POST['prix']);
                if(!empty($data)){
                    addFilters($data);
                } else {
                addMessage('Aucun produit disponible selon ce filtre 2','danger');
                addFilters(getAllProduct());
                }
            }
           

        } else {
            addFilters(getAllProduct());
        }

    } else {
       addFilters(getAllProduct());
    }


$data = $_SESSION['user']['filters'];
unset($_SESSION['user']['filters']);
$allType = getAllTypeOfProduct();

$title = "Boutique";

require_once './inc/haut.inc.php';?>

<h2 class="text-center">Page Boutique</h2>
<div class="row col-6 mx-auto my-4">
    <form method="post">
        <div class="text-center my-2">
            <label class="form-label" for="categorie">Catégorie</label>
            <select class="form-select" name="categorie" id="categorie">
                <option value="">Toutes les catégories</option>
                <?php foreach($allType as $type) { ?>
                <option value="<?=$type['categorie']?>"><?= $type['categorie'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="text-center my-2">
            <label class="form-label" for="prix">Prix</label>
            <select class="form-select" name="prix" id="prix">
                <option value="">Aucun filtre</option>
                <?php for($i=0;$i<4;$i++) {  
                if($i == 0){
                    $num1 = 0;
                    $num2 = 25;
                } else {
                    $num1 = $i*25;
                    $num2 = $num1+25;
                }
                
            ?>
                <option value="<?=$num1?>-<?=$num2?>"><?=$num1?>€ - <?=$num2?>€</option>
                <?php } ?>
                <option value="100">+ de 100 €</option>
            </select>
        </div>
        <div class="text-center">
            <input type="submit" class="btn btn-primary" value="Appliquer filtres">
        </div>
    </form>
</div>

<div class="container text-center d-flex align-items-center flex-wrap" style="min-height: 720px;">
    
    <?php foreach($data as $dataProduit):?>
    <?php $url = mb_substr($dataProduit['photo'],strpos($dataProduit['photo'],"inc"),null,'UTF-8') ?>

    <div class="card"
        style="height:550px;width: 18rem; margin: 0 auto; padding:20px; background : linear-gradient(lightsteelblue,white); border: 0px">
        <div class="card-body d-flex flex-column justify-content-between">
            <h5 style="line-height:20px" class="card-title"><?= $dataProduit['titre']?></h5>
            <img class="rounded-circle imgLittle" src="<?=$url?>" alt="<?= $dataProduit['titre']?>">
            <ul style="list-style : none; padding:0 ;">
                <li style="card-text">Catégorie : <?= $dataProduit['categorie']  ?></li>
                <li style="card-text"><?= substr($dataProduit['description'],0,100).'...' ?></li>
                <li style="card-text">Prix : <?=sprintf('%.2f',$dataProduit['prix']) ?> €</li>
            </ul>
            <div>
                <a href="fiche_produit.php?id=<?= $dataProduit['id_produit']?>" class="btn btn-primary">Voir le
                    produit</a>
                <a href="panier.php?action=ajout&id=<?= $dataProduit['id_produit']?>" class="btn border">🧺</a>
            </div>
        </div>
    </div>
    <?php endforeach;?>


</div>

<?php

    } else {
        header('location:connexion.php');
    }



require_once './inc/bas.inc.php';