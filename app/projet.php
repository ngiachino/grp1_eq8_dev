<?php

include '../database/DBconnect.php';
$conn = connect();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

//test si l'utilisateur est connecté. Sinon le renvoie vers l'index
if($_SESSION['userName'] == null || $_SESSION['userID'] == null){
    header("Location:index.php");
}
//test si l'utilisateur est bien passé par sa page de profil. Sinon le renvoie vers le profil
else if( $_GET['title'] == null || $_GET['owner'] == null){
    header("Location:profil.php");
}

$projectTitle = $_GET['title'];
$projectOwner = $_GET['owner'];
$query2 = "SELECT ID_PROJET FROM projet JOIN utilisateur ON projet.ID_MANAGER = utilisateur.ID_USER WHERE NOM_PROJET ='$projectTitle' AND NOM_USER='$projectOwner'";
$result2 = mysqli_query($conn, $query2);
$projectId = mysqli_fetch_row($result2)[0];

$query = "SELECT * FROM membre WHERE ID_PROJET = '$projectId'";
$result1 = mysqli_query($conn, $query);
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include './defaultHead.php'; ?>
    <title>Projet : <?php echo $projectTitle?> - GoProject</title>
    <link href="../assets/css/projet.css" rel="stylesheet">
</head>

<body>
<div class = "menuBar">
    <div class="menuBar-left">
        <a href="profil.php">GoProject</a>
    </div>
    <div class="menuBar-right">
        <a class = "disconnect" href="./index.php">Se déconnecter</a>
    </div>
</div>

<h1>
    <?php echo $projectTitle?>
</h1>

<div class="supercontainer">

    <div class="container">
        <a class="pageLink" href="#">
            <h2>Les issues</h2>
        </a>
    </div>

    <div class="container">
        <a class="pageLink" href="#">
            <h2>Les tâches</h2>
        </a>
    </div>

    <div class="container">
        <a class="pageLink" href="#">
            <h2>Les releases</h2>
        </a>
    </div>

    <div class="container">
        <a class="pageLink" href="#">
            <h2>Les test</h2>
        </a>
    </div>

    <div class="container">
        <a class="pageLink" href="#">
            <h2>La doc</h2>
        </a>
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