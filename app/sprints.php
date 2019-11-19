<?php

include '../database/DBconnect.php';
include 'sprintCreation.php';
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
$message = addSprint($conn, $idProjet);
$query = "SELECT NOM_SPRINT,DATE_DEBUT,DATE_FIN FROM sprint WHERE ID_PROJET = '$idProjet' ORDER BY DATE_FIN";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include './defaultHead.php'; ?>
    <title>Sprint - GoProject</title>
    <link href="../assets/css/sprints.css" rel="stylesheet">
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
<h1>Les Sprints</h1>
<div class="col-sm-4" id="openNewProjectForm">
    <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#newProjectModal" id="addButton">Créer un nouveau sprint</button>
</div>
<?php $i = 1;
    while($row = mysqli_fetch_row($result)){
?>
<div class="containerSprints">
    <div class="card">
        <div class="card-header">
        <?php echo $row[0]; ?>
        </div>
        <div class="card-body">
            <p class="card-text">Date de début : <?php echo $row[1]?></p>
            <p class="card-text">Date de fin : <?php echo $row[2]?></p>
            <a href="#" class="btn btn-primary">Modifier</a>
            <a href="#" class="btn btn-primary">Supprimer</a>
        </div>
    </div>
</div>
<?php
    }
?>

<div class="modal" tabindex="-1" role="dialog" id="newProjectModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nouveau Sprint</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="form-group">
                        <label for="sprintName">Nom du sprint</label>
                        <input type="text" class="form-control" placeholder="Nom du sprint" id="sprintName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="startDate">Date de début</label>
                        <input type="date" class="form-control" id="sprintStartDate" name="startDate" required>
                    </div>
                    <div class="form-group">
                        <label for="endDate">Date de fin</label>
                        <input type="date" class="form-control" id="sprintEndDate" name="endDate" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="submit" class="btn btn-primary">Créer</button>
                        <button type="button" class="btn btn-secondary buttonCancel" data-dismiss="modal">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php echo $message; ?>
</body>
</html>