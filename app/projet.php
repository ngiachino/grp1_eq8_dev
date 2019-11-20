<?php

include '../database/DBconnect.php';
include 'membersManagement.php';
include 'projectManagement.php';
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
//test si l'utilisateur est bien passé par sa page de profil. Sinon le renvoie vers le profil
else if( $_GET['title'] == null || $_GET['owner'] == null){
    header("Location:profil.php");
}

$projectTitle = $_GET['title'];
$projectOwner = $_GET['owner'];
$query2 = "SELECT ID_PROJET FROM projet JOIN utilisateur ON projet.ID_MANAGER = utilisateur.ID_USER WHERE NOM_PROJET ='$projectTitle' AND NOM_USER='$projectOwner'";
$result2 = mysqli_query($conn, $query2);
$projectId = mysqli_fetch_row($result2)[0];
$_SESSION['projectId'] = $projectId;

$message = addMember($conn, $projectId);
deleteProject($conn, $_SESSION['userID'], $projectTitle, $projectOwner);

$query = "SELECT * FROM membre WHERE ID_PROJET = '$projectId'";
$result1 = mysqli_query($conn, $query);
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include './defaultHead.php'; ?>
    <title>Projet : <?php echo $projectTitle?> - GoProject</title>
    <link href="../assets/css/projet.css" rel="stylesheet">
</head>

<body>
<div class="menuBar">
    <div class="float-left">
        <a href="profil.php">GoProject</a>
    </div>
    <div class="float-right">
        <a class="disconnect" href="./index.php">Se déconnecter</a>
    </div>
</div>

<h1>
    <?php echo $projectTitle?>
</h1>

<div class="container">
    <div class="row mb-2">
        <div class="col-sm">
            <a class="projectComponent" href="issues.php">
                <h2>Les issues</h2>
            </a>
        </div>

        <div class="col-sm">
            <a class="projectComponent" href="sprints.php">
                <h2>Les sprints</h2>
            </a>
        </div>

        <div class="col-sm">
            <a class="projectComponent" href="#">
                <h2>Les releases</h2>
            </a>
        </div>

        <div class="col-sm">
            <a class="projectComponent" href="tests.php">
                <h2>Les test</h2>
            </a>
        </div>

        <div class="col-sm">
            <a class="projectComponent" href="#">
                <h2>La doc</h2>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-5">
            <div class="membersList">
                Informations
                <form class="d-inline" method="post">
                    <button class="btn btn-info" type="submit" name="modify">Modifier</button>
                    <button class="btn btn-danger" type="submit" name="delete">Supprimer</button>
                </form>
            </div>
        </div>

        <div class="col-7">
            <div class="membersList">
                <form class="form-container d-inline" method="POST">
                    <input type="text" name="userName" placeholder="Pseudo ou Email" id="userName">
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
                    <?php while($member = mysqli_fetch_row($result1)) { ?>
                        <li><?php echo '- '.$member[2] ?>
                            <form method="post">
                                <input type="hidden" name="name" value="<?php echo $member[2];?>">
                                <input type="<?php if($member[2] == $projectOwner){echo "hidden";} else{echo "submit";} ?>" name="deleteUser" value="&#x274C;">
                            </form>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>

</body>
</html>

<?php
if(isset($_POST['deleteUser'])){
    $userToDelete = $_POST['name'];
    $query = "DELETE FROM membre WHERE NOM_MEMBRE = '$userToDelete'";
    $result = mysqli_query($conn,$query);
    header("Refresh:0");
}
?>
