<?php
function addTest($conn, $idProjet){
    if (isset($_POST['submit'])) {
        $description = $_POST['description'];
        $etat = $_POST['etat'];
        $date = $_POST['date'];
        $query = "INSERT INTO `test` (ID_PROJET, DATE_DEBUT, ETAT, DESCRIPTION)
            VALUES ('$idProjet','$date','$etat','$description')";
        if (!mysqli_query($conn, $query)) {
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
        $testDescription = $_POST['description'];
        $testEtat = $_POST['etat'];
        $testDate = $_POST['date'];
        $testID = $_POST['id'];
        //test que l'utilisateur n'a pas déjà créé un projet du même nom
        $sqlTest1 = "SELECT ID_TEST FROM `test` WHERE ID_PROJET = '$projectID' AND ID_TEST != '$testID'";
        $result1 = mysqli_query($conn, $sqlTest1);

        if (mysqli_num_rows($result1) > 0) {
            return "Ce test existe déjà";
        } else {
            $sql = "UPDATE test
            SET DESCRIPTION='$testDescription', DATE_DEBUT='$testDate', ETAT='$testEtat' 
            WHERE ID_TEST = '$testID'";
            if (!mysqli_query($conn, $sql)) {
                echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
            } else {
                return "Votre test a bien été modifiée";
            }
        }
    }
}
