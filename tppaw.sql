-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 02 fév. 2025 à 12:11
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tppaw`
--

-- --------------------------------------------------------

--
-- Structure de la table `formulaire`
--

CREATE TABLE `formulaire` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `lieu_naissance` varchar(255) NOT NULL,
  `fil` varchar(20) DEFAULT NULL,
  `adresse` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `nat` varchar(255) DEFAULT NULL,
  `cod` varchar(5) DEFAULT NULL,
  `cod_post` varchar(10) NOT NULL,
  `situ` varchar(20) DEFAULT NULL,
  `systeme` varchar(255) DEFAULT NULL,
  `applications` text DEFAULT NULL,
  `sexe` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `formulaire`
--

INSERT INTO `formulaire` (`id`, `nom`, `prenom`, `email`, `date_naissance`, `lieu_naissance`, `fil`, `adresse`, `ville`, `nat`, `cod`, `cod_post`, `situ`, `systeme`, `applications`, `sexe`) VALUES
(2, 'taibi', 'zahreddine', 'ananini@gmail.com', '2003-07-26', 'fi darhoum', '3ISIL', '3 frere', '', 'Algerie', 'DZ', '22000', 'celibataire', 'Windows, Android', 'fifa23', 'male'),
(3, 'Hiya', 'aya', 'anamimi@gmail.com', '2003-07-03', 'fl\' manzil', '3ISIL', '3 soeurs', '', 'Algerie', 'DZ', '31000', 'celibataire', 'Unix, Android', 'fortnite', 'female'),
(4, 'moun', 'promes', 'anamoumou@gmail.com', '2007-07-23', 'fl\' manzil', '3ISIL', 'texas,90', '', 'frence', 'FR', '20000', 'celibataire', 'Unix', 'fortnite', 'male'),
(5, 'hidayet', 'chinois', 'chichai@gmail.com', '2009-08-07', 'fl\' manzil', '3ISIL', 'dddddddd', '', 'Algerie', 'DZ', '12000', 'marie', 'Unix, Windows', 'youtube', 'female'),
(6, 'mouh', 'chiwawa', 'taibizahreddine@gmail.com', '1998-07-09', 'fl\' manzil', '3ISIL', '7da jarhoum', '', 'Algerie', 'DZ', '23000', 'divorce', 'Android', 'youtube', 'male');

-- --------------------------------------------------------

--
-- Structure de la table `informations`
--

CREATE TABLE `informations` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `lieu_naissance` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `gra` varchar(255) NOT NULL,
  `spec` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `cod_post` varchar(10) NOT NULL,
  `nat` varchar(255) DEFAULT NULL,
  `cod` varchar(5) DEFAULT NULL,
  `systeme` varchar(255) DEFAULT NULL,
  `situ` varchar(255) DEFAULT NULL,
  `applications` text DEFAULT NULL,
  `sexe` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `informations`
--

INSERT INTO `informations` (`id`, `nom`, `prenom`, `date_naissance`, `lieu_naissance`, `email`, `gra`, `spec`, `adresse`, `cod_post`, `nat`, `cod`, `systeme`, `situ`, `applications`, `sexe`) VALUES
(1, 'si', 'ALI', '1972-07-07', 'fi darhoum', 'taibizahreddine@gmail.com', 'PROF', 'info', 'la maccta', '22000', 'Algerien', 'DZ', 'Unix, Windows', 'marie', 'mysql', 'male'),
(2, 'si', 'fater', '1972-07-07', 'fi darhoum', 'sifater@gmail.com', 'PROF', 'info', 'la duabi', '22000', 'Algerien', 'DZ', 'Unix, Windows', 'marie', 'facebook', 'male'),
(3, 'Mme', 'nabila', '1972-07-19', 'fi darhoum', 'Mmenabila@gmail.com', 'PROF', 'math', 'le village', '22000', 'Algerien', 'DZ', 'Unix, Windows, Android', 'marie', 'spyder', 'female'),
(4, 'Mme', 'zwawya', '1990-07-19', 'fi darhoum', 'Mmezwawya@gmail.com', 'PROF', 'info', 'la maison', '22000', 'Algerien', 'DZ', 'Unix, Windows', 'marie', 'sgbd', 'female'),
(5, 'Mme', 'sara', '1990-04-01', 'fi sbitar', 'Mmesara@gmail.com', 'PROF', 'info', 'fi dar', '22000', 'Algerien', 'DZ', 'Unix', 'marie', 'mysql', 'female');

-- --------------------------------------------------------

--
-- Structure de la table `modules`
--

CREATE TABLE `modules` (
  `id` int(11) NOT NULL,
  `code_module` varchar(255) NOT NULL,
  `Nom_module` varchar(255) NOT NULL,
  `coefficient` decimal(10,2) NOT NULL,
  `volume_horaire` int(11) NOT NULL,
  `fil` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `modules`
--

INSERT INTO `modules` (`id`, `code_module`, `Nom_module`, `coefficient`, `volume_horaire`, `fil`) VALUES
(1, '001', 'IHM', '2.00', 12, '3ISIL'),
(2, '002', 'ASI', '2.00', 12, '3ISIL'),
(3, '003', 'SAD', '2.00', 12, '3ISIL'),
(4, '004', 'PAW', '2.00', 12, '3ISIL'),
(5, '005', 'SID', '4.00', 20, '3ISIL'),
(6, '006', 'GL', '4.00', 20, '3ISIL');

-- --------------------------------------------------------

--
-- Structure de la table `notes`
--

CREATE TABLE `notes` (
  `Num_Etudiant` int(11) DEFAULT NULL,
  `Nom_module` varchar(255) DEFAULT NULL,
  `code_module` varchar(255) DEFAULT NULL,
  `coefficient` decimal(5,2) DEFAULT NULL,
  `Note` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `notes`
--

INSERT INTO `notes` (`Num_Etudiant`, `Nom_module`, `code_module`, `coefficient`, `Note`) VALUES
(2, 'IHM', '001', '2.00', '16.00'),
(2, 'ASI', '002', '2.00', '16.00'),
(2, 'SAD', '003', '2.00', '13.00'),
(2, 'PAW', '004', '2.00', '17.00'),
(2, 'SID', '005', '4.00', '7.00'),
(2, 'GL', '006', '4.00', '20.00'),
(3, 'IHM', '001', '2.00', '10.00'),
(3, 'ASI', '002', '2.00', '13.00'),
(3, 'SAD', '003', '2.00', '9.00'),
(3, 'PAW', '004', '2.00', '11.00'),
(3, 'SID', '005', '4.00', '11.00'),
(3, 'GL', '006', '4.00', '8.00'),
(4, 'IHM', '001', '2.00', '16.00'),
(4, 'ASI', '002', '2.00', '20.00'),
(4, 'SAD', '003', '2.00', '15.00'),
(4, 'PAW', '004', '2.00', '15.00'),
(4, 'SID', '005', '4.00', '11.00'),
(4, 'GL', '006', '4.00', '10.00'),
(5, 'IHM', '001', '2.00', '11.00'),
(5, 'ASI', '002', '2.00', '15.00'),
(5, 'SAD', '003', '2.00', '15.00'),
(5, 'PAW', '004', '2.00', '10.00'),
(5, 'SID', '005', '4.00', '10.00'),
(5, 'GL', '006', '4.00', '10.00'),
(6, 'IHM', '001', '2.00', '2.00'),
(6, 'ASI', '002', '2.00', '8.00'),
(6, 'SAD', '003', '2.00', '4.00'),
(6, 'PAW', '004', '2.00', '10.00'),
(6, 'SID', '005', '4.00', '9.00'),
(6, 'GL', '006', '4.00', '12.00');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `types` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `email`, `mdp`, `types`) VALUES
(1, 'kylianzahro@gmail.com', 'Taibi2003', 'Admin'),
(2, 'ananini@gmail.com', 'ananini', 'User'),
(3, 'anamimi@gmail.com', 'anamimi', 'User'),
(4, 'anamoumou@gmail.com', 'anamoumou', 'User'),
(5, 'chichai@gmail.com', 'chichai', 'User'),
(6, 'taibizahreddine@gmail.com', 'chiwawa', 'User');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `formulaire`
--
ALTER TABLE `formulaire`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `informations`
--
ALTER TABLE `informations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `formulaire`
--
ALTER TABLE `formulaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `informations`
--
ALTER TABLE `informations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
