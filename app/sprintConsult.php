<?php
include '../database/DBconnect.php';
include 'sprintControl.php';
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
else if( $_GET['projectId'] == null || $_GET['sprintId'] == null){
    header("Location:sprints.php");
}

$projectId = $_GET['projectId'];
$sprintId = $_GET['sprintId'];

$connexion=null;
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include './defaultHead.php'; ?>
    <title>Tasks - GoProject</title>
    <link href="../assets/projet.css" rel="stylesheet">
</head>

<body>

<div class = "menuBar">
    <div class="menuBar-left">
        <a id="title" href="profil.php">GoProject</a>
    </div>
    <div class="menuBar-right">
        <a class="disconnect">Se déconnecter</a>
    </div>
</div>

<div class="supercontainer">
    <div class="container" id="tasks">
        <h2>Les tâches</h2>
    </div>
</div>



</body>
</html>