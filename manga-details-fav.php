<?php
session_start();
include "bdd.php";
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
$url = "https"; 
else
$url = "http"; 
// Ajoutez // à l'URL.
$url .= "://"; 
// Ajoutez l'hôte (nom de domaine, ip) à l'URL.
$url .= $_SERVER['HTTP_HOST']; 
// Ajouter l'emplacement de la ressource demandée à l'URL
$url .= $_SERVER['REQUEST_URI']; 
// Afficher l'URL
$idSearch = substr($url, -1);

$idUser = $_SESSION['idUtilisateur'];



if(isset($_SESSION['idUtilisateur']) && $_SESSION['favcheck'] == false){
    //$idSearch = '<script type="text/javascript">document.write(UrlId);</script>';
    $requeteFav = $bdd->prepare("INSERT INTO favoris (idManga,idUtilisateur) VALUES ($idSearch,$idUser)");
    $requeteFav->execute();
    $reponseFav = $requeteFav->fetch(PDO::FETCH_ASSOC);

    header("Location: ./manga-details.php?".$idSearch);
    
} elseif(isset($_SESSION['idUtilisateur']) && $_SESSION['favcheck'] == true){
    $requeteRemFav = $bdd->prepare("DELETE FROM favoris WHERE idUtilisateur = $idUser AND idManga=$idSearch");
    $requeteRemFav->execute();
    $reponseRemFav = $requeteRemFav->fetch(PDO::FETCH_ASSOC);
    header("Location: ./manga-details.php?".$idSearch);


}
