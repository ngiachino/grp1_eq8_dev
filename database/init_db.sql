-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 20 nov. 2019 à 15:50
-- Version du serveur :  10.4.8-MariaDB
-- Version de PHP :  7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `cdp`
--

-- --------------------------------------------------------

--
-- Structure de la table `documentation`
--

CREATE TABLE `documentation` (
  `ID_DOCUMENTATION` int(50) UNSIGNED NOT NULL,
  `TITRE` varchar(100) NOT NULL,
  `DESCRIPTION` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='La table des Documentations';

-- --------------------------------------------------------

--
-- Structure de la table `issue`
--

CREATE TABLE `issue` (
  `ID_USER_STORY` int(50) UNSIGNED NOT NULL COMMENT '"Identifiant de la user story"',
  `PRIORITE` varchar(10) NOT NULL COMMENT '"Les valeurs de la priorité sont Basse, Moyenne, Haute "',
  `DIFFICULTE` varchar(10) NOT NULL COMMENT '"Les valeurs de la difficulté sont Basse, Moyenne, Haute "',
  `DESCRIPTION` varchar(500) NOT NULL,
  `ID_PROJET` int(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='La table des Issues';

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `ID_MEMBRE` int(50) UNSIGNED NOT NULL,
  `ID_PROJET` int(50) UNSIGNED NOT NULL,
  `NOM_MEMBRE` varchar(50) NOT NULL,
  `ID_SPRINT` int(50) UNSIGNED NOT NULL,
  `ID_TACHE` int(50) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

CREATE TABLE `projet` (
  `ID_PROJET` int(50) UNSIGNED NOT NULL COMMENT '"Identifiant du projet"',
  `NOM_PROJET` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '"Intitulé du projet"',
  `ID_MANAGER` int(50) UNSIGNED NOT NULL COMMENT '"Identifiant du Créateur du projet"',
  `DESCRIPTION` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '" Description du projet"'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='L''entité Projet';

-- --------------------------------------------------------

--
-- Structure de la table `release`
--

CREATE TABLE `release` (
  `ID_RELEASE` int(50) NOT NULL,
  `ID_PROJET` int(50) NOT NULL,
  `VERSION` varchar(10) NOT NULL,
  `DESCRIPTION` varchar(500) NOT NULL,
  `DATE_RELEASE` date NOT NULL,
  `URL_DOCKER` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='La table des Releases';

-- --------------------------------------------------------

--
-- Structure de la table `sprint`
--

CREATE TABLE `sprint` (
  `ID_SPRINT` int(50) UNSIGNED NOT NULL COMMENT '"identifiant et numéro du sprint"',
  `ID_PROJET` int(50) UNSIGNED NOT NULL COMMENT '"identifiant du projet auquel appartient le sprint"',
  `DATE_DEBUT` date NOT NULL,
  `DATE_FIN` date NOT NULL,
  `NOM_SPRINT` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Table des sprints';

-- --------------------------------------------------------

--
-- Structure de la table `tache`
--

CREATE TABLE `tache` (
  `ID_TACHE` int(50) UNSIGNED NOT NULL COMMENT '"Identifiant de la tâche"',
  `ID_PROJET` int(50) UNSIGNED NOT NULL COMMENT '"identifiant du projet auquel appartient la tâche"',
  `ID_SPRINT` int(50) UNSIGNED NOT NULL COMMENT '"Identifiant du sprint auquel appartient la tâche"',
  `ID_USER_STORY` int(50) UNSIGNED NOT NULL COMMENT '"Identifiant de la USS qui correspond à la tâche"',
  `DESCRIPTION` int(50) NOT NULL,
  `DUREE_TACHE` float NOT NULL COMMENT '" Durée de la tâche. Ne dépasse pas une journée"',
  `IS_DONE` tinyint(1) NOT NULL COMMENT '"Indique si la tâche a été effectuée"',
  `IS_CLOSED` tinyint(1) NOT NULL COMMENT '"Indique si la tâche a été cloturée Dans le cas où elle n''a pas été traitée, elle sera transférée vers le nouveau sprint ou abandonnée"'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='La table des tâches';

-- --------------------------------------------------------

--
-- Structure de la table `test`
--

CREATE TABLE `test` (
  `ID_TEST` int(50) UNSIGNED NOT NULL,
  `ID_PROJET` int(50) UNSIGNED NOT NULL,
  `DATE_DEBUT` date NOT NULL,
  `ETAT` tinyint(1) NOT NULL,
  `DESCRIPTION` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='La table des tests';

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `ID_USER` int(50) UNSIGNED NOT NULL,
  `NOM_USER` varchar(20) NOT NULL,
  `PASSWORD_USER` varchar(50) NOT NULL,
  `MAIL_USER` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `documentation`
--
ALTER TABLE `documentation`
  ADD PRIMARY KEY (`ID_DOCUMENTATION`);

--
-- Index pour la table `issue`
--
ALTER TABLE `issue`
  ADD PRIMARY KEY (`ID_USER_STORY`,`ID_PROJET`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`ID_MEMBRE`,`ID_PROJET`,`ID_SPRINT`,`ID_TACHE`);

--
-- Index pour la table `projet`
--
ALTER TABLE `projet`
  ADD PRIMARY KEY (`ID_PROJET`,`ID_MANAGER`);

--
-- Index pour la table `release`
--
ALTER TABLE `release`
  ADD PRIMARY KEY (`ID_RELEASE`);

--
-- Index pour la table `sprint`
--
ALTER TABLE `sprint`
  ADD PRIMARY KEY (`ID_SPRINT`);

--
-- Index pour la table `tache`
--
ALTER TABLE `tache`
  ADD PRIMARY KEY (`ID_TACHE`,`ID_PROJET`,`ID_SPRINT`,`ID_USER_STORY`);

--
-- Index pour la table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`ID_TEST`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`ID_USER`),
  ADD UNIQUE KEY `NOM_USER` (`NOM_USER`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `projet`
--
ALTER TABLE `projet`
  MODIFY `ID_PROJET` int(50) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '"Identifiant du projet"', AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `release`
--
ALTER TABLE `release`
  MODIFY `ID_RELEASE` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `sprint`
--
ALTER TABLE `sprint`
  MODIFY `ID_SPRINT` int(50) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '"identifiant et numéro du sprint"', AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `ID_USER` int(50) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
