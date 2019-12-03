<?php
function showHistorique($idProjet){
    $conn = connect();
    $sql = $conn->prepare("SELECT DESCRIPTION FROM historique WHERE ID_PROJET = ? ORDER BY ID_HISTORIQUE DESC");
    $sql->bind_param("i",$idProjet);
    $sql->execute();
    return $sql->get_result();
}
function addHistorique($idProjet,$description){
    $conn = connect();
    $sql = $conn->prepare("INSERT INTO historique (ID_PROJET,DESCRIPTION)
    VALUES (?,?)");
    $sql->bind_param("is",$idProjet,$description);
    $sql->execute();
}
?>