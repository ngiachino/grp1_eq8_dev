<?php

$dbserver ='localhost';
$dbuser = 'aouldamara';
$password = 'cdp';
$dbname = "aouldamara";

$conn = new mysqli($dbserver, $dbuser, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$query = "SELECT * FROM projet";
$result1 = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>

<head>
    <?php include './defaultHead.php'; ?>
    <title>Mon profil - GoProject</title>
    <link href="profil.css" rel="stylesheet">
    <script src="profil.js" defer></script>
</head>



<body>
<div class = "menuBar">
    <span id="title">GoProject</span>
    <div class="menuBar-right">
        <a class = "disconnect">Se déconnecter</a>
    </div>
</div>
<div class="pageName">
    <p>Mon Profil</p>
</div>
<div class = "container-left">
    <table class="floatLeft" id="projectsList">
        <tr>
            <td class="listTitle">Mes projets</td>
        </tr>
        <?php $i = 0;
        while($row1 = mysqli_fetch_row($result1)):;?>
            <tr>
                <td>
                    <span><?php echo $row1[1];?></span>
                    <br/>
                    <span class="subtitle"><?php echo $row1[2];?></span>
                </td>
            </tr>
            <?php
            $i++;
        endwhile;
        while ($i<4){
            echo '<tr><td></td></tr>';
            $i++;
        }
        ?>
    </table>
</div>



<div class = "container-right">
    <table class="floatRight" id="TasksList">
        <tr>
            <td class="listTitle">Mes tâches</td>
        </tr>
        <tr>
            <td>
                <span>T3 - Sprint1</span>
                <br/>
                <span class="subtitle">Nom du projet</span>
                <br/>
                <span class="subtitle">Du 04/11/2019 au 11/11/2019</span>
            </td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td></td>
        </tr>
    </table>
</div>
<div class="addButton" id="openNewProjectForm">
    <h1>Nouveau projet</h1>
    <p class = "subtitle">Créer un nouveau projet</p>
</div>
<div id="newProjectModal" class="modal">
    <div class="modal-content">
        <form class="form-container" action = "newProject.php" method = "POST">
            <h1>Nouveau projet</h1>

            <label for="name"><b>Nom du projet :</b></label>
            <br/>
            <input type="text" name="name" required id="projectName">
            <br/><br/>
            <label for="description"><b>Description :</b></label>
            <br/>
            <input type="text" name="description" id="projectDescription">
            <br/><br/>
            <input type="submit" name="submit" class="submit" value="Créer">

            <button type="button" class="buttonCancel" id="closeForm">Annuler</button>
        </form>
    </div>
</div>
</body>
</html>