<?php
include_once 'historiqueManagement.php';

function startDocumentation(){
    session_start();

    if($_SESSION['projectId'] == null){
        header("Location:../../index.php");
    }
    return $_SESSION['projectId'];
}

function showDocumentation($idProjet){
    $conn = connect();
    $query = "SELECT TITRE,DESCRIPTION,LIEN,ID_DOCUMENTATION FROM `documentation` WHERE ID_PROJET = '$idProjet' ORDER BY ID_DOCUMENTATION";
    return mysqli_query($conn, $query);
}

function startAddDocumentation($idProjet){
    if (isset($_POST['submit'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        addDocumentation($idProjet,$title,$description);
    }
}

function addDocumentation($idProjet,$title,$description){
    $conn = connect();
    $link = upload($idProjet);
    if($link !=-1){
        $sql = $conn->prepare("INSERT INTO `documentation` (ID_PROJET, TITRE, DESCRIPTION, LIEN)
        VALUES (?,?,?,?)");
        $sql->bind_param("isss",$idProjet,$title,$description,$link);
        $sql->execute();
        addHistorique($idProjet,"Le document ".$title." a été créé");
        header("Location:documentation.php");
    }
    return -1;
}

function startDeleteDocumentation($idProjet){
    if (isset($_POST['delete'])) {
        $documentID = $_POST['id'];
        deleteDocumentation($idProjet,$documentID);
    }
}

function deleteDocumentation($idProjet,$documentID){
    $conn = connect();
    $queryTest = "SELECT LIEN FROM `documentation` WHERE ID_DOCUMENTATION = '$documentID'";
    $result = mysqli_query($conn, $queryTest);
    
    $link = mysqli_fetch_row($result)[0];
    unlink($link); //Delete the file

    $query = "DELETE FROM `documentation` WHERE ID_DOCUMENTATION = '$documentID' AND ID_PROJET = '$idProjet'";
    mysqli_query($conn, $query);
    addHistorique($idProjet,"Un document a été supprimé");
    header("Location:documentation.php");
}

function startModifyDocumentation($idProjet){
    if(isset($_POST['modify'])){
        $title = $_POST['title'];
        $description = $_POST['description'];
        $documentID = $_POST['id'];
        modifyDocumentation($idProjet,$title,$description,$documentID);
    }
}

function modifyDocumentation($idProjet,$title,$description,$documentID){
    $conn = connect();
    $queryTest = "SELECT LIEN FROM `documentation` WHERE ID_DOCUMENTATION = '$documentID'";
    $result = mysqli_query($conn, $queryTest);
    $link = mysqli_fetch_row($result)[0];
    $target_dir = "../../uploads/";
    $target_file = $target_dir . $idProjet . basename($_FILES["fileToUpload"]["name"]);
    if($link != $target_file && basename($_FILES["fileToUpload"]["name"]) != NULL){
        unlink($link); //Delete the file
        upload($idProjet);
        $sql = $conn->prepare("UPDATE `documentation`
        SET TITRE = ?, DESCRIPTION = ?, LIEN = ?
        WHERE ID_DOCUMENTATION = ?");
        $sql->bind_param("sssi",$title,$description,$target_file,$documentID);
        $sql->execute();
    }
    else{
        $sql = $conn->prepare("UPDATE `documentation`
        SET TITRE = ?, DESCRIPTION = ?
        WHERE ID_DOCUMENTATION = ?");
        $sql->bind_param("ssi",$title,$description,$documentID);
        $sql->execute();
    }
    addHistorique($idProjet,"Le document ". $title ."a été modifié");
    header("Location:documentation.php");
}

function upload($idProjet){
    $target_dir = "../../uploads/";
    $target_file = $target_dir . $idProjet . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $documentFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($documentFileType != "txt" && $documentFileType != "md" && $documentFileType != "pdf") {
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            return $target_file;
        } else {
            return false;
        }
    }
}
