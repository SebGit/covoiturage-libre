-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 30 juin 2022 à 14:53
-- Version du serveur :  8.0.29-0ubuntu0.20.04.3
-- Version de PHP : 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `covoiturette`
--

-- --------------------------------------------------------

--
-- Structure de la table `trajets`
--

CREATE TABLE `trajets` (
  `ID` int NOT NULL,
  `TYPE` varchar(256) NOT NULL,
  `STATUT` varchar(256) NOT NULL,
  `DEPART` varchar(256) NOT NULL,
  `DEPART_LAT` varchar(256) NOT NULL,
  `DEPART_LON` varchar(256) NOT NULL,
  `ARRIVEE` varchar(256) NOT NULL,
  `ARRIVEE_LAT` varchar(256) NOT NULL,
  `ARRIVEE_LON` varchar(256) NOT NULL,
  `DATE_PARCOURS` date NOT NULL,
  `HEURE` varchar(256) NOT NULL,
  `PLACES` int NOT NULL,
  `CONFORT` varchar(256) NOT NULL,
  `COMMENTAIRES` text NOT NULL,
  `PRIX` int NOT NULL,
  `ETAPE1` text NOT NULL,
  `ETAPE1_LAT` varchar(256) NOT NULL,
  `ETAPE1_LON` varchar(256) NOT NULL,
  `PRIX1` int NOT NULL,
  `ETAPE2` varchar(256) NOT NULL,
  `ETAPE2_LAT` varchar(256) NOT NULL,
  `ETAPE2_LON` varchar(256) NOT NULL,
  `PRIX2` int NOT NULL,
  `ETAPE3` varchar(256) NOT NULL,
  `ETAPE3_LAT` varchar(256) NOT NULL,
  `ETAPE3_LON` varchar(256) NOT NULL,
  `PRIX3` int NOT NULL,
  `CIVILITE` varchar(12) NOT NULL,
  `NOM` varchar(256) NOT NULL,
  `AGE` varchar(10) NOT NULL,
  `EMAIL` varchar(256) NOT NULL,
  `TELEPHONE` varchar(256) NOT NULL,
  `CODE_CREATION` varchar(256) NOT NULL,
  `CODE_MODIFICATION` varchar(256) NOT NULL,
  `CODE_SUPPRESSION` varchar(256) NOT NULL,
  `IP_CREATION` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `villes`
--

CREATE TABLE `villes` (
  `ID` int NOT NULL,
  `COMMUNE` varchar(256) NOT NULL,
  `PAYS` varchar(256) NOT NULL,
  `LATITUDE` varchar(256) NOT NULL,
  `LONGITUDE` varchar(256) NOT NULL,
  `CPOSTAL` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `villes`
--

INSERT INTO `villes` (`ID`, `COMMUNE`, `PAYS`, `LATITUDE`, `LONGITUDE`, `CPOSTAL`) VALUES
(1, 'Auberviliers', 'FR', '48.912259', '2.384049', '93100'),
(2, 'FDJ', 'FR', '48.912259', '2.384049', '93100');

-- --------------------------------------------------------

--
-- Structure de la table `villes_ws`
--

CREATE TABLE `villes_ws` (
  `ID` int NOT NULL,
  `longitude` varchar(256) NOT NULL,
  `latitude` varchar(256) NOT NULL,
  `commune` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `villes_ws`
--

INSERT INTO `villes_ws` (`ID`, `longitude`, `latitude`, `commune`) VALUES
(1, 'Aubervilliers', '48.912259', '2.384049'),
(2, 'FDJ', '48.912259', '2.384049');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `trajets`
--
ALTER TABLE `trajets`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `villes`
--
ALTER TABLE `villes`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `villes_ws`
--
ALTER TABLE `villes_ws`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `trajets`
--
ALTER TABLE `trajets`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `villes`
--
ALTER TABLE `villes`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `villes_ws`
--
ALTER TABLE `villes_ws`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
