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

$query = "SELECT * FROM membre WHERE ID_PROJET = '$projectId'";
$result1 = mysqli_query($conn, $query);
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include './defaultHead.php'; ?>
    <title>Projet : <?php echo $projectTitle?> - GoProject</title>
    <link href="../assets/css/projet.css" rel="stylesheet">
</head>

<body>
<div class = "menuBar">
    <div class="menuBar-left">
        <a href="profil.php">GoProject</a>
    </div>
    <div class="menuBar-right">
        <a class = "disconnect" href="./index.php">Se déconnecter</a>
    </div>
</div>

<h1>
    <?php echo $projectTitle?>
</h1>

<div class="supercontainer">

    <div class="container">
        <a class="pageLink" href="issues.php">
            <h2>Les issues</h2>
        </a>
    </div>

    <div class="container">
        <a class="pageLink" href="#">
            <h2>Les tâches</h2>
        </a>
    </div>

    <div class="container">
        <a class="pageLink" href="#">
            <h2>Les releases</h2>
        </a>
    </div>

    <div class="container">
        <a class="pageLink" href="#">
            <h2>Les test</h2>
        </a>
    </div>

    <div class="container">
        <a class="pageLink" href="#">
            <h2>La doc</h2>
        </a>
    </div>

</div>

<div id="membersList">
    <div class="container">
        <form class="form-container" method = "POST">
            <input type="text" name="userName" placeholder="Pseudo ou Email" id="userName">
            <input type="submit" name="submit" class="submit" value="Inviter membre">
        </form>
        <?php
        if(isset($_POST['submit'])){
            $userName = $_POST['userName'];
            //Test que le champ n'est pas vide
            if(empty($userName)){
                echo "<span>Vous devez indiquer un pseudo ou un mail</span></br>";
            }
            else{
                //Test que l'utilisateur n'est pas déjà dans le projet
                $query = "SELECT ID_MEMBRE FROM membre JOIN utilisateur ON membre.ID_MEMBRE = utilisateur.ID_USER WHERE (NOM_MEMBRE ='$userName' OR MAIL_USER='$userName') AND ID_PROJET = '$projectId'";
                $result = mysqli_query($conn, $query);
                if(mysqli_num_rows($result) != 0){
                    echo "<span>Cet utilisateur fait déjà parti du projet</span></br>";
                }
                else{
                    //Test que l'utilisateur existe (mail ou pseudo)
                    $query = "SELECT ID_USER,NOM_USER FROM utilisateur WHERE NOM_USER ='$userName' OR MAIL_USER = '$userName'";
                    $result = mysqli_query($conn, $query);
                    if(mysqli_num_rows($result) == 0){
                        echo "<span>Ce pseudo/mail ne correspond à aucun utilisateur</span></br>";
                    }
                    //Ajout de l'utilisateur au projet
                    else{
                        $row = mysqli_fetch_row($result);
                        $memberName=$row[1];
                        $memberId=$row[0];
                        $query = "INSERT INTO membre (ID_MEMBRE, ID_PROJET, NOM_MEMBRE)
                        VALUES ('$memberId','$projectId','$memberName')";
                        if(mysqli_query($conn,$query) === FALSE){
                            echo "Error: " . $query . "<br>" . $conn->connect_error . "<br>";
                        }
                        header("Refresh:0");
                    }
                }
            }

        }
        ?>
        Liste des membres

        <ul>
            <?php while($member = mysqli_fetch_row($result1)) { ?>
                <li><?php echo $member[2] ?>
                <form method="post">
                <input type="hidden" name="name" value="<?php echo $member[2];?>">
                <input type="<?php if($member[2] == $projectOwner){echo "hidden";} else{echo "submit";} ?>" name="deleteUser" value="&#x274C;">
                </form></li>
            <?php } ?>
        </ul>

    </div>
</div>

</body>
</html>

<?php 
if(isset($_POST['deleteUser'])){
    $userToDelete = $_POST['name'];
    $query = "DELETE FROM membre WHERE NOM_MEMBRE = '$userToDelete'";
    $result = mysqli_query($conn,$query);
    header("Refresh:0");
}
?>