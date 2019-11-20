<?php
function addRelease($conn, $idProjet){
    if (isset($_POST['submit'])) {
        $description = $_POST['description'];
        $version = $_POST['version'];
        $lien = $_POST['lien'];
        $date = $_POST['date'];
        $query = "INSERT INTO `release` (VERSION,DESCRIPTION,DATE_RELEASE,URL_DOCKER,ID_PROJET)
            VALUES ('$version','$description','$date','$lien','$idProjet')";
        if (mysqli_query($conn, $query) === FALSE) {
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
?>