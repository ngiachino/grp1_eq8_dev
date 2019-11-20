<?php

include '../database/DBconnect.php';
include 'releaseManagement.php';
$conn = connect();
session_start();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if($_SESSION['projectId'] == null){
  header("Location:index.php");
}

$idProjet = $_SESSION['projectId'];
addRelease($conn,$idProjet);
$query = "SELECT VERSION,DESCRIPTION,DATE_RELEASE,URL_DOCKER FROM `release` WHERE ID_PROJET = '$idProjet' ORDER BY DATE_RELEASE";
$result = mysqli_query($conn, $query);
if($result === FALSE){
    echo "Error: " . $query . "<br>" . $conn->error . "<br>";
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include './defaultHead.php'; ?>
    <title>Release - GoProject</title>
    <link href="../assets/css/projet.css" rel="stylesheet">
</head>

<body>
<div class="menuBar">
    <div class="float-left">
        <a href="profil.php">GoProject</a>
    </div>
    <div class="float-right">
        <a class="disconnect" href="./index.php">Se déconnecter</a>
    </div>
</div>
<form method="POST" id="newReleaseForm"></form>
<h1>Releases</h1>
<table class="table" id="releasesList" summary="Table des releases du projet">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Version</th>
      <th scope="col">Lien</th>
      <th scope="col">Description</th>
      <th scope="col">Date</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  <?php
    while($row = mysqli_fetch_row($result)){?>

    <tr>
      <td><?php echo $row[0];?></td>
      <td><a href="<?php echo $row[3];?>">Lien de la version</a></td>
      <td><?php echo $row[1];?></td>
      <td><?php echo $row[2];?></td>
      <td>
          <input class="btn btn-info" type="submit" name="modify" value="Modifier">
          <input class="btn btn-danger" type="submit" name="delete" value="Supprimer">
      </td>
    </tr>
    <?php 
      }
    ?>
    <tr>
        <td>
            <input class="form-control" type="text" name="version" form="newReleaseForm" maxlength="10" placeholder="Version" required>
        </td>
        <td>
            <input class="form-control" type="text" name="lien" form="newReleaseForm" maxlength="100" placeholder="Lien de la version" required>
        </td>
        <td>
            <textarea class="form-control" name="description" form="newReleaseForm" maxlength="500" placeholder="Description (optionnel)"></textarea>
        </td>
        <td>
            <input type="date" class="form-control" form="newReleaseForm" name="date" required>
        </td>
        <td>
            <input class="btn btn-dark" type="submit" name="submit" value="Créer" form="newReleaseForm">
        </td>
    </tr>
  </tbody>
</table>
</body>
</html>
