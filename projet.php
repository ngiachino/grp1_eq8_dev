<?php

include 'database/DBconnect.php';
$conn = connect();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$query = "SELECT * FROM membre WHERE ID_PROJET = 1";
$query2 = "SELECT * FROM projet WHERE ID_PROJET = 1";
$result1 = mysqli_query($conn, $query);
$result2 = mysqli_fetch_row(mysqli_query($conn, $query2));
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include './defaultHead.php'; ?>
    <title>Projet : <?php echo $result2[1]?> - GoProject</title>
    <link href="projet.css" rel="stylesheet">
</head>

<body>
<div class = "menuBar">
    <div class="menuBar-left">
        <a href="profil.php">GoProject</a>
    </div>
    <div class="menuBar-right">
        <a href="#">Se déconnecter</a>
    </div>
</div>

<h1>
    <?php echo $result2[1]?>
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