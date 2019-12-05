<?php
    include_once 'src/database/DBconnect.php';
    include_once 'src/app/management/projectManagement.php';
    include_once 'src/app/management/registerManagement.php';
    include_once 'src/app/management/membersManagement.php';
    use PHPUnit\Framework\TestCase;
    /**
    * @group testsUnitaires
    *
    */
    class MemberTest extends TestCase{
        /** @test */
        public function testAddMember(){
            $conn = connect();
            $this->clear();
            $userName = "TestAccount";
            $userName2 = "TestAccount2";

            register($userName,"TestAccount@test.fr","test","test");
            $sql = "SELECT ID_USER FROM utilisateur WHERE NOM_USER = 'TestAccount'";
            $result = $conn->query($sql);
            $row = mysqli_fetch_assoc($result);
            $userID = $row["ID_USER"];

            register($userName2,"TestAccount2@test.fr","test","test");

            addProject("TestProjet","Exemple de description",$userName,$userID,false);
            $sql = "SELECT ID_PROJET FROM projet WHERE NOM_PROJET = 'TestProjet'";
            $result = $conn->query($sql);
            $row = mysqli_fetch_assoc($result);
            $idProjet = $row["ID_PROJET"];


            $res = addMember($idProjet,$userName);
            $this->assertEquals($res,"<span>Cet utilisateur fait déjà parti du projet</span></br>");
            $sql = "SELECT ID_MEMBRE FROM membre WHERE ID_PROJET = '$idProjet'";
            $result = $conn->query($sql);
            $this->assertEquals($result->num_rows, 1);

            $res = addMember($idProjet,"TestAccount3");
            $this->assertEquals($res,"<span>Ce pseudo/mail ne correspond à aucun utilisateur</span></br>");
            $sql = "SELECT ID_MEMBRE FROM membre WHERE ID_PROJET = '$idProjet'";
            $result = $conn->query($sql);
            $this->assertEquals($result->num_rows, 1);

            $res = addMember($idProjet,$userName2);
            $this->assertEquals($res,"L'utilisateur a bien été ajouté");
            $sql = "SELECT ID_MEMBRE FROM membre WHERE ID_PROJET = '$idProjet'";
            $result = $conn->query($sql);
            $this->assertEquals($result->num_rows, 2);
            
            $this->clear();

        }
        public function testDeleteMember(){
            $conn = connect();
            $this->clear();
            $userName = "TestAccount";
            $userName2 = "TestAccount2";

            register($userName,"TestAccount@test.fr","test","test");
            $sql = "SELECT ID_USER FROM utilisateur WHERE NOM_USER = 'TestAccount'";
            $result = $conn->query($sql);
            $row = mysqli_fetch_assoc($result);
            $userID = $row["ID_USER"];

            register($userName2,"TestAccount2@test.fr","test","test");

            addProject("TestProjet","Exemple de description",$userName,$userID,false);
            $sql = "SELECT ID_PROJET FROM projet WHERE NOM_PROJET = 'TestProjet'";
            $result = $conn->query($sql);
            $row = mysqli_fetch_assoc($result);
            $idProjet = $row["ID_PROJET"];

            addMember($idProjet,$userName2);

            $res = deleteMember($idProjet,$userName2);
            $this->assertEquals($res,"L'utilisateur a été supprimé du projet");
            $sql = "SELECT ID_MEMBRE FROM membre WHERE ID_PROJET = '$idProjet'";
            $result = $conn->query($sql);
            $this->assertEquals($result->num_rows, 1);

            $this->clear();
        }
        
        private function clear(){
            $conn = connect();
            $sql = "DELETE FROM utilisateur WHERE NOM_USER = 'TestAccount' OR MAIL_USER = 'TestAccount@test.fr' OR NOM_USER = 'TestAccount2' OR MAIL_USER = 'TestAccount2@test.fr'";
            $conn->query($sql);
            $sql = "DELETE FROM membre WHERE NOM_MEMBRE = 'TestAccount' OR NOM_MEMBRE = 'TestAccount2'";
            $conn->query($sql);
            $sql = "DELETE FROM projet WHERE NOM_PROJET = 'TestProjet'";
            $conn->query($sql);
        }
    }