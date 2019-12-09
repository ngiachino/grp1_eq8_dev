<?php
    include_once 'src/database/DBconnect.php';
    include_once 'src/app/management/projectManagement.php';
    include_once 'src/app/management/registerManagement.php';
    include_once 'src/app/management/testManagement.php';
    include_once 'utils.php';
    use PHPUnit\Framework\TestCase;
    /**
    * @group testsUnitaires
    *
    */
    class TestTest extends TestCase{
        /** @test */
        public function testAddTest(){
            $conn = connect();
            $this->clear();

            $userID=createAccount($conn);
            $idProjet = createProject($conn,$userID);

            $res = addTest($idProjet,"Description de Test","Echec","2019-12-29",false);
            $this->assertEquals($res,"Un test a été créé");
            $sql = "SELECT ID_TEST FROM test WHERE ID_PROJET = '$idProjet'";
            $result = $conn->query($sql);
            $this->assertEquals($result->num_rows, 1);
            $this->clear();
        }

        public function testDeleteTest(){
            $conn = connect();
            $this->clear();

            $userID=createAccount($conn);
            $idProjet = createProject($conn,$userID);
            $testID = $this->createTest($conn,$idProjet);

            $res = deleteTest($idProjet,$testID,false);
            $this->assertEquals($res,"Un test a été supprimé");


            $sql = "SELECT ID_TEST FROM test WHERE ID_PROJET = '$idProjet'";
            $result = $conn->query($sql);
            $this->assertEquals($result->num_rows, 0);
            $this->clear();
        }

        public function testModifyTest(){
            $conn = connect();
            $this->clear();

            $userID=createAccount($conn);
            $idProjet = createProject($conn,$userID);
            $testID = $this->createTest($conn,$idProjet);
            
            $res = modifyTest($idProjet,"Description de Test","Réussite","2019-12-29",$testID,false);
            $this->assertEquals($res,"Votre test a bien été modifié");

            $sql = "SELECT ID_TEST FROM test WHERE ID_PROJET = '$idProjet' AND DESCRIPTION = 'Description de Test'";
            $result = $conn->query($sql);
            $this->assertEquals($result->num_rows, 1);

            $sql = "SELECT ID_TEST FROM test WHERE ID_PROJET = '$idProjet' AND DESCRIPTION = 'Description de Test' AND ETAT ='Réussite'";
            $result = $conn->query($sql);
            $this->assertEquals($result->num_rows, 1);
            

            $this->clear();
        }
        private function createTest($conn,$idProjet){
            addTest($idProjet,"Description de Test","Echec","2019-12-29",false);
            $sql = "SELECT ID_TEST FROM test WHERE ID_PROJET = '$idProjet'";
            $result = $conn->query($sql);
            $row = mysqli_fetch_assoc($result);
            return $row["ID_TEST"];
        }
        private function clear(){
            $conn = connect();
            $sql = "DELETE FROM utilisateur WHERE NOM_USER = 'TestAccount' OR MAIL_USER = 'TestAccount@test.fr'";
            $conn->query($sql);
            $sql = "DELETE FROM membre WHERE NOM_MEMBRE = 'TestAccount'";
            $conn->query($sql);
            $sql = "DELETE FROM projet WHERE NOM_PROJET = 'TestProjet'";
            $conn->query($sql);
            $sql = "DELETE FROM `test` WHERE `DESCRIPTION` = 'Description de Test'";
            $conn->query($sql);
        }
    }
