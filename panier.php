<?php

require_once 'inc/init.inc.php';

if(isConnected() && !isAdmin()){

    $dataProduct = getAllProduct();

    if(!isset($_SESSION['user']['panier']) && !isset($_GET['action'])){
        addMessage('Le panier est vide pour le moment, visitez la boutique !','info');
    }

    if(isset($_GET['action']) && ($_GET['action'] == 'ajout') && isset($_GET['id']))
    {
        if(!isset($_SESSION['user']['panier'][$_GET['id']]))
        addBasket($_GET['id'],1);
    }

    if(isset($_GET['action']) && $_GET['action'] == 'delete'){
        unset($_SESSION['user']['panier'][$_GET['id']]);
    }

    if(isset($_GET['action']) && $_GET['action'] == "valider"){
        sql("INSERT INTO commande (id_membre,montant,date_enregistrement) VALUES (:id_membre,:montant,NOW())", array(
            'id_membre' => $_SESSION['user']['id_membre'],
            'montant' => getFinalPrice(),
        ));

        $orderId = getLastInsertId();

        foreach($_SESSION['user']['panier'] as $id => $quantity){
            sql("INSERT INTO details_commande (id_commande,id_produit,quantite,prix) VALUES (:id_commande,:id_produit,:quantite,:prix)", array(
                'id_commande' => $orderId,
                'id_produit' => $id,
                'quantite' => $quantity,
                'prix' => calcPrice(getPriceById($id),$quantity)
            ));
        }
        unset($_SESSION['user']['panier']);
        addMessage('Commande validée avec succès','success');

        header('location:/site/');

    }

   
    
$title = "Panier";

require_once './inc/haut.inc.php';?>

<h2 class="text-center">Panier</h2>

<?php  if(isset($_SESSION['user']['panier'])) { ?>

<form method="post">
    <div class="table-responsive">
        <table class="table text-center">
            <thead>
                <tr>
                    <th scope="col">Produit</th>
                    <th class="col"></th>
                    <th scope="col">Quantité</th>
                    <th class="col"></th>
                    <th class="col"></th>
                    <th scope="col">Prix (€)</th>
                    <th scope="col">Stock</th>
                </tr>
            </thead>
            <tbody>

                <?php 

// echo '<pre>' ;  print_r($dataProduct); echo '</pre>' ;

    if(isset($_SESSION['user']['panier']))
    {?>

                <?php foreach($_SESSION['user']['panier'] as $id => $quantity){
            if(!empty($_POST)){
                foreach($_POST as $key => $value){
                    if ($id == $key)
                    {
                            $_SESSION['user']['panier'][$id] = $value;
                            header('location:panier.php');
                          
                    }
                }
                
            }
            foreach($dataProduct as $data){
                 if($id == $data['id_produit']){ ?>
                <tr class="align-middle">
                    <td class="col-md-2"><?= $data['titre']  ?></td>
                    <td class="col-md-1">
                        <div class="btn btn-primary" id=moins-<?=$id?>>-</div>
                    </td>
                    <td class="col-md-1"><input readonly class="text-center" type="number" name="<?=$id?>" id=<?=$id?>
                            value=<?= $quantity ?>></td>
                    <td class="col-md-1">
                        <div class="btn btn-primary" id=plus-<?=$id?>>+</div>
                    </td>
                    <td><a style="text-decoration:none" href="?action=delete&id=<?=$id?>">❌</a></td>
                    <td class="col-md-2"><?= calcPrice($data['prix'],$quantity)  ?></td>
                    <td class="col-md-2" id="stock-<?=$id?>"><?= $data['stock'] ?></td>
                </tr>
                <?php
                }  
            }       
    //   echo  "ID produit : $id  --- QUANTITE : $quantity <br>";
        }?>
                <?php 
    } ?>
            </tbody>
        </table>


    </div>
    <div class="text-center">
        <input type="submit" value="Mettre à jour les changements" class="btn border btn-warning my-3">
    </div>
    <h4 class="text-center my-4">Prix final du panier : <?= (getFinalPrice()) ?? 0 ?>€</h4>
</form>

<div class="text-center">
    <a href="?action=valider"><button class="btn btn-primary">Valider la commande</button></a>
</div>
<?php
}

} else {
    header('location:connexion.php');
}
require_once './inc/bas.inc.php';