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
    $sqlTest1 = "SELECT ID_USER_STORY FROM `issue` WHERE ID_PROJET = '$projectID' AND DESCRIPTION = '$description' AND ID_USER_STORY != '$idUS'";
    $result1 = mysqli_query($conn, $sqlTest1);
    if (mysqli_num_rows($result1) > 0) {
        return "Cette US existe déjà";
    } else {
        $sql = "UPDATE `issue`
        SET PRIORITE = '$priority', DIFFICULTE = '$difficulty', DESCRIPTION = '$description'
        WHERE ID_USER_STORY = '$idUS'";
        mysqli_query($conn, $sql);
        return "Votre issue a bien été modifiée";
    }
}
