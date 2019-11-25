<?php
include '../../database/DBconnect.php';
include '../management/sprintManagement.php';
$conn = connect();
session_start();

if($_SESSION['projectId'] == null){
    header("Location:index.php");
}

$idProjet = $_SESSION['projectId'];
$messageAdd = addSprint($conn, $idProjet);
$messageDel = deleteSprint($conn);
$messageModify = modifySprint($conn, $idProjet);
$query = "SELECT NOM_SPRINT,DATE_DEBUT,DATE_FIN, ID_SPRINT FROM sprint WHERE ID_PROJET = '$idProjet' ORDER BY DATE_FIN";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include './defaultHead.php'; ?>
    <title>Sprint - GoProject</title>
    <link href="../../assets/css/sprints.css" rel="stylesheet">
</head>

<body>
<?php include "navbar.php";?>
<h1>Les Sprints</h1>

<div class="col-sm-4" id="openNewSprintForm">
    <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#newSprintModal" id="addButton">Créer un nouveau sprint</button>
</div>

<div class="row">
    <?php
    while($row = mysqli_fetch_row($result)){
        ?>
        <div class="containerSprints">
            <div class="card">
                <a href="sprintConsult.php?projectId=<?php echo $idProjet;?>&sprintId=<?php echo $row[3];?>">
                    <div class="card-header">
                        <?php echo $row[0]; ?>
                    </div>
                </a>
                <div class="card-body">
                    <p class="card-text">Date de début : <?php echo $row[1]?></p>
                    <p class="card-text">Date de fin : <?php echo $row[2]?></p>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $row[3];?>">
                        <button type="submit" name="delete" class="btn btn-secondary">Supprimer</button>
                    </form>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modifySprintModal<?php echo $row[3];?>">Modifier</button>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>

<div class="modal" tabindex="-1" role="dialog" id="newSprintModal">
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
<?php
//positionne le pointeur au début de result
//contenu de row NOM_SPRINT,DATE_DEBUT,DATE_FIN, ID_SPRINT
mysqli_data_seek($result,0);
while($row = mysqli_fetch_row($result)){
    ?>
    <div class="modal" tabindex="-1" role="dialog" id="modifySprintModal<?php echo $row[3];?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier Sprint</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $row[3];?>">
                        <div class="form-group">
                            <!--PAS ENCORE TESTÉ-->

                            <label for="sprintName">Nom du sprint</label>
                            <input type="text" class="form-control" value="<?php echo $row[0];?>" id="sprintName" name="name" required>

                        </div>
                        <div class="form-group">
                            <label for="startDate">Date de début</label>
                            <input type="date" class="form-control" value="<?php echo $row[1];?>" id="sprintStartDate" name="startDate" required>
                        </div>
                        <div class="form-group">
                            <label for="endDate">Date de fin</label>
                            <input type="date" class="form-control" value="<?php echo $row[2];?>" id="sprintEndDate" name="endDate" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="modify" class="btn btn-primary">Modifier</button>
                            <button type="button" class="btn btn-secondary buttonCancel" data-dismiss="modal">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
}
echo $messageAdd;
echo $messageDel;
echo $messageModify;
?>
</body>
</html>
