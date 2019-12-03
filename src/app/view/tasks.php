<?php
include  '../management/taskManagement.php';
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
$addMessage = addTask($conn,$projectId, $sprintId);
$assignMessage = assignTask($conn,$projectId, $sprintId );
$modifyTaskMessage = modifyTask($conn, $projectId, $sprintId);
$issueAddMessage = addIssueTask($conn, $projectId);


$query = "SELECT DISTINCT tache.DESCRIPTION, tache.DUREE_TACHE, tache.IS_DONE, tache.ID_TACHE
              FROM tache  
              WHERE tache.ID_PROJET = '$projectId'
                    AND tache.ID_SPRINT = '$sprintId'
                    ";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include 'defaultHead.php'; ?>
    <title>Tasks - GoProject</title>
    <link href="../../assets/css/projet.css" rel="stylesheet">
</head>

<body>
<?php include 'navbar.php'; ?>
<div class="container-fluid">
    <!--AFFICHER LE NUMERO DE SPRINT -->
    <div class="row">
        <div class="col-md-3">
            <h2>Sprint <?php echo $sprintId ?></h2>
        </div>
        <!--BARRE DE PROGRESSION D UN SPRINT -->
    </div>
    <button type="button" class="btn btn-lg  btn-dark" data-toggle="collapse" data-target="#demo">
        Ajouter une tâche
    </button>
    <!--CREER UNE TACHE-->
    <div id="demo" class="collapse">
        <!-- Le formulaire de creation de la tâche -->
        <form method="POST">
            <div class="form-group">
                <label for="taskDescription">Description de la tâche:</label>
                <input type="text" class="form-control" id="taskDescription" name="taskDescription">
            </div>
            <div class="form-group">
                <label for="taskDuration">Durée de la tâche: </label>
                <input type="text" class="form-control" id="taskDuration" name="taskDuration">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
        <!--FIN DU FORMULAIRE-->
    </div>
</div>
<br>
<br>

<!--AFFICHAGE DES TÂCHES COURRANTES DU SPRINT-->
<div class="container-fluid">
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
        while($row = mysqli_fetch_row($result)){
            ?>
            <tr>
                <th scope="row"><?php echo $i;?>
                </th>

                <td><?php echo $row[0];?></td>
                <td><?php echo $row[1];?></td>
                <!--ETAT-->
                <td><?php
                    if($row[2] == 1)
                    {  echo "DONE";}
                    else{
                        echo "UNDONE";
                    }?>
                </td>
                <!--MEMBRES-->
                <td><?php
                    //LES MEMBRES
                    $taskId = $row[3];
                    $deleteMessage = deleteTask($conn);
                    ?>
                    <!-- Afficher les membres  de la tâche -->
                    <span>
                            <?php
                            $taskId = $row[3];
                            $resultMember = getMemberTask($conn, $taskId, $sprintId, $projectId);
                            while($rowMembers = mysqli_fetch_row($resultMember)){
                                ?>

                                <?php
                                deleteMember($conn,$projectId, $sprintId);
                                $memberName = $rowMembers[0];
                                $memberId = $rowMembers[1];
                                ?>
                                <form method="POST">
                                    <?php echo $memberName;?>
                                    <input type="hidden" name="taskId" value="<?php echo $taskId;?>">
                                    <input type="hidden" name="memberId" value="<?php echo $memberId;?>">
                                    <button type="submit" class="fa fa-times btn btn-danger" name="deleteMember"></button>
                                        </form>
                            <?php  } ?>
                    </span>
                </td>
                <!--USER STORIES-->
                <td>
                    <span>
                    <?php
                    deleteIssueFromTask($conn,$projectId);
                    $resultIssues = getIssuesTask($conn, $taskId, $projectId);
                    while($rowIssue = mysqli_fetch_row($resultIssues)){
                        $issueId = $rowIssue[0];
                        $issueDescription = $rowIssue[1];
                        ?>
                        <!--Bouton delete-->
                        <form method="POST">
                        <ul class="list-group">
                                 <li class="list-group-item"><?php echo $issueId.'-'.$issueDescription; ?>
                                     <input type="hidden" name="issueId" value=<?php echo $issueId;?>>
                                     <input type="hidden" name="taskId" value=<?php echo $taskId;?>>
                                 <button type="submit" class="fa fa-trash" name="deleteIssue"></button>
                                 </li>
                        </ul>
                        </form>
                    <?php  } ?>
                    </span>
                </td>
                <!--ACTION-->
                <td>
                    <!--MENU ASSIGNER-->
                    <button type="button" class="btn  btn-dark" data-toggle="collapse" data-target="<?php echo "#demo".$i;?>">
                        Assigner la tâche
                    </button>
                    <div id=<?php echo "demo".$i; ?> class="collapse">
                        <!-- Le formulaire d'attribution de la tâche -->
                        <form method="POST">
                            <input type="hidden" name="taskId" value="<?php echo $row[3];?>">
                            <div class="form-group">
                                <label for="userName">User:</label>
                                <input type="text" class="form-control" id="userName" name="userName">
                            </div>
                            <button type="submit" name="assigner" class="btn btn-primary">Assigner</button>
                        </form>
                    </div>
                    <br> <br>
                    <!-- AJOUTER -->
                    <button type="button" class="btn  btn-dark" data-toggle="collapse" data-target="<?php echo "#us".$i;?>">
                        Ajouter une USS
                    </button>
                    <div id=<?php echo "us".$i; ?> class="collapse">
                        <!-- Le formulaire d'ajout d'une US -->
                        <form method="POST">
                            <div class="form-group">
                                <input type="hidden" name="taskIdentificateur" value="<?php echo $row[3];?>">
                                <label for="issueId">User Story:</label>
                                <input type="text" class="form-control" id="issueId" name="issueId">
                            </div>
                            <button type="submit" name="lier" class="btn btn-primary">Lier</button>
                        </form>
                    </div>
                    <br>
                    <!--MODIFIER UNE TÂCHE  -->
                    <button type="button" class="btn  btn-dark" data-toggle="collapse" data-target="<?php echo "#modifier".$i;?>">
                        Modifier la tâche
                    </button>
                    <div id="<?php echo "modifier".$i; ?>" class="collapse">
                        <!-- Le formulaire d'attribution de la tâche -->
                        <form method="POST">
                            <div class="form-group">
                                <input type="hidden" name="taskId" value="<?php echo $row[3];?>">
                                <label for="descriptionTask">Description:</label>
                                <input type="text" class="form-control" id="descriptionTask" name="descriptionTask" placeholder="<?php echo $row[0];?>">
                                <br>
                                <label for="durationTask">Durée:</label>
                                <input type="text" class="form-control" id="durationTask" name="durationTask" placeholder="<?php echo $row[1];?>">
                            </div>
                            <button type="submit" name="modifier" class="btn btn-primary">Modifier</button>
                        </form>
                    </div>
                    <!-- DELETE-->
                    <br><br>
                    <form method="POST">
                        <input type="hidden" name="taskId" value="<?php echo $row[3];?>">
                        <button type="submit" name="delete" class="btn btn-secondary">Supprimer</button>
                    </form>
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
