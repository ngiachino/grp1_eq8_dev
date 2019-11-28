<?php
function startIssues(){
    if($_SESSION['projectId'] == null){
        header("Location:index.php");
    }
    return $_SESSION['projectId'];
}

function showIssues($idProjet){
    $conn = connect();
    $query = "SELECT ID_USER_STORY,PRIORITE,DIFFICULTE,DESCRIPTION FROM issue WHERE ID_PROJET = '$idProjet' ORDER BY ID_USER_STORY";
    return mysqli_query($conn, $query);
}

function startAddIssue($idProjet){
    $conn = connect();
    if (isset($_POST['submit'])) {
        $description = $_POST['description'];
        $priority = $_POST['priority'];
        $difficulty = $_POST['difficulty'];
        addIssue($idProjet,$description,$priority,$difficulty);
    }
}

function addIssue($idProjet,$description,$priority,$difficulty){
    $conn = connect();
    $query = "INSERT INTO issue (PRIORITE, DIFFICULTE, DESCRIPTION, ID_PROJET)
        VALUES ('$priority','$difficulty','$description','$idProjet')";
    mysqli_query($conn, $query);
    return "Votre issue a été créée";
}

function startDeleteIssue($idProjet){
    if (isset($_POST['delete'])) {
        $issueID = $_POST['id'];
        deleteIssue($issueID, $idProjet);
    }
}

function deleteIssue($issueID, $idProjet){
    $conn = connect();
    $query = "DELETE FROM issue WHERE ID_USER_STORY = '$issueID' AND ID_PROJET = '$idProjet'";
    mysqli_query($conn, $query);
    return "Votre issue a été supprimée";
}