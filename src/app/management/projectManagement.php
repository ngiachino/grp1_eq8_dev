<?php
include_once 'historiqueManagement.php';
include_once 'utils.php';

function startProfil(){
    $conn = connect();
    //test si l'utilisateur est connecté. Sinon le renvoie vers l'index
    if($_SESSION['userName'] == null || $_SESSION['userID'] == null){
        header("Location:../../index.php");
    }
    $userID = $_SESSION['userID'];
    //Selection liste de projets
    $query = "SELECT DISTINCT NOM_PROJET,NOM_USER FROM projet
    JOIN utilisateur ON projet.ID_MANAGER = utilisateur.ID_USER
    JOIN membre ON projet.ID_PROJET = membre.ID_PROJET
    WHERE ID_MEMBRE = '$userID'";
    return mysqli_query($conn,$query);
}

function getCurrentProject($projectId){
    $conn = connect();
    $queryProjet = " SELECT ID_PROJET,NOM_PROJET,ID_MANAGER,DESCRIPTION FROM projet WHERE ID_PROJET = '$projectId'";
    $result = mysqli_query($conn, $queryProjet);
    if(!($result)) {
        echo "Error: " . $queryProjet . "<br>" . $conn->error . "<br>";
        $result = null;
    }
    return $result;
}

function startAddProject(){
    if (isset($_POST['submit'])) {
        $projectName = $_POST['name'];
        $projectDesc = $_POST['description'];
        $userName = $_SESSION['userName'];
        $userID = $_SESSION['userID'];
        addProject($projectName,$projectDesc,$userName,$userID,true);
    }
}

function addProject($projectName,$projectDesc,$userName,$userID,$processIsolation){
    $conn = connect();
    //test que tous les champs sont remplis
    if (empty($projectName) || empty($projectDesc)) {
        aggregateMessage("Vous devez remplir tous les champs");
    } else {
        //test que l'utilisateur n'a pas déjà créé un projet du même nom
        $sql = $conn->prepare("SELECT ID_PROJET FROM projet WHERE NOM_PROJET = ? AND ID_MANAGER = ?");
        $sql->bind_param("si",$projectName,$userID);
        $sql->execute();
        $result1 = $sql->get_result();

        if (mysqli_num_rows($result1) > 0) {
            aggregateMessage("Vous avez déjà créé un projet du même nom");
        } else {

            $sql = $conn->prepare("INSERT INTO projet (NOM_PROJET, ID_MANAGER, DESCRIPTION)
            VALUES (?,?,?)");
            $sql->bind_param("sis",$projectName,$userID,$projectDesc);
            $sql->execute();

            $sql = $conn->prepare("INSERT INTO membre (ID_MEMBRE, ID_PROJET, NOM_MEMBRE)
            VALUES (?,LAST_INSERT_ID(),?)");
            $sql->bind_param("is",$userID,$userName);
            $sql->execute();


            if($processIsolation){
                header("Location: profil.php");
            }
            aggregateMessage("Votre projet a bien été créé");
        }
    }
}

function startDeleteProject($idProject){
    if (isset($_POST['delete'])) {
        deleteProject($idProject,true);
    }
}

function deleteProject($idProject,$processIsolation){
    $conn = connect();
    $sql = "DELETE FROM projet WHERE ID_PROJET = '$idProject'";
    mysqli_query($conn, $sql);
    $sql = "DELETE FROM membre WHERE ID_PROJET = '$idProject'";
    mysqli_query($conn, $sql);
    $sql = "DELETE FROM release WHERE ID_PROJET = '$idProject'";
    mysqli_query($conn, $sql);
    $sql = "DELETE FROM sprint WHERE ID_PROJET = '$idProject'";
    mysqli_query($conn, $sql);
    $sql = "DELETE FROM tache WHERE ID_PROJET = '$idProject'";
    mysqli_query($conn, $sql);
    $sql = "DELETE FROM test WHERE ID_PROJET = '$idProject'";
    mysqli_query($conn, $sql);
    $sql = "DELETE FROM documentation WHERE ID_PROJET = '$idProject'";
    mysqli_query($conn, $sql);
    $sql = "DELETE FROM issue WHERE ID_PROJET = '$idProject'";
    mysqli_query($conn, $sql);
    if($processIsolation){
        header("Location: profil.php");
    }
    aggregateMessage("Votre projet a bien été supprimé");
}

function startModifyProject($projectID)
{
    if (isset($_POST['modify'])) {
        $projectName = $_POST['name'];
        $projectDesc = $_POST['description'];
        modifyProject($projectID, $projectName, $projectDesc);
    }
}

function modifyProject($projectID,$projectName,$projectDesc){
    $conn = connect();
    $userName = $_SESSION['userName'];

    //teste qu'un projet de même ID n'a pas déjà été créée
    $sql = $conn->prepare("SELECT ID_PROJET FROM `projet` WHERE NOM_PROJET = ? AND ID_PROJET != ?");
    $sql->bind_param("si",$projectName,$projectID);
    $sql->execute();
    $result1 = $sql->get_result();
    if (mysqli_num_rows($result1) > 0) {
        aggregateMessage("Ce projet existe déjà");
    } else {
        $sql = $conn->prepare("UPDATE `projet`
        SET NOM_PROJET = ?, DESCRIPTION = ?
        WHERE ID_PROJET = ?");
        $sql->bind_param("ssi",$projectName,$projectDesc,$projectID);
        $sql->execute();
        addHistorique($projectID,"Le projet a été modifié");
        header("Location:projet.php?title=$projectName&owner=$userName");
        aggregateMessage("Votre projet a bien été modifié");
    }
}

function getUserTasks(){
    $conn = connect();
    $userID = $_SESSION['userID'];
    $idCurrentSprint = getCurrentSprint($conn);
    $queryTask ="SELECT tache.DESCRIPTION, membre.ID_SPRINT, NOM_PROJET, DATE_DEBUT, DATE_FIN
                 FROM membre JOIN tache ON membre.ID_TACHE = tache.ID_TACHE
                             JOIN projet ON membre.ID_PROJET = projet.ID_PROJET
                             JOIN sprint ON membre.ID_SPRINT = sprint.ID_SPRINT 
                WHERE membre.ID_SPRINT = $idCurrentSprint and membre.ID_MEMBRE = $userID";
    return mysqli_query($conn, $queryTask);
}

function getCurrentSprint($conn){
    $currentSprintQuery = "SELECT ID_SPRINT FROM sprint 
                      ORDER BY ID_SPRINT
                      DESC LIMIT 1";

    $sprintId = mysqli_query($conn, $currentSprintQuery);
    if(!$sprintId){
        echo "Error: " . $currentSprintQuery . "<br>" . $conn->error . "<br>";
        return null;
    }
    else{
        return  mysqli_fetch_row($sprintId)[0];
    }
}
