<?php
function addTest($conn, $idProjet){
    if (isset($_POST['submit'])) {
        $description = $_POST['description'];
        $etat = $_POST['etat'];
        $date = $_POST['date'];
        $query = "INSERT INTO `test` (ID_PROJET, DATE_DEBUT, ETAT, DESCRIPTION)
            VALUES ('$idProjet','$date','$etat','$description')";
        if (mysqli_query($conn, $query) === FALSE) {
            echo "Error: " . $query . "<br>" . $conn->error . "<br>";
        }
    }
}
function deleteTest($conn, $idProjet)
{
    if (isset($_POST['delete'])) {
        $testID = $_POST['id'];
        $query = "DELETE FROM `test` WHERE ID_TEST = '$testID' AND ID_PROJET = '$idProjet'";
        mysqli_query($conn, $query);
    }
}
function modifyTest($conn,$projectID){
    if(isset($_POST['modify'])){
        $description = $_POST['description'];
        $etat = $_POST['etat'];
        $date = $_POST['date'];
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
            if (mysqli_query($conn, $sql) === FALSE) {
                echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
            } else {
                return "Votre release a bien été modifiée";
            }
        }
    }
}
