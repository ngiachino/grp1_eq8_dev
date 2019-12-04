ass <?php
include_once 'src/database/DBconnect.php';
include_once 'src/app/management/registerManagement.php';
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

        register("TestAccount","TestAccount@test.fr","test","test");
        $this->assertContains("Votre compte a bien été créé", getMessage());
        $sql = "SELECT ID_USER FROM utilisateur WHERE NOM_USER = 'TestAccount'";
        $result = $conn->query($sql);
        $this->assertEquals($result->num_rows, 1);

        register("TestAccount","Test@test.test","test2","test2");
        $this->assertContains("Ce pseudo est déjà associé à un compte", getMessage());
        $sql = "SELECT ID_USER FROM utilisateur WHERE NOM_USER = 'TestAccount'";
        $result = $conn->query($sql);
        $this->assertEquals($result->num_rows, 1);

        register("Test","TestAccount@test.fr","test2","test2");
        $this->assertContains("Ce mail est déjà associé à un compte", getMessage());
        $sql = "SELECT ID_USER FROM utilisateur WHERE MAIL_USER = 'TestAccount@test.fr'";
        $result = $conn->query($sql);
        $this->assertEquals($result->num_rows, 1);

        register("TestAccount2","TestAccount2@test.fr","test","test2");
        $this->assertContains("Les mots de passe ne sont pas identiques", getMessage());
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
