<?php
    include_once 'src/database/DBconnect.php';
    include_once 'src/app/management/projectManagement.php';
    include_once 'src/app/management/registerManagement.php';
    include_once 'src/app/management/issuesManagement.php';
    include_once 'utils.php';
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

            $userID=createAccount($conn);
            $idProjet = createProject($conn,$userID);

            addIssue($idProjet,"Description de test","HIGH",2);
            $this->assertContains("Votre issue a été créée", getMessage());
            $sql = "SELECT ID_USER_STORY FROM issue WHERE ID_PROJET = '$idProjet'";
            $result = $conn->query($sql);
            $this->assertEquals($result->num_rows, 1);

            $this->clear();

        }
        public function testDeleteIssue(){
            $conn = connect();
            $this->clear();

            $userID=createAccount($conn);
            $idProjet = createProject($conn,$userID);
            $issueID = $this->createIssue($conn,$idProjet);

            deleteIssue($issueID, $idProjet);
            $this->assertContains("Votre issue a été supprimée", getMessage());

            $sql = "SELECT ID_USER_STORY FROM issue WHERE ID_PROJET = '$idProjet'";
            $result = $conn->query($sql);
            $this->assertEquals($result->num_rows, 0);
        }
        public function testModifyIssue(){
            $conn = connect();
            $this->clear();

            $userID=createAccount($conn);
            $idProjet = createProject($conn,$userID);
            $issueID = $this->createIssue($conn,$idProjet);
            
            modifyIssue($idProjet,$issueID,"LOW",2,"Description de test");
            $this->assertContains("Votre issue a bien été modifiée", getMessage());

            $sql = "SELECT ID_USER_STORY FROM issue WHERE ID_PROJET = '$idProjet' AND DESCRIPTION = 'Description de test'";
            $result = $conn->query($sql);
            $this->assertEquals($result->num_rows, 1);

            $sql = "SELECT ID_USER_STORY FROM issue WHERE ID_PROJET = '$idProjet' AND DESCRIPTION = 'Description de test' AND PRIORITE='LOW'";
            $result = $conn->query($sql);
            $this->assertEquals($result->num_rows, 1);

            $this->clear();
        }
        private function createIssue($conn,$idProjet){
            addIssue($idProjet,"Description de test","HIGH",2);
            $sql = "SELECT ID_USER_STORY FROM issue WHERE ID_PROJET = '$idProjet'";
            $result = $conn->query($sql);
            $row = mysqli_fetch_assoc($result);
            return $row["ID_USER_STORY"];
        }
        private function clear(){
            $conn = connect();
            $sql = "DELETE FROM utilisateur WHERE NOM_USER = 'TestAccount' OR MAIL_USER = 'TestAccount@test.fr'";
            $conn->query($sql);
            $sql = "DELETE FROM membre WHERE NOM_MEMBRE = 'TestAccount'";
            $conn->query($sql);
            $sql = "DELETE FROM issue WHERE DESCRIPTION = 'Description de test'";
            $conn->query($sql);
            $sql = "DELETE FROM projet WHERE NOM_PROJET = 'TestProjet'";
            $conn->query($sql);
        }
    }
