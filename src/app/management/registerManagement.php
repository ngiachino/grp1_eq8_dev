<?php
include_once 'general.php';

function startRegister(){
    if(isset($_POST['submitInsc'])){
        $pseudoInsc = $_POST['pseudoInsc'];
        $mailInsc = $_POST['mailInsc'];
        $pswdInsc = $_POST['pswdInsc'];
        $pswdConfirmInsc = $_POST['pswdConfirmInsc'];
        register($pseudoInsc,$mailInsc,$pswdInsc,$pswdConfirmInsc);
    }
}

function checkMailUsed($conn, $mailInsc){
    //test que le mail n'est pas déjà utilisé
    $sqlTest = $conn->prepare("SELECT ID_USER FROM utilisateur WHERE MAIL_USER = ?");
    $message = "Ce pseudo est déjà associé à un compte";
    return checkFieldsUsed($sqlTest, $mailInsc, $message);
}

function checkNameUsed($conn, $pseudoInsc){
    //test que le pseudo n'est pas déjà utilisé
    $sqlTest = $conn->prepare("SELECT ID_USER FROM utilisateur WHERE NOM_USER = ?");
    $message = "Ce pseudo est déjà associé à un compte";
    return checkFieldsUsed($sqlTest, $pseudoInsc, $message);
}

function checkFieldsUsed($sqlTest, $pseudoInsc, $message){
    $sqlTest->bind_param("s",$pseudoInsc);
    $sqlTest->execute();
    $result = $sqlTest->get_result();

    if($result->num_rows > 0){
        //return "Ce pseudo est déjà associé à un compte";
        aggregateMessage($message);
        return true;
    }
    return false;
}

function register($pseudoInsc,$mailInsc,$pswdInsc,$pswdConfirmInsc){
    $conn = connect();
    //test que tous les champs sont remplis
    if(empty($pseudoInsc) || empty($mailInsc) || empty($pswdInsc) || empty($pswdConfirmInsc)){
        aggregateMessage("Vous devez remplir tous les champs");
        return;
    }
    //test que les deux mots de passe sont identiques
    else if($pswdInsc != $pswdConfirmInsc){
        aggregateMessage("Les mots de passe ne sont pas identiques");
        return;
    }

    if(!checkMailUsed($conn, $mailInsc) && !checkNameUsed($conn, $pseudoInsc)){
        $hash = password_hash($pswdInsc, PASSWORD_DEFAULT);
        $sql = $conn->prepare("INSERT INTO utilisateur (NOM_USER, PASSWORD_USER, MAIL_USER)
        VALUES (?,?,?)");
        $sql->bind_param("sss",$pseudoInsc,$hash,$mailInsc);
        $sql->execute();
        aggregateMessage("Votre compte a bien été créé");
    }
}
