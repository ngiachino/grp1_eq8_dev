<?php
function addTask($conn,$projectId,$sprintId)
{     if (isset($_POST['submit']))
    {
        $description = $_POST['taskDescription'];
        $duration = $_POST['taskDuration'];
        if (empty($description)|| empty($duration))
        {
            return " Veuillez remplir tous les champs!";
        }
        else{
        $query = "INSERT INTO `tache`(`ID_PROJET`, `ID_SPRINT`,`ID_USER_STORY`, `DESCRIPTION`, 
                                     `DUREE_TACHE`, `IS_DONE`, `IS_CLOSED`) 
                         VALUES (  '$projectId','$sprintId','1','$description','$duration',
                                    '0','0' )";

        if (mysqli_query($conn, $query) == FALSE) {
            echo "Error: " . $query . "<br>" . $conn->error . "<br>";

                      }
        else {
                return " Tâche ajoutée ";
             }
        }
    }
}


function assignTask($conn,$projectId, $sprintId)
{

    $taskId = $_POST['taskId'];
    $userId = $_POST['userId'];
  //Récuperer le nom du user
   $query = "SELECT NOM_USER from utilisateur WHERE ID_USER = $userId";
   $userName = mysqli_query($conn, $query);
   //Ajouter user a membre
    $query = " INSERT INTO membre VALUES ('$userId', '$projectId','$userName'
                           ,'$sprintId', '$taskId')";









}
//function deleteTask($conn)
//{
//    if (isset($_POST['delete'])) {
//        if (empty($_POST['taskId'])) { return " Impossible";}
//            $taskId = $_POST['taskId'];
//            $query = "DELETE FROM Tache WHERE ID_TACHE = '$taskId'";
//            mysqli_query($conn, $query);
//        }
//}



