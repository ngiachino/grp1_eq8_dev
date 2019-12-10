<?php
include_once 'historiqueManagement.php';
include_once 'utils.php';

function startAddTask($conn,$projectId,$sprintId)
{
    if (isset($_POST['addTask'])) {
        $description = $_POST['taskDescription'];
        $duration = $_POST['taskDuration'];
        $isDone =  $_POST['nameState'];
        if(taskExist($conn,$projectId,$sprintId,$description)){
            aggregateMessage("Il existe déjà une tâche avec cette description");
            return;
        }
        if (empty($description) || empty($duration)) {
            aggregateMessage("Veuillez remplir tous les champs!");
            return;
        } else {     
            addTask($conn, $projectId, $sprintId, $description, $duration,$isDone);
        }
    }
}

function addTask($conn, $projectId, $sprintId, $description, $duration, $isDone)
{
    $sql = $conn->prepare("INSERT INTO `tache`(`ID_PROJET`, `ID_SPRINT`,`ID_USER_STORY`,`DESCRIPTION`,`DUREE_TACHE`, `IS_DONE`) 
                            VALUES (?,?,-1,?,?,?)");
    $sql->bind_param("iisss",$projectId,$sprintId,$description,$duration,$isDone);
    $sql->execute();
    addHistorique($projectId,"Une tâche a été créée");
    aggregateMessage("Tâche ajoutée");
}

function assignTask($conn,$projectId, $sprintId)
{
    if (isset($_POST['assigner']) && (!(empty($_POST['userName'])) || !(empty($_POST['taskId'])))) {
        $userName = $_POST['userName'];
        $taskId = $_POST['taskId'];
        $queryExistMember = "SELECT ID_MEMBRE
                                 from membre join utilisateur 
                                             on membre.ID_MEMBRE = utilisateur.ID_USER 
                                WHERE NOM_USER = '$userName' AND ID_TACHE != '$taskId' AND ID_PROJET = '$projectId' ";
        $resultMember = mysqli_query($conn, $queryExistMember);
        if (mysqli_num_rows($resultMember) != 0) {
            $row = mysqli_fetch_row($resultMember);
            $userId = $row[0];
            $queryAssign = " INSERT INTO membre 
                                    VALUES ('$userId', '$projectId','$userName'
                                            ,'$sprintId', '$taskId')";
            mysqli_query($conn, $queryAssign);
            aggregateMessage("La tache a été assignée!");
            return;
        }
    }
}

function addIssueTask($connexion, $projectId){
    if(isset($_POST['lier'])){
        if(empty($_POST['issueId'])){
            aggregateMessage("Veuillez indiquez l'User Story");
            return;
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
            aggregateMessage("L'identifiant de cette User Story n'existe pas ou alors elle est déjà liée à la tâche");
            return;
        }
        $resultIssue = mysqli_fetch_row($exist);
        $issueId = $resultIssue[0];
        $priorite = $resultIssue[1];
        $difficulte = $resultIssue[2];
        $description = $resultIssue[3];
        //AJOUTER
        $sql = $connexion->prepare("INSERT INTO `issue`(`ID_USER_STORY`, `PRIORITE`,`DIFFICULTE`, `DESCRIPTION`, `ID_PROJET`, `ID_TACHE`) 
                                VALUES ('$issueId','$priorite','$difficulte',?,'$projectId','$taskId')");
        $sql->bind_param("s",$description);
        $sql->execute();
        aggregateMessage("La tache a été reliée à l'User Story'");
        return;
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
            aggregateMessage("La modification de la tâche a été faite!");
            if (!empty($_POST['descriptionTask']) && empty($_POST['durationTask'])) {
                modifyDescriptionTask($conn, $taskId, $projectId, $sprintId, $_POST['descriptionTask']);
            }
            elseif (empty($_POST['descriptionTask']) && !empty($_POST['durationTask'])) {
                modifyDurationTask($conn, $taskId, $projectId, $sprintId, $_POST['durationTask']);
            }
            else{
                modifyDescriptionTask($conn, $taskId, $projectId, $sprintId, $_POST['descriptionTask']);
                modifyDurationTask($conn, $taskId, $projectId, $sprintId, $_POST['durationTask']);
            }
        }
}

function modifyDescriptionTask($conn, $taskId, $projectId, $sprintId, $description)
{
    $sql = $conn->prepare("UPDATE tache SET DESCRIPTION = ? WHERE ID_TACHE = ? AND ID_PROJET = ? AND ID_SPRINT = ?");
    $sql->bind_param("siii",$description,$taskId,$projectId,$sprintId);
    $sql->execute();
}

function modifyDurationTask($conn, $taskId, $projectId, $sprintId, $duration)
{
    $queryUpdate = "UPDATE tache 
                    SET DUREE_TACHE = '$duration'
                    WHERE ID_TACHE = '$taskId'AND 
                          ID_PROJET = '$projectId' AND 
                          ID_SPRINT = '$sprintId' ";
    mysqli_query($conn, $queryUpdate);
    $sql = $conn->prepare("UPDATE tache SET DUREE_TACHE = ? WHERE ID_TACHE = ? AND ID_PROJET = ? AND ID_SPRINT = ?");
    $sql->bind_param("siii",$duration,$taskId,$projectId,$sprintId);
    $sql->execute();
}

function detachTaskFromIssues($conn, $projectId, $taskId)
{
    $queryDelete = "DELETE FROM issue WHERE ID_TACHE = '$taskId' and ID_PROJET = '$projectId'";
    mysqli_query($conn,$queryDelete);
}

function detachTaskFromMembers($conn, $projectId, $sprintId, $taskId)
{
    $queryDelete = "DELETE FROM membre WHERE ID_TACHE = '$taskId' and ID_PROJET = '$projectId' and ID_SPRINT='$sprintId'";
    mysqli_query($conn,$queryDelete);
}

function startDeleteTask($conn,$projectId,$sprintId){
    if (isset($_POST['delete'])) {
        if (empty($_POST['taskId'])) {
            aggregateMessage("Impossible");
            return;
        }
        $taskId = $_POST['taskId'];
        deleteTask($conn, $projectId, $sprintId, $taskId);
    }
}

function deleteTask($conn, $projectId, $sprintId,$taskId)
{
    detachTaskFromIssues($conn, $projectId, $taskId);
    detachTaskFromMembers($conn, $projectId, $sprintId, $taskId);

    $query = "DELETE FROM Tache WHERE ID_TACHE = '$taskId'";
    mysqli_query($conn, $query);
    aggregateMessage("La suppression de la tâche a été faite. ");
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

function startDeleteMemberTask($conn, $projectId, $sprintId, $taskId){
    if(isset($_POST['deleteMember'])){
        $memberId = $_POST['idMember'];
        deleteMemberTask($conn, $projectId, $sprintId, $taskId, $memberId);
    }
}

function deleteMemberTask($conn, $projectId, $sprintId, $taskId, $memberId){
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
        if(empty($_POST['taskState'])){
            aggregateMessage("Veuillez choisir un état");
            return;
        }
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
                 FROM tache WHERE tache.ID_PROJET = '$projectId' AND tache.ID_SPRINT = '$sprintId'
                 ORDER BY tache.ID_TACHE
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
        return mysqli_query($conn, $queryGet);
    }
    return getAllTasks($conn, $projectId,$sprintId);
}

function getCurrentTasksNumber($conn,$projectId, $sprintId)
{
    $queryNumber = "SELECT DISTINCT count(ID_TACHE) FROM tache WHERE ID_PROJET = $projectId AND ID_SPRINT= $sprintId";
    return mysqli_query($conn,$queryNumber);
}

function getMembersProject($projectId,$conn){
    $sql = "SELECT DISTINCT NOM_MEMBRE FROM membre WHERE ID_PROJET = '$projectId'";
    return mysqli_query($conn,$sql);
}

function getIssuesProject($projectId,$conn){
    $sql = "SELECT DISTINCT ID_USER_STORY FROM issue WHERE ID_PROJET = '$projectId'";
    return mysqli_query($conn,$sql);
}

function taskExist($conn,$projectId,$sprintId,$description){
    $sql = $conn->prepare("SELECT ID_TACHE FROM tache WHERE ( DESCRIPTION=? 
                    AND ID_PROJET='$projectId' AND ID_SPRINT= '$sprintId')");
    $sql->bind_param("s",$description);
    $sql->execute();
    $result = $sql->get_result();
    return mysqli_num_rows($result) != 0;
}
