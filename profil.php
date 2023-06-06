<?php
session_start();
include "bdd.php";

if(isset($_SESSION['idUtilisateur'])){
    $requete = $bdd->prepare('SELECT * FROM utilisateurs WHERE idUtilisateur = "'.$_SESSION['idUtilisateur'].'"');
    $requete->execute();
    $reponse = $requete->fetch(PDO::FETCH_ASSOC);

    $requeteFav = $bdd->prepare('SELECT favoris.idManga,mangas.nomMan FROM favoris INNER JOIN mangas ON favoris.idManga = mangas.idManga WHERE favoris.idUtilisateur = "'.$_SESSION['idUtilisateur'].'"');
    $requeteFav->execute();


    $requeteAdmin = $bdd->prepare('SELECT COUNT(idUtilisateur) FROM utilisateurs WHERE admin = 1 AND idUtilisateur = "'.$_SESSION['idUtilisateur'].'"');
    $requeteAdmin->execute();
    $reponseAdmin = $requeteAdmin->fetch(PDO::FETCH_COLUMN);

    $_SESSION['admin'] = $reponseAdmin;

?>
<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Anime">
    <meta name="keywords" content="Anime, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="./img/favicon.png">
    <title>Anime | MangaWorld</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/profil.css" type="text/css">
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/plyr.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>


    <!-- Header Section Begin -->
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="header__logo">
                        <a href="./index.php">
                            <img src="img/logo.png" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="header__nav">
                        <nav class="header__menu mobile-menu">
                            <ul>
                                <li><a href="./index.php">ACCUEIL</a></li>
                                <li><a href="./nosmangas.php">NOS MANGAS</a></li>
                                <?php if(isset($_SESSION['idUtilisateur'])) : ?>
                                <?php else : ?>
                                    <li><a href="./signup.php">INSCRIPTION</a></li>
                                <?php endif;?>       
                                <li><a href="./contact.php">CONTACTS</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="header__right">
                        <a href="#" class="search-switch"><span class="icon_search"></span></a>
                        <?php if(isset($_SESSION['idUtilisateur'])) : ?>
                            <a href="./profil.php"><span class="icon_profile"></span></a>
                        <?php else : ?>
                                <a href="./login.php"><span class="icon_profile"></span></a>
                        <?php endif; ?>        
                        <span><div class="user-widget">
                        <?php if(isset($_SESSION['idUtilisateur'])) : ?>
                            <a href="./logout.php">Se déconnecter ? Utilisateur : <i style="color: red"><?php print_r($reponse['pseudo'])  ?></i> </a>
                        <?php else : ?>
                            <a href="./login.php">Se connecter</a>
                        <?php endif; ?>
                        </div></span>
                    </div>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>

    <body>
    <div class="container mt-4 mb-4 p-3 d-flex justify-content-center"> 
        <div class="card p-4"> 
            <div class=" image d-flex flex-column justify-content-center align-items-center"> 
                <button class="btn btn-secondary"> <img src="<?php print_r($reponse["avatar"]);?>" height="100" width="100" />
                </button> 
                <span class="idd">@<?php print_r($reponse["pseudo"]);?></span> 
            <div class="d-flex flex-row justify-content-center align-items-center mt-3"> 
            </div> 
            <!-- <div class=" d-flex mt-2"> 
                <button class="btn1 btn-dark">EDITER PROFIL</button> 
            </div>  -->
            <span>MANGAS FAVORIS :</span>
            <div class="d-flex mt-2"> 
                <ul>
                <?php while($reponseFav = $requeteFav->fetch(PDO::FETCH_ASSOC)){ ?>
                <li><a href="manga-details.php?<?php print_r($reponseFav["idManga"]); ?>"><?php print_r($reponseFav["nomMan"]); ?></a></li>
            <?php } ?>
                </ul>    
        </div> 
        <div class=" px-2 rounded mt-4 date "> 
                <span class="join">Joined <?php print_r($reponse["dateCreation"]);?></span> 
            </div> 
        <?php if($reponseAdmin == true) : ?>
            <div class=" d-flex mt-2"> 
                </div> 
                    <button class="btn1 btn-dark" value=".admin.php" onclick="self.location.href='./admin.php'" onclick>PAGE ADMIN</button>   
                </div> 
                <?php else : ?>
                <?php endif;?>   
    </div>
</div>
    </body>
<?php } ?>
</html>