<?php
include_once 'historiqueManagement.php';

function startAddSprint($conn, $projectId)
{
    if (isset($_POST['submit'])) {
        $sprintName = $_POST['name'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        //test que tous les champs sont remplis
        if (empty($sprintName) || empty($startDate) || empty($endDate)) {
            return "Vous devez remplir tous les champs";
        }
        if($startDate>$endDate){
            return "La date de début ne peut pas être supérieure à celle de la fin";
        }
        else{
            addSprint($conn, $projectId,$sprintName,$startDate,$endDate);
        }
    }
}

function addSprint($conn,$projectID,$sprintName, $startDate, $endDate)
{
    //test que l'utilisateur n'a pas déjà créé un sprint  du même nom
    $sql = $conn->prepare("SELECT ID_SPRINT FROM sprint WHERE NOM_SPRINT = ? AND ID_PROJET = ?");
    $sql->bind_param("si",$sprintName,$projectID);
    $sql->execute();
    $result1 = $sql->get_result();

    if (mysqli_num_rows($result1) > 0) {
        return "Vous avez déjà créé un sprint du même nom";
    } else {
        $sql = $conn->prepare("INSERT INTO sprint (NOM_SPRINT, ID_PROJET, DATE_DEBUT, DATE_FIN)
                                    VALUES (?,?,?,?)");
        $sql->bind_param("siss",$sprintName,$projectID,$startDate,$endDate);
        $sql->execute();
        addHistorique($projectID,"Le ".$sprintName." a été ajouté au projet");
        return "Votre sprint a bien été crée";
    }
}
function startDeleteSprint($conn){
    if (isset($_POST['delete'])) {
        $sprintID = $_POST['id'];
        deleteSprint($conn,$sprintID);
    }
}

function deleteSprint($conn, $sprintId)
{
    $query="SELECT NOM_SPRINT, ID_PROJET FROM sprint WHERE ID_SPRINT ='$sprintId'";
    $result=mysqli_query($conn,$query);
    $row = mysqli_fetch_row($result);
    $sprintName=$row[0];
    $projectID =$row[1];
    $query = "DELETE FROM sprint WHERE ID_SPRINT = '$sprintId'";
    mysqli_query($conn,$query);
    addHistorique($projectID,"Le".$sprintName." a été supprimé du projet");
    return "votre sprint a été supprimé";
}
function startModifySprint($conn,$projectId){
    if(isset($_POST['modify'])){
        $sprintID = $_POST['id'];
        $sprintName = $_POST['name'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        //test que tous les champs sont remplis
        if (empty($sprintName) || empty($startDate) || empty($endDate)) {
            return "Vous devez remplir tous les champs";
        }
        if($startDate>$endDate){
            return "La date de début ne peut pas être supérieure à celle de la fin";
        }
        else {
            modifySprint($conn,$projectId,$sprintID,$sprintName,$startDate,$endDate);
        }
    }
}

function modifySprint($conn,$projectID,$sprintID,$sprintName,$startDate,$endDate){
        //test que l'utilisateur n'a pas déjà créé un sprint du même nom
        $sql = $conn->prepare("SELECT ID_SPRINT FROM sprint WHERE NOM_SPRINT = ? AND ID_PROJET = ? AND ID_SPRINT != ?");
        $sql->bind_param("sii",$sprintName,$projectID,$sprintID);
        $sql->execute();
        $result1 = $sql->get_result();
        if (mysqli_num_rows($result1) > 0) {
            return "Vous avez déjà créé un sprint du même nom";
        } else {
            $sql = $conn->prepare("UPDATE sprint
            SET NOM_SPRINT=?, DATE_DEBUT=?, DATE_FIN=?
            WHERE ID_SPRINT = ?");
            $sql->bind_param("sssi",$sprintName,$startDate,$endDate,$sprintID);
            $sql->execute();
            addHistorique($projectID,$sprintName." a été modifié");
            return "Votre sprint a bien été modifié";
        }
}

function getSprintData($conn, $projectId, $sprintId){
    $queryGetSprint = "SELECT * FROM sprint
                       WHERE ID_PROJET = $projectId 
                            AND ID_SPRINT = '$sprintId'";
    return mysqli_query($conn, $queryGetSprint);
}

function getDaysSprint($conn, $projectId, $sprintId){

    $queryMinusDate = "SELECT DATE_DEBUT, DATE_FIN, CURDATE()
                       FROM sprint
                       WHERE ID_SPRINT='$sprintId'
                         AND ID_PROJET='$projectId'";
     return mysqli_query($conn,$queryMinusDate);
}



function getTasksSprint($conn){

if ($_GET['projectId'] == null || $_GET['sprintId'] == null) {
    header("Location:sprints.php");
}
$sprintId = $_GET['sprintId'];

//Récuperer les tâches d'un sprint
$query = "SELECT *
          FROM Sprint
          WHERE ID_SPRINT = $sprintId";
mysqli_query($conn, $query);

}

?>
