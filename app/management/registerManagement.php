<?php
function register(){
    $conn = connect();
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if(isset($_POST['submitInsc'])){
        $pseudoInsc = $_POST['pseudoInsc'];
        $mailInsc = $_POST['mailInsc'];
        $pswdInsc = $_POST['pswdInsc'];
        $pswdConfirmInsc = $_POST['pswdConfirmInsc'];

        //test que tous les champs sont remplis
        if(empty($pseudoInsc) || empty($mailInsc) || empty($pswdInsc) || empty($pswdConfirmInsc)){
            return "Vous devez remplir tous les champs";
        }
        //test que les deux mots de passe sont identiques
        else if($pswdInsc != $pswdConfirmInsc){
            return "Les mots de passe ne sont pas identiques";
        }
        else{

            //test que le mail n'est pas déjà utilisé
            $sqlTest1 = "SELECT ID_USER FROM utilisateur WHERE MAIL_USER = '$mailInsc'";
            $result1 = $conn->query($sqlTest1);

            //test que le pseudo n'est pas déjà utilisé
            $sqlTest2 = "SELECT ID_USER FROM utilisateur WHERE NOM_USER = '$pseudoInsc'";
            $result2 = $conn->query($sqlTest2);
            if($result1->num_rows > 0){
                return "Ce mail est déjà associé à un compte";
            }
            else if($result2->num_rows > 0){
                return "Ce pseudo est déjà associé à un compte";
            }
            else{
                $sql = "INSERT INTO utilisateur (NOM_USER, PASSWORD_USER, MAIL_USER)
                VALUES ('$pseudoInsc','$pswdInsc','$mailInsc')";
                if ($conn->query($sql) === FALSE) {
                    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
                }
                else{
                    return "Votre compte a bien été créé";
                }
            }
        }
    }
}
?>