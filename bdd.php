<?php
$hote = 'mysql-mangaworld.alwaysdata.net';
$utilisateur = '289768';
$mdp = '?????';
$nombdd = 'mangaworld_bdd';
$bdd = new PDO("mysql:host=$hote;dbname=$nombdd", $utilisateur, $mdp);
?>
