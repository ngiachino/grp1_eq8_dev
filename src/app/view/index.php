<?php

include 'database/DBconnect.php';
include 'app/management/loginManagement.php';
include 'app/management/registerManagement.php';
session_start();
session_unset();
startConnexion();
startRegister();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/main.css">
    <link href="assets/css/navbar.css" rel="stylesheet">
    <title>Mon profil - GoProject</title>
    <link href="assets/css/index.css" rel="stylesheet">
</head>

<body>
<div class = "menuBar">
    <span id="title">GoProject</span>
</div>

<h1>Bienvenue</h1>

<div class="container">
    <div class="row justify-content-around">
        <div class="col-sm-5 logInscBox">
            <form class="form-container" method = "POST" id="formCo">
                <h2>Connexion</h2>
                <div>
                    <label for="nameCo">Email ou Pseudo</label>
                    <input class="form-control" type="text" name="nameCo" id="nameCo" required>
                </div>
                <div>
                    <label for="pswdCo">Mot de passe</label>
                    <input class="form-control" type="password" name="pswdCo" id="pswdCo" required>
                </div>
                <div>
                    <input class="mt-4 btn btn-primary btn-block" type="submit" name="submitCo" value = "Se connecter">
                </div>
            </form>
        </div>
        

        <div class="col-sm-5 logInscBox">
            <form class="form-container" method = "POST" id="formInsc">
                <h2>Inscription</h2>
                <div>
                    <label for="pseudoInsc">Pseudo</label>
                    <input class="form-control" type="text" name="pseudoInsc" pattern="[A-Za-z0-9]*" title="Seuls les caractères alphanumériques sont autorisés" id="pseudoInsc">
                </div>
                <div>
                    <label for="mailInsc">Email</label>
                    <input class="form-control" type="email" name="mailInsc" id="mailInsc">
                </div>
                <div>
                    <label for="pswdInsc">Mot de passe</label>
                    <input class="form-control" type="password" name="pswdInsc" id="pswdInsc">
                </div>
                <div>
                    <label for="pswdConfirmInsc">Confirmer mot de passe</label>
                    <input class="form-control" type="password" name="pswdConfirmInsc" id="pswdConfirmInsc">
                </div>
                <div>
                    <input class="mt-4 btn btn-primary btn-block" type="submit" name="submitInsc" value="S'inscrire">
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
