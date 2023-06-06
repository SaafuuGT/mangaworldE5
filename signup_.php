<?php
session_start();
include "bdd.php";

if(isset($_SESSION['id'])){
    header('Location: ./index.php');
    exit;
}
    if (isset($_POST['inscription'])){
        if(!empty($_POST['email']) && !empty($_POST['mdp'])){
            $pseudo=htmlspecialchars($_POST['pseudo']);
            $email=htmlspecialchars($_POST['email']);
            $mdp=htmlspecialchars($_POST['mdp']);
            $avatar=htmlspecialchars($_POST['avatar']);

            $sel = "ce444a5ae47c6c2ce727685e94dec90fbb7ee0821200a907aa48530a";

            $mdpSHA2 = hash("sha224", $mdp);
            $passwordCONCAT = $sel . $mdp;
            $mdp = hash("sha224", $passwordCONCAT);



            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                header("Location: signup.php");
                echo "L'adresse e-mail est INVALIDE";

            }
            else {

                $target_dir = "./img/userPFP";
                $avatar = $target_dir . $_POST["title"] . "_" . basename($_FILES["includedFile"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($avatar,PATHINFO_EXTENSION));
                // Check if image file is a actual image or fake image
                if(isset($_POST["submit"])) {
                  $check = getimagesize($_FILES["includedFile"]["tmp_name"]);
                  if($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                  } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                  }
                }
                if($uploadOk == 1){
                    move_uploaded_file($_FILES["includedFile"]["tmp_name"], $avatar);
                }   

                $insertUser=$bdd->prepare("INSERT INTO utilisateurs (pseudo, email, mdp, avatar, dateCreation) VALUES (?, ?, ?, ?, CURDATE())");
                $insertUser->bindParam(1, $pseudo);
                $insertUser->bindParam(2, $email);
                $insertUser->bindParam(3, $mdp);
                $insertUser->bindParam(4, $avatar);
                $insertUser->execute();
                header("location:./index.php");
            }

        }
        else{
            header("Location: signup.php");
        }

    } 


?>
