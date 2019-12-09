<?php
include_once 'src/database/DBconnect.php';
include_once 'src/app/management/projectManagement.php';
include_once 'src/app/management/registerManagement.php';
include_once 'src/app/management/issuesManagement.php';
include_once 'src/app/management/taskManagement.php';
include_once 'utils.php';
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
        $messageAdd = createTask($conn,$userID,$projectId,$sprintId);
        $this->assertEquals($messageAdd,"Tâche ajoutée ");
        //RECHECK TASK'S NUMBER
        $sql = "SELECT ID_TACHE from tache WHERE DESCRIPTION='Test Description'";
        $resultTask = mysqli_query($conn,$sql);
        $taskNumber=mysqli_num_rows($resultTask);
        $this->assertEquals($taskNumber, 1);
        $this->clear();
    }

    public function testDeleteTask(){
        $conn = connect();
        $this->clear();
        $userID=createAccount($conn);
        $projectId = createProject($conn,$userID);
        $sprintId = createSprint($conn,$projectId);
        //CREATE THE TASK
        createTask($conn,$userID,$projectId,$sprintId);
        //Get taskId
        $queryId ="SELECT ID_TACHE from tache WHERE DESCRIPTION= 'Test Description'";
        $result = mysqli_query($conn,$queryId);
        $taskId= mysqli_fetch_row($result)[0];
        //DELETE
        deleteTask($conn,$projectId,$sprintId,$taskId);
        $queryId ="SELECT ID_TACHE from tache WHERE DESCRIPTION= 'Test Description'";
        $result = mysqli_query($conn,$queryId);
        $taskNumber=mysqli_num_rows($result);
        $this->assertEquals($taskNumber, 0);
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
