<?php
include_once '../../database/DBconnect.php';
include '../management/membersManagement.php';
include '../management/projectManagement.php';
include_once '../management/historiqueManagement.php';

$projectId = startProject();
$message = startAddMember($projectId);
$messageDelMember = startDeleteMember($projectId);
$messageDelProject = startDeleteProject($projectId);
$messageModif = startModifyProject($projectId);
$result1 = showMembers($projectId);
$result12 = getCurrentProject($projectId);
$rowProject = mysqli_fetch_row($result12);
$historiques = showHistorique($projectId);
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include './defaultHead.php'; ?>
    <title>Projet : <?php echo $_GET['title']?> - GoProject</title>
    <link href="../../assets/css/projet.css" rel="stylesheet">
</head>

<body>
<?php include 'navbar.php'; ?>

<h1>
    <?php echo $_GET['title']?>
</h1>

<div class="container">
    <div class="row mb-2">
        <div class="col-sm">
            <a class="projectComponent" id="issues" href="issues.php">
                <h2>Issues</h2>
            </a>
        </div>

        <div class="col-sm">
            <a class="projectComponent" id="sprints" href="sprints.php">
                <h2>Sprints</h2>
            </a>
        </div>

        <div class="col-sm">
            <a class="projectComponent" id="releases" href="release.php">
                <h2>Releases</h2>
            </a>
        </div>

        <div class="col-sm">
            <a class="projectComponent" id="tests" href="tests.php">
                <h2>Tests</h2>
            </a>
        </div>

        <div class="col-sm">
            <a class="projectComponent" id="documentation" href="documentation.php">
                <h2>Documents</h2>
            </a>
        </div>
    </div>
    <!--Encadré contenant l'Historique et les boutons de modification du projet-->
    <div class="row">
        <div class="col-5">
            <div class="membersList">
                Informations
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modifyProjectModal">Modifier</button>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delProjectModal">Supprimer</button>
                <div>Description : <?php echo $rowProject[3];?></div>
                <div class="py-2">Historique :</div>
                <div class="scrollable">
                    <ul class="list-group list-group-flush" id="historique">
                    <?php $i=0;
                        while($i<10){
                            if($historique = mysqli_fetch_row($historiques)){
                                echo "<li class='list-group-item'>".$historique[0]."</li>";
                            
                            }
                            else{
                                echo "<li class='list-group-item'>-</li>";
                            }
                            $i++;
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
         <!--Liste des membres d'un projet-->               
        <div class="col-7">
            <div class="membersList">
                <form class="form-container d-inline" method="POST">
                    <input type="text" name="userName" class="form-control w-50 d-inline mb-2" placeholder="Pseudo ou Email" id="userName">
                    <input type="submit" name="submit" class="submit btn btn-outline-danger" value="Inviter membre">
                </form>
                <span class="p-3 small font-weight-bold">
                    <?php
                    echo $message;
                    ?>
                </span>
                <div>
                    Liste des membres :
                </div>

                <ul>
                    <?php $i = 0;
                        while($member = mysqli_fetch_row($result1)) { ?>
                        <li class="d-flex"><?php echo '- '.$member[0] ?>
                            <form method="post">
                                <input class="" type="hidden" name="name" value="<?php echo $member[0];?>">
                                <button class="deleteElement fas fa-times btn bg-transparent btn-sm float-left" style="display:<?php if($member[0] == $_GET['owner']){echo "none";} else{echo "";} ?>" name="deleteUser" id="<?php echo $member[0];?>"></button>
                            </form>
                        </li>
                    <?php $i++;
                    } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<!--Modal de suppression de projet-->
<div class="modal" tabindex="-1" role="dialog" id="delProjectModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Voulez-vous vraiment supprimer le projet?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
                <div class="modal-footer">
                    <input type="submit" class="btn btn-danger" name="delete" value="Supprimer">
                    <button type="button" class="btn btn-secondary buttonCancel" data-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Modal de modification de projet-->
<div class="modal" tabindex="-1" role="dialog" id="modifyProjectModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier Projet</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $rowProject[0];?>">
                    <div class="form-group">
                        <label for="projectName">Nom du projet</label>
                        <input type="text" class="form-control" id="projectName" name="name" value="<?php echo $_GET['title']?>">
                    </div>
                    <div class="form-group">
                        <label for="projectDesc">Description du projet</label>
                        <textarea class="form-control" name="description" id="projectDesc"><?php echo $rowProject[3];?></textarea>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="modify" class="btn btn-primary" value="Modifier">
                        <button type="button" class="btn btn-secondary buttonCancel" data-dismiss="modal">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php echo $messageModif?>
</div>

<span class="m-4 font-weight-bold">
<?php echo $messageModif?>
</span>

</body>
</html>
