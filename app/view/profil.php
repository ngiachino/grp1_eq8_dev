<?php
include '../management/projectManagement.php';
include '../../database/DBconnect.php';
session_start();
$result1 = startProfil();
$message = startAddProject();
$userTasks = getUserTasks();
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include './defaultHead.php'; ?>
    <title>Mon profil - GoProject</title>
    <link href="../../assets/css/profil.css" rel="stylesheet">
</head>


<body>

<div class = "menuBar">
    <span id="title">GoProject</span>
    <div class="float-right">
        <a class="disconnect" href="./index.php">Se déconnecter</a>
    </div>
</div>

<h1>Mon Profil</h1>

<div class="container">
    <div class="row justify-content-aroud">
        <div class = "col-sm-4">
            <table class="table table-bordered table-hover" id="projectsList">
                <tr>
                    <th class="listTitle text-center" id="projectListTitle">Mes projets</th>
                </tr>
                <?php $i = 0;
                while($row1 = mysqli_fetch_row($result1)){?>
                    <tr>
                        <td class="tdProject">
                            <a class="d-inline-block w-100 h-100" href="./projet.php?title=<?php echo $row1[0];?>&owner=<?php echo $row1[1];?>">
                                <span class="projectTitle"><?php echo $row1[0];?></span>
                                <br/>
                                <span class="projectOwner">Créateur : <?php echo $row1[1];?></span>
                            </a>
                        </td>
                    </tr>
                    <?php
                    $i++;
                }
                while ($i<4){
                    echo '<tr><td></td></tr>';
                    $i++;
                }
                ?>
            </table>
        </div>

        <div class="col-sm-4" id="openNewProjectForm">
            <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#newProjectModal" id="addButton">Créer un nouveau projet</button>
        </div>

        <div class = "col-sm-4">
            <table class="table table-bordered table-hover" id="TasksList">
                <tr>
                    <th class="listTitle text-center" id="taskListTitle">Mes tâches</th>
                </tr>

                <!--DESCRIPTION, ID_SPRINT, NOM_PROJET, DATE_DEBUT, DATE_FIN-->
                <?php
                while($userTasks && $tasks = mysqli_fetch_row($userTasks))
                {
                    ?>
                    <tr>
                        <td>
                            <span> <?php echo $tasks[0]; ?> - Sprint : <?php echo $tasks[1]; ?></span>
                            <br/>
                            <span class="subtitle">Projet : <?php echo $tasks[2] ;  ?></span>
                            <br/>
                            <span class="subtitle">Du  <?php echo $tasks[3] ;?> au <?php echo $tasks[4] ;?></span>
                        </td>
                    </tr>
                <?php }  ?>

                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="newProjectModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nouveau projet</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="form-group">
                        <label for="projectName">Nom du projet</label>
                        <input type="text" class="form-control" placeholder="Nom" id="projectName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="projectDescription">Description</label>
                        <textarea class="form-control" placeholder="Description" id="projectDescription" name="description" required></textarea>
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

<span class="m-4">
<?php
echo $message;
?>
</span>


</body>
</html>
