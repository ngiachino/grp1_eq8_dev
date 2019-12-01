<?php
    include_once '../../src/database/DBconnect.php';
    include_once '../../src/app/management/projectManagement.php';
    include_once '../../src/app/management/registerManagement.php';
    include_once '../../src/app/management/issuesManagement.php';
    use PHPUnit\Framework\TestCase;
    /**
    * @group testsUnitaires
    *
    */
    class IssueTest extends TestCase{
        /** @test */
        public function testAddIssue(){
            $conn = connect();
            $this->clear();
            $userName = "TestAccount";

            register($userName,"TestAccount@test.fr","test","test");
            $sql = "SELECT ID_USER FROM utilisateur WHERE NOM_USER = 'TestAccount'";
            $result = $conn->query($sql);
            $row = mysqli_fetch_assoc($result);
            $userID = $row["ID_USER"];

            addProject("TestProjet","Exemple de description",$userName,$userID,false);
            $sql = "SELECT ID_PROJET FROM projet WHERE NOM_PROJET = 'TestProjet'";
            $result = $conn->query($sql);
            $row = mysqli_fetch_assoc($result);
            $idProjet = $row["ID_PROJET"];

            $res = addIssue($idProjet,"Description de test","HIGH",2);
            $this->assertEquals($res,"Votre issue a été créée");
            $sql = "SELECT ID_USER_STORY FROM issue WHERE ID_PROJET = '$idProjet'";
            $result = $conn->query($sql);
            $this->assertEquals($result->num_rows, 1);

            $this->clear();

        }
        public function testDeleteIssue(){
            $conn = connect();
            $this->clear();
            $userName = "TestAccount";

            register($userName,"TestAccount@test.fr","test","test");
            $sql = "SELECT ID_USER FROM utilisateur WHERE NOM_USER = 'TestAccount'";
            $result = $conn->query($sql);
            $row = mysqli_fetch_assoc($result);
            $userID = $row["ID_USER"];

            addProject("TestProjet","Exemple de description",$userName,$userID,false);
            $sql = "SELECT ID_PROJET FROM projet WHERE NOM_PROJET = 'TestProjet'";
            $result = $conn->query($sql);
            $row = mysqli_fetch_assoc($result);
            $idProjet = $row["ID_PROJET"];

            addIssue($idProjet,"Description de test","HIGH",2);
            $sql = "SELECT ID_USER_STORY FROM issue WHERE ID_PROJET = '$idProjet'";
            $result = $conn->query($sql);
            $row = mysqli_fetch_assoc($result);
            $issueID = $row["ID_USER_STORY"];

            $res = deleteIssue($issueID, $idProjet);
            $this->assertEquals($res,"Votre issue a été supprimée");

            $sql = "SELECT ID_USER_STORY FROM issue WHERE ID_PROJET = '$idProjet'";
            $result = $conn->query($sql);
            $this->assertEquals($result->num_rows, 0);
        }
        public function testModifyIssue(){
            $conn = connect();
            $this->clear();
            $userName = "TestAccount";

            register($userName,"TestAccount@test.fr","test","test");
            $sql = "SELECT ID_USER FROM utilisateur WHERE NOM_USER = 'TestAccount'";
            $result = $conn->query($sql);
            $row = mysqli_fetch_assoc($result);
            $userID = $row["ID_USER"];

            addProject("TestProjet","Exemple de description",$userName,$userID,false);
            $sql = "SELECT ID_PROJET FROM projet WHERE NOM_PROJET = 'TestProjet'";
            $result = $conn->query($sql);
            $row = mysqli_fetch_assoc($result);
            $idProjet = $row["ID_PROJET"];

            addIssue($idProjet,"Description de test","HIGH",2);
            $sql = "SELECT ID_USER_STORY FROM issue WHERE ID_PROJET = '$idProjet'";
            $result = $conn->query($sql);
            $row = mysqli_fetch_assoc($result);
            $issueID = $row["ID_USER_STORY"];

            $res = modifyIssue($idProjet,$issueID,"LOW",2,"Description de test");
            $this->assertEquals($res,"Votre issue a bien été modifiée");

            $sql = "SELECT ID_USER_STORY FROM issue WHERE ID_PROJET = '$idProjet' AND DESCRIPTION = 'Description de test'";
            $result = $conn->query($sql);
            $this->assertEquals($result->num_rows, 1);

            $sql = "SELECT ID_USER_STORY FROM issue WHERE ID_PROJET = '$idProjet' AND DESCRIPTION = 'Description de test' AND PRIORITE='LOW'";
            $result = $conn->query($sql);
            $this->assertEquals($result->num_rows, 1);

            $this->clear();
        }
        private function clear(){
            $conn = connect();
            $sql = "DELETE FROM utilisateur WHERE NOM_USER = 'TestAccount' OR MAIL_USER = 'TestAccount@test.fr'";
            $conn->query($sql);
            $sql = "DELETE FROM membre WHERE NOM_MEMBRE = 'TestAccount'";
            $conn->query($sql);
            $sql = "DELETE FROM issue WHERE DESCRIPTION = 'Description de test'";
            $conn->query($sql);
        }
    }
