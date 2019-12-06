<?php

include '../../database/DBconnect.php';
include '../management/documentationManagement.php';

$idProjet = startDocumentation();
$result = showDocumentation($idProjet);
startAddDocumentation($idProjet);
startDeleteDocumentation($idProjet);
startModifyDocumentation($idProjet);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include './defaultHead.php'; ?>
    <title>Documentation - GoProject</title>
</head>


<body>
<?php include 'navbar.php'; ?>

<form method="POST" id="newDocumentForm" enctype="multipart/form-data"></form>
<h1>La documentation</h1>

<table class="table" id="documentationList">
    <thead class="thead-dark">
    <tr>
        <th scope="col">Titre</th>
        <th scope="col">Description</th>
        <th scope="col">Document</th>
        <th scope="col">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $i=0;
    while($row = mysqli_fetch_row($result)){?>

        <tr>
            <td><?php echo $row[0];?></td>
            <td><?php echo $row[1];?></td>
            <td><a href="<?php echo $row[2];?>" target="_blank">Lien</a></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $row[3];?>">
                    <button type="submit" name="delete" class="btn btn-secondary">Supprimer</button>
                </form>
                <button class="btn btn-primary" data-toggle="modal" data-target="#modifyDocumentModal<?php echo $row[3];?>">Modifier</button>
            </td>
        </tr>
        <?php
        $i++;
    }
    ?>
    <tr>
        <td>
            <input type="text" class="form-control" name="title" form="newDocumentForm" maxlength="100" placeholder="Titre" required>
        </td>
        <td>
            <textarea class="form-control" form="newDocumentForm" name="description" placeholder="Description (optionnel)"></textarea>
        </td>
        <td>
            <input type="file" name="fileToUpload" form="newDocumentForm" id="fileToUpload" accept=".txt,.md,.pdf" required>
        </td>
        <td>
            <input class="btn btn-dark" type="submit" name="submit" value="Créer" form="newDocumentForm">
        </td>
    </tr>
    </tbody>
</table>
<?php
//positionne le pointeur au début de result
mysqli_data_seek($result,0);
while($row = mysqli_fetch_row($result)){
    ?>
    <div class="modal" tabindex="-1" role="dialog" id="modifyDocumentModal<?php echo $row[3];?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier document</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $row[3];?>">
                        <div class="form-group">
                            <label for="documentTitle">Titre</label>
                            <input type="text" class="form-control" value="<?php echo $row[0];?>" id="documentTitle" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="documentDescription">Description</label>
                            <textarea class="form-control" id="documentDescription" name="description"><?php echo $row[1];?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="documentDescription">Document</label>
                            <br>
                            <input type="file" id="documentFileToUpload" name="fileToUpload" accept=".txt,.md,.pdf">
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
