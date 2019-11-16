<?php

include '../database/DBconnect.php';
$conn = connect();
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();

//test si l'utilisateur est connecté. Sinon le renvoie vers l'index
if($_SESSION['userName'] == null || $_SESSION['userID'] == null){
    header("Location:index.php");
}

$userName = $_SESSION['userName'];
$userID = $_SESSION['userID'];

$query = "SELECT NOM_PROJET,NOM_USER FROM projet JOIN utilisateur ON projet.ID_MANAGER = utilisateur.ID_USER WHERE ID_MANAGER = '$userID'";
$result1 = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>

<head>
    <?php include './defaultHead.php'; ?>
    <title>Mon profil - GoProject</title>
    <link href="../assets/css/profil.css" rel="stylesheet">
    <script src="../assets/js/profil.js" defer></script>
</head>



<body>
<div class = "menuBar">
    <span id="title">GoProject</span>
    <div class="menuBar-right">
        <a class = "disconnect" href="./index.php">Se déconnecter</a>
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
                <td class = tdProject>
                    <span class="projectTitle"><?php echo $row1[0];?></span>
                    <br/>
                    <span class="projectOwner"><?php echo $row1[1];?></span>
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
        <form class="form-container" method = "POST">
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

<?php
    if(isset($_POST['submit'])){
        $projectName = $_POST['name'];
        $projectDesc = $_POST['description'];

        //test que tous les champs sont remplis
        if(empty($projectName) || empty($projectDesc)){
            echo "Vous devez remplir tous les champs";
        }
        else{

            //test que l'utilisateur n'a pas déjà créé un projet du même nom
            $sqlTest1 = "SELECT ID_PROJET FROM projet WHERE NOM_PROJET = '$projectName' AND ID_MANAGER = '$userID'";
            $result1 = mysqli_query($conn,$sqlTest1);

            if(mysqli_num_rows($result1) > 0){
                echo "Vous avez déjà créé un projet du même nom";
            }
            else{
                $sql = "INSERT INTO projet (NOM_PROJET, ID_MANAGER, DESCRIPTION)
                VALUES ('$projectName','$userID','$projectDesc')";

                $sql2 = "INSERT INTO membre (ID_MEMBRE, ID_PROJET, NOM_MEMBRE)
                VALUES ('$userID',LAST_INSERT_ID(),'$userName')";

                if (mysqli_query($conn,$sql) === FALSE) {
                    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
                }
                else if(mysqli_query($conn,$sql2) === FALSE){
                    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
                }
                else{
                    echo "Votre projet a bien été crée";
                    header("Refresh:0");
                }
            }
        }
    }
?>
</body>
</html>