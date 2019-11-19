<?php
include './projectCreation.php';
include '../database/DBconnect.php';
$conn = connect();
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();

//test si l'utilisateur est connecté. Sinon le renvoie vers l'index
if($_SESSION['userName'] == null || $_SESSION['userID'] == null){
    header("Location:index.php");
}

$userName = $_SESSION['userName'];
$userID = $_SESSION['userID'];

$message = addProject($conn, $userID, $userName);

//Selection liste de projets
$query = "SELECT NOM_PROJET,NOM_USER FROM projet
JOIN utilisateur ON projet.ID_MANAGER = utilisateur.ID_USER
JOIN membre ON projet.ID_PROJET = membre.ID_PROJET
WHERE ID_MEMBRE = '$userID'";
$result1 = mysqli_query($conn,$query);
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include './defaultHead.php'; ?>
    <title>Mon profil - GoProject</title>
    <link href="../assets/css/profil.css" rel="stylesheet">
</head>


<body>
<div class = "menuBar">
    <span id="title">GoProject</span>
    <div class="menuBar-right">
        <a class="disconnect" href="./index.php">Se déconnecter</a>
    </div>
</div>

<h1 class="text-center">Mon Profil</h1>

<div class="container">
    <div class="row justify-content-aroud">
        <div class = "col-sm-4">
            <table class="table table-bordered table-hover" id="projectsList" summary="Table des projets de l'utilisateur">
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
                                <span class="projectOwner"><?php echo $row1[1];?></span>
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
            <table class="table table-bordered table-hover" id="TasksList" summary="Table des tâches de l'utilisateur">
                <tr>
                    <th class="listTitle text-center" id="taskListTitle">Mes tâches</th>
                </tr>
                <tr>
                    <td>
                        <span>T3 - Sprint1</span>
                        <br/>
                        <span class="subtitle">Nom du projet</span>
                        <br/>
                        <span class="subtitle">Du 04/11/2019 au 11/11/2019</span>
                    </td>
                </tr>
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

<?php
echo $message;
?>


</body>
</html>
