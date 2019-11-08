<?php

$dbserver ='localhost';
$dbuser = 'root';
$password = '';
$dbname = "cdp";

$conn = new mysqli($dbserver, $dbuser, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$query = "SELECT * FROM membre WHERE ID_PROJET = 1";
$result1 = mysqli_query($conn, $query);
?>




<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Mon profil - GoProject</title>
    <link href="projet.css" rel="stylesheet">
    <script src="profil.js" defer></script>
</head>

<body>
<div class = "menuBar">
    <span id="title">GoProject</span>
    <div class="menuBar-right">
        <a class = "disconnect">Se déconnecter</a>
    </div>
</div>

<h1>Nom du projet</h1>

<div class="supercontainer">

    <div class="container">
        <h2>Les issues</h2>
    </div>

    <div class="container">
        <h2>Les tâches</h2>
    </div>

    <div class="container">
        <h2>Les releases</h2>
    </div>

    <div class="container">
        <h2>Les test</h2>
    </div>

    <div class="container">
        <h2>La doc</h2>
    </div>

</div>

<div id="membersList">
    <div class="container">
        <button type="submit">Inviter membre</button>
        Liste des membres

        <ul>
            <?php while($member = mysqli_fetch_row($result1)) { ?>
                <li><?php echo $member[2] ?><a>&#x274C;</a></li>
            <?php } ?>
        </ul>

    </div>
</div>

</body>
</html>