<?php

require_once '../inc/init.inc.php';

if(isAdmin()){


    if(isset($_GET['action']) && $_GET['action'] == 'valider' && isset($_GET['id'])){
        $stockData = getStockFromId($_GET['id']);
      
        foreach($stockData as $stock){
            $quantity = getQuantityById($_GET['id'],$stock['id_produit']);
         
           if($quantity<=$stock['stock']){
                $newStock = $stock['stock'] - $quantity;
                sessionStock($stock['id_produit'],$newStock);   
           } 
        }
        if (isset($_SESSION['commande']) && count($_SESSION['commande']) == count($stockData)){
            foreach($_SESSION['commande'] as $id => $newStock){
                sql("UPDATE produit SET stock = :newStock WHERE id_produit = :id_produit", array(
                    'newStock' => $newStock,
                    'id_produit' => $id
                ));
                sql("UPDATE commande SET etat = :etat WHERE id_commande = :id_commande", array(
                    'etat' => 'envoyé',
                    'id_commande' => $_GET['id']
                ));
                
            }
            addMessage('Commande n°'. $_GET['id'] .' validée avec succès, stock mis à jour','success');
        } else {
            addMessage('Commande non validée. Les stocks sont trop faibles','danger');
        }
       
        unset($_SESSION['commande']);
    }

    if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])){
        sql("DELETE FROM commande WHERE id_commande = :id", array(
            'id' => $_GET['id']
        ));
        addMessage('Commande n°'.$_GET['id'].' supprimée','info');
    }

    if(isset($_GET['action']) && $_GET['action'] == 'livraison' && isset($_GET['id'])){
        sql("UPDATE commande SET etat = :etat WHERE id_commande = :id_commande", array(
            'etat' => 'livré',
            'id_commande' => $_GET['id']
        ));
        addMessage('Commande n°'. $_GET['id'] .' livrée avec succès','success');

    }


    $orders = getAllNewOrders();

    $oldOrders = getOldOrders();

$title = "Gestion Commande";

require_once '../inc/haut.inc.php';



?>

<h2 class="text-center">Gestion des commandes en cours</h2>
<hr>
<?php 

foreach($orders as $order){

    ?>
<hr>
<h3>Commande N°<?= $order['id_commande'] ?> -- <?= $order['etat'] ?></h3>
<p><?= $order['date_enregistrement'] ?></p>
<hr>
<?php

   $details = getOrderDetails($order['id_commande']);
   foreach($details as $detail){
?>
<div class="row mx-auto my-3">
    <div class="col-2">x<?= $detail['quantite'] ?> - <?= $detail['titre'] ?></div>
    <div class="col-2"><?= sprintf('%.2f',$detail['prix'])  ?> €</div>
</div>

<?php if($order['etat'] == 'en cours de traitement'){?>
<p>Stock restant : <?= $detail['stock']  ?></p>
<hr>

<?php
}
}
?>
<?php if($order['etat'] == 'en cours de traitement'){
        
      ?>
<div class="text-center">

    <a href="?action=valider&id=<?= $order['id_commande'] ?>"><button class="btn btn-primary mx-2">Valider la
            commande</button></a>
    <a href="?action=delete&id=<?= $order['id_commande'] ?>"><button class="btn btn-danger mx-2">Refuser la
            commande</button></a>
</div>
<?php  } else if ($order['etat'] == 'envoyé') { ?>
<div class="text-center">
    <hr>
    <a href="?action=livraison&id=<?= $order['id_commande'] ?>"><button class="btn btn-success">Valider la
            réception</button></a>
</div>


<?php } ?>

<hr>
<?php
}
?>


<hr>
<h2 class="text-center">Commandes livrées</h2>
<?php

foreach($oldOrders as $old){

    ?>
<h3>Commande N°<?= $old['id_commande'] ?> -- <?= $old['etat'] ?></h3>
<p><?= $old['date_enregistrement'] ?></p>



<?php
   
   $oldDetails = getOrderDetails($old['id_commande']);
   foreach($oldDetails as $oldDetail){
    ?>
<div class="row mx-auto my-3">
    <div class="col-2">x<?= $oldDetail['quantite'] ?> - <?= $oldDetail['titre'] ?></div>
    <div class="col-2"><?= sprintf('%.2f',$oldDetail['prix'])  ?> €</div>
</div>

<?php

}
?>
<hr>
<?php
}

?>

<?php

} else {
    header('location:/site/');
}
require_once '../inc/bas.inc.php';