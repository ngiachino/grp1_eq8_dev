<?php
function addRelease($conn, $idProjet){
    if (isset($_POST['submit'])) {
        $description = $_POST['description'];
        $version = $_POST['version'];
        $lien = $_POST['lien'];
        $date = $_POST['date'];
        $query = "INSERT INTO `release` (VERSION,DESCRIPTION,DATE_RELEASE,URL_DOCKER,ID_PROJET)
            VALUES ('$version','$description','$date','$lien','$idProjet')";
        if (!mysqli_query($conn, $query)) {
            echo "Error: " . $query . "<br>" . $conn->error . "<br>";
        }
    }
}
function deleteRelease($conn, $idProjet)
{
    if (isset($_POST['delete'])) {
        $releaseID = $_POST['id'];
        $query = "DELETE FROM `release` WHERE ID_RELEASE = '$releaseID' AND ID_PROJET = '$idProjet'";
        mysqli_query($conn, $query);
    }
}
function modifyRelease($conn,$projectID){
    if(isset($_POST['modify'])){
        $releaseID = $_POST['id'];
        $releaseVersion = $_POST['version'];
        $releaseLink = $_POST['link'];
        $releaseDescription = $_POST['description'];
        $releaseDate = $_POST['date'];
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
            if (!mysqli_query($conn, $sql)) {
                echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
            } else {
                return "Votre release a bien été modifiée";
            }
        }
    }
}
?>
