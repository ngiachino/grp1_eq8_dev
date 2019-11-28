<?php
include '../../database/DBconnect.php';
include '../management/issuesManagement.php';

session_start();

$idProjet = startIssues();
startAddIssue($idProjet);
startDeleteIssue($idProjet);
startModifyIssue($idProjet);
$result = showIssues($idProjet);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include './defaultHead.php'; ?>
    <title>Issues - GoProject</title>
    <link href="../../assets/css/issues.css" rel="stylesheet">
</head>

<body>
<?php include 'navbar.php'; ?>

<h1>Issues</h1>
<form method="POST" id="newIssueForm"></form>
<table class="table" id="issuesList">
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
  <?php $i = 1;
    while($row = mysqli_fetch_row($result)){?>
    <tr>
      <th scope="row"><?php echo $i;?>
          <form method="POST" id="deleteModifyForm<?php echo $i; ?>"></form>
          <input form="deleteModifyForm<?php echo $i; ?>" type="hidden" name="id" value="<?php echo $row[0];?>">
      </th>
      <td><?php echo $row[3];?></td>
      <td><?php echo $row[1];?></td>
      <td><?php echo $row[2];?></td>
      <td>
          <button class="btn btn-primary" data-toggle="modal" data-target="#modifyIssueModal<?php echo $row[0];?>">Modifier</button>
          <input class="btn btn-danger" form="deleteModifyForm<?php echo $i; ?>" type="submit" name="delete" value="Supprimer">
      </td>
    </tr>
    <?php
      $i++;
      }
    ?>
    <tr>
        <th scope="row"></th>
        <td>
            <input class="form-control" type="text" name="description" form="newIssueForm" maxlength="500" placeholder="Description" required>
        </td>
        <td>
            <select class="form-control" name="priority" form="newIssueForm">
                <option value="High">High</option>
                <option value="Medium">Medium</option>
                <option value="Low">Low</option>
            </select>
        </td>
        <td>
            <input class="form-control" type="number" name="difficulty" form="newIssueForm" min="1" step="1" placeholder="Difficulté" required>
        </td>
        <td>
            <input class="btn btn-dark" type="submit" name="submit" value="Créer" form="newIssueForm">
        </td>
    </tr>
  </tbody>
</table>

<?php
//positionne le pointeur au début de result
mysqli_data_seek($result,0);
while($row = mysqli_fetch_row($result)){
    ?>
    <div class="modal" tabindex="-1" role="dialog" id="modifyIssueModal<?php echo $row[0];?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier Issue</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $row[0];?>">
                        <div class="form-group">
                            <label for="issueDescription">Description de l'issue</label>
                            <textarea class="form-control" id="issueDescription" name="description"><?php echo $row[3];?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="issuePriorite">Priorité de l'issue</label>
                            <select class="form-control" name="priority" id="issuePriorite">
                                <option value="High">High</option>
                                <option value="Medium">Medium</option>
                                <option value="Low">Low</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="issueDifficulte">Difficulté de l'issue</label>
                            <input type="number" class="form-control" value="<?php echo $row[2];?>" id="issueDifficulte" name="difficulty" min="1" step="1" required>
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
