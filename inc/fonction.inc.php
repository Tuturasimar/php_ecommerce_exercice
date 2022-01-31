<?php

// Fonction pour protéger des injections

function sql($req, $params = array())
{
    global $pdo;
    $statement = $pdo->prepare($req);

    if (!empty($params)){
        foreach ($params as $key => $value){
            $statement->bindValue($key, $value,PDO::PARAM_STR);
        } 
    }
    
    $statement->execute();
    return $statement;
}

// Fonction de connection / admin

function isConnected(){
    return isset($_SESSION['user']);
}

function isAdmin(){
   if ($_SESSION['user']['statut'] == 1 ){
       return true;
   } else {
       return false;
   }
}

// Fonctions table MEMBRE

function getUserByPseudo ($pseudo)
{
    $rep = sql("SELECT * FROM membre WHERE pseudo = :pseudo", array(
        'pseudo' => $pseudo));

    if($rep->rowCount() == 1)
    {
        return $rep->fetch();
    }
    else
    {
        return false;
    }

}

function getAllUser(){
    $rep = sql("SELECT * FROM membre");
    return $rep->fetchAll();
}

function getUserById($id)
{
    $rep = sql("SELECT * FROM membre WHERE id_membre = :id", array(
        'id' => $id
    ));
    if($rep->rowCount() == 1)
    return $rep->fetch();
}

function getStatutById($id)
{
    $rep = sql("SELECT statut FROM membre WHERE id_membre = :id", array(
        'id' => $id
    ));
    $statut = $rep->fetch();
    return $statut['statut'];
}

function getUserFields(){
    $rep = sql("DESC membre");
    return $rep->fetchAll();
}

////////////////////////////////////////

// Fonctions table PRODUIT

function getProductByReference ($ref)
{
    $rep = sql("SELECT * FROM produit WHERE reference = :reference", array(
        'reference' => $ref));

    if($rep->rowCount() == 1)
    {
        return $rep->fetch();
    }
    else
    {
        return false;
    }
}

function getAllProduct(){
    $rep = sql("SELECT * FROM produit");
    return $rep->fetchAll();
}

function getAllTypeOfProduct(){
    $rep = sql("SELECT DISTINCT categorie from produit");
    return $rep->fetchAll();
}

function getProductById($id){
    $rep = sql("SELECT * FROM produit WHERE id_produit = :id", array(
        'id' => $id
    ));
    return $rep->fetch();
}

function getStockFromId($id){
    $rep = sql("SELECT id_produit, titre, stock FROM produit WHERE id_produit IN 
    (SELECT id_produit FROM details_commande WHERE id_commande = :id)",array(
        'id' => $id
    ));
    return $rep->fetchAll();
}

function getPriceById($id){
    $rep = sql("SELECT prix FROM produit WHERE id_produit = :id", array(
        'id' => $id
    ));
    $data = $rep->fetch();
    return $data['prix'];
}

function getImgById($id) {
    $req = sql("SELECT photo FROM produit WHERE id_produit = :id", array(
        'id' => $id
    ));
    return $req->fetch();
}

function getProductFields(){
    $rep = sql("DESC produit");
    return $rep->fetchAll();
}

function deleteProduct($id){
    $data = getProductById(($id));
    $url = $data['photo'];
    unlink($url);
    $req = sql("DELETE FROM produit WHERE id_produit=$id");
}

////////////////////////////////////////

// Filtres de la boutique

function getFiltersTypePrice($type,$num){
    if(!is_array($num)){
    $rep = sql("SELECT * FROM produit WHERE categorie = :categorie AND prix > :prix ", array(
        'categorie' => $type,
        'prix' => $num
       ));
    
    return $rep->fetchAll();

    } else {
        $rep = sql("SELECT * FROM produit WHERE categorie = :categorie AND prix BETWEEN :num1 AND :num2", array(
            'categorie' => $type,
            'num1' => $num[0],
            'num2' => $num[1]
        ));
    return $rep -> fetchAll();
    }
}

function getFiltersType($type){
    $rep = sql("SELECT * FROM produit WHERE categorie = :categorie",array(
        'categorie' => $type
    ));
    return $rep->fetchAll();
}

function getFiltersPrice($num){
    if(!is_array($num)){
        $rep = sql("SELECT * FROM produit WHERE prix > :prix ", array(
            'prix' => $num
           ));
        
        return $rep->fetchAll();
    
        } else {
            $rep = sql("SELECT * FROM produit WHERE prix BETWEEN :num1 AND :num2", array(
                'num1' => $num[0],
                'num2' => $num[1]
            ));
        return $rep -> fetchAll();
        }
}


////////////////////////////////////////

// Fonctions table COMMANDE

function getOrderByMemberId($id){
    $rep = sql("SELECT *, DATE_FORMAT(date_enregistrement, '%d/%m/%Y à %H:%i:%s') as date_fr FROM commande WHERE id_membre IN (:id) ORDER BY etat",array(
        'id' => $id
    ));
    return $rep->fetchAll();
}

function getAllNewOrders(){
    $rep = sql("SELECT * FROM commande WHERE etat NOT IN (:etat) ORDER BY etat", array(
        'etat' => 'livré'
    ));
    return $rep->fetchAll();
}

function getOldOrders(){
    $rep = sql("SELECT * FROM commande WHERE etat IN (:etat)",array(
        'etat' => 'livré'
    ));
    return $rep->fetchAll();
}

////////////////////////////////////////

// Fonctions JOIN


function getOrderDetails($id){
    $rep = sql("SELECT c.id_commande, p.titre, d.quantite, d.prix, p.stock
    FROM details_commande d
    LEFT JOIN produit p ON d.id_produit = p.id_produit
    LEFT JOIN commande c ON c.id_commande = d.id_commande
    WHERE d.id_commande IN (:id) ", array(
        'id' => $id
    )
    );
    return $rep->fetchAll();
}

function getQuantityById($id_commande,$id_produit){
    $rep = sql("SELECT quantite FROM details_commande WHERE id_commande = :id_commande AND id_produit = :id_produit", array(
        'id_commande' => $id_commande,
        'id_produit' => $id_produit
    ));
    $qte = $rep -> fetch();
    return $qte['quantite'];
}


////////////////////////////////////////

// Fonction sur $_SESSION

function addMessage($message,$classe)
{
    if(!isset($_SESSION['messages'][$classe]))
    {
        $_SESSION['message'][$classe]= array();
    }
    $_SESSION['messages'][$classe][] = $message;
}

function showMessages(){
    $messages = "";

    if(isset($_SESSION['messages']))
    {
        foreach(array_keys($_SESSION['messages']) as $className)
        {
            $messages .= '<div class="alert alert-'.$className.'">'.implode('<br>',$_SESSION['messages'][$className]).'</div>';
        }
    }
    return $messages;
}

function addBasket($id,$quantity){
    if(!isset($_SESSION['user']['panier']))
        {
            $_SESSION['user']['panier'] = array();
        }
        $_SESSION['user']['panier'][$id] =  $quantity ;
}

function sessionStock($id,$stock){
    
    if(!isset($_SESSION['commande']))
    {
        $_SESSION['commande'] = array();
    }
    $_SESSION['commande'][$id] = $stock;
}

function addFilters($filters){
    if(!isset($_SESSION['user']['filters']))
    {
        $_SESSION['user']['filters'] = array();
    }
    $_SESSION['user']['filters'] = $filters;
}


function getLastInsertId(){
    global $pdo;

    $id = $pdo->lastInsertId();

    return $id;
}

////////////////////////////////////////

// Fonctions pour l'image

function saveImg($ext,$temp) {
    $filePath =  __DIR__ .'/img/'.substr(md5(time()),0,10). '.' . $ext;
    move_uploaded_file($temp,$filePath);
    return $filePath;
}

////////////////////////////////////////

// Fontions calculs

function calcPrice($prix,$qte){
    floatval($prix);
    floatval($qte);
    $price = $prix * $qte;
    return $price;
}

function getFinalPrice(){
$data = getAllProduct();
$total = 0;
    if (isset($_SESSION['user']['panier'])){
        foreach($_SESSION['user']['panier'] as $id => $quantity){
        //$message .= "$id  $quantity <br>";  // 9 1  10 4  12 7
            foreach($data as $dataProduct){
                if($id == $dataProduct['id_produit']){
                $total += $dataProduct['prix'] * $quantity;
                }
            }
        }   
    return $total;

    }
    
}

////////////////////////////////////////

// Fonction debug

function debug($var,$mode = 1)
{
    echo '<div style="background: orange;padding: 5px;float: right; clear:both;">';
    $trace = debug_backtrace();
    $trace = array_shift($trace);

    echo "Debug demandé dans le fichier : $trace[file] à la ligne $trace[line].";

    if($mode === 1)
    {
        echo '<pre>' ; print_r($var); echo '</pre>';
    }
    else
    {
        echo '<pre>' ; var_dump($var); echo '</pre>';
    }
    echo '</div>';
}