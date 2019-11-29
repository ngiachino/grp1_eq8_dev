<?php
    include_once '../../database/DBconnect.php';
    include_once '../../app/management/registerManagement.php';
    use PHPUnit\Framework\TestCase;
    /**
    * @group testsUnitaires
    *
    */
    class RegisterTest extends TestCase{
        /** @test */
        public function testRegister(){
            $conn = connect();
            $this->clear();

            $res = register("TestAccountSelenium","TestAccountSelenium@test.fr","test","test");
            $this->assertEquals($res,"Votre compte a bien été créé");
            $sql = "SELECT ID_USER FROM utilisateur WHERE NOM_USER = 'TestAccountSelenium'";
            $result = $conn->query($sql);
            $this->assertEquals($result->num_rows, 1);

            $res = register("TestAccountSelenium","Test@test.test","test2","test2");
            $this->assertEquals($res,"Ce pseudo est déjà associé à un compte");
            $sql = "SELECT ID_USER FROM utilisateur WHERE NOM_USER = 'TestAccountSelenium'";
            $result = $conn->query($sql);
            $this->assertEquals($result->num_rows, 1);

            $res = register("Test","TestAccountSelenium@test.fr","test2","test2");
            $this->assertEquals($res,"Ce mail est déjà associé à un compte");
            $sql = "SELECT ID_USER FROM utilisateur WHERE MAIL_USER = 'TestAccountSelenium@test.fr'";
            $result = $conn->query($sql);
            $this->assertEquals($result->num_rows, 1);

            $res = register("TestAccountSelenium2","TestAccountSelenium2@test.fr","test","test2");
            $this->assertEquals($res,"Les mots de passe ne sont pas identiques");
            $sql = "SELECT ID_USER FROM utilisateur WHERE NOM_USER = 'TestAccountSelenium2'";
            $result = $conn->query($sql);
            $this->assertEquals($result->num_rows, 0);

            $this->clear();
        }
        private function clear(){
            $conn = connect();
            $sql = "DELETE FROM utilisateur WHERE NOM_USER = 'TestAccountSelenium' OR MAIL_USER = 'TestAccountSelenium@test.fr' OR NOM_USER = 'TestAccountSelenium2' OR MAIL_USER = 'TestAccountSelenium@test.fr'";
            $conn->query($sql);
        }
    }
