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
    return 'Tâche non ajoutée';
}


function assignTask($conn,$projectId, $sprintId)
{
    if (isset($_POST['assigner'])) {
        $userName = $_POST['userName'];
        $taskId = $_POST['taskId'];
        if (empty($userName)|| empty($taskId))
        {
            return " Veuillez remplir tous les champs!";
        }
        else {

            $queryExistMember = "SELECT ID_MEMBRE
                                 from membre join utilisateur 
                                             on membre.ID_MEMBRE = utilisateur.ID_USER 
                                WHERE NOM_USER = '$userName' AND ID_TACHE != '$taskId' ";

            $resultMember = mysqli_query($conn, $queryExistMember);
            if(!($resultMember))
                 echo  "Error: " . $queryExistMember . "<br>" . $conn->error . "<br>";

            if ( mysqli_num_rows($resultMember) != 0)
            { // il est membre du projet et du sprint mais cette tâche ne lui est pas encore affectée

                $row =  mysqli_fetch_row($resultMember);
                $userId= $row[0];
                $queryAssign = " INSERT INTO membre 
                                VALUES ('$userId', '$projectId','$userName'
                                        ,'$sprintId', '$taskId')";
                if (!(mysqli_query($conn,$queryAssign)) )
                    {
                        echo "Error: ".$queryAssign. "<br>" . $conn->error . "<br>";
                       return "la tâche n'a pas été assignée!";
                    }

            } else
                return "Cette tâche est déjà assigné à cet utilisateur";
        }
    }
}

function getMemberTask($connexion,$taskId, $sprintId, $projectId)
{
    $queryMemberName = "SELECT NOM_MEMBRE from membre
                        WHERE ID_PROJET = '$projectId' AND ID_SPRINT = '$sprintId' AND ID_TACHE = '$taskId' ";

    $result = mysqli_query($connexion, $queryMemberName);
    if($result == false)
        echo "Error: " . $queryMemberName . "<br>" . $connexion->error . "<br>";
     else return $result;
}
function deleteTask($conn)
{
    if (isset($_POST['delete'])) {
        if (empty($_POST['taskId'])) { return " Impossible";}
            $taskId = $_POST['taskId'];
            $query = "DELETE FROM Tache WHERE ID_TACHE = '$taskId'";
            mysqli_query($conn, $query);
        }
}



