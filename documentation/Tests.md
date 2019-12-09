# Tests unitaires

### Dépendances :
Pour l'exécution des tests, vous devez avoir phpunit d'installé sur votre machine.

### Exécution :
Depuis la racine du projet, vous devez lancer la commande suivante :
```
phpunit tests/tests_unitaires/.
```
## Suivi des tests
Le suivi des tests est effectué à l'aide de Travis. Vous pouvez suivre le résultat de ces tests à l'adresse suivant :
https://travis-ci.com/ngiachino/grp1_eq8_dev 

# Tests de validation

### Dépendances :
- Vous devez avoir Python 3.5+ d'installé sur votre machine.
- Vous devez avoir pytest et Selenium d'installé. Vous pouvez lancer les scripts suivants pour les installer :
```
pip install pytest
pip install selenium
```
ChromeDriver étant inclu dans le dossier tests_E2E, il n'est pas nécessaire de le télécharger. Le script ira directement chercher celui-ci.

### Exécution :
- Si le site n'est pas hébergé en local, vous pouvez modifier l'url de la page dnas le fichier **/tests/tests_E2E/url.txt**
- Depuis le dossier **/tests/tests_E2E**, lancez la commande suivante :
```
python tests.py
```
## Suivi des tests
Le script Python créé un fichier "latest_log.txt" contenant les informations de la dernière exécution du script.
Le résultat des tests E2E est répertorié dans le tableau ci-dessous.

## Résultats des Tests
Les tests ont été réalisés en local avec Selenium et avec le script Python pour ceux ne provoquant pas d'erreur de délais.

|Description du test|Date de la dernière exécution|Résultat|
|:-----------------:|:---------------------------:|:------:|
|Connexion|09/12/2019|Réussi|
|Deconnexion|09/12/2019|Réussi|
|Ajout d'issue|09/12/2019|Réussi|
|Suppression d'issue|09/12/2019|Réussi|
|Ajout de membre|09/12/2019|Réussi|
|Suppression de membre|09/12/2019|Réussi|
|Ajout de release|09/12/2019|Réussi|
|Modification de release|09/12/2019|Réussi|
|Suppression de release|09/12/2019|Réussi|
|Redirection vers la release en cas de clique sur le lien|09/12/2019|Réussi|
|Ajout de sprint|09/12/2019|Réussi|
|Modification de sprint|09/12/2019|Réussi|
|Suppression de sprint|09/12/2019|Réussi|