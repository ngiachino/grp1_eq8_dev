<?php

function startProfil(){
    $conn = connect();
    //test si l'utilisateur est connecté. Sinon le renvoie vers l'index
    if($_SESSION['userName'] == null || $_SESSION['userID'] == null){
        header("Location:index.php");
    }
    $userID = $_SESSION['userID'];
    //Selection liste de projets
    $query = "SELECT DISTINCT NOM_PROJET,NOM_USER FROM projet
    JOIN utilisateur ON projet.ID_MANAGER = utilisateur.ID_USER
    JOIN membre ON projet.ID_PROJET = membre.ID_PROJET
    WHERE ID_MEMBRE = '$userID'";
    return mysqli_query($conn,$query);
}

function startAddProject(){
    if (isset($_POST['submit'])) {
        $projectName = $_POST['name'];
        $projectDesc = $_POST['description'];
        $userName = $_SESSION['userName'];
        $userID = $_SESSION['userID'];
        return addProject($projectName,$projectDesc,$userName,$userID,true);
    }
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
?>