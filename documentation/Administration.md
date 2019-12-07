# Mise en place du site
## Docker
Il est nécessaire d'avoir installé **Docker** au préalable.

Vous pouvez déployer le site web en lançant la commande suivante depuis le dossier **/src** :
```
docker-compose up --build
```
Pour vérifier que le site fonctionne, il suffit d'ouvrir un navigateur et d'entrer l'URL suivant :
```
http://localhost/
```
ou
```
http://localhost:80/
```

## Mise en place personnalisée 
- La base de donnée MySql peut être installée avec le fichier **init_db.sql** contenu dans le dossier **/src/database**. Ce fichier contient la base de données du site. Celle-ci est vide, excepté un compte TestSelenium avec un projet afin de faire fonctionner les tests Selenium.

- Vous devez également modifier le fichier **/src/database/logs.php** et y renseigner les identifiants de la base de données.

- Le code du site (Contenu dans le dossier **/src**) doit être hébergé sur un serveur php.