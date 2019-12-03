<?php
include_once 'historiqueManagement.php';

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
    $sql = $conn->prepare("INSERT INTO `test` (ID_PROJET, DATE_DEBUT, ETAT, DESCRIPTION)
    VALUES (?,?,?,?)");
    $sql->bind_param("isss",$idProjet,$date,$etat,$description);
    $sql->execute();
    addHistorique($idProjet,"Un test a été créé");
    header("Location:tests.php");
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
    addHistorique($idProjet,"Un test a été supprimé");
    header("Location:tests.php");
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
    $sql = $conn->prepare("UPDATE test
    SET DESCRIPTION=?, DATE_DEBUT=?, ETAT=?
    WHERE ID_TEST = ?");
    $sql->bind_param("sssi",$testDescription,$testDate,$testEtat,$testID);
    $sql->execute();
    addHistorique($idProjet,"Un test a été modifié");
    header("Location: tests.php");
    return "Votre test a bien été modifiée";
}

function getSuccessPercent($idProjet){
    $conn = connect();
    $query = "SELECT ETAT FROM `test` WHERE ID_PROJET = '$idProjet'";
    $result = mysqli_query($conn, $query);
    $num_rows = mysqli_num_rows($result);
    if($num_rows==0){
        return 0;
    }
    else{
        $num_success = 0;
        while($row = mysqli_fetch_row($result)){
            if($row[0] == "Réussite"){
                $num_success++;
            }
        }
        return round(($num_success*100)/$num_rows);
    }
}
