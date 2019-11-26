<?php
function startRelease(){
    session_start();
    if($_SESSION['projectId'] == null){
        header("Location:index.php");
    }
    return $_SESSION['projectId'];
}
function viewReleases($idProjet){
    $conn = connect();
    $query = "SELECT VERSION,DESCRIPTION,DATE_RELEASE,URL_DOCKER,ID_RELEASE FROM `release` WHERE ID_PROJET = '$idProjet' ORDER BY DATE_RELEASE";
    return mysqli_query($conn, $query);
}
function startAddRelease($idProjet){
    if (isset($_POST['submit'])) {
        $description = $_POST['description'];
        $version = $_POST['version'];
        $lien = $_POST['lien'];
        $date = $_POST['date'];
        addRelease($idProjet,$description,$version,$lien,$date);
    }
}
function addRelease($idProjet,$description,$version,$lien,$date){
    $conn = connect();
    $query = "INSERT INTO `release` (VERSION,DESCRIPTION,DATE_RELEASE,URL_DOCKER,ID_PROJET)
        VALUES ('$version','$description','$date','$lien','$idProjet')";
    mysqli_query($conn, $query);
}

function startDeleteRelease($idProjet){
    if (isset($_POST['delete'])) {
        $releaseID = $_POST['id'];
        deleteRelease($idProjet,$releaseID);
    }
}
function deleteRelease($idProjet,$releaseID){
    $conn = connect();
    $query = "DELETE FROM `release` WHERE ID_RELEASE = '$releaseID' AND ID_PROJET = '$idProjet'";
    mysqli_query($conn, $query);
}
function startModifyRelease($projectID){
    if(isset($_POST['modify'])){
        $releaseID = $_POST['id'];
        $releaseVersion = $_POST['version'];
        $releaseLink = $_POST['link'];
        $releaseDescription = $_POST['description'];
        $releaseDate = $_POST['date'];
        return modifyRelease($projectID,$releaseID,$releaseVersion,$releaseLink,$releaseDescription,$releaseDate);
    }
}
function modifyRelease($projectID,$releaseID,$releaseVersion,$releaseLink,$releaseDescription,$releaseDate){
    $conn = connect();
    //test que l'utilisateur n'a pas déjà créé un projet du même nom
    $sqlTest1 = "SELECT ID_RELEASE FROM `release` WHERE VERSION = '$releaseVersion' AND ID_PROJET = '$projectID' AND ID_RELEASE != '$releaseID'";
    $result1 = mysqli_query($conn, $sqlTest1);
    if (mysqli_num_rows($result1) > 0) {
        return "Ce numéro de version existe déjà";
    } else {
        $sql = "UPDATE `release`
        SET VERSION='$releaseVersion',DESCRIPTION='$releaseDescription',
        DATE_RELEASE='$releaseDate',URL_DOCKER='$releaseLink' 
        WHERE ID_RELEASE = '$releaseID'";
        mysqli_query($conn, $sql);
        return "Votre release a bien été modifiée";
    }
}
?>
