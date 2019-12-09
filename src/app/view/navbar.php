<?php
include_once '../management/projectManagement.php';
$row = mysqli_fetch_row(startProfil());
?>

<link href="../../assets/css/navbar.css" rel="stylesheet">

<div class="menuBar">
    <div class="float-left">
        <form>
            <button class="fa fa-chevron-circle-left btn btn-transparent btn-xsm" style="color: white;" type="button" value="back" onclick="history.go(-1)"></button>
        </form>
    </div>
    <div class="float-left">
        <a href="profil.php">GoProject</a>
    </div>
    <div class="float-left px-4">
        <a href="./projet.php?title=<?php echo $row[0];?>&owner=<?php echo $row[1];?>">Projet</a>
    </div>
    <div class="float-right">
        <a class="disconnect" href="../../index.php">Se déconnecter</a>
    </div>
</div>
