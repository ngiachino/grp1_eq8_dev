<?php
    include_once 'src/database/DBconnect.php';
    include_once 'src/app/management/projectManagement.php';
    include_once 'src/app/management/registerManagement.php';
    include_once 'src/app/management/utils.php';
    use PHPUnit\Framework\TestCase;
    /**
    * @group testsUnitaires
    *
    */
    class ProjectTest extends TestCase{
        /** @test */
        public function testAddProject(){
            $conn = connect();
            $this->clear();

            $userID=createAccount($conn);

            addProject("TestProjet","Exemple de description","TestAccount",$userID,false);
            $this->assertContains("Votre projet a bien été créé", getMessage());
            $sql = "SELECT ID_PROJET FROM projet WHERE NOM_PROJET = 'TestProjet' AND ID_MANAGER = '$userID'";
            $result = $conn->query($sql);
            $this->assertEquals($result->num_rows, 1);

            addProject("TestProjet","Exemple de description2","TestAccount",$userID,false);
            $this->assertContains("Vous avez déjà créé un projet du même nom", getMessage());
            $sql = "SELECT ID_PROJET FROM projet WHERE NOM_PROJET = 'TestProjet' AND ID_MANAGER = '$userID'";
            $result = $conn->query($sql);
            $this->assertEquals($result->num_rows, 1);
            $this->clear();

        }
        public function testDeleteProject(){
            $conn = connect();
            $this->clear();

            $userID=createAccount($conn);

            addProject("TestProjet","Exemple de description","TestAccount",$userID,false);
            $sql = "SELECT ID_PROJET FROM projet WHERE NOM_PROJET = 'TestProjet' AND ID_MANAGER = '$userID'";
            $result = $conn->query($sql);
            $row = mysqli_fetch_assoc($result);
            $projectID = $row["ID_PROJET"];
            deleteProject($projectID,false);
            $this->assertContains("Votre projet a bien été supprimé", getMessage());
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
            $sql = "DELETE FROM projet WHERE NOM_PROJET = 'TestProjet'";
            $conn->query($sql);
        }
    }
