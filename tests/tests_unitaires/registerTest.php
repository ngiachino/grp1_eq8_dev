<?php
    include '../../database/DBconnect.php';
    include '../../app/management/registerManagement.php';
    use PHPUnit\Framework\TestCase;

    class registerTest extends TestCase{
        /** @test */
        public function testRegister(){
            $conn = connect();
            $this->clear();

            $res = register("TestAccount","TestAccount@test.fr","test","test");
            $this->assertEquals($res,"Votre compte a bien été créé");
            $sql = "SELECT ID_USER FROM utilisateur WHERE NOM_USER = 'TestAccount'";
            $result = $conn->query($sql);
            $this->assertEquals($result->num_rows, 1);

            $res = register("TestAccount","Test@test.test","test2","test2");
            $this->assertEquals($res,"Ce pseudo est déjà associé à un compte");
            $sql = "SELECT ID_USER FROM utilisateur WHERE NOM_USER = 'TestAccount'";
            $result = $conn->query($sql);
            $this->assertEquals($result->num_rows, 1);

            $res = register("Test","TestAccount@test.fr","test2","test2");
            $this->assertEquals($res,"Ce mail est déjà associé à un compte");
            $sql = "SELECT ID_USER FROM utilisateur WHERE MAIL_USER = 'TestAccount@test.fr'";
            $result = $conn->query($sql);
            $this->assertEquals($result->num_rows, 1);

            $res = register("TestAccount2","TestAccount2@test.fr","test","test2");
            $this->assertEquals($res,"Les mots de passe ne sont pas identiques");
            $sql = "SELECT ID_USER FROM utilisateur WHERE NOM_USER = 'TestAccount2'";
            $result = $conn->query($sql);
            $this->assertEquals($result->num_rows, 0);

            $this->clear();
        }
        private function clear(){
            $conn = connect();
            $sql = "DELETE FROM utilisateur WHERE NOM_USER = 'TestAccount' OR MAIL_USER = 'TestAccount@test.fr' OR NOM_USER = 'TestAccount2' OR MAIL_USER = 'TestAccount@test.fr'";
            $conn->query($sql);
        }
    }
