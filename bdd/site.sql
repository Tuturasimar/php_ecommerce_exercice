-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : ven. 28 jan. 2022 à 15:41
-- Version du serveur :  5.7.34
-- Version de PHP : 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `site`
--

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id_commande` int(11) NOT NULL,
  `id_membre` int(11) DEFAULT NULL,
  `montant` float NOT NULL,
  `date_enregistrement` datetime NOT NULL,
  `etat` enum('en cours de traitement','envoyé','livré') NOT NULL DEFAULT 'en cours de traitement'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_commande`, `id_membre`, `montant`, `date_enregistrement`, `etat`) VALUES
(17, 8, 104.89, '2022-01-27 21:13:57', 'en cours de traitement'),
(18, 5, 201.9, '2022-01-28 16:26:20', 'livré'),
(19, 5, 148.69, '2022-01-28 16:27:21', 'envoyé');

-- --------------------------------------------------------

--
-- Structure de la table `details_commande`
--

CREATE TABLE `details_commande` (
  `id_details_commande` int(11) NOT NULL,
  `id_commande` int(11) DEFAULT NULL,
  `id_produit` int(11) DEFAULT NULL,
  `quantite` int(3) NOT NULL,
  `prix` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `details_commande`
--

INSERT INTO `details_commande` (`id_details_commande`, `id_commande`, `id_produit`, `quantite`, `prix`) VALUES
(16, 17, 9, 4, 56.92),
(17, 17, 14, 3, 47.97),
(18, 18, 21, 1, 35.7),
(19, 18, 18, 1, 120.45),
(20, 18, 20, 1, 45.75),
(21, 19, 9, 3, 42.69),
(22, 19, 19, 1, 34.6),
(23, 19, 21, 2, 71.4);

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `id_membre` int(11) NOT NULL,
  `pseudo` varchar(30) NOT NULL,
  `mdp` varchar(70) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `civilite` enum('m','f') NOT NULL,
  `ville` varchar(50) NOT NULL,
  `code_postal` int(5) UNSIGNED ZEROFILL NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `statut` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `civilite`, `ville`, `code_postal`, `adresse`, `statut`) VALUES
(1, 'Bobby', '$2y$10$nsIkmaz5eoxOczRLjhPmfepbDLZcefVchy/ZR9GlK3m05XuyQIGrK', 'Test', 'Testest', 'test@test.com', 'm', 'Test', 73384, 'TEST de la test', 1),
(4, 'Miranda', '$2y$10$Tm8G6vBsv.2BsWhJrrdBeOMzsdAXudkHvldPTr44xwZP6X6VfFLE6', 'Lawson', 'Miranda', 'miranda@gmail.com', 'f', 'Cergy', 67564, '5 rue des Prunelles', 0),
(5, 'test', '$2y$10$7GhR0gQJBczd0wBOYRdHxu5noIMnZ4ngUuimcrUK.vkoHVMB6czvm', 'test', 'test', 'test@gmail.com', 'm', 'test es', 45454, 'test de la test', 0),
(7, 'Jean-Ernest', '$2y$10$WOp63dQHsTMJk/ARujAUFefWnYFcKhb4K6oEO8fDYB2DGBrN.ZuHS', 'Jean', 'Ernest', 'jean.ernest@gmail.com', 'm', 'Paris', 75000, '62 rue de la transcendance', 1),
(8, 'Dobby', '$2y$10$Cbkv/OOyzRlR0r7tSyMhE.DSPplm4r5/auLptuT8KjRoJ9GX6XZw6', 'Maison', 'Elfe', 'dobby@gmail.com', 'm', 'Placard sous l\'escalier', 67450, 'Placard sous l\'escalier', 0);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id_produit` int(11) NOT NULL,
  `reference` varchar(20) NOT NULL,
  `categorie` varchar(20) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `couleur` varchar(20) NOT NULL,
  `taille` varchar(5) NOT NULL,
  `public` enum('m','f','mixte') NOT NULL,
  `photo` varchar(250) NOT NULL,
  `prix` float NOT NULL,
  `stock` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `reference`, `categorie`, `titre`, `description`, `couleur`, `taille`, `public`, `photo`, `prix`, `stock`) VALUES
(9, 'Robe rouge', 'Robe', 'Robe rouge', 'Ceci est une robe, et on teste la persistance des données quand on écrit un truc                        ', 'Rouge', 's', 'm', '/Applications/MAMP/htdocs/Site/inc/img/899cd1ee72.jpg', 14.23, 5),
(10, 'Meme', 'Meme', 'Jack et le code', 'L\'image parle d\'elle même', 'Indéfini', 'm', 'mixte', '/Applications/MAMP/htdocs/Site/inc/img/bdf6119630.jpg', 15.45, 7),
(14, 'Another meme', 'Meme', 'Css meme', 'Et c\'est reparti mon kiki !', 'Indéfini', 'm', 'mixte', '/Applications/MAMP/htdocs/Site/inc/img/17c704661a.jpg', 101.5, 5),
(15, 'Veste-01', 'Veste', 'Veste brune', 'Veste brune pour le travail', 'Brune', 'm', 'f', '/Applications/MAMP/htdocs/Site/inc/img/84bc06806e.jpg', 15.65, 15),
(16, 'Manteau-01', 'Manteau', 'Manteau d\'hiver', 'Manteau pour se protéger du froid en cette période hivernale.', 'Mixte', 'l', 'mixte', '/Applications/MAMP/htdocs/Site/inc/img/959a5a11e7.jpg', 68.99, 18),
(17, 'Chemise-01', 'Chemise', 'Chemise simple', 'Chemise bordeaux, sans plus.', 'Bordeaux', 'l', 'mixte', '/Applications/MAMP/htdocs/Site/inc/img/ee2e948d31.jpg', 8.99, 25),
(18, 'Manteau-02', 'Manteau', 'Manteau rouge ', 'Ce manteau volumineux vous fera remarquer de très loin. A porter avec précaution durant les fêtes de San Fermin de Pampelune.', 'Rouge', 'm', 'f', '/Applications/MAMP/htdocs/Site/inc/img/6f2da1cbf3.jpg', 120.45, 9),
(19, 'Pull-01', 'Pull', 'Pull orange', 'C\'est un pull simple, mais doux.', 'Orange', 's', 'mixte', '/Applications/MAMP/htdocs/Site/inc/img/b6caa21ec4.jpg', 34.6, 8),
(20, 'Chemise-02', 'Chemise', 'Chemise blanche', 'C\'est une chemise qui se porte bien avec un costard.', 'Blanche', 'l', 'mixte', '/Applications/MAMP/htdocs/Site/inc/img/0837e7878e.jpg', 45.75, 24),
(21, 'Chemise-03', 'Chemise', 'Chemise à carreaux', 'Chemise légère à porter durant l\'été, couleurs chaudes.', 'Noir et Jaune', 'l', 'mixte', '/Applications/MAMP/htdocs/Site/inc/img/1241611876.jpg', 35.7, 12),
(22, 'Chemise-04', 'Chemise', 'Chemise aux manches courtes', 'Chemise légère avec perles incrustées.', 'Bleue', 's', 'f', '/Applications/MAMP/htdocs/Site/inc/img/b4f4ed765e.jpg', 88.55, 15);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `id_membre` (`id_membre`);

--
-- Index pour la table `details_commande`
--
ALTER TABLE `details_commande`
  ADD PRIMARY KEY (`id_details_commande`),
  ADD KEY `id_commande` (`id_commande`),
  ADD KEY `id_produit` (`id_produit`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id_membre`),
  ADD UNIQUE KEY `pseudo` (`pseudo`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id_produit`),
  ADD UNIQUE KEY `reference` (`reference`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `details_commande`
--
ALTER TABLE `details_commande`
  MODIFY `id_details_commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `id_membre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id_produit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`id_membre`) REFERENCES `membre` (`id_membre`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `details_commande`
--
ALTER TABLE `details_commande`
  ADD CONSTRAINT `details_commande_ibfk_1` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id_commande`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `details_commande_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id_produit`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
