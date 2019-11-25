<?php

include '../../database/DBconnect.php';
include '../management/releaseManagement.php';
$conn = connect();
session_start();

if($_SESSION['projectId'] == null){
    header("Location:index.php");
}

$idProjet = $_SESSION['projectId'];
addRelease($conn,$idProjet);
deleteRelease($conn,$idProjet);
modifyRelease($conn,$idProjet);
$query = "SELECT VERSION,DESCRIPTION,DATE_RELEASE,URL_DOCKER,ID_RELEASE FROM `release` WHERE ID_PROJET = '$idProjet' ORDER BY DATE_RELEASE";
$result = mysqli_query($conn, $query);
if(!$result){
    echo "Error: " . $query . "<br>" . $conn->error . "<br>";
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include './defaultHead.php'; ?>
    <title>Release - GoProject</title>
</head>

<body>
<?php include "navbar.php";?>

<form method="POST" id="newReleaseForm"></form>
<h1>Releases</h1>
<table class="table" id="releasesList">
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
    $i=0;
    while($row = mysqli_fetch_row($result)){?>

        <tr>
            <td><?php echo $row[0];?></td>
            <td><a id="link<?php echo $i?>" href="<?php echo $row[3];?>">Lien de la version</a></td>
            <td><?php echo $row[1];?></td>
            <td><?php echo $row[2];?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $row[4];?>">
                    <button type="submit" name="delete" class="btn btn-secondary">Supprimer</button>
                </form>
                <button class="btn btn-primary" data-toggle="modal" data-target="#modifyReleaseModal<?php echo $row[4];?>">Modifier</button>
            </td>
        </tr>
        <?php
        $i++;
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
<?php
//positionne le pointeur au début de result
mysqli_data_seek($result,0);
while($row = mysqli_fetch_row($result)){
    ?>
    <div class="modal" tabindex="-1" role="dialog" id="modifyReleaseModal<?php echo $row[4];?>">
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
                        <input type="hidden" name="id" value="<?php echo $row[4];?>">
                        <div class="form-group">
                            <!--PAS ENCORE TESTÉ-->
                            <label for="releaseVersion">Version de la release</label>
                            <input type="text" class="form-control" value="<?php echo $row[0];?>" id="releaseVersion" name="version" required>
                        </div>
                        <div class="form-group">
                            <label for="releaseLink">Lien de la release</label>
                            <input type="text" class="form-control" value="<?php echo $row[3];?>" id="releaseLinl" name="link" required>
                        </div>
                        <div class="form-group">
                            <label for="releaseLink">Description</label>
                            <textarea class="form-control" id="releaseDescription" name="description"><?php echo $row[1];?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="releaseLink">Date de la release</label>
                            <input type="date" class="form-control" value="<?php echo $row[2];?>" id="releaseDate" name="date" required>
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
