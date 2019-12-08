<?php
include_once 'src/database/DBconnect.php';
include_once 'src/app/management/projectManagement.php';
include_once 'src/app/management/registerManagement.php';
include_once 'src/app/management/issuesManagement.php';
include_once 'src/app/management/sprintManagement.php';
include_once 'utils.php';
use PHPUnit\Framework\TestCase;
/**
 * @group testsUnitaires
 *
 */
class SprintTest extends TestCase{
    /** @test */
    public function testAddSprint(){
        $conn = connect();
        $this->clear();
        $userID=createAccount($conn);
        $projectId = createProject($conn,$userID);
        $today = date("Y-m-d");
        $nextWeek = date("Y-m-d", strtotime("+1 week"));
        $messageResult = addSprint($conn,$projectId,"sprint test", $today, $nextWeek );
        $this->assertEquals($messageResult,"Votre sprint a bien été crée");

        $sql = "SELECT ID_SPRINT FROM sprint WHERE ID_PROJET=$projectId and NOM_SPRINT='sprint test'";
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
        $sql = "DELETE FROM projet WHERE NOM_PROJET = 'TestProjet'";
        $conn->query($sql);
        $sql = "DELETE FROM sprint WHERE NOM_SPRINT='sprint test'";
        $conn->query($sql);
    }
}
