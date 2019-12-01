<?php
function startTests(){
    session_start();

    if($_SESSION['projectId'] == null){
        header("Location:../../index.php");
    }
    return $_SESSION['projectId'];
}

function showTests($idProjet){
    $conn = connect();
    $query = "SELECT DATE_DEBUT,ETAT,DESCRIPTION,ID_TEST FROM `test` WHERE ID_PROJET = '$idProjet' ORDER BY ID_TEST";
    return mysqli_query($conn, $query);
}


function startAddTest($idProjet){
    if (isset($_POST['submit'])) {
        $description = $_POST['description'];
        $etat = $_POST['etat'];
        $date = $_POST['date'];
        addTest($idProjet,$description,$etat,$date);
    }
}
function addTest($idProjet,$description,$etat,$date){
    $conn = connect();
    $query = "INSERT INTO `test` (ID_PROJET, DATE_DEBUT, ETAT, DESCRIPTION)
        VALUES ('$idProjet','$date','$etat','$description')";
    mysqli_query($conn, $query);
    header("Location: tests.php");
}

function startDeleteTest($idProjet){
    if (isset($_POST['delete'])) {
        $testID = $_POST['id'];
        deleteTest($idProjet,$testID);
    }
}
function deleteTest($idProjet,$testID){
    $conn = connect();
    $query = "DELETE FROM `test` WHERE ID_TEST = '$testID' AND ID_PROJET = '$idProjet'";
    mysqli_query($conn, $query);
    header("Location: tests.php");
}
function startModifyTest($idProjet){
    if(isset($_POST['modify'])){
        $testDescription = $_POST['description'];
        $testEtat = $_POST['etat'];
        $testDate = $_POST['date'];
        $testID = $_POST['id'];
        modifyTest($idProjet,$testDescription,$testEtat,$testDate,$testID);
    }
}
function modifyTest($idProjet,$testDescription,$testEtat,$testDate,$testID){
    $conn = connect();
    //test que l'utilisateur n'a pas déjà créé un projet du même nom
    $sqlTest1 = "SELECT ID_TEST FROM `test` WHERE ID_PROJET = '$idProjet' AND ID_TEST != '$testID'";
    $result1 = mysqli_query($conn, $sqlTest1);

    if (mysqli_num_rows($result1) > 0) {
        return "Ce test existe déjà";
    } else {
        $sql = "UPDATE test
        SET DESCRIPTION='$testDescription', DATE_DEBUT='$testDate', ETAT='$testEtat' 
        WHERE ID_TEST = '$testID'";
        mysqli_query($conn, $sql);
        header("Location: tests.php");
        return "Votre test a bien été modifiée";
    }
}
