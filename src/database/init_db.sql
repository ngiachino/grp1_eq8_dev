-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  lun. 02 déc. 2019 à 12:42
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
  `DESCRIPTION` varchar(500) NOT NULL,
  `LIEN` varchar(100) NOT NULL
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
  `ID_PROJET` int(50) NOT NULL,
  `ID_TACHE` int(11) NOT NULL
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

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`ID_MEMBRE`, `ID_PROJET`, `NOM_MEMBRE`, `ID_SPRINT`, `ID_TACHE`) VALUES
(157, 143, 'TestAccountSelenium', 0, 0);

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

--
-- Déchargement des données de la table `projet`
--

INSERT INTO `projet` (`ID_PROJET`, `NOM_PROJET`, `ID_MANAGER`, `DESCRIPTION`) VALUES
(143, 'Projet Selenium', 157, 'test');

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

--
-- Déchargement des données de la table `release`
--

INSERT INTO `release` (`ID_RELEASE`, `ID_PROJET`, `VERSION`, `DESCRIPTION`, `DATE_RELEASE`, `URL_DOCKER`) VALUES
(25, 143, '1.0', 'Release 1 - Github', '2019-12-14', 'https://github.com/ngiachino/grp1_eq8_dev/releases/tag/0.1.0');

-- --------------------------------------------------------

--
-- Structure de la table `sprint`
--

CREATE TABLE `sprint` (
  `ID_SPRINT` int(50) UNSIGNED NOT NULL COMMENT '"identifiant et numéro du sprint"',
  `ID_PROJET` int(50) UNSIGNED NOT NULL COMMENT '"identifiant du projet auquel appartient le sprint"',
  `DATE_DEBUT` date NOT NULL,
  `DATE_FIN` date NOT NULL,
  `NOM_SPRINT` varchar(20) DEFAULT NULL,
  `ETAT` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Table des sprints';

-- --------------------------------------------------------

--
-- Structure de la table `tache`
--

CREATE TABLE `tache` (
  `ID_TACHE` int(50) UNSIGNED NOT NULL COMMENT '"Identifiant de la tâche"',
  `ID_PROJET` int(50) UNSIGNED NOT NULL COMMENT '"identifiant du projet auquel appartient la tâche"',
  `ID_SPRINT` int(50) UNSIGNED NOT NULL COMMENT '"Identifiant du sprint auquel appartient la tâche"',
  `ID_USER_STORY` varchar(50) NOT NULL COMMENT '"Identifiant de la USS qui correspond à la tâche"',
  `DESCRIPTION` varchar(50) NOT NULL,
  `DUREE_TACHE` float NOT NULL COMMENT '" Durée de la tâche. Ne dépasse pas une journée"',
  `IS_DONE` varchar(20) NOT NULL COMMENT '"Indique si la tâche a été effectuée"',
  `MEMBRES` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='La table des tâches';

-- --------------------------------------------------------

--
-- Structure de la table `test`
--

CREATE TABLE `test` (
  `ID_TEST` int(50) UNSIGNED NOT NULL,
  `ID_PROJET` int(50) UNSIGNED NOT NULL,
  `DATE_DEBUT` date NOT NULL,
  `ETAT` varchar(10) NOT NULL,
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
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`ID_USER`, `NOM_USER`, `PASSWORD_USER`, `MAIL_USER`) VALUES
(158, 'TestAccountSelenium2', 'test', 'selenium2@s.s'),
(157, 'TestAccountSelenium', 'test', 'selenium@s.s');

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
  ADD PRIMARY KEY (`ID_USER_STORY`,`ID_PROJET`,`ID_TACHE`) USING BTREE;

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
-- AUTO_INCREMENT pour la table `issue`
--
ALTER TABLE `issue`
  MODIFY `ID_USER_STORY` int(50) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '"Identifiant de la user story"', AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT pour la table `projet`
--
ALTER TABLE `projet`
  MODIFY `ID_PROJET` int(50) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '"Identifiant du projet"', AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT pour la table `release`
--
ALTER TABLE `release`
  MODIFY `ID_RELEASE` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `sprint`
--
ALTER TABLE `sprint`
  MODIFY `ID_SPRINT` int(50) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '"identifiant et numéro du sprint"', AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `tache`
--
ALTER TABLE `tache`
  MODIFY `ID_TACHE` int(50) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '"Identifiant de la tâche"', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `test`
--
ALTER TABLE `test`
  MODIFY `ID_TEST` int(50) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `ID_USER` int(50) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
