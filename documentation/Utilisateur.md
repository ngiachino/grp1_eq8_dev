__Documentation de la release V0.3.0__

__Dernière mise à jour le 10/12/2019__

# Documentation Utilisateur

Cette documentation présente l'application et l'ensemble de ses fonctionnalités.

## A propos de GoProject

GoProject est une plateforme dédiée à la methodologie de gestion de projets agile. Actuellement, elle peut être utilisée par une ou plusieurs équipes de développeurs afin de gérer le déroulement de leurs projets. Il est possible de mettre en place le backlog d'un projet, ses différents sprints,ses tâches ainsi que les tests et la documentation du projet.
 

## Type d'utilisateurs

Il existe 2 types d'utilisateurs :

- Visiteur ( utilisateur non authentifié ) : cet utilisateur a un accès à la page d'authentification/d'inscription afin de se connecter ou de s'inscrire.
- Membre ( utilisateur authentifié ) : cet utilisateur a accès à tous les projets qu'il crée et aux projets dans lesquels il est membre. Il aura aussi le droit de modifier/supprimer l'un de ces projets ainsi que de manipuler leurs contenu (Membres, Backlog, Sprints, Tâches, Tests, Releases, Documentations).

## Interfaces

L'application est divisée en 8 parties.

- La page d'acceuil contenant un formulaire d'authentification / d'inscription.
- La page profil de l'utilisateur contenant la liste de ses projets et de ses tâches.
- la page projet qui représente un dashbord regroupant l'ensemble des informations à propos du projet, ses membres, son backlog, ses sprints, ses tests, ses release, ses documentations et son historique de modifications.
- la page issue qui représente le backlog, elle regroupe la liste des user stories du projets ainsi que les actions permettant de les gérer
- la page sprints qui contient l'ensemble des sprints du projets, ainsi que les différentes actions permettant de les gérer.
- la page des tâches qui contient les tâches d'un sprint et les différentes actions permettant de les gérer.
- la page des tests qui contient les tests d'un projet et les différentes actions permettant de les gérer.
- la page des releases qui contient les releases d'un projet et les différentes actions permettant de les gérer.

## Fonctionnalités
### Fonctionnalités générales

Un utilisateur connecté peut créer un projet, le modifier et le supprimer.
Il est également possible d'ajouter un ou plusieurs utilisateurs au projet. Ces nouveaux membres pourront eux aussi éditer ce projet.
Sur la page d'un projet, vous pourrez avoir accès aux pages suivantes : "Issues","Sprints", "Tests" et "Documentation". Depuis ces pages vous pourrez créer et parametrer chacun de ces aspects. Il sera également possible de les modifier ou encore de les supprimer.

Un sprint est représenté par un nom mais aussi une date de début et une date de fin. Il est possible de définir une liste de tâches à suivre lors de ce sprint. Vous pourrez également assigner des membres du projet à chaque sprint ou encore lier un sprint à une issue.

### Fonctionnalités particulières

Depuis la page de profil, l'utilisateur pourra consulter la liste des tâches auxquelles il a été assigné. En cliquant sur une de ces tâches, il sera redirigé vers le sprint comprenant cette tâche.

Depuis la page principale d'un projet, chaque membre peut consulter l'historique des modifications d'un projet. Cet historique contient les dix dernières modifications apportées au projet (Par exemple, modification d'une issue, suppression d'un membre...etc).

Depuis la page Tasks, comprenant la liste des tâches d'un sprint, les membres pourront consulter la barre de progression qui représente les jours restants avant la fin d'un sprint.
A noter que si le sprint n'est pas commencé, cette barre indiquera le nombre de jour restant avant le début du sprint.
Sur cette même page il est également possible de choisir les tâches à afficher en choisissant l'êtat des tâches voulu. (Par exemple pour n'afficher que les tâches ayant pour état To Do).

Depuis la page Tests, il est possible de consulter une barre de progression indiquant le pourcentage de tests concluants sur le total de tests renseignés.

Depuis la page Documentation, il est demandé de renseigner un document provenant de l'ordinateur de la personne créant le nouveau document. Ce document peut être aux formats .pdf, .txt et .md. Les autres extensions ne sont pas acceptées.
Après avoir fournit un document, il sera possible de le consulter depuis la page documentation.