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
        $query = "SELECT MAX(ID_USER_STORY) FROM issue WHERE ID_PROJET='$idProjet'";
        $result = mysqli_query($conn, $query);
        if (!mysqli_query($conn, $query)) {
            //Si il n'y a pas encore d'issue pour ce projet
            $idUS = 1;
        } else {
            $idUS = mysqli_fetch_row($result)[0] + 1;
        }
        $description = $_POST['description'];
        $priority = $_POST['priority'];
        $difficulty = $_POST['difficulty'];
        addIssue($idProjet,$idUS,$description,$priority,$difficulty);
    }
}

function addIssue($idProjet,$idUS,$description,$priority,$difficulty){
    $conn = connect();
    $query = "INSERT INTO issue (ID_USER_STORY, PRIORITE, DIFFICULTE, DESCRIPTION, ID_PROJET)
        VALUES ('$idUS','$priority','$difficulty','$description','$idProjet')";
    mysqli_query($conn, $query);
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
}