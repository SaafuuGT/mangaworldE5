<?php
session_start();

if(isset($_SESSION['id'])){
    header('Location: ./index.php');
    exit;
}
if(isset($_POST['email']) && isset($_POST['mdp'])) {
    // connexion à la base de données
    $hote = 'mysql-mangaworld.alwaysdata.net';
    $utilisateur = '289768';
    $mdp = 'SaafuuDesu123';
    $nombdd = 'mangaworld_bdd';
    $db = mysqli_connect($hote, $utilisateur, $mdp, $nombdd)
    or die('could not connect to database');
    
    // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
    // pour éliminer toute attaque de type injection SQL et XSS
    $email = mysqli_real_escape_string($db,htmlspecialchars($_POST['email'])); 
    $mdp = mysqli_real_escape_string($db,htmlspecialchars($_POST['mdp']));
    $sel = "ce444a5ae47c6c2ce727685e94dec90fbb7ee0821200a907aa48530a";

    $mdpSHA2 = hash("sha224", $mdp);
    $passwordCONCAT = $sel . $mdp;
    $mdpHash = hash("sha224", $passwordCONCAT);



 
 if($email !== "" && $mdp !== "") {
 
    $requete = "SELECT count(*), idUtilisateur FROM utilisateurs where email = '".$email."' and mdp = '".$mdpHash."' ";
    $exec_requete = mysqli_query($db,$requete);
    $reponse = mysqli_fetch_array($exec_requete);
    $count = $reponse['count(*)'];
    {
    if($count!=0) // nom d'utilisateur et mot de passe correctes
    {
        $_SESSION['email'] = $email;
        $_SESSION['idUtilisateur'] = $reponse['idUtilisateur'];
        $_SESSION['mdp'] = $motdepasse;


        header('Location: index.php');
        //header('Location: accueil.php');
    }

    else
    {
        header('Location: login.php?erreur=1'); // utilisateur ou mot de passe incorrect
    }
 } 
}
else
{
    header('Location: login.php?erreur=1');
    }
}
?>
