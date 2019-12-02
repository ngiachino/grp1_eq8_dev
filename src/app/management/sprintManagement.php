<?php
function addSprint($conn,$projectID)
{
    if (isset($_POST['submit'])) {
        $sprintName = $_POST['name'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        //test que tous les champs sont remplis
        if (empty($sprintName) || empty($startDate) || empty($endDate)) {
            return "Vous devez remplir tous les champs";
        } else {
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
                return "Votre sprint a bien été crée";
            }
        }
    }
}
function deleteSprint($conn)
{
    if (isset($_POST['delete'])) {
        $sprintID = $_POST['id'];
        $query = "DELETE FROM sprint WHERE ID_SPRINT = '$sprintID'";
        mysqli_query($conn,$query);
    }
}
function modifySprint($conn,$projectID){
    if(isset($_POST['modify'])){
        $sprintID = $_POST['id'];
        $sprintName = $_POST['name'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        //test que tous les champs sont remplis
        if (empty($sprintName) || empty($startDate) || empty($endDate)) {
            return "Vous devez remplir tous les champs";
        } else {
            //test que l'utilisateur n'a pas déjà créé un projet du même nom
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
                return "Votre sprint a bien été modifié";
            }
        }
    }
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