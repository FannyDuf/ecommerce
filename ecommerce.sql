-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 06 août 2018 à 08:32
-- Version du serveur :  5.7.21
-- Version de PHP :  5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `ecommerce`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Chat'),
(2, 'Chien'),
(13, 'Autre');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL,
  `category` text NOT NULL,
  `weight` int(11) NOT NULL,
  `shipping` int(11) NOT NULL,
  `tva` int(11) NOT NULL,
  `final_price` float NOT NULL,
  `stock` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `title`, `description`, `price`, `category`, `weight`, `shipping`, `tva`, `final_price`, `stock`) VALUES
(31, 'Inauguration', 'jjj', 88, '0', 0, 0, 20, 0, 0),
(35, 'BON', 'CA COMMENCE A ME GAVER', 5555555, 'Chien', 0, 0, 20, 0, 9),
(36, 'houra', 'PINAISE', 444, 'Chat', 0, 0, 20, 0, 0),
(38, 'Croquettes', 'Controle poils.', 56, 'Chat', 0, 0, 20, 0, 0),
(39, 'Croquettes', 'Controle poils.', 62, 'Chien', 0, 0, 20, 0, 0),
(40, 'FANE', 'sdjlskfjqlksdjqskfsojkslkvjsdlkvjsdlkvjsdlkfvjsdlkfjsdlkfjsdklfjslkfjsdlkfjsdlkfj jfkljnsdlkfvnjsldkfvjnlkxdjflksnflks,n  Ã¹mlk,dfv,ndvj,mkl', 77, 'Autre', 0, 0, 20, 0, 0),
(41, 'AG 5 B', 'qqqqqqqqqqqqqqqqqqqqqqq', 9999, 'Chien', 900012, 180, 20, 11196.9, 0),
(42, 'AG 5 B', 'SSSSSSS', 555, 'Autre', 900012, 180, 20, 882, 10),
(43, 'AG 1', 'ggggggggg', 66, 'Chien', 900012, 180, 20, 295.2, 3),
(44, 'ESSAI', 'ESSAIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIII', 90, 'Chien', 900012, 180, 20, 324, 99),
(45, 'TEST', 'DESCRIPTION', 89, 'AUTRE', 57, 14, 19, 99, 5),
(46, 'TEST', 'DESCRIPTION', 89, 'AUTRE', 57, 14, 19, 99, 5),
(47, 'dddddddddddddd', 'ddddddddddd', 3, 'Chien', 900012, 180, 20, 219.6, 9);

-- --------------------------------------------------------

--
-- Structure de la table `weights`
--

DROP TABLE IF EXISTS `weights`;
CREATE TABLE IF NOT EXISTS `weights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `weights`
--

INSERT INTO `weights` (`id`, `name`, `price`) VALUES
(1, '900012345678910', 0),
(2, '900012345678910', 99),
(3, '900012', 180);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
