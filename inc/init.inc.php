<?php

// Connexion à la BDD

session_name('SITE_E_COMMERCE');
session_start();



$pdo = new PDO(
    'mysql:host=localhost;charset=utf8;dbname=site','root','root',array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    )
    );

// $mysqli = new mysqli("localhost","root","root","site");

// if($mysqli->connect_error) die ('Un problème est survenu lors de la tentative de connexion à la BDD : '.$mysqli->connect_error);

// $mysqli->set_charset("utf8");

// Session


// Chemin

define("RACINE_SITE","/site/");

// Variables

$contenu = '';

// Autres inclusions

require_once 'fonction.inc.php';