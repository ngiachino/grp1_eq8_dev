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
        //test l'existence de la tache
        $query = "INSERT INTO `tache`(`ID_PROJET`, `ID_SPRINT`,`ID_USER_STORY`, `DESCRIPTION`, 
                                     `DUREE_TACHE`, `IS_DONE`, `IS_CLOSED`) 
                         VALUES (  '$projectId','$sprintId','-1','$description','$duration',
                                    '0','0' )";
        if (!(mysqli_query($conn, $query))) {
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
            if(!($resultMember)) {
                echo "Error: " . $queryExistMember . "<br>" . $conn->error . "<br>";
            }
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
             {  return "Cette tâche est déjà assigné à cet utilisateur"; }
        }
    }
}
function addUSStask($connexion, $sprintId, $projectId){
  if(isset($_POST['lier'])){
      if(empty($_POST['issueId'])){
          return "Veuillez indiquez la USS";
      }
      $taskId = $_POST['taskIdentificateur'];
      $issueId = $_POST['issueId'];
      //Verification de l'existance de la USS qu'on veut lier à la tâche
      $queryExistUss = "SELECT ID_USER_STORY, PRIORITE, DIFFICULTE, DESCRIPTION FROM issue 
                        WHERE ID_USER_STORY = '$issueId' and ID_PROJET = $projectId  AND ID_TACHE != $taskId 
                        ORDER BY ID_USER_STORY
                        DESC LIMIT 1 ";
      $exist = mysqli_query($connexion, $queryExistUss);
      if(mysqli_num_rows($exist)== 0 || !($exist)) {
          return "L'identifiant de cette User story n'existe pas ou alors elle est déjà liée à la tâche";
      }

        $resultIssue = mysqli_fetch_row($exist);
        $issueId = $resultIssue[0];
        $priorite = $resultIssue[1];
        $difficulte = $resultIssue[2];
        $description = $resultIssue[3];
      //AJOUTER
      $queryInsert = "INSERT INTO `issue`(`ID_USER_STORY`, `PRIORITE`,`DIFFICULTE`, `DESCRIPTION`, 
                                     `ID_PROJET`, `ID_TACHE`) 
                         VALUES (  '$issueId','$priorite','$difficulte','$description',
                                    '$projectId','$taskId')";
      if (!(mysqli_query($connexion, $queryInsert))) {
              echo "Error: " . $queryInsert . "<br>" . $connexion->error . "<br>";
          return "Impossible de relier la tâche à l'US";
      }
      else {
          return $issueId."La tache a été reliée à la US";
      }
  }
  return;
}

function getMemberTask($connexion,$taskId, $sprintId, $projectId)
{
    $queryMemberName = "SELECT NOM_MEMBRE from membre
                        WHERE ID_PROJET = '$projectId' AND ID_SPRINT = '$sprintId' AND ID_TACHE = '$taskId' ";

    $result = mysqli_query($connexion, $queryMemberName);
    if(!($result) ) {
        echo "Error: " . $queryMemberName . "<br>" . $connexion->error . "<br>";
        return "erreur lors de la récuperation des membres";
    }
     else
     { return $result;}
     return;
}
function modifyTask($conn, $projectId, $sprintId)
{
    if(isset($_POST['modifier'])){
        if(!empty($_POST['taskId'])) {
            $taskId= $_POST['taskId'];
            if (!empty($_POST['descriptionTask']) && empty($_POST['durationTask'])) {
                return modifyDescriptionTask($conn, $taskId, $projectId, $sprintId, $_POST['descriptionTask']);
            }
            elseif  (empty($_POST['descriptionTask']) && !empty($_POST['durationTask'])) {
                return modifyDurationTask($conn, $taskId, $projectId, $sprintId, $_POST['durationTask']);
            }
            else{
                $modifyTaskMessage= modifyDescriptionTask($conn, $taskId, $projectId, $sprintId, $_POST['descriptionTask']);
                $modifyTaskMessage= $modifyTaskMessage.modifyDurationTask($conn, $taskId, $projectId, $sprintId, $_POST['durationTask']);
                return $modifyTaskMessage;
            }
        }
    }
    return;
}

function modifyDescriptionTask($conn, $taskId, $projectId, $sprintId, $description)
{
    $queryUpdate = "UPDATE tache 
                    SET DESCRIPTION = '$description'
                    WHERE ID_TACHE = '$taskId'AND 
                          ID_PROJET = '$projectId' AND 
                          ID_SPRINT = '$sprintId' ";
    $updateResult = mysqli_query($conn, $queryUpdate);
    if(!$updateResult)
    {  echo "Error: " . $queryUpdate . "<br>" . $conn->error . "<br>";}
    else
    {   return "LA Modification de la description de la tâche a été faite! ";}
    return;
}
function modifyDurationTask($conn, $taskId, $projectId, $sprintId, $duration)
{
    $queryUpdate = "UPDATE tache 
                    SET DUREE_TACHE = '$duration'
                    WHERE ID_TACHE = '$taskId'AND 
                          ID_PROJET = '$projectId' AND 
                          ID_SPRINT = '$sprintId' ";
    $updateResult = mysqli_query($conn, $queryUpdate);
    if(!$updateResult) {
        echo "Error: " . $queryUpdate . "<br>" . $conn->error . "<br>";
        return;
    }
    else {
        return "LA Modification de la durée de la tâche a été faite! ";
    }
    return;
}
function deleteTask($conn)
{
    if (isset($_POST['delete'])) {
        if (empty($_POST['taskId'])) { return " Impossible";}
            $taskId = $_POST['taskId'];
            $query = "DELETE FROM Tache WHERE ID_TACHE = '$taskId'";
            $deleteResult= mysqli_query($conn, $query);
        if(!$deleteResult) {
            echo "Error: " . $deleteResult . "<br>" . $conn->error . "<br>";
            return;
        }
        else {
            return "LA suppresion la tâche a été faite! ";
        }
        }
    return;

}

function getIssuesTask($conn, $taskId, $sprintId, $projectId){
    //je récupère les issues d'une tâches
    $queryIssues= "SELECT tache.ID_USER_STORY, issue.DESCRIPTION 
                   FROM tache JOIN issue ON tache.ID_USER_STORY = issue.ID_USER_STORY
                   WHERE tache.ID_PROJET = '$projectId' AND ID_SPRINT = '$sprintId' AND ID_TACHE = '$taskId' ";
    $result = mysqli_query($conn, $queryIssues);
    if(!$result) {
        echo "Error: " . $queryIssues . "<br>" . $conn->error . "<br>";
        return "erreur  lors de la récuperation des User stories";
    }
    else
    {
        return $result;
    }
    return;
}



