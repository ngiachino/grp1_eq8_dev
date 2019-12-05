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
?>