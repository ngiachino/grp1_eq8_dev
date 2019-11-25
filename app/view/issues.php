<?php
include '../../database/DBconnect.php';
include '../management/issuesManagement.php';
$conn = connect();
session_start();

$idProjet = start();
startAddIssue($idProjet);
startDeleteIssue($idProjet);
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
          <input class="btn btn-info" type="submit" name="modify" value="Modifier">
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
</body>
</html>
