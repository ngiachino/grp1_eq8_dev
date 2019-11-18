<?php

include '../database/DBconnect.php';
$conn = connect();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$query = "SELECT ID_USER_STORY,PRIORITE,DIFFICULTE,DESCRIPTION FROM issue";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include './defaultHead.php'; ?>
    <title>Issues - GoProject</title>
    <link href="../assets/css/projet.css" rel="stylesheet">
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
<h1>Issues</h1>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Description</th>
      <th scope="col">Priorité</th>
      <th scope="col">Difficulté</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php $i = 0;
    while($row = mysqli_fetch_row($result)){?>
    <tr>
      <th scope="row"><?php echo $row[0];?></th>
      <td><?php echo $row[3];?></td>
      <td><?php echo $row[1];?></td>
      <td><?php echo $row[2];?></td>
      <td><button class="modify" type="button">Modifier</button><button class="supprimer" type="button">Supprimer</button></td>
    </tr>
    <?php } ?>
    <tr>
        <th scope="row"><input type="number" name="idUS"></th>
        <td><input type="text" name="description"></td>
        <td><input type="text" name="priorité"></td>
        <td><input type="number" name="difficulté"></td>
        <td><input type="submit" name="submit" value="Créer"></td> 
    </tr>
  </tbody>
</table>
</body>
</html>