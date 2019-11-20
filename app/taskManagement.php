<?php
function addTask($conn,$projectId,$sprintId,$userStoryId)
{
    if (isset($_POST['taskDescription'])
        && isset($_POST['taskDuration']))
    {
        $description = $_POST['taskDescription'];
        $duration = $_POST['taskDuration'];

        $query = "INSERT INTO Tache (
                             ID_PROJECT,
                             ID_SPRINT,
                             ID_USER_STORY,
                             DESCRIPTION,
                             DUREE_TACHE,
                             IS_DONE,
                             IS_CLOSED       
                          )
                          VALUE (
                           $projectId,
                           $sprintId,
                           $userStoryId,
                           $description,
                           $duration,
                           0,
                           0
                          );                  
                  ";
    mysqli_query($conn,$query);
    }
}


function assignTask($conn, $taskId, $userId)
{
    $query = "SELECT ID_SPRINT  FROM TACHE WHERE ID_TACHE = '$taskId'";
    $sprintId = mysqli_query($conn, $query);
}
function deleteTask($conn)
{
    if (isset($_POST['taskId'])) {
        $taskId = $_POST['taskId'];
        $query = "DELETE FROM Tache WHERE ID_TACHE = '$taskId'";
        mysqli_query($conn,$query);
    }
}
?>