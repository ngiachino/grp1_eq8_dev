<?php

include '../database/DBconnect.php';
include './login.php';
include './register.php';
session_start();
session_unset();
connexion();
register();
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

<div class="container">
    <div class="row justify-content-around">
        <div class="col-sm-5">
            <form class="form-container" method = "POST" id="formCo">
                <h2>Connexion</h2>
                <div>
                    <label for="nameCo">Email ou Pseudo</label>
                    <input type="text" name="nameCo" id="nameCo" required>
                </div>
                <div>
                    <label for="pswdCo">Mot de passe</label>
                    <input type="password" name="pswdCo" id="pswdCo" required>
                </div>
                <div>
                    <input class="mt-4" type="submit" name="submitCo" value = "Se connecter">
                </div>
            </form>
        </div>
        

        <div class="col-sm-5">
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
                    <input class="mt-4" type="submit" name="submitInsc" value="S'inscrire">
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>