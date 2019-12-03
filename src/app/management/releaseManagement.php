<?php
include_once 'historiqueManagement.php';

function startRelease(){
    session_start();
    if($_SESSION['projectId'] == null){
        header("Location:../../index.php");
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
    $sql = $conn->prepare("INSERT INTO `release` (VERSION,DESCRIPTION,DATE_RELEASE,URL_DOCKER,ID_PROJET)
    VALUES (?,?,?,?,?)");
    $sql->bind_param("ssssi",$version,$description,$date,$lien,$idProjet);
    $sql->execute();
    addHistorique($idProjet,"La release ".$version." a été créée");
    return $sql->get_result();
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
    addHistorique($idProjet,"Une release a été supprimée");
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
    $sql = $conn->prepare("UPDATE `release`
    SET VERSION=?,DESCRIPTION=?,
    DATE_RELEASE=?,URL_DOCKER=? 
    WHERE ID_RELEASE = ?");
    $sql->bind_param("ssssi",$releaseVersion,$releaseDescription,$releaseDate,$releaseLink,$releaseID);
    $sql->execute();
    addHistorique($projectID,"La release ".$releaseVersion." a été modifiée");
    return "Votre release a bien été modifiée";
}
?>
