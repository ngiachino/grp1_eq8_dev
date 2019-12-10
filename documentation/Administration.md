
__Documentation de la release V0.3.0__

__Dernière mise à jour le 09/12/2019__

# Mise en place du site
## Docker
Il est nécessaire d'avoir installé **Docker** au préalable. Dans le cas de l'utilisation de Docker Desktop, ce dernier doit être lancé avant de poursuivre les étapes suivantes.

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
- La base de donnée MySql peut être installée avec le fichier **init_db.sql** contenu dans le dossier **/src/database**. Ce fichier contient la base de données du site. Cette base de données est vide excepté deux comptes permettant l'execution des tests Selenium.

- Vous devez également modifier le fichier **/src/database/logs.php** et y renseigner les identifiants de la base de données.

- Le code du site (Contenu dans le dossier **/src**) doit être hébergé sur un serveur php.