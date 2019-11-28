<?php
include '../../database/DBconnect.php';

function startProject(){
    $conn = connect();

    session_start();

    //test si l'utilisateur est connecté. Sinon le renvoie vers l'index
    if($_SESSION['userName'] == null || $_SESSION['userID'] == null){
        header("Location:index.php");
    }
    //test si l'utilisateur est bien passé par sa page de profil. Sinon le renvoie vers le profil
    else if( $_GET['title'] == null || $_GET['owner'] == null){
        header("Location:profil.php");
    }

    $projectTitle = $_GET['title'];
    $projectOwner = $_GET['owner'];
    $query2 = "SELECT ID_PROJET FROM projet JOIN utilisateur ON projet.ID_MANAGER = utilisateur.ID_USER WHERE NOM_PROJET ='$projectTitle' AND NOM_USER='$projectOwner'";
    $result2 = mysqli_query($conn, $query2);
    $projectId = mysqli_fetch_row($result2)[0];
    $_SESSION['projectId'] = $projectId;
    return $projectId;
}

function showMembers($projectId){
    $conn = connect();

    $query = "SELECT * FROM membre WHERE ID_PROJET = '$projectId'";
    return mysqli_query($conn, $query);
}

function startAddMember($projectId){
    if (isset($_POST['submit'])) {
        $userName = $_POST['userName'];
        return addMember($projectId,$userName);
    }
}
function addMember($projectId,$userName)
{
    $conn = connect();

    //Test que le champ n'est pas vide
    if (empty($userName)) {
        return "<span>Vous devez indiquer un pseudo ou un mail</span></br>";
    } else {
        //Test que l'utilisateur n'est pas déjà dans le projet
        $query = "SELECT ID_MEMBRE FROM membre JOIN utilisateur ON membre.ID_MEMBRE = utilisateur.ID_USER WHERE (NOM_MEMBRE ='$userName' OR MAIL_USER='$userName') AND ID_PROJET = '$projectId'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) != 0) {
            return "<span>Cet utilisateur fait déjà parti du projet</span></br>";
        } else {
            //Test que l'utilisateur existe (mail ou pseudo)
            $query = "SELECT ID_USER,NOM_USER FROM utilisateur WHERE NOM_USER ='$userName' OR MAIL_USER = '$userName'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) == 0) {
                return "<span>Ce pseudo/mail ne correspond à aucun utilisateur</span></br>";
            } //Ajout de l'utilisateur au projet
            else {
                $row = mysqli_fetch_row($result);
                $memberName = $row[1];
                $memberId = $row[0];
                $query = "INSERT INTO membre (ID_MEMBRE, ID_PROJET, NOM_MEMBRE)
                    VALUES ('$memberId','$projectId','$memberName')";
                mysqli_query($conn, $query);
            }
        }
    }
}

function startDeleteMember($projectId){
    if(isset($_POST['deleteUser'])){
        $userToDelete = $_POST['name'];
        deleteMember($projectId,$userToDelete);
    }
}
function deleteMember($projectId,$userToDelete){
    $conn = connect();

    $query = "DELETE FROM membre WHERE NOM_MEMBRE = '$userToDelete' AND ID_PROJET = '$projectId'";
    mysqli_query($conn,$query);
}
?>