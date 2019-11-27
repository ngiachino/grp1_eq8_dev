    <?php
    include  'taskManagement.php';
    include '../../database/DBconnect.php';
    include 'sprintManagement.php';
    $conn = connect();

    session_start();
    //test si l'utilisateur est connecté. Sinon le renvoie vers l'index
    if($_SESSION['userName'] == null || $_SESSION['userID'] == null){
        header("Location:index.php");
    }
    //test si l'utilisateur est bien passé par sa page de profil. Sinon le renvoie vers le profil
    else if( $_GET['projectId'] == null || $_GET['sprintId'] == null){
        header("Location:sprints.php");
    }

    $projectId = $_GET['projectId'];
    $sprintId = $_GET['sprintId'];
    $addMessage = addTask($conn,$projectId, $sprintId);
    $assignMessage = assignTask($conn,$projectId, $sprintId );

    $query = "SELECT tache.DESCRIPTION, tache.DUREE_TACHE, NOM_MEMBRE, tache.ID_TACHE
              FROM tache  left join membre 
                          on tache.ID_TACHE = membre.ID_TACHE 
              WHERE tache.ID_PROJET = '$projectId'
                    AND tache.ID_SPRINT = '$sprintId'
                    ";

    if(mysqli_query($conn, $query) == FALSE)
        echo "Error: " . $query . "<br>" . $conn->error . "<br>";
    $result = mysqli_query($conn, $query);
    ?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <?php include '../view/defaultHead.php'; ?>
        <title>Tasks - GoProject</title>
        <link href="../../assets/projet.css" rel="stylesheet">
    </head>

    <body>

    <div class = "menuBar">
        <div class="menuBar-left">
            <a id="title" href="profil.php">GoProject</a>
        </div>
        <div class="menuBar-right">
            <a class="disconnect">Se déconnecter</a>
        </div>
    </div>

    <div class="supercontainer">
        <div class="container" id="tasks">
            <h2>Les tâches</h2>
        </div>
    </div>

    <div class="container">
        <!--AFFICHER LE NUMERO DE SPRINT -->
        <h2>Sprint <?php echo $sprintId ?></h2>
        <button type="button" class="btn btn-lg  btn-dark" data-toggle="collapse" data-target="#demo">
            Ajouter une tâche
        </button>
        <div id="demo" class="collapse">
            <!-- Le formulaire de creation de la tâche -->
            <form method="POST">
                <div class="form-group">
                    <label for="taskDescription">Description de la tâche:</label>
                    <input type="text" class="form-control" name="taskDescription">
                </div>
                <div class="form-group">
                    <label for="taskDuration">Durée de la tâche: </label>
                    <input type="text" class="form-control" name="taskDuration">
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
            <!--FIN DU FORMULAIRE-->
        </div>
    </div>
    <br>
    <br>
    <!--AFFICHAGE DES TÂCHES COURRANTES DU SPRINT-->
    <!-- $result recupère les tâches du sprint courant -->
    <!-- DESCRIPTION, DUREE_TACHE, NOM_MEMBRE -->
    <div class="container">
    <table class="table" id="taskList" summary="Table des tâches du projet">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Numéro </th>
            <th scope="col">Description</th>
            <th scope="col">Durée</th>
            <th scope="col">Membre

        </tr>
        </thead>

        <tbody>
        <?php
        $i = 1;
        while($row = mysqli_fetch_row($result)){
            ?>
            <tr>
                <th scope="row"><?php echo $i;?>
                </th>
                <td><?php echo $row[0];?></td>
                <td><?php echo $row[1];?></td>
                <td><?php echo $row[2];
                        $collapseTarget = "#demo".$i;
                        $target = "demo".$i;
                    ?>
                        <button type="button" class="btn  btn-dark" data-toggle="collapse"
                                                 data-target=<?php echo $collapseTarget;?> >
                            Assigner la tâche
                        </button>
                    <div id=<?php echo $target; ?> class="collapse">
                        <!-- Le formulaire d'attribution de la tâche -->
                        <form method="POST">
                            <input type="hidden" name="taskId" value=<?php echo $row[3];?>>
                            <div class="form-group">
                                <label for="userName">User:</label>
                                <input type="text" class="form-control" name="userName">
                            </div>
                             <button type="submit" name="assigner" class="btn btn-primary">Assigner</button>
                        </form>
                    </div>
                        <!--FIN DU FORMULAIRE-->
                         <!-- Afficher les membres  de la tâche -->
                    <span>
                            <?php
                            $taskId = $row[3];
                            $resultMember = getMemberTask($conn, $taskId, $sprintId, $projectId);
                            while($rowMembers = mysqli_fetch_row($resultMember)){
                                ?>
                                <ul class="list-group">
                                    <li class="list-group-item"> <?php echo $rowMembers[0]; ?>
                                </ul>
                            <?php   } ?>
                    </span>

          </th>
        </td>
    </tr>
            <?php
            $i++;
        }
        ?>
        </tbody>
    </table>
    </div>
<?php
 echo $addMessage;
echo $assignMessage;
$connexion=null;
    ?>

    </body>
    </html>