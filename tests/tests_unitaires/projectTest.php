<?php
    include '../../database/DBconnect.php';
    include '../../app/management/projectManagement.php';
    include '../../app/management/registerManagement.php';
    use PHPUnit\Framework\TestCase;

    class projectTest extends TestCase{
        /** @test */
        public function testAddProject(){
            $conn = connect();
            $this->clear();
           
            $userName = "TestAccount";
            $res = register($userName,"TestAccount@test.fr","test","test");
            $sql = "SELECT ID_USER FROM utilisateur WHERE NOM_USER = 'TestAccount'";
            $result = $conn->query($sql);
            $row = mysqli_fetch_assoc($result);
            $userID = $row["ID_USER"];

            $res = addProject("TestProjet","Exemple de description",$userName,$userID,false);
            $this->assertEquals($res,"Votre projet a bien été créé");
            $sql = "SELECT ID_PROJET FROM projet WHERE NOM_PROJET = 'TestProjet' AND ID_MANAGER = '$userID'";
            $result = $conn->query($sql);
            $this->assertEquals($result->num_rows, 1);

            $res = addProject("TestProjet","Exemple de description2",$userName,$userID,false);
            $this->assertEquals($res,"Vous avez déjà créé un projet du même nom");
            $sql = "SELECT ID_PROJET FROM projet WHERE NOM_PROJET = 'TestProjet' AND ID_MANAGER = '$userID'";
            $result = $conn->query($sql);
            $this->assertEquals($result->num_rows, 1);

            $sql = "DELETE FROM projet WHERE ID_MANAGER = '$userID'";
            $conn->query($sql);
            $this->clear();

        }
        public function testDeleteProject(){
            $conn = connect();
            $this->clear();

            $userName = "TestAccount";
            $res = register($userName,"TestAccount@test.fr","test","test");
            $sql = "SELECT ID_USER FROM utilisateur WHERE NOM_USER = 'TestAccount'";
            $result = $conn->query($sql);
            $row = mysqli_fetch_assoc($result);
            $userID = $row["ID_USER"];

            addProject("TestProjet","Exemple de description",$userName,$userID,false);
            $sql = "SELECT ID_PROJET FROM projet WHERE NOM_PROJET = 'TestProjet' AND ID_MANAGER = '$userID'";
            $result = $conn->query($sql);
            $row = mysqli_fetch_assoc($result);
            $projectID = $row["ID_PROJET"];
            $res = deleteProject($projectID,false);
            $this->assertEquals($res,"Votre projet a bien été supprimé");
            $sql = "SELECT ID_PROJET FROM projet WHERE NOM_PROJET = 'TestProjet' AND ID_MANAGER = '$userID'";
            $result = $conn->query($sql);
            $this->assertEquals($result->num_rows, 0);

            $sql = "SELECT ID_PROJET FROM membre WHERE ID_PROJET = '$projectID'";
            $result = $conn->query($sql);
            $this->assertEquals($result->num_rows, 0);
        }
        private function clear(){
            $conn = connect();
            $sql = "DELETE FROM utilisateur WHERE NOM_USER = 'TestAccount' OR MAIL_USER = 'TestAccount@test.fr'";
            $conn->query($sql);
            $sql = "DELETE FROM membre WHERE NOM_MEMBRE = 'TestAccount'";
            $conn->query($sql);
        }
    }
