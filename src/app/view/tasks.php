<?php
include '../management/taskManagement.php';
include '../../database/DBconnect.php';
include '../management/sprintManagement.php';
$conn = connect();

session_start();
//test si l'utilisateur est connecté. Sinon le renvoie vers l'index
if($_SESSION['userName'] == null || $_SESSION['userID'] == null){
    header("Location:index.php");
}
//test si l'utilisateur est bien passé par sa page de profil. Sinon le renvoie vers le profil
else if( $_GET['projectId'] == null || $_GET['sprintId'] == null){
    header("Location:sprints.php");
}

$projectId = $_GET['projectId'];
$sprintId = $_GET['sprintId'];
$addMessage = startAddTask($conn,$projectId, $sprintId);
$assignMessage = assignTask($conn,$projectId, $sprintId );
$modifyTaskMessage = modifyTask($conn, $projectId, $sprintId);
$issueAddMessage = addIssueTask($conn, $projectId);
$editStateTaskMessage = editTaskEtat($conn, $projectId, $sprintId );
$deleteMessage = startDeleteTask($conn,$projectId,$sprintId);
$result= getTaskWithSpecificState($conn,$projectId, $sprintId);
$resultSprintDays = getDaysSprint($conn,$projectId,$sprintId);

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include 'defaultHead.php'; ?>
    <title>Tasks - GoProject</title>
    <link href="../../assets/css/tasks.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<br>
<div class="container">
    <div class="card card-body bg-ligh">
        <!--AFFICHER LE NUMERO DE SPRINT -->
        <div class="row">
            <div class="col-md-3">
                <h2>
                    <?php
                    $getSprintName = "SELECT NOM_SPRINT from sprint WHERE ID_SPRINT ='$sprintId'";
                    $result = mysqli_query($conn,$getSprintName);
                    $sprintName = mysqli_fetch_row($result)[0];
                    echo $sprintName;
                    ?>
                </h2>
            </div>
            <!--Statistiques -->
            <div class="col-md-9">
                <!--BARRE DE PROGRESSION D UN SPRINT-->
                <?php
                $sprintDays = mysqli_fetch_row($resultSprintDays);
                $sprintLeftDays = $sprintDays[1];
                $sprintNumberDays = $sprintDays[0];
                $daysPercent = ((($sprintNumberDays - $sprintLeftDays) * 100) / $sprintNumberDays);
                ?>
                <div class="progress">
                    <div class="progress-bar bg-dark" role="progressbar" style="width: <?php echo $daysPercent;?>%">
                        <?php echo $sprintLeftDays.' jours restant'; ?>
                    </div>
                </div>
                <!--CHIFFRES-->
            </div>
        </div>
    </div>
</div>
<br>
<div class="container">
    <button type="button" class="btn btn-lg btn-dark" data-toggle="collapse" data-target="#demo">
        Ajouter une tâche
    </button>
    <!--CREER UNE TACHE-->
    <div id="demo" class="collapse">
        <!-- Le formulaire de creation de la tâche -->
        <form method="POST">
            <div class="form-group">
                <label for="taskDescription">Description de la tâche:</label>
                <textarea class="form-control" id="taskDescription" maxlength="500" name="taskDescription"></textarea>
            </div>

            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="taskDuration">Durée de la tâche (en jour/homme) :</label>
                    <input type="number" step="0.5" class="form-control" id="taskDuration" name="taskDuration">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="taskState">Etat de la tâche: </label>
                    <select class="form-control form-control-sm" name="taskState" id="taskState">
                        <option value="TO DO">TO DO</option>
                        <option value="ON GOING">ON GOING</option>
                        <option value="DONE">DONE</option>
                    </select>
                </div>
            </div>
            <button type="submit" name="submit" class="btn btn-dark btn-sm">Ajouter</button>
        </form>
        <!--FIN DU FORMULAIRE-->
    </div>
</div>
<br>
<!--CHOISIR LE TYPE DE TACHE QU'ON VEUT CONSULTER-->
<div class="container">
    <form method="POST">
        <label for="nameState"></label>
        <select class="form-control w-25 d-inline" id="nameState" name="nameState">
            <option value="" disabled selected>Sélectionnez le type de tâche</option>
            <option value="ALL">ALL</option>
            <option value="TO DO">TO DO</option>
            <option value="ON GOING">ON GOING </option>
            <option value="DONE">DONE</option>
        </select>
        <button type="submit" name="choseState" class="btn btn-secondary btn-sm">Valider</button>
    </form>
</div>
<br>
<!--AFFICHAGE DES TÂCHES COURRANTES DU SPRINT-->
<div class="taskTable">
    <table class="table" id="taskList">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Numéro </th>
            <th scope="col">Description</th>
            <th scope="col">Durée</th>
            <th scope="col">Etat</th>
            <th scope="col">Membre</th>
            <th scope ="col">User Stories</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        while ($row = mysqli_fetch_row($result)) {
        ?>
        <tr>
            <th scope="row"><?php echo $i;?></th>
            <td><?php echo $row[0];?></td>
            <td><?php echo $row[1];?></td>
            <!--ETAT-->
            <td>
                <!-- FORMULAIRE DE MODIFICATION DE L ETAT D UNE TACHE-->
                <span class="fas fa-edit float-left" data-toggle="collapse" data-target="<?php echo "#state".$i;?>">
                    </span>
                <!--AFFICHAGE DE L ETAT-->
                <?php
                $taskState = $row[2];
                echo $taskState;
                ?>
                <div id="<?php echo "state".$i; ?>" class="collapse">
                    <form method="POST">
                        <input type="hidden" name="taskId" value="<?php echo $row[3];?>">
                        <div class="form-group">
                            <label for="taskState">Nouvel Etat :</label>
                            <br>
                            <select class="custom-select" name="taskState" id="taskState">
                                <option value="TO DO">TO DO</option>
                                <option value="ON GOING">ON GOING</option>
                                <option value="DONE">DONE</option>
                            </select>
                        </div>
                        <button type="submit" name="editTaskState" class="btn btn-secondary btn-sm">Valider</button>
                    </form>
                </div>
            </td>
            <!--MEMBRES-->
            <td >
                <!-- ADD MEMBER FORM-->
                <span class="fas fa-user-plus float-left" data-toggle="collapse" data-target="<?php echo "#demo".$i;?>"> </span>
                <div id="<?php echo "demo".$i; ?>" class="collapse float-center">
                    <!-- Le formulaire d'attribution de la tâche -->
                    <br>
                    <form method="POST">
                        <input type="hidden" name="taskId" value="<?php echo $row[3];?>">
                        <div class="form-group">
                            <select class="form-control w-25 d-inline" id="userName" name="userName">
                                <?php
                                $members = getMembersProject($projectId,$conn);
                                while($member = mysqli_fetch_row($members)){
                                    echo "<option value=$member[0]>$member[0]</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" name="assigner" class="btn btn-secondary btn-sm float-left">Assigner</button>
                    </form>
                </div>
                <!--LISTE DES MEMBRES-->
                <table class="table table-no-border">
                    <tbody>
                    <!-- LIST OF TASK'S MEMBERS-->
                    <br>
                    <?php
                    //LES MEMBRES
                    $taskId = $row[3];
                    startDeleteMemberTask($conn, $projectId, $sprintId, $taskId);
                    $taskMembers = getMemberTask($conn, $taskId, $sprintId, $projectId);

                    // Afficher les membres  de la tâche
                    $j = 0;
                    while ($member = mysqli_fetch_row($taskMembers)) {
                    $memberName = $member[0];
                    ?>
                    <tr>
                        <td >
                            <form method="post">
                                <?php echo $member[0]; ?>
                                <button type="submit" class="taskDeleteElement fas fa-times btn  float-left" name="deleteMember"></button>
                                <input class="form-control" type="hidden" name="idMember" value="<?php echo $member[1];?>">
                            </form>
                        </td>
                        <?php $j++;
                        } ?>
                    </tr>
                    </tbody>
                </table>
            </td>
            <!--USER STORIES-->
            <td>
                    <span class="fas fa-plus float-left" data-toggle="collapse" data-target="<?php echo "#us".$i;?>">
                    </span>
                <div id="<?php echo "us".$i; ?>" class="collapse">
                    <!-- Le formulaire d'ajout d'une US -->
                    <br>
                    <form method="POST">
                        <div class="form-group">
                            <input type="hidden" name="taskIdentificateur" value="<?php echo $row[3];?>">
                            <select class="form-control w-25 d-inline" id="issueId" name="issueId">
                                <?php
                                $k=1;
                                $issues = getIssuesProject($projectId,$conn);
                                while($issue = mysqli_fetch_row($issues)){
                                    echo "<option value=$issue[0]>US$i</option>";
                                    $k++;
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" name="lier" class="btn btn-secondary btn-sm float-left">Lier</button>
                    </form>
                </div>

                <table class="table table-no-border">
                    <tbody>
                    <?php
                    deleteIssueFromTask($conn,$projectId);
                    $resultIssues = getIssuesTask($conn, $taskId, $projectId);
                    $l = 1;
                    while ($rowIssue = mysqli_fetch_row($resultIssues)) {
                        $issueId = $rowIssue[0];
                        $issueNumber = $l;
                        $l++;
                        ?>
                        <tr>
                            <!--Bouton delete-->
                            <td>
                                <form method="POST">
                                    <button type="submit" class="taskDeleteElement fas fa-times btn bg-transparent btn-sm float-left" name="deleteIssue"></button>
                                    <?php echo "US$issueNumber"; ?>
                                    <input type="hidden" name="issueId" value="<?php echo $issueId;?>">
                                    <input type="hidden" name="taskId" value="<?php echo $taskId;?>">
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </td>
            <!--ACTION-->
            <td>

                <!-- ACTION SUR UNE TACHE-->
                <!--MODIFIER UNE TÂCHE  -->
                <button class="fas fa-edit btn btn-light" data-toggle="modal" data-target="<?php echo "#modifyTaskModal".$i;?>">
                </button>
                <!-- DELETE-->
                <form method="POST" class="d-inline">
                    <input type="hidden" name="taskId" value="<?php echo $row[3];?>">
                    <button type="submit" name="delete" class="fa fa-close btn btn-light d-inline"></button>
                </form>
</div>
    <div class="modal" tabindex="-1" role="dialog" id="modifyTaskModal<?php echo $i;?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier tâche</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <div class="form-group">
                            <label for="descriptionTask">Description:</label>
                            <br>
                            <textarea class="form-control" id="descriptionTask" maxlength="500" name="descriptionTask"><?php echo $row[0];?></textarea>
                            <br>
                            <label for="durationTask">Durée:</label> <br>
                            <input type="number" step="0.5" class="form-control-sm" id="durationTask" name="durationTask" placeholder="<?php echo $row[1];?>">
                            <input type="hidden" name="taskId" value="<?php echo $row[3];?>">
                        </div>
                        <button type="submit" name="modifier" class="btn btn-secondary btn-sm">Modifier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!--FIN Des ACTIONS FORMULAIRE-->
    </td>
    </tr>
<?php
$i++;
}
?>
</tbody>
</table>
</div>
<?php
$connexion=null;
?>

</body>
</html>

