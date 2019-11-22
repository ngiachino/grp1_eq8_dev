<?php
function addMember($conn, $projectId)
{
    if (isset($_POST['submit'])) {
        $userName = $_POST['userName'];
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
                    if (!mysqli_query($conn, $query)) {
                        return "Error: " . $query . "<br>" . $conn->connect_error . "<br>";
                    }
                }
            }
        }
    }
}
