-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Lun 04 Septembre 2017 à 10:01
-- Version du serveur :  10.1.25-MariaDB-1~xenial
-- Version de PHP :  7.1.9-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `ONLGSP`
--
CREATE DATABASE IF NOT EXISTS `ONLGSP` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ONLGSP`;

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `idAdmin` int(11) NOT NULL,
  `email` varchar(190) NOT NULL,
  `password` varchar(255) NOT NULL,
  `clePublic` text NOT NULL,
  `Ip` varchar(15) NOT NULL,
  `session` varchar(250) DEFAULT NULL,
  `finSession` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actif` char(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONS POUR LA TABLE `admin`:
--

--
-- Contenu de la table `admin`
--

INSERT INTO `admin` (`idAdmin`, `email`, `password`, `clePublic`, `Ip`, `session`, `finSession`, `actif`) VALUES
(1, 'contacts@cbsecurite.com', '556972429c265aab19b92b814d2ffe9b2b4dc7e99176aae6e211ad425a37ec15', '', '78.228.17.76', 'f137b82b02368c9213c8c39c1a404cb45df2098329cbc9891f392f7496e36d85', '2017-09-04 10:17:47', '1'),
(2, 'kiki-mixtomatoz@hotmail.fr', '2fdf2b1a395936873dc960917da16b91294e06185b8826dc11b0ee924b817bea', '', '81.66.220.216', '09a56677ce5b847cc23b110c0ea4b722b2546778039ddc0e5017996662a9586f', '2017-09-03 17:52:56', '1'),
(3, 'pro.sylvain.galoustoff@gmail.com', '035170b5cc86ee0520405f290d2013843791d174f963d265b418fca16936129f', '', '80.215.14.10', NULL, '2017-09-03 14:28:04', '1');

-- --------------------------------------------------------

--
-- Structure de la table `adminDetails`
--

CREATE TABLE `adminDetails` (
  `idAdminDetails` int(11) NOT NULL,
  `idAdmin` int(11) NOT NULL,
  `raisonSociale` varchar(250) DEFAULT NULL,
  `tvaIntra` varchar(20) DEFAULT NULL,
  `ape` varchar(10) DEFAULT NULL,
  `siret` varchar(20) DEFAULT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `adresse` text,
  `cp` varchar(5) DEFAULT NULL,
  `ville` varchar(100) DEFAULT NULL,
  `pays` varchar(100) DEFAULT NULL,
  `telephone` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONS POUR LA TABLE `adminDetails`:
--   `idAdmin`
--       `admin` -> `idAdmin`
--

--
-- Contenu de la table `adminDetails`
--

INSERT INTO `adminDetails` (`idAdminDetails`, `idAdmin`, `raisonSociale`, `tvaIntra`, `ape`, `siret`, `nom`, `prenom`, `adresse`, `cp`, `ville`, `pays`, `telephone`) VALUES
(1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `jeux`
--

CREATE TABLE `jeux` (
  `idJeux` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `fichierSh` varchar(100) NOT NULL,
  `taille` decimal(5,0) NOT NULL,
  `actif` char(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONS POUR LA TABLE `jeux`:
--

--
-- Contenu de la table `jeux`
--

INSERT INTO `jeux` (`idJeux`, `titre`, `image`, `fichierSh`, `taille`, `actif`) VALUES
(1, 'Ark : Combat Evolved', 'Ark', 'arkserver', '5675', '1'),
(2, '7 Days to Die', '7_days_to_die', 'sdtdserver', '3290', '1'),
(3, 'ARMA 3', 'Arma3', 'arma3server', '4916', '1'),
(4, 'Ballistic Overkill', 'Ballistic', 'boserver', '139', '1'),
(5, 'Battlefield 1942', 'Battlefield', 'bf1942server', '156', '1'),
(6, 'Black Mesa : Deathmatch', 'BlackMesa', 'bmdmserver', '12699', '1'),
(7, 'Blade Symphony', 'BladeSymphony', 'bsserver', '0', '0'),
(8, 'BrainBread 2', 'BrainBread2', 'bb2server', '1440', '1'),
(9, 'Call of Duty', 'Cod', 'codserver', '1181', '1'),
(10, 'Call of Duty 2', 'Cod2', 'cod2server', '3521', '1'),
(11, 'Call of Duty 4', 'Cod4', 'cod4server', '3765', '1'),
(12, 'CodeName CURE', 'CodeName', 'ccserver', '1875', '1'),
(13, 'Call of Duty - United Offensive', 'CodunitedOffensive', 'coduoserver', '2108', '1'),
(14, 'Call of Duty 5 - World at War', 'CodWorldatWar', 'codwawserver', '8239', '1'),
(15, 'Counter Strick Condition Z��ro', 'CounterStrickCondition0', 'csczserver', '66', '1'),
(16, 'Counter Strike 1.6', 'counter-strike-1-6', 'csserver', '0', '0'),
(17, 'Counter Strike Global Offensive', 'counter-strike-global-offensive', 'csgoserver', '15147', '1'),
(18, 'Counter Strike : Source', 'counter-strike-source', 'cssserver', '2180', '1'),
(19, 'Day of Defeat', 'day-of-defeat', 'dodserver', '66', '1'),
(20, 'Day of Defeat : Source', 'day-of-defeat-source', 'dodsserver', '1693', '1'),
(21, 'Day of Infamy', 'day-of-infamy', 'doiserver', '10753', '1'),
(22, 'Deathmatch Classic', 'deathmatch-classic', 'dmcserver', '66', '1'),
(23, 'Don\'t Starve Together', 'dont-starve-together', 'dstserver', '794', '1'),
(24, 'Double Action : Boogaloo', 'double-action-boogaloo', 'dabserver', '2105', '1'),
(25, 'Empires Mod', 'empires-logo', 'emserver', '4205', '1'),
(26, 'Factorio', 'factorio', 'fctrserver', '130', '1'),
(27, 'Fistful of Frags', 'fistful-of-frags', 'fofserver', '2521', '1'),
(28, 'Garry\'s Mod', 'garrys-mod', 'gmodserver', '3741', '1'),
(29, 'Goldeneye : Source', 'goldeneye-source', 'gesserver', '2814', '1'),
(30, 'Half Life 2 : Deathmatch', 'half-life-2-deathmatch', 'hl2dmserver', '685', '1'),
(31, 'Half Life : Deathmatch', 'half-life-deathmatch', 'hldmserver', '750', '1'),
(32, 'Half Life Deathmatch : Source', 'half-life-deathmatch-source', 'hldmsserver', '959', '1'),
(33, 'Hurtworld', 'hurtworld', 'hwserver', '993', '1'),
(34, 'Insurgency', 'insurgency', 'insserver', '8871', '1'),
(35, 'Just Cause 2', 'just-cause-2', 'jc2server', '29', '1'),
(36, 'Killing Floor', 'killing-floor', 'kfserver', '2270', '1'),
(37, 'Left 4 Dead', 'left-4-dead', 'l4dserver', '7402', '1'),
(38, 'Left 4 Dead 2', 'left-4-dead-2', 'l4d2server', '7773', '1'),
(39, 'Minecraft', 'minecraft', 'mcserver', '29', '1'),
(40, 'Multi Theft Auto', 'multi-theft-auto', 'mtaserver', '91', '1'),
(41, 'Natural Selection 2', 'natural-selection-2', 'ns2server', '0', '0'),
(42, 'Natural Selection 2 : Combat', 'natural-selection-2-combat', 'ns2cserver', '0', '0'),
(43, 'No More Room in Hell', 'no-more-room-in-hell', 'nmrihserver', '6457', '1'),
(44, 'Opposing Force', 'opposing-force', 'opforserver', '66', '1'),
(45, 'Pirates, Vikings & Knights II', 'pirates-vikings-knights', 'pvkiiserver', '2187', '1'),
(46, 'Project Cars', 'project-cars', 'pcserver', '24', '1'),
(47, 'Project Zomboid', 'project-zomboid', 'pzserver', '1002', '1'),
(48, 'Quake 2', 'quake-2', 'q2server', '199', '1'),
(49, 'Mumble', 'mumble', 'mumbleserver', '34', '1'),
(50, 'Quake 3 : Arena', 'quake-3-arena', 'q3server', '826', '1'),
(51, 'Quake Live', 'quake-live', 'qlserver', '963', '1'),
(52, 'Quake World', 'quake-world', 'qwserver', '257', '1'),
(53, 'Red Orchestra : Ostfront 41-45', 'red-orchestra', 'roserver', '1146', '1'),
(54, 'Ricochet', 'ricochet', 'ricochetserver', '66', '1'),
(55, 'Rust', 'rust-header', 'rustserver', '5796', '1'),
(56, 'Serious Sam 3 : BFE', 'serious-sam-3', 'ss3server', '44', '1'),
(57, 'Starbound', 'starbound', 'sbserver', '0', '0'),
(58, 'Sven Co-op', 'sven-co-op', 'svenserver', '1874', '1'),
(59, 'Team Fortress 2', 'team-fortress-2', 'tf2server', '6685', '1'),
(60, 'Team Fortress Classic', 'team-fortress-classic', 'tfcserver', '66', '1'),
(61, 'Teamspeak 3', 'teamspeak-3', 'ts3server', '13', '1'),
(62, 'Teeworlds', 'teeworlds', 'twserver', '0', '1'),
(63, 'Terraria', 'terraria', 'terrariaserver', '0', '1'),
(64, 'Tower Unite', 'tower-unite', 'tuserver', '571', '1'),
(65, 'Unreal Tournament 3', 'unreal-tournament-3', 'ut3server', '0', '0'),
(66, 'Unreal Tournament 99', 'unreal-tournament-99', 'ut99server', '285', '1'),
(67, 'Unreal Tournament 2004', 'unreal-tournament-2004', 'ut2k4server', '5754', '1'),
(68, 'Wolfenstien : Enemy Territory', 'wolfenstien-enemy-territory', 'wetserver', '270', '1');

-- --------------------------------------------------------

--
-- Structure de la table `menus`
--

CREATE TABLE `menus` (
  `idMenus` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `icone` varchar(255) NOT NULL,
  `role` int(1) NOT NULL DEFAULT '0',
  `actif` int(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONS POUR LA TABLE `menus`:
--

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `idUsers` int(11) NOT NULL,
  `pseudo` varchar(100) NOT NULL,
  `email` varchar(190) NOT NULL,
  `password` varchar(100) NOT NULL,
  `Ip` varchar(15) NOT NULL,
  `session` varchar(250) NOT NULL,
  `finSession` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actif` char(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONS POUR LA TABLE `users`:
--

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`idUsers`, `pseudo`, `email`, `password`, `Ip`, `session`, `finSession`, `actif`) VALUES
(1, 'mrtechno01', 'contacts@cbsecurite.com', '', '', '', '2017-09-04 01:52:21', '1'),
(2, 'test', 'test@test.fr', '', '', '', '2017-09-04 02:12:25', '0');

-- --------------------------------------------------------

--
-- Structure de la table `usersDetails`
--

CREATE TABLE `usersDetails` (
  `idUsersDetails` int(11) NOT NULL,
  `idUsers` int(11) NOT NULL,
  `raisonSociale` varchar(250) DEFAULT NULL,
  `tvaIntra` varchar(20) DEFAULT NULL,
  `ape` varchar(10) DEFAULT NULL,
  `siret` varchar(20) DEFAULT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `adresse` text,
  `cp` varchar(5) DEFAULT NULL,
  `ville` varchar(100) DEFAULT NULL,
  `pays` varchar(100) DEFAULT NULL,
  `telephone` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONS POUR LA TABLE `usersDetails`:
--   `idUsers`
--       `users` -> `idUsers`
--

--
-- Contenu de la table `usersDetails`
--

INSERT INTO `usersDetails` (`idUsersDetails`, `idUsers`, `raisonSociale`, `tvaIntra`, `ape`, `siret`, `nom`, `prenom`, `adresse`, `cp`, `ville`, `pays`, `telephone`) VALUES
(1, 1, NULL, NULL, NULL, NULL, 'PONCET', 'GÃ©rald', '34 Rue de la RÃ©publique', '69430', 'BEAUJEU', 'FRANCE', NULL),
(2, 2, NULL, NULL, NULL, NULL, 'BLABLA', 'Jean', '650 rue du blabla', '69000', 'BLABLA SUR RHONE', 'FRANCE', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `usersJeux`
--

CREATE TABLE `usersJeux` (
  `idUsersJeux` int(11) NOT NULL,
  `idUsers` int(11) NOT NULL,
  `idJeux` int(11) NOT NULL,
  `dateDebut` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateFin` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `actif` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONS POUR LA TABLE `usersJeux`:
--   `idJeux`
--       `jeux` -> `idJeux`
--   `idUsers`
--       `users` -> `idUsers`
--

-- --------------------------------------------------------

--
-- Structure de la table `usersMembres`
--

CREATE TABLE `usersMembres` (
  `idUsersMembres` int(11) NOT NULL,
  `idUsers` int(11) NOT NULL,
  `pseudoMembres` varchar(100) NOT NULL,
  `emailMembres` varchar(255) NOT NULL,
  `passwordMembres` varchar(100) NOT NULL,
  `nomMembres` varchar(100) NOT NULL,
  `prenomMembres` varchar(100) NOT NULL,
  `paysMembres` varchar(100) NOT NULL,
  `actifMembres` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONS POUR LA TABLE `usersMembres`:
--   `idUsers`
--       `users` -> `idUsers`
--

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `view_users`
--
CREATE TABLE `view_users` (
`idUsers` int(11)
,`pseudoUsers` varchar(100)
,`emailUsers` varchar(190)
,`passwordUsers` varchar(100)
,`sessionUsers` varchar(250)
,`ipUsers` varchar(15)
,`finSessionUsers` timestamp
,`actifUsers` char(1)
,`raisonSocialeUsers` varchar(250)
,`tvaIntraUsers` varchar(20)
,`apeUsers` varchar(10)
,`siretUsers` varchar(20)
,`nomUsers` varchar(100)
,`prenomUsers` varchar(100)
,`adresseUsers` text
,`cpUsers` varchar(5)
,`villeUsers` varchar(100)
,`paysUsers` varchar(100)
,`telephoneUsers` varchar(10)
);

-- --------------------------------------------------------

--
-- Structure de la vue `view_users` exportée comme un table
--
DROP TABLE IF EXISTS `view_users`;
CREATE TABLE`view_users`(
    `idUsers` int(11) NOT NULL DEFAULT '0',
    `pseudoUsers` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
    `emailUsers` varchar(190) COLLATE utf8mb4_general_ci NOT NULL,
    `passwordUsers` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
    `sessionUsers` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
    `ipUsers` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
    `finSessionUsers` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
    `actifUsers` char(1) COLLATE utf8mb4_general_ci DEFAULT '0',
    `raisonSocialeUsers` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
    `tvaIntraUsers` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
    `apeUsers` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
    `siretUsers` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
    `nomUsers` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
    `prenomUsers` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
    `adresseUsers` text COLLATE utf8mb4_general_ci DEFAULT NULL,
    `cpUsers` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
    `villeUsers` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
    `paysUsers` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
    `telephoneUsers` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL
);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`idAdmin`);

--
-- Index pour la table `adminDetails`
--
ALTER TABLE `adminDetails`
  ADD PRIMARY KEY (`idAdminDetails`),
  ADD KEY `idAdmin` (`idAdmin`);

--
-- Index pour la table `jeux`
--
ALTER TABLE `jeux`
  ADD PRIMARY KEY (`idJeux`);

--
-- Index pour la table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`idMenus`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUsers`);

--
-- Index pour la table `usersDetails`
--
ALTER TABLE `usersDetails`
  ADD PRIMARY KEY (`idUsersDetails`),
  ADD KEY `idUsers` (`idUsers`);

--
-- Index pour la table `usersJeux`
--
ALTER TABLE `usersJeux`
  ADD PRIMARY KEY (`idUsersJeux`),
  ADD KEY `idUsers` (`idUsers`),
  ADD KEY `idJeux` (`idJeux`);

--
-- Index pour la table `usersMembres`
--
ALTER TABLE `usersMembres`
  ADD PRIMARY KEY (`idUsersMembres`),
  ADD KEY `idUsers` (`idUsers`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `idAdmin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `adminDetails`
--
ALTER TABLE `adminDetails`
  MODIFY `idAdminDetails` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `idUsers` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `usersDetails`
--
ALTER TABLE `usersDetails`
  MODIFY `idUsersDetails` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `usersJeux`
--
ALTER TABLE `usersJeux`
  MODIFY `idUsersJeux` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `usersMembres`
--
ALTER TABLE `usersMembres`
  MODIFY `idUsersMembres` int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `adminDetails`
--
ALTER TABLE `adminDetails`
  ADD CONSTRAINT `adminDetails_ibfk_1` FOREIGN KEY (`idAdmin`) REFERENCES `admin` (`idAdmin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `usersDetails`
--
ALTER TABLE `usersDetails`
  ADD CONSTRAINT `usersDetails_ibfk_1` FOREIGN KEY (`idUsers`) REFERENCES `users` (`idUsers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `usersJeux`
--
ALTER TABLE `usersJeux`
  ADD CONSTRAINT `usersJeux_ibfk_2` FOREIGN KEY (`idJeux`) REFERENCES `jeux` (`idJeux`),
  ADD CONSTRAINT `usersJeux_ibfk_3` FOREIGN KEY (`idUsers`) REFERENCES `users` (`idUsers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `usersMembres`
--
ALTER TABLE `usersMembres`
  ADD CONSTRAINT `usersMembres_ibfk_1` FOREIGN KEY (`idUsers`) REFERENCES `users` (`idUsers`) ON DELETE CASCADE ON UPDATE CASCADE;


--
-- Métadonnées
--
USE `phpmyadmin`;

--
-- Métadonnées pour admin
--
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__column_info')
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__table_uiprefs')
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__tracking')

--
-- Métadonnées pour adminDetails
--
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__column_info')
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__table_uiprefs')
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__tracking')

--
-- Métadonnées pour jeux
--
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__column_info')
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__table_uiprefs')
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__tracking')

--
-- Métadonnées pour menus
--
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__column_info')
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__table_uiprefs')
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__tracking')

--
-- Métadonnées pour users
--
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__column_info')
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__table_uiprefs')
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__tracking')

--
-- Métadonnées pour usersDetails
--
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__column_info')
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__table_uiprefs')
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__tracking')

--
-- Métadonnées pour usersJeux
--
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__column_info')
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__table_uiprefs')
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__tracking')

--
-- Métadonnées pour usersMembres
--
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__column_info')
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__table_uiprefs')
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__tracking')

--
-- Métadonnées pour view_users
--
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__column_info')
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__table_uiprefs')
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__tracking')

--
-- Métadonnées pour ONLGSP
--
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__bookmark')
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__relation')
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__savedsearches')
-- Erreur de lecture des données :  (#1142 - SELECT command denied to user 'ONLGSP'@'localhost' for table 'pma__central_columns')
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
