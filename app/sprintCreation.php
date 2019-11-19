<?php
function addSprint($conn,$projectID)
{
    if (isset($_POST['submit'])) {
        $sprintName = $_POST['name'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        //test que tous les champs sont remplis
        if (empty($sprintName) || empty($startDate) || empty($endDate)) {
            return "Vous devez remplir tous les champs";
        } else {
            //test que l'utilisateur n'a pas déjà créé un projet du même nom
            $sqlTest1 = "SELECT ID_SPRINT FROM sprint WHERE NOM_SPRINT = '$sprintName' AND ID_PROJET = '$projectID'";
            $result1 = mysqli_query($conn, $sqlTest1);

            if (mysqli_num_rows($result1) > 0) {
                return "Vous avez déjà créé un sprint du même nom";
            } else {
                $sql = "INSERT INTO sprint (NOM_SPRINT, ID_PROJET, DATE_DEBUT, DATE_FIN)
                VALUES ('$sprintName','$projectID','$startDate', '$endDate')";

                if (mysqli_query($conn, $sql) === FALSE) {
                    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
                } else {
                    return "Votre sprint a bien été crée";
                }
            }
        }
    }
}
?>