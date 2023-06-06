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

//TRUCS IMPORTANTS
$idSearch = substr($url, -3, 1);
$idChap = substr($url, -1);

$urlChap = substr($url, 0, -1);
//var_dump($urlChap);

if(isset($_SESSION['idUtilisateur'])){
    $requete = $bdd->prepare('SELECT * FROM utilisateurs WHERE idUtilisateur = "'.$_SESSION['idUtilisateur'].'"');
    $requete->execute();
    $reponse = $requete->fetch(PDO::FETCH_ASSOC);
} 

    //$idSearch = '<script type="text/javascript">document.write(UrlId);</script>';
    $requeteManga = $bdd->prepare('SELECT * FROM mangas WHERE idManga='.$idSearch);
    $requeteManga->execute(); 
    $reponseManga = $requeteManga->fetch(PDO::FETCH_ASSOC);

    //requete chap
    $requeteChap = $bdd->prepare('SELECT DISTINCT numChap,nomChap FROM chapitre INNER JOIN mangas ON chapitre.idManga = mangas.idManga 
    WHERE mangas.idManga ='.$idSearch);
    $requeteChap->execute(); 
    

    //TEST;
    $requetePages = $bdd->prepare('SELECT chemPage FROM mangas INNER JOIN chapitre ON mangas.idManga = chapitre.idManga 
    INNER JOIN pages ON pages.idChapitre = chapitre.idChapitre WHERE mangas.idManga ='.$idSearch.' AND chapitre.numChap ='.$idChap);
    $requetePages->execute(); 
    $reponsePages = $requetePages->fetch(PDO::FETCH_ASSOC);
    
    //$requeteManga = $bdd->prepare('SELECT * FROM mangas WHERE idManga = "'.$idSearch.'"');?>

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
    <link rel="stylesheet" href="css/slider.css" type="text/css">

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
    <!-- Header End -->

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="./nosmangas.php"><i class="fa fa-home"></i> Nos mangas</a>
                        <a href="./manga-details.php?<?php print_r($reponseManga["idManga"]) ?>">Détails</a>
                        <a href="#">SHONEN</a>
                        <span><?php print_r($reponseManga['nomMan'])  ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!-- Breadcrumb End -->

    <!-- Anime Section Begin -->

    <div id="wrapper">
   
   <h1>CHAPITRE N°<?php print_r($idChap) ?> </h1>  
   <div id="slider-wrap">
      <ul id="slider">
      <li>
         <img src="<?php print_r($reponsePages['chemPage'])?>">          
         <i class="fa fa-image"></i>
       </li>   
      <?php while($reponsePages = $requetePages->fetch(PDO::FETCH_ASSOC)){ ?> 
    <img src="<?php print_r($reponsePages['chemPage'])  ?>">
    <li>
         <img src="<?php print_r($reponsePages['chemPage'])?>">          
         <i class="fa fa-image"></i>
    <?php }
    ?>
       </li>   
    </ul>
    
     <!--controls-->
    <div class="btns" id="next"><i class="fa fa-arrow-right"></i></div>
    <div class="btns" id="previous"><i class="fa fa-arrow-left"></i></div>
    <div id="counter"></div>
    <div id="pagination-wrap">
      <ul>
      </ul>
    </div>
    <!--controls-->         
</div>
</div>
 

    <!-- <div class="container">
    <div class="slider">
    <img class="active" src="<?php //print_r($reponsePages['chemPage'])  ?>">
    <?php //while($reponsePages = $requetePages->fetch(PDO::FETCH_ASSOC)){ ?> 
    <img src="<?php //print_r($reponsePages['chemPage'])  ?>">
    <?php //}
    ?>
    </div>
    <div class="cont-btn">
    <div class="btn-nav left">←</div>
    <div class="btn-nav right">→</div>
    </div>
    </div> -->
<div class="anime__details__episodes">
                        <div class="section-title">
                            <h5>CHANGER DE CHAPITRE</h5>
                        </div>
                        <select name="chapitre" onchange="location = this.value;">
                        <?php while($reponseChap = $requeteChap->fetch(PDO::FETCH_ASSOC)){ ?> 
                        <option value="<?php print_r($urlChap.$reponseChap["numChap"])?>">Ch n°<?php print_r($reponseChap["numChap"]);?></option>
                    <?php } ?>
                        </select>
         </div>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-lg-8">
                    <div class="anime__details__review">
                        <div class="section-title">
                            <h5>Reviews</h5>
                        </div>
                        <div class="anime__review__item">
                            <div class="anime__review__item__pic">
                                <img src="img/anime/review-1.jpg" alt="">
                            </div>
                            <div class="anime__review__item__text">
                                <h6>Chris Curry - <span>1 Hour ago</span></h6>
                                <p>whachikan Just noticed that someone categorized this as belonging to the genre
                                "demons" LOL</p>
                            </div>
                        </div>
                        <div class="anime__review__item">
                            <div class="anime__review__item__pic">
                                <img src="img/anime/review-2.jpg" alt="">
                            </div>
                            <div class="anime__review__item__text">
                                <h6>Lewis Mann - <span>5 Hour ago</span></h6>
                                <p>Finally it came out ages ago</p>
                            </div>
                        </div>
                        <div class="anime__review__item">
                            <div class="anime__review__item__pic">
                                <img src="img/anime/review-3.jpg" alt="">
                            </div>
                            <div class="anime__review__item__text">
                                <h6>Louis Tyler - <span>20 Hour ago</span></h6>
                                <p>Where is the episode 15 ? Slow update! Tch</p>
                            </div>
                        </div>
                        <div class="anime__review__item">
                            <div class="anime__review__item__pic">
                                <img src="img/anime/review-4.jpg" alt="">
                            </div>
                            <div class="anime__review__item__text">
                                <h6>Chris Curry - <span>1 Hour ago</span></h6>
                                <p>whachikan Just noticed that someone categorized this as belonging to the genre
                                "demons" LOL</p>
                            </div>
                        </div>
                        <div class="anime__review__item">
                            <div class="anime__review__item__pic">
                                <img src="img/anime/review-5.jpg" alt="">
                            </div>
                            <div class="anime__review__item__text">
                                <h6>Lewis Mann - <span>5 Hour ago</span></h6>
                                <p>Finally it came out ages ago</p>
                            </div>
                        </div>
                        <div class="anime__review__item">
                            <div class="anime__review__item__pic">
                                <img src="img/anime/review-6.jpg" alt="">
                            </div>
                            <div class="anime__review__item__text">
                                <h6>Louis Tyler - <span>20 Hour ago</span></h6>
                                <p>Where is the episode 15 ? Slow update! Tch</p>
                            </div>
                        </div>
                    </div>
                    <div class="anime__details__form">
                        <div class="section-title">
                            <h5>Your Comment</h5>
                        </div>
                        <form action="#">
                            <textarea placeholder="Your Comment"></textarea>
                            <button type="submit"><i class="fa fa-location-arrow"></i> Review</button>
                        </form>
                    </div>
                </div>
            </div>
        </div> -->
    </section>
    <!-- Anime Section End -->


      <!-- Footer Section End -->
      <?php include "footer.php"; ?>
      <!-- Search model Begin -->
      <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch"><i class="icon_close"></i></div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
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
    <script src="js/slider.js"></script>
    
</body>

</html>