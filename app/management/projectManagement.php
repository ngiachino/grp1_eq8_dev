<?php
function addProject($conn, $userID, $userName)
{
    if (isset($_POST['submit'])) {
        $projectName = $_POST['name'];
        $projectDesc = $_POST['description'];
        //test que tous les champs sont remplis
        if (empty($projectName) || empty($projectDesc)) {
            return "Vous devez remplir tous les champs";
        } else {

            //test que l'utilisateur n'a pas déjà créé un projet du même nom
            $sqlTest1 = "SELECT ID_PROJET FROM projet WHERE NOM_PROJET = '$projectName' AND ID_MANAGER = '$userID'";
            $result1 = mysqli_query($conn, $sqlTest1);

            if (mysqli_num_rows($result1) > 0) {
                return "Vous avez déjà créé un projet du même nom";
            } else {
                $sql = "INSERT INTO projet (NOM_PROJET, ID_MANAGER, DESCRIPTION)
                VALUES ('$projectName','$userID','$projectDesc')";

                $sql2 = "INSERT INTO membre (ID_MEMBRE, ID_PROJET, NOM_MEMBRE)
                VALUES ('$userID',LAST_INSERT_ID(),'$userName')";

                if (!mysqli_query($conn, $sql)) {
                    return "Error: " . $sql . "<br>" . $conn->error . "<br>";
                } else if (!mysqli_query($conn, $sql2)) {
                    return "Error: " . $sql . "<br>" . $conn->error . "<br>";
                } else {
                    return "Votre projet a bien été créé";
                }
            }
        }
    }
}

function editProject($conn){

}

function deleteProject($conn, $userID, $projectName){
    if (isset($_POST['delete'])) {
        $sql = "DELETE FROM projet WHERE NOM_PROJET = '$projectName' AND ID_MANAGER = '$userID'";

        if (!mysqli_query($conn, $sql)) {
            return "Error: " . $sql . "<br>" . $conn->error . "<br>";
        } else {
            header("Location: profil.php");
            return "Votre projet a bien été supprimé";
        }
    }
}
