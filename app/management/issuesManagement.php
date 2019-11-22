<?php
function addIssue($conn, $idProjet){
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
        $query = "INSERT INTO issue (ID_USER_STORY, PRIORITE, DIFFICULTE, DESCRIPTION, ID_PROJET)
            VALUES ('$idUS','$priority','$difficulty','$description','$idProjet')";
        if (!mysqli_query($conn, $query)) {
            echo "Error: " . $query . "<br>" . $conn->connect_error . "<br>";
        }
    }
}

function deleteIssue($conn, $idProjet)
{
    if (isset($_POST['delete'])) {
        $issueID = $_POST['id'];
        $query = "DELETE FROM issue WHERE ID_USER_STORY = '$issueID' AND ID_PROJET = '$idProjet'";
        mysqli_query($conn, $query);
    }
}

function editIssue($conn){

}
