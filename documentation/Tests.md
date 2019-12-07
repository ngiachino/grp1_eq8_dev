# Tests unitaires

### Dépendances :
Pour l'exécution des tests, vous devez avoir phpunit d'installé sur votre machine.

### Exécution :
Depuis la racine du projet, vous devez lancer la commande suivante :
```
phpunit tests/tests_unitaires/.
```

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


