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
        //test que le mail ou le pseudo et le mot de passe correspondent
        $sql = $conn->prepare("SELECT ID_USER,NOM_USER,PASSWORD_USER FROM utilisateur WHERE (MAIL_USER = ? OR NOM_USER =?)");
        $sql->bind_param("ss",$nameCo,$nameCo);
        $sql->execute();
        $result = $sql->get_result();
        if($result->num_rows == 0){
            return "Ce compte n'existe pas";
        }
        else{
            $data = mysqli_fetch_assoc($result);
            if(password_verify($pswdCo,$data['PASSWORD_USER'])){
                $_SESSION['userName'] = $data['NOM_USER'];
                $_SESSION['userID'] = $data['ID_USER'];
                header("Location:app/view/profil.php");
                return "Vous êtes connecté !";
            }
            else{
                return "Le mot de passe n'est pas valide";
            }
            
        }
    }
}
?>
