<?php

include '../../database/DBconnect.php';
include '../management/testManagement.php';
$conn = connect();
session_start();

if($_SESSION['projectId'] == null){
    header("Location:index.php");
}

$idProjet = $_SESSION['projectId'];
addTest($conn,$idProjet);
deleteTest($conn,$idProjet);
modifyTest($conn,$idProjet);
$query = "SELECT DATE_DEBUT,ETAT,DESCRIPTION,ID_TEST FROM `test` WHERE ID_PROJET = '$idProjet' ORDER BY ID_TEST";
$result = mysqli_query($conn, $query);
if(!$result){
    echo "Error: " . $query . "<br>" . $conn->error . "<br>";
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include './defaultHead.php'; ?>
    <title>Tests - GoProject</title>
    <link href="../../assets/css/profil.css" rel="stylesheet">
</head>


<body>
<?php include 'navbar.php'; ?>

<form method="POST" id="newTestForm"></form>
<h1>Les Tests</h1>

<table class="table" id="testsList">
    <thead class="thead-dark">
    <tr>
        <th scope="col">Description</th>
        <th scope="col">Date</th>
        <th scope="col">Etat</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $i=0;
    while($row = mysqli_fetch_row($result)){?>

        <tr>
            <td><?php echo $row[2];?></td>
            <td><?php echo $row[0];?></td>
            <td><?php echo $row[1];?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $row[3];?>">
                    <button type="submit" name="delete" class="btn btn-secondary">Supprimer</button>
                </form>
                <button class="btn btn-primary" data-toggle="modal" data-target="#modifyTestModal<?php echo $row[3];?>">Modifier</button>
            </td>
        </tr>
        <?php
        $i++;
    }
    ?>
    <tr>
        <td>
            <textarea class="form-control" name="description" form="newTestForm" maxlength="500" placeholder="Description" required></textarea>
        </td>
        <td>
            <input type="date" class="form-control" form="newTestForm" name="date" required>
        </td>
        <td>
            <input type="number" class="form-control" name="etat" form="newTestForm" placeholder="Etat" min="1" step="1" required>
        </td>
        <td>
            <input class="btn btn-dark" type="submit" name="submit" value="Créer" form="newTestForm">
        </td>
    </tr>
    </tbody>
</table>
<?php
//positionne le pointeur au début de result
mysqli_data_seek($result,0);
while($row = mysqli_fetch_row($result)){
    ?>
    <div class="modal" tabindex="-1" role="dialog" id="modifyTestModal<?php echo $row[3];?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier Release</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $row[3];?>">
                        <div class="form-group">
                            <label for="testDescription">Description</label>
                            <textarea class="form-control" id="testDescription" name="description"><?php echo $row[2];?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="testDate">Date</label>
                            <input type="date" class="form-control" value="<?php echo $row[0];?>" id="testDate" name="date" required>
                        </div>
                        <div class="form-group">
                            <label for="testEtat">Etat du test</label>
                            <input type="number" class="form-control" value="<?php echo $row[1];?>" id="testEtat" name="etat" min="1" step="1" required>
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
?>
</body>
</html>
