-- phpMyAdmin SQL Dump
-- version 3.1.2deb1ubuntu0.2
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Jeu 07 Novembre 2019 à 13:15
-- Version du serveur: 5.0.75
-- Version de PHP: 5.2.6-3ubuntu4.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `aouldamara`
--

-- --------------------------------------------------------

--
-- Structure de la table `Documentation`
--

CREATE TABLE IF NOT EXISTS `Documentation` (
  `ID_DOCUMENTATION` int(50) unsigned NOT NULL,
  `TITRE` varchar(100) NOT NULL,
  `DESCRIPTION` varchar(500) NOT NULL,
  PRIMARY KEY  (`ID_DOCUMENTATION`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='La table des Documentations';

--
-- Contenu de la table `Documentation`
--


-- --------------------------------------------------------

--
-- Structure de la table `Issue`
--

CREATE TABLE IF NOT EXISTS `Issue` (
  `ID_USER_STORY` int(50) unsigned NOT NULL COMMENT '"Identifiant de la user story"',
  `PRIORITE` varchar(10) NOT NULL COMMENT '"Les valeurs de la priorité sont Basse, Moyenne, Haute "',
  `DIFFICULTE` varchar(10) NOT NULL COMMENT '"Les valeurs de la difficulté sont Basse, Moyenne, Haute "',
  `DESCRIPTION` varchar(500) NOT NULL,
  PRIMARY KEY  (`ID_USER_STORY`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='La table des Issues';

--
-- Contenu de la table `Issue`
--


-- --------------------------------------------------------

--
-- Structure de la table `Membre`
--

CREATE TABLE IF NOT EXISTS `Membre` (
  `ID_MEMBRE` int(50) unsigned NOT NULL,
  `ID_PROJET` int(50) unsigned NOT NULL,
  `NOM_MEMBRE` varchar(50) NOT NULL,
  `ID_SPRINT` int(50) unsigned NOT NULL,
  `ID_TACHE` int(50) unsigned NOT NULL,
  PRIMARY KEY  (`ID_MEMBRE`,`ID_PROJET`,`ID_SPRINT`,`ID_TACHE`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Membre`
--


-- --------------------------------------------------------

--
-- Structure de la table `Projet`
--

CREATE TABLE IF NOT EXISTS `Projet` (
  `ID_PROJET` int(50) unsigned NOT NULL COMMENT '"Identifiant du projet"',
  `NOM_PROJET` varchar(20) character set utf8 collate utf8_bin NOT NULL COMMENT '"Intitulé du projet"',
  `ID_MANAGER` int(50) unsigned NOT NULL COMMENT '"Identifiant du Créateur du projet"',
  `DESCRIPTION` text character set utf8 collate utf8_bin NOT NULL COMMENT '" Description du projet"',
  PRIMARY KEY  (`ID_PROJET`,`ID_MANAGER`),
  UNIQUE KEY `nom_projet` (`NOM_PROJET`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='L''entité Projet';

--
-- Contenu de la table `Projet`
--


-- --------------------------------------------------------

--
-- Structure de la table `Release`
--

CREATE TABLE IF NOT EXISTS `Release` (
  `ID_RELEASE` int(50) NOT NULL,
  `ID_PROJET` int(50) NOT NULL,
  `DESCRIPTION` varchar(500) NOT NULL,
  `DATE_RELEASE` date NOT NULL,
  `URL_DOCKER` varchar(500) NOT NULL,
  PRIMARY KEY  (`ID_RELEASE`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='La table des Releases';

--
-- Contenu de la table `Release`
--


-- --------------------------------------------------------

--
-- Structure de la table `Sprint`
--

CREATE TABLE IF NOT EXISTS `Sprint` (
  `ID_SPRINT` int(50) unsigned NOT NULL COMMENT '"identifiant et numéro du sprint"',
  `ID_PROJET` int(50) unsigned NOT NULL COMMENT '"identifiant du projet auquel appartient le sprint"',
  `DATE_DEBUT` date NOT NULL,
  `DATE_FIN` date NOT NULL,
  PRIMARY KEY  (`ID_SPRINT`,`ID_PROJET`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Table des sprints';

--
-- Contenu de la table `Sprint`
--


-- --------------------------------------------------------

--
-- Structure de la table `Tache`
--

CREATE TABLE IF NOT EXISTS `Tache` (
  `ID_TACHE` int(50) unsigned NOT NULL COMMENT '"Identifiant de la tâche"',
  `ID_PROJET` int(50) unsigned NOT NULL COMMENT '"identifiant du projet auquel appartient la tâche"',
  `ID_SPRINT` int(50) unsigned NOT NULL COMMENT '"Identifiant du sprint auquel appartient la tâche"',
  `ID_USER_STORY` int(50) unsigned NOT NULL COMMENT '"Identifiant de la USS qui correspond à la tâche"',
  `DESCRIPTION` int(50) NOT NULL,
  `DUREE_TACHE` float NOT NULL COMMENT '" Durée de la tâche. Ne dépasse pas une journée"',
  `IS_DONE` tinyint(1) NOT NULL COMMENT '"Indique si la tâche a été effectuée"',
  `IS_CLOSED` tinyint(1) NOT NULL COMMENT '"Indique si la tâche a été cloturée Dans le cas où elle n''a pas été traitée, elle sera transférée vers le nouveau sprint ou abandonnée"',
  PRIMARY KEY  (`ID_TACHE`,`ID_PROJET`,`ID_SPRINT`,`ID_USER_STORY`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='La table des tâches';

--
-- Contenu de la table `Tache`
--


-- --------------------------------------------------------

--
-- Structure de la table `Test`
--

CREATE TABLE IF NOT EXISTS `Test` (
  `ID_TEST` int(50) unsigned NOT NULL,
  `ID_PROJET` int(50) unsigned NOT NULL,
  `DATE_DEBUT` date NOT NULL,
  `ETAT` tinyint(1) NOT NULL,
  `DESCRIPTION` varchar(500) NOT NULL,
  PRIMARY KEY  (`ID_TEST`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='La table des tests';

--
-- Contenu de la table `Test`
--

