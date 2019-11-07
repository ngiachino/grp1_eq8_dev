<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Mon profil - GoProject</title>
    <link href="index.css" rel="stylesheet">
    <script src="profil.js" defer></script>
</head>

<body>
<div class = "menuBar">
    <span id="title">GoProject</span>
</div>

<h1>Bienvenue</h1>

<div class="supercontainer">
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
            <button type="submit">Se connecter</button>
        </div>
    </div>

    <div class="container">
        <h2>Inscription</h2>
        <div>
            <label for="mailInsc">Email</label>
            <input type="email" name="mailInsc" id="mailInsc">
        </div>
        <div>
            <label for="pseudoInsc">Pseudo</label>
            <input type="text" name="pseudoInsc" id="pseudoInsc">
        </div>
        <div>
            <label for="pswdInsc">Mot de passe</label>
            <input type="password" name="pswdInsc" id="pswdInsc">
        </div>
        <div>
            <label for="pswdConfirmInsc">Mot de passe</label>
            <input type="password" name="pswdConfirmInsc" id="pswdConfirmInsc">
        </div>
        <div>
            <button type="submit">S'inscrire</button>
        </div>
    </div>
</div>


</body>
</html>