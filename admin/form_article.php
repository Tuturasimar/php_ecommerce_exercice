<?php

require_once '../inc/init.inc.php';

if(isAdmin()){

if(!empty($_POST))
{
    $err = 0;

    if(empty($_POST['reference']))
    {
        $err++;
        addMessage('Renseignez une référence','danger');
    } else {
        $ref = getProductByReference($_POST['reference']);
        if ($ref)
        {
            $err++;
            addMessage('Référence de l\'article déjà utilisée','danger');
        }
    }

    if(empty($_POST['categorie']))
    {
        $err++;
        addMessage('Renseignez une catégorie','danger');
    }

    if(empty($_POST['titre']))
    {
        $err++;
        addMessage('Renseignez un titre','danger');
    }

    if(empty($_POST['description']))
    {
        $err++;
        addMessage('Renseignez une description de l\'article','danger');
    }

    if(empty($_POST['couleur']))
    {
        $err++;
        addMessage('Renseignez la couleur','danger');
    }

    if(empty($_POST['taille']))
    {
        $err++;
        addMessage('Renseignez la taille','danger');
    }

    if(empty($_POST['prix']))
    {
        $err++;
        addMessage('Renseignez le prix de l\'article','danger');
    }

    if(empty($_POST['stock']))
    {
        $err++;
        addMessage('Renseignez le stock de l\'article','danger');
    }

    if(!empty($_FILES['photo'])){
        if(empty($_FILES['photo']['name'])){
            $err++;
            addMessage('Veuillez insérer une image','danger');
        } else {
            
            $format = ['png','jpeg','jpg'];
            $pic_name = $_FILES['photo']['name'];
            $array = explode(".",$pic_name);
            $pic_extension = end($array);
            $pic_temp = $_FILES['photo']['tmp_name'];
            if(in_array($pic_extension,$format)){
               $filePath = saveImg($pic_extension,$pic_temp);
            } else {
                $err++;
                addMessage('Extension choisie n\'est pas une image','danger');
            }
        }
    }

    if($err == 0)
    {
        if (isset($_GET['id']))
        {
            if($_GET['action'] == 'modif'){
                $url =  getImgById($_GET['id']);
                unlink($url['photo']);
              }

            $id = $_GET['id'];

            sql("REPLACE INTO produit (id_produit,reference,categorie,titre,description,couleur,taille,public,photo,prix,stock) 
            VALUES (:id_produit,:reference,:categorie,:titre,:description,:couleur,:taille,:public,:photo,:prix,:stock)", array(
                'id_produit' => $id,
                'reference' => $_POST['reference'],
                'categorie' => $_POST['categorie'],
                'titre' => $_POST['titre'],
                'description' => $_POST['description'],
                'couleur' => $_POST['couleur'],
                'taille' => $_POST['taille'],
                'public' => $_POST['public'],
                'photo' => $filePath,
                'prix' => $_POST['prix'],
                'stock' => $_POST['stock']
            ));
            addMessage('Article modifié','success');
        } else {
            sql("INSERT INTO produit (reference,categorie,titre,description,couleur,taille,public,photo,prix,stock) 
            VALUES (:reference,:categorie,:titre,:description,:couleur,:taille,:public,:photo,:prix,:stock)", array(
                'reference' => $_POST['reference'],
                'categorie' => $_POST['categorie'],
                'titre' => $_POST['titre'],
                'description' => $_POST['description'],
                'couleur' => $_POST['couleur'],
                'taille' => $_POST['taille'],
                'public' => $_POST['public'],
                'photo' => $filePath,
                'prix' => $_POST['prix'],
                'stock' => $_POST['stock']
            ));
            addMessage('Article crée','success');
        }
        
        
        header('location:/site/');
        exit();
    }
    if(isset($filePath))
    unlink($filePath);

    addMessage('Assurez vous de sélectionner de nouveau une taille et d\'uploader une nouvelle image','danger');

   
}

if (isset($_GET['id'])){
$data = getProductById($_GET['id']);}
// $url = mb_substr($data['photo'],strpos($data['photo'],"inc"),null,'UTF-8');}

$title = "Créer article";

require_once '../inc/haut.inc.php';?>



<div class="row my-4">
    <h1 class="text-center"><?= $_GET['action'] == 'modif' ? "Modification produit n°$_GET[id]" : "Nouveau produit"  ?>
    </h1>
    <hr>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label" for="reference">Reference</label>

            <input type="text" id="reference" name="reference" placeholder="Référence de l'article" class="form-control"
                value="<?= ($_GET['action'] == 'modif') ? $data['reference'] : ((!empty($_POST['reference'])) ? $_POST['reference'] : '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label" for="categorie">Catégorie</label>

            <input type="text" id="categorie" name="categorie" placeholder="Catégorie" class="form-control"
                value="<?= ($_GET['action'] == 'modif') ? $data['categorie'] : ((!empty($_POST['categorie'])) ? $_POST['categorie'] : '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label" for="titre">Titre</label>
            <input type="text" id="titre" name="titre" placeholder="Titre" class="form-control"
                value="<?= ($_GET['action'] == 'modif') ? $data['titre'] : ((!empty($_POST['categorie'])) ? $_POST['titre'] : '' )?>">
        </div>
        <div class="mb-3">
            <label class="form-label" for="description">Description de l'article</label>
            <textarea id="description" name="description" class="form-control" rows="10"
                col="30"><?= ($_GET['action'] == 'modif') ? $data['description'] : ((!empty($_POST['categorie'])) ? $_POST['description'] : '')?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label" for="couleur">Couleur</label>
            <input type="text" id="couleur" name="couleur" placeholder="Couleur" class="form-control"
                value="<?= ($_GET['action'] == 'modif') ? $data['couleur'] : ((!empty($_POST['categorie'])) ? $_POST['couleur'] : '')?>">
        </div>
        <div class="mb-3">
            <label class="form-label" for="taille">Taille</label>
            <select class="form-select" id="taille" name="taille">
                <option value="">--Choisissez une taille--</option>
                <option value="xs" <?php if($_GET['action'] == 'modif' && $data['taille'] == 'xs') { ?> selected
                    <?php } ?>>XS</option>
                <option value="s" <?php if($_GET['action'] == 'modif' && $data['taille'] == 's') { ?> selected
                    <?php } ?>>S</option>
                <option value="m" <?php if($_GET['action'] == 'modif' && $data['taille'] == 'm') { ?> selected
                    <?php } ?>>M</option>
                <option value="l" <?php if($_GET['action'] == 'modif' && $data['taille'] == 'l') { ?> selected
                    <?php } ?>>L</option>
                <option value="xl" <?php if($_GET['action'] == 'modif' && $data['taille'] == 'xl') { ?> selected
                    <?php } ?>>XL</option>
                <option value="xxl" <?php if($_GET['action'] == 'modif' && $data['taille'] == 'xxl') { ?> selected
                    <?php } ?>>XXL</option>
            </select>
        </div>
        <div class="mb-3 form-check form-check-inline ">
            <label class="form-label" for="m">Homme</label>
            <input class="form-check-input form-control" type="radio" id="m" name="public" value="m"
                <?php if(($_GET['action'] == 'modif' && $data['public'] == 'm') || ($_GET['action'] == 'add')) {  ?>checked
                <?php } ?>>

        </div>
        <div class="mb-3 form-check form-check-inline">
            <label class="form-label" for="f">Femme</label>
            <input class="form-check-input form-control" type="radio" id="f" name="public" value="f"
                <?php if($_GET['action'] == 'modif' && $data['public'] == 'f') { ?> checked <?php } ?>>

        </div>
        <div class="mb-3 form-check form-check-inline">
            <label class="form-label" for="mixte">Mixte</label>
            <input class="form-check-input form-control" type="radio" id="mixte" name="public" value="mixte"
                <?php if($_GET['action'] == 'modif' && $data['public'] == 'mixte') { ?> checked <?php }?>>

        </div>
        <div class="mb-3">
            <label class="form-label" for="photo">Photo : Sélectionnez de nouveau une photo</label>
            <input class="form-control" type="file" name="photo" id="photo">
        </div>
        <div class="mb-3">
            <label class="form-label" for="prix">Prix</label>
            <input type="number" id="prix" name="prix" placeholder="4.96" class="form-control" step=".01"
                value="<?= ($_GET['action'] == 'modif') ? floatval($data['prix']) : ((!empty($_POST['categorie'])) ? $_POST['prix'] : '')?>">
        </div>
        <div class="mb-3">
            <label class="form-label" for="stock">Stock</label>
            <input type="number" id="stock" name="stock" placeholder="10" class="form-control"
                value="<?= ($_GET['action'] == 'modif') ? floatval($data['stock']) : ((!empty($_POST['categorie'])) ? $_POST['stock'] : '') ?>">
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </form>
</div>


<?php


} else {
    header('location:/site/');

}
require_once '../inc/bas.inc.php';