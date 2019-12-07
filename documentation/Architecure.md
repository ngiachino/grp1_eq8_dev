# Architecture

- Le dossier **/src** contient le code du projet
- Le dossier **/test** contient les tests unitaires et les tests E2E

## Code du projet

Pour l'architecture du projet, nous avons choisi de séparer le code dans les dossiers **app** pour le code php et **assets** pour les fichiers CSS et Javascript (Actuellement nous n'avons pas de javascript mais il pourrait y en avoir par la suite).

Le dossier **database** contient les fichiers permettant de faire fonctionner notre base de donnée :
    - Le fichier **DBConnect.php** contient la fonction de connexion à la base de données.
    - Le fichier **init_db.sql** permet d'initialiser la base de données sql.
    - Les fichiers **logs.X.php** contiennent les identifiants de la base de données.

Le dossier **uploads** permet de stocker les documents ajouté à un projet via le site web.


### Le dossier src/app :

- Le sous-dossier **view** contient le visuel des pages du projet.
- Le sous-dossier **management** contient les fonctions permettant de gérer le projet. (Par exemple issuesManagement.php contient les fonctions de gestion des issues).