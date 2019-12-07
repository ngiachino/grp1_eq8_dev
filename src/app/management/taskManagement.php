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
    else {
        //test l'existence de la tache
        $taskState = $_POST['taskState'];
        $query = "INSERT INTO `tache`(`ID_PROJET`, `ID_SPRINT`,`ID_USER_STORY`, 
                                          `DESCRIPTION`,`DUREE_TACHE`, `IS_DONE`) 
                         VALUES ('$projectId','$sprintId','-1','$description','$duration','$taskState')";
        mysqli_query($conn, $query);
        return " Tâche ajoutée ";
    }
    }
    return null;
}

function assignTask($conn,$projectId, $sprintId)
{
    if (isset($_POST['assigner']) || !(empty($_POST['userName'])) || !(empty($_POST['taskId'])) ) {
        $userName = $_POST['userName'];
        $taskId = $_POST['taskId'];
        $queryExistMember = "SELECT ID_MEMBRE
                                 from membre join utilisateur 
                                             on membre.ID_MEMBRE = utilisateur.ID_USER 
                                WHERE NOM_USER = '$userName' AND ID_TACHE != '$taskId' ";
        $resultMember = mysqli_query($conn, $queryExistMember);
        if (mysqli_num_rows($resultMember) != 0) {
            $row = mysqli_fetch_row($resultMember);
            $userId = $row[0];
            $queryAssign = " INSERT INTO membre 
                                    VALUES ('$userId', '$projectId','$userName'
                                            ,'$sprintId', '$taskId')";
            mysqli_query($conn, $queryAssign);
            return "La tache a été assignée!";
        }
    }
}

function addIssueTask($connexion, $projectId){
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
                       VALUES ('$issueId','$priorite','$difficulte','$description',
                                    '$projectId','$taskId')";
        mysqli_query($connexion, $queryInsert);
        return $issueId."La tache a été reliée à la US";
    }
}

function getMemberTask($connexion,$taskId, $sprintId, $projectId)
{
    $queryMemberName = "SELECT NOM_MEMBRE, ID_MEMBRE 
                        FROM membre
                        WHERE ID_PROJET = '$projectId' 
                              AND ID_SPRINT = '$sprintId' 
                              AND ID_TACHE = '$taskId' ";
    return mysqli_query($connexion, $queryMemberName);
}

function modifyTask($conn, $projectId, $sprintId)
{
    if(isset($_POST['modifier'])&& !empty($_POST['taskId'])) {
            $taskId= $_POST['taskId'];
            if (!empty($_POST['descriptionTask']) && empty($_POST['durationTask'])) {
                return modifyDescriptionTask($conn, $taskId, $projectId, $sprintId, $_POST['descriptionTask']);
            }
            elseif  (empty($_POST['descriptionTask']) && !empty($_POST['durationTask'])) {
                return modifyDurationTask($conn, $taskId, $projectId, $sprintId, $_POST['durationTask']);
            }
            else{
                return modifyDescriptionTask($conn, $taskId, $projectId, $sprintId, $_POST['descriptionTask'])
                            .modifyDurationTask($conn, $taskId, $projectId, $sprintId, $_POST['durationTask']);
            }
        }
}

function modifyDescriptionTask($conn, $taskId, $projectId, $sprintId, $description)
{
    $queryUpdate = "UPDATE tache 
                    SET DESCRIPTION = '$description'
                    WHERE ID_TACHE = '$taskId'AND 
                          ID_PROJET = '$projectId' AND 
                          ID_SPRINT = '$sprintId' ";
    mysqli_query($conn, $queryUpdate);
    return "LA Modification de la description de la tâche a été faite! ";
}
function modifyDurationTask($conn, $taskId, $projectId, $sprintId, $duration)
{
    $queryUpdate = "UPDATE tache 
                    SET DUREE_TACHE = '$duration'
                    WHERE ID_TACHE = '$taskId'AND 
                          ID_PROJET = '$projectId' AND 
                          ID_SPRINT = '$sprintId' ";
    mysqli_query($conn, $queryUpdate);
    return "La modification de la durée de la tâche a été faite! ";
}

function deleteTask($conn)
{
    if (isset($_POST['delete'])) {
        if (empty($_POST['taskId'])) {
            return "Impossible";
        }
        $taskId = $_POST['taskId'];
        $query = "DELETE FROM Tache WHERE ID_TACHE = '$taskId'";
        mysqli_query($conn, $query);
        return "La suppresion la tâche a été faite! ";
    }
    return null;
}

function getIssuesTask($conn, $taskId, $projectId){
    //je récupère les issues d'une tâches
    $queryIssues= "SELECT ID_USER_STORY, DESCRIPTION 
                   FROM issue
                   WHERE ID_PROJET = '$projectId' AND ID_TACHE = '$taskId' ";
    return mysqli_query($conn, $queryIssues);
}

function deleteIssueFromTask($conn, $projectId){
    if(isset($_POST['deleteIssue'])){
        $idIssue = $_POST['issueId'];
        $taskId = $_POST['taskId'];
        $queryDeleteIssue = "DELETE FROM issue 
                            WHERE ID_USER_STORY ='$idIssue' AND
                                   ID_TACHE = '$taskId'AND
                                   ID_PROJET = '$projectId' ";
        mysqli_query($conn, $queryDeleteIssue);
    }
}

function startDeleteMember($conn, $projectId, $sprintId, $taskId){
    if(isset($_POST['deleteMember'])){
        $memberId = $_POST['idMember'];
        deleteMember($conn, $projectId, $sprintId, $taskId, $memberId);
    }
}

function deleteMember($conn, $projectId, $sprintId, $taskId, $memberId){
    $queryDeleteMember ="DELETE FROM membre 
                             WHERE ID_TACHE = '$taskId'AND 
                                   ID_PROJET = '$projectId' AND 
                                   ID_SPRINT = '$sprintId' AND
                                   ID_MEMBRE = '$memberId'";
    mysqli_query($conn, $queryDeleteMember);
}

function editTaskEtat($conn, $projectId, $sprintId ){
    if(isset($_POST['editTaskState']))
    {
        if(empty($_POST['taskState'])){return "Veuillez choisir un état";}
        $taskId = $_POST['taskId'];
        $taskState = $_POST['taskState'];
        $queryEditTaskState = "UPDATE tache
                               SET IS_DONE ='$taskState'
                               WHERE ID_TACHE = '$taskId'AND 
                                     ID_PROJET = '$projectId' AND 
                                     ID_SPRINT = '$sprintId' ";
        mysqli_query($conn, $queryEditTaskState);
    }
}
function getAllTasks($conn, $projectId, $sprintId){
    $queryGet = "SELECT DISTINCT tache.DESCRIPTION, tache.DUREE_TACHE, tache.IS_DONE, tache.ID_TACHE
                 FROM tache  
                 WHERE tache.ID_PROJET = '$projectId'
                    AND tache.ID_SPRINT = '$sprintId'
                    ";
    return mysqli_query($conn, $queryGet);
}

function getTaskWithSpecificState($conn, $projectId, $sprintId){
    if(isset($_POST['choseState'])) {
        $state = $_POST['nameState'];
        if($state== "ALL"){
            return getAllTasks($conn, $projectId,$sprintId);
        }
        $queryGet = "SELECT DISTINCT tache.DESCRIPTION, tache.DUREE_TACHE, tache.IS_DONE, tache.ID_TACHE
                     FROM tache  
                     WHERE tache.ID_PROJET = '$projectId'
                          AND tache.ID_SPRINT = '$sprintId'
                          AND tache.IS_DONE = '$state'";
        $result = mysqli_query($conn, $queryGet);
    }
    else{
        $result = getAllTasks($conn,$projectId,$sprintId);
    }
    return $result;
}


