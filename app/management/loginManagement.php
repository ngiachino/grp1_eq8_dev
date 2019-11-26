<?php
function startConnexion(){
    if(isset($_POST['submitCo'])){
        $nameCo = $_POST['nameCo'];
        $pswdCo = $_POST['pswdCo'];
        connexion($nameCo,$pswdCo);
    }
}

function connexion($nameCo,$pswdCo){
    $conn = connect();
    
    //test que tous les champs sont remplis
    if(empty($nameCo) || empty($pswdCo)){
        return "Vous devez remplir tous les champs";
    }
    else{
        //test que le mail n'est pas déjà utilisé
        $sql = "SELECT ID_USER,NOM_USER FROM utilisateur WHERE (MAIL_USER = '$nameCo' OR NOM_USER = '$nameCo') AND PASSWORD_USER = '$pswdCo'";
        $result = $conn->query($sql);
        if($result->num_rows == 0){
            return "Le compte et le mot de passe ne correspondent pas";
        }
        else{
            $data = mysqli_fetch_assoc($result);
            $_SESSION['userName'] = $data['NOM_USER'];
            $_SESSION['userID'] = $data['ID_USER'];
            header("Location:profil.php");
            return "Vous êtes connecté !";
        }
    }
}
?>
