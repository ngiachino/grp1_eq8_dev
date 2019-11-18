<?php

include '../database/DBconnect.php';
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
$query = "SELECT ID_USER_STORY,PRIORITE,DIFFICULTE,DESCRIPTION FROM issue WHERE ID_PROJET = '$idProjet'";
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
<form method="POST" id="newIssueForm"></form>
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
      <td><input type="submit" name="modify" value="Modifier"><input type="submit" name="delete" value="Supprimer"></td>
    </tr>
    <?php } ?>
    <tr>
        <th scope="row"></th>
        <td><input type="text" name="description" form="newIssueForm"></td>
        <td><input type="text" name="priority" form="newIssueForm"></td>
        <td><input type="number" name="difficulty" form="newIssueForm"></td>
        <td><input type="submit" name="submit" value="Créer" form="newIssueForm"></td> 
    </tr>
  </tbody>
</table>
</body>
</html>
<?php
if(isset($_POST['submit'])){
    $query = "SELECT MAX(ID_USER_STORY) FROM issue WHERE ID_PROJET='$idProjet'";
    $result = mysqli_query($conn, $query);
    if(mysqli_query($conn,$query) === FALSE){
      $idUS=1;
    }
    else{
      $idUS = mysqli_fetch_row($result)[0]+1;
    }
    $description = $_POST['description'];
    $priority = $_POST['priority'];
    $difficulty = $_POST['difficulty'];
    $query = "INSERT INTO issue (ID_USER_STORY, PRIORITE, DIFFICULTE, DESCRIPTION, ID_PROJET)
              VALUES ('$idUS','$priority','$difficulty','$description','$idProjet')";
    if(mysqli_query($conn,$query) === FALSE){
      echo "Error: " . $query . "<br>" . $conn->connect_error . "<br>";
    }
    header("Refresh:0");
  }
?>