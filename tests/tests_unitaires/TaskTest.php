<?php
include_once 'src/database/DBconnect.php';
include_once 'src/app/management/projectManagement.php';
include_once 'src/app/management/registerManagement.php';
include_once 'src/app/management/taskManagement.php';
include_once 'src/app/management/sprintManagement.php';
include_once 'utils.php';
include_once 'src/app/management/utils.php';
use PHPUnit\Framework\TestCase;
/**
 * @group testsUnitaires
 *
 */
class TaskTest extends TestCase{
    /** @test */
    public function testAddTask(){
        $conn = connect();
        $this->clear();
        $userID=createAccount($conn);
        $projectId = createProject($conn,$userID);
        $sprintId = createSprint($conn,$projectId);
        //CREATE THE TASK
        addTask($conn,$projectId,$sprintId,"Test Description",1,"TO DO");
        $this->assertContains("Tâche ajoutée", getMessage());
        $sql = "SELECT ID_TACHE from tache WHERE ID_PROJET= '$projectId'";
        $result = $conn->query($sql);
        $this->assertEquals($result->num_rows, 1);
        $this->clear();
    }

    public function testDeleteTask(){
        $conn = connect();
        $this->clear();
        $userID=createAccount($conn);
        $projectId = createProject($conn,$userID);
        $sprintId = createSprint($conn,$projectId);
        $taskId = createTask($conn, $projectId, $sprintId);
        //DELETE
        deleteTask($conn, $projectId, $sprintId, $taskId);
        $this->assertContains("La suppresion la tâche a été faite! ", getMessage());
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
        $sql = "DELETE FROM tache WHERE DESCRIPTION ='Test Description'";
        $conn->query($sql);
    }
}

function createTask($conn, $projectId, $sprintId){
    $description ="Test Description";
    $duration= 1;
    addTask($conn, $projectId,$sprintId,$description,$duration,"TO DO");
    $sql ="SELECT ID_TACHE from tache WHERE DESCRIPTION= 'Test Description'";
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    return $row["ID_TACHE"];
}
