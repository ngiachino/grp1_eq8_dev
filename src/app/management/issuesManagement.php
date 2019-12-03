<?php
include_once 'historiqueManagement.php';

function startIssues(){
    if($_SESSION['projectId'] == null){
        header("Location:../../index.php");
    }
    return $_SESSION['projectId'];
}

function showIssues($idProjet){
    $conn = connect();
    $sql = $conn->prepare("SELECT ID_USER_STORY,PRIORITE,DIFFICULTE,DESCRIPTION FROM issue WHERE ID_PROJET = ? ORDER BY ID_USER_STORY");
    $sql->bind_param("i",$idProjet);
    $sql->execute();
    return $sql->get_result();
}

function startAddIssue($idProjet){
    if (isset($_POST['submit'])) {
        $description = $_POST['description'];
        $priority = $_POST['priority'];
        $difficulty = $_POST['difficulty'];
        addIssue($idProjet,$description,$priority,$difficulty);
    }
}

function addIssue($idProjet,$description,$priority,$difficulty){
    $conn = connect();
    $sql = $conn->prepare("INSERT INTO issue (PRIORITE, DIFFICULTE, DESCRIPTION, ID_PROJET)
    VALUES (?,?,?,?)");
    $sql->bind_param("sisi",$priority,$difficulty,$description,$idProjet);
    $sql->execute();
    addHistorique($idProjet,"Une issue a été créée");
    return "Votre issue a été créée";
}

function startModifyIssue($projectID){
    if(isset($_POST['modify'])){
        $idUS = $_POST['id'];
        $priority = $_POST['priority'];
        $difficulty = $_POST['difficulty'];
        $description = $_POST['description'];
        return modifyIssue($projectID,$idUS,$priority,$difficulty,$description);
    }
}
function modifyIssue($projectID,$idUS,$priority,$difficulty,$description){
    $conn = connect();
    //test qu'une US de même description n'a pas déjà été créée
    $sqlTest1 = $conn->prepare("SELECT ID_USER_STORY FROM `issue` WHERE ID_PROJET = ? AND DESCRIPTION = ? AND ID_USER_STORY != ?");
    $sqlTest1->bind_param("isi",$projectID,$description,$idUS);
    $sqlTest1->execute();
    $result1 = $sqlTest1->get_result();
    if (mysqli_num_rows($result1) > 0) {
        return "Cette US existe déjà";
    } else {
        $sql = $conn->prepare("UPDATE `issue`
        SET PRIORITE = ?, DIFFICULTE = ?, DESCRIPTION = ?
        WHERE ID_USER_STORY = ?");
        $sql->bind_param("sisi",$priority,$difficulty,$description,$idUS);
        $sql->execute();
        addHistorique($projectID,"Une issue a été modifiée");
        return "Votre issue a bien été modifiée";
    }
}

function startDeleteIssue($idProjet){
    if (isset($_POST['delete'])) {
        $issueID = $_POST['id'];
        deleteIssue($issueID, $idProjet);
    }
}

function deleteIssue($issueID, $idProjet){
    $conn = connect();
    $sql = $conn->prepare("DELETE FROM issue WHERE ID_USER_STORY = ? AND ID_PROJET = ?");
    $sql->bind_param("ii",$issueID,$idProjet);
    $sql->execute();
    addHistorique($idProjet,"Une issue a été supprimée");
    return "Votre issue a été supprimée";
}
