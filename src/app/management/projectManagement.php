<?php

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
        return null;
    }
    else {
        return $result;
    }
}

function startAddProject(){
    if (isset($_POST['submit'])) {
        $projectName = $_POST['name'];
        $projectDesc = $_POST['description'];
        $userName = $_SESSION['userName'];
        $userID = $_SESSION['userID'];
        return addProject($projectName,$projectDesc,$userName,$userID,true);
    }
    return null;
}

function addProject($projectName,$projectDesc,$userName,$userID,$processIsolation){
    $conn = connect();
    //test que tous les champs sont remplis
    if (empty($projectName) || empty($projectDesc)) {
        return "Vous devez remplir tous les champs";
    } else {
        //test que l'utilisateur n'a pas déjà créé un projet du même nom
        $sqlTest1 = "SELECT ID_PROJET FROM projet WHERE NOM_PROJET = '$projectName' AND ID_MANAGER = '$userID'";
        $result1 = mysqli_query($conn, $sqlTest1);

        if (mysqli_num_rows($result1) > 0) {
            return "Vous avez déjà créé un projet du même nom";
        } else {
            $sql = "INSERT INTO projet (NOM_PROJET, ID_MANAGER, DESCRIPTION)
            VALUES ('$projectName','$userID','$projectDesc')";

            $sql2 = "INSERT INTO membre (ID_MEMBRE, ID_PROJET, NOM_MEMBRE)
            VALUES ('$userID',LAST_INSERT_ID(),'$userName')";
            mysqli_query($conn, $sql);
            mysqli_query($conn, $sql2);
            if($processIsolation){
                header("Location: profil.php");
            }
            return "Votre projet a bien été créé";
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
    return "Votre projet a bien été supprimé";
}

function startModifyProject($projectID)
{
    if (isset($_POST['modify'])) {
        $projectName = $_POST['name'];
        $projectDesc = $_POST['description'];
        return modifyProject($projectID, $projectName, $projectDesc);
    }
    return null;
}

function modifyProject($projectID,$projectName,$projectDesc){
    $conn = connect();
    $userName = $_SESSION['userName'];
    //teste qu'un projet de même ID n'a pas déjà été créée
    $sqlTest1 = "SELECT ID_PROJET FROM `projet` WHERE NOM_PROJET = '$projectName'AND ID_PROJET != '$projectID'";
    $result1 = mysqli_query($conn, $sqlTest1);
    if (mysqli_num_rows($result1) > 0) {
        return "Ce projet existe déjà";
    } else {
        $sql = "UPDATE `projet`
        SET NOM_PROJET = '$projectName', DESCRIPTION = '$projectDesc'
        WHERE ID_PROJET = '$projectID'";
        mysqli_query($conn, $sql);
        header("Location:projet.php?title=$projectName&owner=$userName");
        return "Votre projet a bien été modifié";
    }
}

function getUserTasks()
{   $conn = connect();
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
