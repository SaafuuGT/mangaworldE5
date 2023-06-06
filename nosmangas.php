<?php
session_start();
include "bdd.php";


if(isset($_SESSION['idUtilisateur'])){
    $requete = $bdd->prepare('SELECT * FROM utilisateurs WHERE idUtilisateur = "'.$_SESSION['idUtilisateur'].'"');
    $requete->execute();
    $reponse = $requete->fetch(PDO::FETCH_ASSOC);
} 


$requeteManga = $bdd->prepare('SELECT * FROM mangas INNER JOIN favoris ON mangas.idManga = favoris.idManga GROUP by mangas.nomMan ORDER BY mangas.nomMan ASC;');
$requeteManga->execute(); 


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
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/plyr.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>
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
                                <li class="active"><a href="./nosmangas.php">NOS MANGAS</a></li>
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
                        <!-- <a href="#" class="search-switch"><span class="icon_search"></span></a> -->
                        <?php if(isset($_SESSION['idUtilisateur'])) : ?>
                            <a href="./profil.php"><span class="icon_profile"></span></a>
                        <?php else : ?>
                                <!-- <a href="./login.php"><span class="icon_profile"></span></a> -->
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
    <!-- Header End -->

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="./index.php"><i class="fa fa-home"></i> Accueil</a>
                        <a href="./nosmangas.php">Nos Mangas</a>
                        <span>SHONEN</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Product Section Begin -->
    <section class="product-page spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="product__page__content">
                        <div class="product__page__title">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-6">
                                    <div class="section-title">
                                        <h4>SHONEN</h4>
                                    </div>
                                </div>
                                <!-- <div class="col-lg-4 col-md-4 col-sm-6">
                                    <div class="product__page__filter">
                                        <p>Trier par:</p>
                                        <select>
                                            <option value="">A-Z</option>
                                            <option value="">1-10</option>
                                        </select>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                        <div class="row">
                        <?php
                        while($reponseManga = $requeteManga->fetch(PDO::FETCH_ASSOC)){ ?> 
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                <a href="manga-details.php?<?php print_r($reponseManga["idManga"])?>">
                                        <div class="product__item__pic set-bg" data-setbg="<?php echo $reponseManga["pagePrincipale"] ?>">
                                        <div class="ep">18 / 18</div>
                                        <div class="comment"><i class="fa fa-comments"></i> 11</div>
                                        <div class="view"><i class="fa fa-heart"></i> <?php print_r($reponseNbLikes); ?></div>
                                </div>
                                    <div class="product__item__text">
                                        <ul>
                                            <li>Active</li>
                                            <li>Movie</li>
                                        </ul>
                                        <h5><a onclick="setManga()" href="./manga-details.php?<?php print_r($reponseManga["idManga"]) ?>"><?php print_r($reponseManga["nomMan"])  ?></a></h5>
                                    </div>
                                </div>
                            </div>
                            </a>
                            <?php 
                            }?>     
                        </div>          
                    </div>
                    <div class="product__pagination">
                        <a href="#" class="current-page">1</a>
                        <a href="#">2</a>
                        <a href="#">3</a>
                        <a href="#">4</a>
                        <a href="#">5</a>
                        <a href="#"><i class="fa fa-angle-double-right"></i></a>
                    </div>
                </div>

<!-- Search model end -->

<!-- Js Plugins -->
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/player.js"></script>
<script src="js/jquery.nice-select.min.js"></script>
<script src="js/mixitup.min.js"></script>
<script src="js/jquery.slicknav.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/main.js"></script>

</body>

</html>