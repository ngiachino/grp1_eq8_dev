<?php
    function createAccount($conn){
            register("TestAccount","TestAccount@test.fr","test","test");
            $sql = "SELECT ID_USER FROM utilisateur WHERE NOM_USER = 'TestAccount'";
            $result = $conn->query($sql);
            $row = mysqli_fetch_assoc($result);
            return $row["ID_USER"];
        }
    function createProject($conn,$userID){
            addProject("TestProjet","Exemple de description","TestAccount",$userID,false);
            $sql = "SELECT ID_PROJET FROM projet WHERE NOM_PROJET = 'TestProjet'";
            $result = $conn->query($sql);
            $row = mysqli_fetch_assoc($result);
            return $row["ID_PROJET"];
        }
    function createSprint($conn, $projectId){
        $today = date("Y-m-d");
        $nextWeek = date("Y-m-d", strtotime("+1 week"));
        addSprint($conn,$projectId,'sprint test', $today,$nextWeek);
        $sql ="SELECT ID_SPRINT from sprint WHERE NOM_SPRINT= 'sprint test'";
        $result = $conn->query($sql);
        $row = mysqli_fetch_assoc($result);
        return $row["ID_SPRINT"];
    }
?>