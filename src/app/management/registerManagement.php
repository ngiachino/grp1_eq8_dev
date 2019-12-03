<?php
function startRegister(){
    if(isset($_POST['submitInsc'])){
        $pseudoInsc = $_POST['pseudoInsc'];
        $mailInsc = $_POST['mailInsc'];
        $pswdInsc = $_POST['pswdInsc'];
        $pswdConfirmInsc = $_POST['pswdConfirmInsc'];
        register($pseudoInsc,$mailInsc,$pswdInsc,$pswdConfirmInsc);
    }
}
function register($pseudoInsc,$mailInsc,$pswdInsc,$pswdConfirmInsc){
    $conn = connect();
    //test que tous les champs sont remplis
    if(empty($pseudoInsc) || empty($mailInsc) || empty($pswdInsc) || empty($pswdConfirmInsc)){
        return "Vous devez remplir tous les champs";
    }
    //test que les deux mots de passe sont identiques
    else if($pswdInsc != $pswdConfirmInsc){
        return "Les mots de passe ne sont pas identiques";
    }
    //test que le mail n'est pas déjà utilisé
    $sqlTest1 = $conn->prepare("SELECT ID_USER FROM utilisateur WHERE MAIL_USER =?");
    $sqlTest1->bind_param("s",$mailInsc);
    $sqlTest1->execute();
    $result1 = $sqlTest1->get_result();

    //test que le pseudo n'est pas déjà utilisé
    $sqlTest2 = $conn->prepare("SELECT ID_USER FROM utilisateur WHERE NOM_USER = ?");
    $sqlTest2->bind_param("s",$pseudoInsc);
    $sqlTest2->execute();
    $result2 = $sqlTest2->get_result();
    if($result1->num_rows > 0){
        return "Ce mail est déjà associé à un compte";
    }
    else if($result2->num_rows > 0){
        return "Ce pseudo est déjà associé à un compte";
    }
    else{
        $hash = password_hash($pswdInsc, PASSWORD_DEFAULT);
        $sql = $conn->prepare("INSERT INTO utilisateur (NOM_USER, PASSWORD_USER, MAIL_USER)
        VALUES (?,?,?)");
        $sql->bind_param("sss",$pseudoInsc,$hash,$mailInsc);
        $sql->execute();
        return "Votre compte a bien été créé";
    }
}
?>
