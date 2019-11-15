<?php
session_start();
if(isset($_POST['mailInsc']) && isset($_POST['pseudoInsc']) && isset($_POST['pswdInsc']) && isset($_POST['pswdConfirmInsc']) )
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
    $mail = $_POST['mailInsc'];

    //Rechercher le user dans la BDD
    $pdo_query = $connexion->prepare('SELECT count(*)  FROM utilisateur WHERE NOM_USER = ?');
    $pdo_query->execute([$username]);
    $exist = $pdo_query->fetch();

    //test Existance
    if($exist != 0){
        echo "This User exists";
        $_SESSION['username'] = $username;
        header('Location : index.php');
    }
    else {

        $pdo_query = $connexion->prepare('INSERT INTO utilisateur (NOM_USER, PASSWORD_USER, MAIL_USER) 
                                           VALUE 
                                            (   $username,
                                               $password,
                                               $mail 
                                            );
                                         ');
        $pdo_query->execute();

        header('Location:profil.php');
    }

    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

    $connexion=null;
}

?>