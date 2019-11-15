<?php

include '../database/DBconnect.php';
$conn = connect();
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include './defaultHead.php'; ?>
    <title>Mon profil - GoProject</title>
    <link href="../assets/css/index.css" rel="stylesheet">
</head>

<body>
<div class = "menuBar">
    <span id="title">GoProject</span>
</div>

<h1>Bienvenue</h1>

<div class="supercontainer">
    <form class="form-container" method = "POST" id="formCo">
    <div class="container">
        <h2>Connexion</h2>
        <div>
            <label for="nameCo">Email ou Pseudo</label>
            <input type="text" name="nameCo" id="nameCo">
        </div>
        <div>
            <label for="pswdCo">Mot de passe</label>
            <input type="password" name="pswdCo" id="pswdCo">
        </div>
        <div>
            <input type="submit" name="submitCo" value = "Se connecter">
        </div>
    </div>

    <div class="container">
    <form class="form-container" method = "POST" id="formInsc">
        <h2>Inscription</h2>
        <div>
            <label for="pseudoInsc">Pseudo</label>
            <input type="text" name="pseudoInsc" id="pseudoInsc">
        </div>
        <div>
            <label for="mailInsc">Email</label>
            <input type="email" name="mailInsc" id="mailInsc">
        </div>
        <div>
            <label for="pswdInsc">Mot de passe</label>
            <input type="password" name="pswdInsc" id="pswdInsc">
        </div>
        <div>
            <label for="pswdConfirmInsc">Confirmer mot de passe</label>
            <input type="password" name="pswdConfirmInsc" id="pswdConfirmInsc">
        </div>
        <div>
            <input type="submit" name="submitInsc" value="S'inscrire">
        </div>
    </form>
    </div>
</div>
<?php
    if(isset($_POST['submitInsc'])){
        $pseudoInsc = $_POST['pseudoInsc'];
        $mailInsc = $_POST['mailInsc'];
        $pswdInsc = $_POST['pswdInsc'];
        $pswdConfirmInsc = $_POST['pswdConfirmInsc'];

        //test que tous les champs sont remplis
        if(empty($pseudoInsc) || empty($mailInsc) || empty($pswdInsc) || empty($pswdConfirmInsc)){
            echo "Vous devez remplir tous les champs";
        }
        //test que les deux mots de passe sont identiques
        else if($pswdInsc != $pswdConfirmInsc){
            echo "Les mots de passe ne sont pas identiques";
        }
        else{

            //test que le mail n'est pas déjà utilisé
            $sqlTest1 = "SELECT ID_USER FROM utilisateur WHERE MAIL_USER = '$mailInsc'";
            $result1 = $conn->query($sqlTest1);

            //test que le pseudo n'est pas déjà utilisé
            $sqlTest2 = "SELECT ID_USER FROM utilisateur WHERE NOM_USER = '$pseudoInsc'";
            $result2 = $conn->query($sqlTest2);

            if(empty($pseudoInsc) || empty($mailInsc) || empty($pswdInsc) || empty($pswdConfirmInsc)){
                echo "Vous devez remplir tous les champs";
            }
            //test que les deux mots de passe sont identiques
            else if($pswdInsc != $pswdConfirmInsc){
                echo "Les mots de passe ne sont pas identiques";
            }
            else if($result1->num_rows > 0){
                echo "Ce mail est déjà associé à un compte";
            }
            else if($result2->num_rows > 0){
                echo "Ce pseudo est déjà associé à un compte";
            }
            else{
                $sql = "INSERT INTO utilisateur (NOM_USER, PASSWORD_USER, MAIL_USER)
                VALUES ('$pseudoInsc','$pswdInsc','$mailInsc')";
                if ($conn->query($sql) === FALSE) {
                    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
                }
                else{
                    echo "Votre compte a bien été crée";
                }
            }
        }
    }
    else if(isset($_POST['submitCo'])){
        $nameCo = $_POST['nameCo'];
        $pswdCo = $_POST['pswdCo'];

        //test que le mail n'est pas déjà utilisé
        $sql = "SELECT ID_USER,NOM_USER FROM utilisateur WHERE (MAIL_USER = '$nameCo' OR NOM_USER = '$nameCo') AND PASSWORD_USER = '$pswdCo'";
        $result = $conn->query($sql);
        if($result === FALSE){
            echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
        }

        else if($result->num_rows == 0){
            echo "Le compte et le mot de passe ne correspondent pas";
        }
        else{
            session_start();
            $data = mysqli_fetch_assoc($result);
            $_SESSION['userName'] = $data['NOM_USER'];
            $_SESSION['userID'] = $data['ID_USER'];
            echo "Vous êtes connecté";
            header("Location:profil.php"); 
        }
    }
  ?>

</body>
</html>