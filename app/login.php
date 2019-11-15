<?php
session_start();

if(isset($_POST['nameCo']) && isset($_POST['pswdCo']) )
{
    $db_username = 'aouldamara';
    $db_password = 'cdp';
    $db_host = 'localhost';
    try {
        $connexion = new PDO("mysql:host=$db_host;dbname=aouldamara",$db_username,$db_password);
        // set the PDO error mode to exception
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";
        //Getting username and passsword
        $username = $_POST['nameCo'];
        $password = password_hash($_POST['pswdCo'], PASSWORD_DEFAULT);

        //Rechercher le user dans la BDD
        $pdo_query = $connexion->prepare('SELECT count(*)  FROM utilisateur WHERE NOM_USER = ? AND PASSWORD_USER= ?');
        $pdo_query->execute([$username,$password]);
        $exist = $pdo_query->fetch();

        //test Existance
        if($exist != 0){
            $_SESSION['username'] = $username;
            header('Location : profile.php');
        }
        else {
            header('Location:index.php');
        }

    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

    $connexion=null;
}

?>