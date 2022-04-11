-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 28 juil. 2021 à 13:12
-- Version du serveur :  10.1.36-MariaDB
-- Version de PHP :  7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `pharmacie`
--

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`pharmacie`@`%` PROCEDURE `verifier_nombre_regions_pays` (IN `pays` INT(11))  NO SQL
SELECT COUNT(region.id) as NOMBRE_REGION FROM `region` WHERE region.id_pays = pays$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `adresse`
--

CREATE TABLE `adresse` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `quartier` varchar(50) NOT NULL,
  `lieu_dit` varchar(50) NOT NULL,
  `type_a` int(11) NOT NULL,
  `id_commune` int(11) NOT NULL,
  `id_pat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `adresse`
--

INSERT INTO `adresse` (`id`, `email`, `quartier`, `lieu_dit`, `type_a`, `id_commune`, `id_pat`) VALUES
(1, 'kevin11@gmail.com', 'makepe', 'bloc m', 1, 5, 1),
(3, 'junior@gmail.com', 'oyack', 'espoir', 0, 3, 2),
(19, 'neymar@gmail.com', 'makepe', 'bloc m', 0, 5, 5);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `adresse_commune`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `adresse_commune` (
`id` int(11)
,`email` varchar(50)
,`quartier` varchar(50)
,`lieu_dit` varchar(50)
,`type_a` int(11)
,`id_commune` int(11)
,`commune` varchar(50)
,`ville` varchar(70)
,`region` varchar(70)
,`pays` varchar(25)
);

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id` int(11) NOT NULL,
  `id_pat` int(11) NOT NULL,
  `id_gest` int(11) DEFAULT NULL,
  `ref_com` varchar(20) NOT NULL,
  `date_com` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `statut` varchar(70) NOT NULL DEFAULT 'en cours',
  `ordonnance` varchar(70) DEFAULT NULL,
  `note` text,
  `livre` int(1) NOT NULL,
  `date_com_traite` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `motif` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id`, `id_pat`, `id_gest`, `ref_com`, `date_com`, `statut`, `ordonnance`, `note`, `livre`, `date_com_traite`, `motif`) VALUES
(1, 1, NULL, 'CMD0000001', '2020-07-30 15:29:27', 'validee', '', 'doliprane 500mg\r\nparacetamol 1000mg\r\nartefan 500mg', 0, '2020-07-30 15:29:27', NULL),
(26, 2, NULL, 'CMD0000012', '2020-09-02 07:23:29', 'validee', 'cle.jpg', NULL, 0, '2020-09-04 07:23:29', NULL),
(31, 5, NULL, 'CMD0000027', '2020-10-12 22:36:44', 'validee', NULL, 'doliprane 500mg\r\nparacetamol 1000mg', 0, '2020-10-12 23:00:00', NULL),
(39, 1, NULL, 'CMD0000014', '2020-10-22 18:38:51', 'rejette', NULL, 'zentel 400mg\r\nclamoxyl 500mg', 0, '2020-10-23 18:38:51', 'necessite une ordonnance'),
(40, 1, NULL, 'CMD0000005', '2020-10-20 19:32:02', 'validee', NULL, 'coartem 80/480\r\nefferalgan 500mg', 0, '2020-10-21 19:32:02', NULL),
(41, 1, NULL, 'CMD0000006', '2020-12-20 22:35:22', 'validee', 'ordonnance1.jpg', NULL, 0, '2020-10-21 19:35:22', NULL),
(42, 1, NULL, 'CMD0000007', '2020-10-01 23:00:00', 'validee', NULL, 'doliprane 1000mg', 0, '2020-10-20 20:22:26', NULL),
(43, 2, NULL, 'CMD0000018', '2020-10-20 22:51:08', 'validee', NULL, 'clamoxyl 500mg  4\r\nAmoxicil 400mg  5\r\neffaralgan  500mg 1', 0, '2020-10-22 22:51:08', NULL),
(45, 1, NULL, 'CMD0000008', '2020-10-21 11:28:13', 'en cours', NULL, 'doliprane 1000mg\nquinine  500mg\ncoartem 500mg', 1, '2020-10-21 11:28:13', NULL),
(46, 1, NULL, 'CMD0000009', '2020-10-21 12:23:57', 'rejette', NULL, 'doliprane 1000mg\nquinine  500mg\ncoartem 500mg', 0, '2020-10-21 12:23:57', NULL),
(47, 1, NULL, 'CMD0000010', '2020-10-21 15:15:11', 'validee', NULL, 'doliprane 1000mg\nquinine  500mg\ncoartem 500mg\nefferagalgan 1000mg', 0, '2020-10-21 15:15:11', NULL);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `commande_patient`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `commande_patient` (
`id` int(11)
,`ref_com` varchar(20)
,`date_com` timestamp
,`statut` varchar(70)
,`ordonnance` varchar(70)
,`motif` varchar(50)
,`note` text
,`livre` int(1)
,`date_com_traite` timestamp
,`nom_patient` varchar(50)
,`prenom_patient` varchar(50)
,`telephone` int(11)
,`email` varchar(50)
,`quartier` varchar(50)
,`lieu_dit` varchar(50)
,`type_adr` int(11)
,`commune` varchar(50)
,`ville` varchar(70)
,`region` varchar(70)
,`pays` varchar(25)
);

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `id` int(11) NOT NULL,
  `id_pat` int(11) DEFAULT NULL,
  `id_gest` int(11) DEFAULT NULL,
  `id_com` int(11) NOT NULL,
  `date_cmt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `titre` varchar(30) DEFAULT NULL,
  `contenu` text NOT NULL,
  `type` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id`, `id_pat`, `id_gest`, `id_com`, `date_cmt`, `titre`, `contenu`, `type`) VALUES
(2, 1, NULL, 1, '2020-07-30 15:56:42', NULL, 'avez vous reçu ma commande?', 0),
(36, NULL, 1, 1, '2020-08-18 07:47:20', 'indisponible', 'oui j\'ai reçu votre commande', 1),
(37, 1, NULL, 1, '2020-08-18 09:02:57', 'indisponible', 'd\'accord merci', 0),
(218, NULL, 1, 1, '2020-10-18 19:00:03', 'votre commande a bien été reçu', 'votre commande est disponible', 1),
(219, 1, NULL, 1, '2020-10-18 19:01:13', 'vous désirez une livraison?', 'ok merci je passerai pour récupérer', 1),
(220, NULL, 1, 1, '2020-10-18 19:02:11', 'd\'accord', 'd\'accord', 1),
(241, NULL, 1, 41, '2020-10-20 20:38:50', 'commande non disponible', 'commande non disponible', 1),
(242, NULL, 1, 42, '2020-10-20 21:23:26', 'commande diponible', 'commande diponible', 1),
(244, NULL, 1, 46, '2020-10-21 13:25:18', 'commande disponible', 'commande disponible', 1),
(245, NULL, 1, 47, '2020-10-21 16:16:28', 'commande disponible', 'commande disponible', 1);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `commentaire_pat_gest`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `commentaire_pat_gest` (
`id` int(11)
,`idpat` int(11)
,`idgest` int(11)
,`idcom` int(11)
,`date_cmt` datetime
,`titre` varchar(30)
,`contenu` text
,`ref_commande` varchar(20)
,`date_commande` timestamp
,`livre` int(1)
,`date_com_traite` timestamp
,`nom` varchar(50)
,`prenom` varchar(50)
,`telephone` int(11)
,`login` varchar(70)
,`type` int(11)
);

-- --------------------------------------------------------

--
-- Structure de la table `commune`
--

CREATE TABLE `commune` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `id_vil` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commune`
--

INSERT INTO `commune` (`id`, `nom`, `id_vil`) VALUES
(1, 'douala 1e', 1),
(2, 'douala 2e', 1),
(3, 'douala 3e', 1),
(4, 'douala 4e', 1),
(5, 'douala 5e', 1),
(8, 'ngaoundere 3e', 50),
(9, 'yaounde 1e', 53),
(10, 'yaounde 2e', 53),
(11, 'yaounde 3e', 53),
(12, 'yaounde 4e', 53),
(13, 'yaounde 5e', 53),
(14, 'yaounde 6e', 53),
(15, 'yaounde 7e', 53),
(17, 'douala 6e', 1);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `commune_ville`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `commune_ville` (
`idcom` int(11)
,`nomcom` varchar(50)
,`idville` int(11)
,`nomville` varchar(70)
);

-- --------------------------------------------------------

--
-- Structure de la table `gestionnaire`
--

CREATE TABLE `gestionnaire` (
  `id` int(11) NOT NULL,
  `login` varchar(70) NOT NULL,
  `password` varchar(70) NOT NULL,
  `id_pat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `gestionnaire`
--

INSERT INTO `gestionnaire` (`id`, `login`, `password`, `id_pat`) VALUES
(1, 'junior', '00000', 1),
(2, 'franck', '1111', 5),
(3, 'camero', '129268a5a67229fcb8feaee3cdae0ee2', 3);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `info_patient`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `info_patient` (
`id` int(11)
,`nom` varchar(50)
,`prenom` varchar(50)
,`telephone` int(11)
,`email` varchar(50)
,`quartier` varchar(50)
,`lieu` varchar(50)
,`type_adr` int(11)
,`commune` varchar(50)
,`ville` varchar(70)
,`region` varchar(70)
,`pays` varchar(25)
);

-- --------------------------------------------------------

--
-- Structure de la table `patient`
--

CREATE TABLE `patient` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `tel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `patient`
--

INSERT INTO `patient` (`id`, `nom`, `prenom`, `tel`) VALUES
(1, 'kevin', '', 655580168),
(2, 'jospin', 'junior', 655321235),
(3, 'junio', 'jospin', 653168536),
(5, 'junio', 'jospin', 653168836),
(6, 'fff', 'junior', 65634674);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `patient_gest`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `patient_gest` (
`id_patient` int(11)
,`nom_patient` varchar(50)
,`prenom_patient` varchar(50)
,`tel_patient` int(11)
,`id_gest` int(11)
,`login` varchar(70)
,`pass` varchar(70)
);

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

CREATE TABLE `pays` (
  `id` int(11) NOT NULL,
  `nom` varchar(25) NOT NULL,
  `indicatif` smallint(2) UNSIGNED ZEROFILL NOT NULL,
  `pattern` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `pays`
--

INSERT INTO `pays` (`id`, `nom`, `indicatif`, `pattern`) VALUES
(1, 'afghanistan', 93, ''),
(2, 'allemagne', 49, ''),
(3, 'andorre', 376, ''),
(4, 'autriche', 43, ''),
(6, 'arabie saoudite', 966, ''),
(7, 'afrique du sud', 27, ''),
(8, 'albanie', 355, ''),
(9, 'algerie', 213, ''),
(10, 'angola', 244, ''),
(16, 'aguilla', 1268, ''),
(17, 'argentine', 54, ''),
(18, 'armenie', 374, ''),
(19, 'aruba', 297, ''),
(20, 'ascension', 47, ''),
(21, 'australie', 61, ''),
(22, 'azerbaidjan', 994, ''),
(23, 'caimansiles', 1345, ''),
(24, 'cambodge', 855, ''),
(25, 'cameroun', 237, '6+[5|6|7|8|9]{1}+[0-9]{6}'),
(26, 'canada', 01, ''),
(27, 'cap-vert', 238, ''),
(30, 'chili', 56, ''),
(31, 'chine', 86, ''),
(32, 'chypre', 357, ''),
(33, 'colombie', 57, ''),
(34, 'comores', 269, ''),
(35, 'congo(brazzaville)', 242, ''),
(36, 'congo(kinshasa)', 243, ''),
(37, 'coree du nord', 850, ''),
(38, 'coree du sud', 82, ''),
(39, 'costa rica', 506, ''),
(40, 'cote d ivoire', 225, ''),
(41, 'croitie', 385, ''),
(42, 'cuba', 53, ''),
(43, 'haiti', 509, ''),
(44, 'honduras', 504, ''),
(45, 'hongkong', 852, ''),
(46, 'hongrie', 36, ''),
(47, 'inde', 91, ''),
(48, 'irak', 964, ''),
(49, 'iran', 98, ''),
(50, 'irlande', 353, ''),
(51, 'islande', 354, ''),
(52, 'italie', 39, ''),
(53, 'israel', 972, ''),
(54, 'jamaique', 1876, ''),
(55, 'japon', 81, ''),
(56, 'jordanie', 962, ''),
(57, 'laos', 856, ''),
(58, 'lesotho', 266, ''),
(59, 'lethonie', 371, ''),
(60, 'burkina-faso', 226, ''),
(61, 'burundi', 257, ''),
(62, 'danemark', 45, ''),
(63, 'djibouti', 253, ''),
(64, 'egypte', 20, ''),
(65, 'emirates arabe unis', 971, ''),
(66, 'equateur', 593, ''),
(67, 'erythee', 291, ''),
(68, 'espagne', 34, ''),
(69, 'estonie', 372, ''),
(71, 'ethiopie', 251, ''),
(72, 'iles feroe', 298, ''),
(73, 'fidji', 679, ''),
(74, 'finlande', 358, ''),
(75, 'france', 33, ''),
(76, 'gabon', 241, ''),
(77, 'gambie', 220, ''),
(78, 'georgie', 995, ''),
(79, 'ghana', 233, ''),
(80, 'grece', 30, ''),
(81, 'guinee', 224, ''),
(82, 'guinee equatorial', 240, ''),
(83, 'guinee bissau', 245, ''),
(84, 'belgique', 32, ''),
(85, 'belize', 501, ''),
(86, 'benin', 229, ''),
(87, 'bermudes', 1441, ''),
(88, 'bielorussie', 375, ''),
(89, 'birmanie', 95, ''),
(90, 'bolivie', 591, ''),
(91, 'bosnie-herzégovine', 387, ''),
(92, 'botswana', 267, ''),
(93, 'bresil', 55, ''),
(94, 'bulgarie', 359, ''),
(95, 'guyane', 592, ''),
(96, 'kazahkhstan', 07, ''),
(97, 'kenya', 254, ''),
(98, 'koweit', 965, ''),
(99, 'macao', 854, ''),
(100, 'macedoine', 389, ''),
(101, 'malaisie', 60, ''),
(102, 'maldives', 960, ''),
(103, 'malawi', 265, ''),
(104, 'mali', 223, ''),
(105, 'malte', 356, ''),
(106, 'maroc', 212, ''),
(107, 'martinique', 596, ''),
(108, 'mauritanie', 222, ''),
(109, 'mexique', 52, ''),
(110, 'moldavie', 373, ''),
(111, 'monaco', 377, ''),
(112, 'montenegro', 382, ''),
(113, 'mozambique', 258, ''),
(114, 'pakistan', 92, ''),
(115, 'palestine', 970, ''),
(116, 'panama', 507, ''),
(117, 'paraguay', 595, ''),
(118, 'pays-bas', 31, ''),
(119, 'perou', 51, ''),
(120, 'phillippines', 63, ''),
(121, 'pologne', 48, ''),
(122, 'portugal', 351, ''),
(123, 'saint-marin', 378, ''),
(124, 'saint pierre miquelon', 508, ''),
(125, 'salomon', 677, ''),
(126, 'salvador', 503, ''),
(127, 'samoa', 685, ''),
(128, 'senegal', 221, ''),
(129, 'serbie', 381, ''),
(130, 'seychelles', 248, ''),
(131, 'sierra leone', 232, ''),
(132, 'singapour', 65, ''),
(133, 'slovaquie', 421, ''),
(134, 'slovenie', 386, ''),
(135, 'soudan', 249, ''),
(136, 'suede', 46, ''),
(137, 'suisse', 41, ''),
(138, 'syrie', 963, ''),
(139, 'ukraine', 380, ''),
(140, 'uruguay', 598, ''),
(149, 'venezuela', 58, ''),
(150, 'iles vierges britaniques', 1284, ''),
(151, 'vietnam', 84, ''),
(152, 'liban', 961, ''),
(153, 'liberia', 231, ''),
(154, 'libye', 218, ''),
(155, 'liechtenstein', 423, ''),
(156, 'lituanie', 370, ''),
(157, 'luxembourg', 352, ''),
(158, 'namibie', 264, ''),
(159, 'nepal', 977, ''),
(160, 'nicaragua', 505, ''),
(161, 'niger', 227, ''),
(162, 'nigeria', 234, ''),
(170, 'nouvelle-caledonie', 687, ''),
(171, 'nouvelle-zelande', 64, ''),
(172, 'oman', 968, ''),
(173, 'ouganda', 256, ''),
(174, 'ouzbekistan', 998, ''),
(175, 'qatar', 974, ''),
(179, 'roumanie', 40, ''),
(180, 'royaume-uni', 44, ''),
(183, 'rwanda', 250, ''),
(184, 'tadjikistan', 992, ''),
(185, 'tanzanie', 255, ''),
(186, 'taiwan', 886, ''),
(187, 'tchad', 235, ''),
(188, 'R tcheque', 420, ''),
(189, 'thailande', 66, ''),
(190, 'togo', 228, ''),
(191, 'tongo', 676, ''),
(192, 'tunisie', 216, ''),
(193, 'turquie', 90, ''),
(194, 'yemen', 67, ''),
(195, 'zambie', 260, ''),
(196, 'zimbabwe', 263, ''),
(197, 'indonesie', 62, ''),
(198, 'turmekistan', 993, ''),
(201, 'ime', 783, '');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `pays_region`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `pays_region` (
`idregion` int(11)
,`nompays` varchar(25)
,`indicatif` smallint(2) unsigned zerofill
,`pattern` varchar(70)
,`nomregion` varchar(70)
,`idpays` int(11)
);

-- --------------------------------------------------------

--
-- Structure de la table `region`
--

CREATE TABLE `region` (
  `id` int(11) NOT NULL,
  `nom` varchar(70) NOT NULL,
  `id_pays` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `region`
--

INSERT INTO `region` (`id`, `nom`, `id_pays`) VALUES
(3, 'nord', 25),
(4, 'adamaoua', 25),
(5, 'est', 25),
(6, 'centre', 25),
(7, 'ouest', 25),
(8, 'littoral', 25),
(9, 'nord-ouest', 25),
(10, 'sud-ouest', 25),
(11, 'Grand Est ', 75),
(12, 'Auvergne-Rhône-Alpes', 75),
(13, 'Nouvelle-Aquitaine', 75),
(16, ' Bourgogne-Franche-Comté', 75),
(17, 'Bretagne', 75),
(18, 'Centre-Val de Loire ', 75),
(19, 'Corse', 75),
(20, 'Hauts-de-France', 75),
(21, 'Île-de-France', 75),
(22, 'Occitanie', 75),
(23, 'Normandie', 75),
(24, 'Pays de la Loire', 75),
(25, 'Provence-Alpes-Côte d\'Azur', 75),
(31, 'nord', 2),
(46, 'extreme-nord', 25),
(52, 'ouest', 9);

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

CREATE TABLE `ville` (
  `id` int(11) NOT NULL,
  `nom` varchar(70) NOT NULL,
  `id_reg` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ville`
--

INSERT INTO `ville` (`id`, `nom`, `id_reg`) VALUES
(1, 'douala', 8),
(11, 'Baré', 8),
(12, 'Bonaléa', 8),
(13, 'Dibombari', 8),
(14, 'Ebone', 8),
(15, 'Loum', 8),
(16, 'Manjo', 8),
(17, 'Mbanga', 8),
(18, 'Melong', 8),
(19, 'Mombo', 8),
(20, 'Nkongsamba', 8),
(21, 'Penja', 8),
(22, 'Ndobian', 8),
(23, 'Nkondjock', 8),
(24, 'Yabassi', 8),
(25, 'Dibamba', 8),
(26, 'Dizangué', 8),
(27, 'Édéa', 8),
(28, 'Massock', 8),
(29, 'Mouanko', 8),
(30, 'Ndom', 8),
(31, 'Ngambe', 8),
(32, 'Ngwei', 8),
(33, 'Nyanon', 8),
(34, 'Pouma', 8),
(35, 'Ngaoundal', 4),
(36, 'Tibati', 4),
(37, 'Galim-Tignère', 4),
(38, 'Kontcha', 4),
(39, 'Mayo-Baléo', 4),
(40, 'Bankim', 4),
(41, 'Banyo', 4),
(42, 'Mayo-Darlé', 4),
(43, 'Dir', 4),
(44, 'Djohong', 4),
(45, 'Meiganga', 4),
(46, 'Ngaoui', 4),
(47, 'Belel', 4),
(48, 'Mbe', 4),
(49, 'Nganha', 4),
(50, 'Ngaoundéré', 4),
(51, 'Nyambaka', 4),
(52, 'Martap', 4),
(53, 'yaounde', 6),
(54, 'eseka', 6),
(55, 'mbalmayo', 6),
(56, 'bafia', 6),
(57, 'mfoundi', 6);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `ville_commune`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `ville_commune` (
`idVille` int(11)
,`nomville` varchar(70)
,`idCommune` int(11)
,`nomCommune` varchar(50)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `ville_region`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `ville_region` (
`idville` int(11)
,`nomville` varchar(70)
,`idregion` int(11)
,`nomregion` varchar(70)
);

-- --------------------------------------------------------

--
-- Structure de la vue `adresse_commune`
--
DROP TABLE IF EXISTS `adresse_commune`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pharmacie`@`%` SQL SECURITY DEFINER VIEW `adresse_commune`  AS  select `adresse`.`id` AS `id`,`adresse`.`email` AS `email`,`adresse`.`quartier` AS `quartier`,`adresse`.`lieu_dit` AS `lieu_dit`,`adresse`.`type_a` AS `type_a`,`adresse`.`id_commune` AS `id_commune`,`commune`.`nom` AS `commune`,`ville`.`nom` AS `ville`,`region`.`nom` AS `region`,`pays`.`nom` AS `pays` from ((((`adresse` join `ville`) join `region`) join `pays`) join `commune`) where ((`commune`.`id_vil` = `ville`.`id`) and (`adresse`.`id_commune` = `commune`.`id`) and (`ville`.`id_reg` = `region`.`id`) and (`region`.`id_pays` = `pays`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure de la vue `commande_patient`
--
DROP TABLE IF EXISTS `commande_patient`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `commande_patient`  AS  select `commande`.`id` AS `id`,`commande`.`ref_com` AS `ref_com`,`commande`.`date_com` AS `date_com`,`commande`.`statut` AS `statut`,`commande`.`ordonnance` AS `ordonnance`,`commande`.`motif` AS `motif`,`commande`.`note` AS `note`,`commande`.`livre` AS `livre`,`commande`.`date_com_traite` AS `date_com_traite`,`patient`.`nom` AS `nom_patient`,`patient`.`prenom` AS `prenom_patient`,`patient`.`tel` AS `telephone`,`adresse`.`email` AS `email`,`adresse`.`quartier` AS `quartier`,`adresse`.`lieu_dit` AS `lieu_dit`,`adresse`.`type_a` AS `type_adr`,`commune`.`nom` AS `commune`,`ville`.`nom` AS `ville`,`region`.`nom` AS `region`,`pays`.`nom` AS `pays` from ((((((`commande` join `patient`) join `adresse`) join `commune`) join `ville`) join `region`) join `pays`) where ((`commande`.`id_pat` = `patient`.`id`) and (`patient`.`id` = `adresse`.`id_pat`) and (`adresse`.`id_commune` = `commune`.`id`) and (`commune`.`id_vil` = `ville`.`id`) and (`ville`.`id_reg` = `region`.`id`) and (`region`.`id_pays` = `pays`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure de la vue `commentaire_pat_gest`
--
DROP TABLE IF EXISTS `commentaire_pat_gest`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `commentaire_pat_gest`  AS  select `commentaire`.`id` AS `id`,`commentaire`.`id_pat` AS `idpat`,`commentaire`.`id_gest` AS `idgest`,`commentaire`.`id_com` AS `idcom`,`commentaire`.`date_cmt` AS `date_cmt`,`commentaire`.`titre` AS `titre`,`commentaire`.`contenu` AS `contenu`,`commande`.`ref_com` AS `ref_commande`,`commande`.`date_com` AS `date_commande`,`commande`.`livre` AS `livre`,`commande`.`date_com_traite` AS `date_com_traite`,`patient`.`nom` AS `nom`,`patient`.`prenom` AS `prenom`,`patient`.`tel` AS `telephone`,`gestionnaire`.`login` AS `login`,`commentaire`.`type` AS `type` from (((`commentaire` left join `patient` on((`commentaire`.`id_pat` = `patient`.`id`))) left join `gestionnaire` on((`commentaire`.`id_gest` = `gestionnaire`.`id`))) left join `commande` on((`commentaire`.`id_com` = `commande`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure de la vue `commune_ville`
--
DROP TABLE IF EXISTS `commune_ville`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pharmacie`@`%` SQL SECURITY DEFINER VIEW `commune_ville`  AS  select `commune`.`id` AS `idcom`,`commune`.`nom` AS `nomcom`,`commune`.`id_vil` AS `idville`,`ville`.`nom` AS `nomville` from (`commune` join `ville` on((`commune`.`id_vil` = `ville`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure de la vue `info_patient`
--
DROP TABLE IF EXISTS `info_patient`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pharmacie`@`%` SQL SECURITY DEFINER VIEW `info_patient`  AS  select `patient`.`id` AS `id`,`patient`.`nom` AS `nom`,`patient`.`prenom` AS `prenom`,`patient`.`tel` AS `telephone`,`adresse`.`email` AS `email`,`adresse`.`quartier` AS `quartier`,`adresse`.`lieu_dit` AS `lieu`,`adresse`.`type_a` AS `type_adr`,`commune`.`nom` AS `commune`,`ville`.`nom` AS `ville`,`region`.`nom` AS `region`,`pays`.`nom` AS `pays` from (((((`patient` join `adresse`) join `commune`) join `ville`) join `region`) join `pays`) where ((`patient`.`id` = `adresse`.`id_pat`) and (`adresse`.`id_commune` = `commune`.`id`) and (`commune`.`id_vil` = `ville`.`id`) and (`ville`.`id_reg` = `region`.`id`) and (`region`.`id_pays` = `pays`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure de la vue `patient_gest`
--
DROP TABLE IF EXISTS `patient_gest`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pharmacie`@`%` SQL SECURITY DEFINER VIEW `patient_gest`  AS  select `patient`.`id` AS `id_patient`,`patient`.`nom` AS `nom_patient`,`patient`.`prenom` AS `prenom_patient`,`patient`.`tel` AS `tel_patient`,`gestionnaire`.`id` AS `id_gest`,`gestionnaire`.`login` AS `login`,`gestionnaire`.`password` AS `pass` from (`gestionnaire` join `patient` on((`patient`.`id` = `gestionnaire`.`id_pat`))) ;

-- --------------------------------------------------------

--
-- Structure de la vue `pays_region`
--
DROP TABLE IF EXISTS `pays_region`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pharmacie`@`%` SQL SECURITY DEFINER VIEW `pays_region`  AS  select `region`.`id` AS `idregion`,`pays`.`nom` AS `nompays`,`pays`.`indicatif` AS `indicatif`,`pays`.`pattern` AS `pattern`,`region`.`nom` AS `nomregion`,`pays`.`id` AS `idpays` from (`pays` join `region` on((`region`.`id_pays` = `pays`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure de la vue `ville_commune`
--
DROP TABLE IF EXISTS `ville_commune`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pharmacie`@`%` SQL SECURITY DEFINER VIEW `ville_commune`  AS  select `ville`.`id` AS `idVille`,`ville`.`nom` AS `nomville`,`commune`.`id` AS `idCommune`,`commune`.`nom` AS `nomCommune` from (`commune` join `ville` on((`ville`.`id` = `commune`.`id_vil`))) ;

-- --------------------------------------------------------

--
-- Structure de la vue `ville_region`
--
DROP TABLE IF EXISTS `ville_region`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pharmacie`@`%` SQL SECURITY DEFINER VIEW `ville_region`  AS  select `ville`.`id` AS `idville`,`ville`.`nom` AS `nomville`,`region`.`id` AS `idregion`,`region`.`nom` AS `nomregion` from (`ville` join `region` on((`ville`.`id_reg` = `region`.`id`))) ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `adresse`
--
ALTER TABLE `adresse`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_vil` (`id_commune`),
  ADD KEY `id_pat` (`id_pat`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ref_com` (`ref_com`),
  ADD KEY `id_pat` (`id_pat`),
  ADD KEY `id_gest` (`id_gest`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pat` (`id_pat`),
  ADD KEY `id_com` (`id_com`),
  ADD KEY `id_gest` (`id_gest`);

--
-- Index pour la table `commune`
--
ALTER TABLE `commune`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_vil` (`id_vil`);

--
-- Index pour la table `gestionnaire`
--
ALTER TABLE `gestionnaire`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `id_pat` (`id_pat`);

--
-- Index pour la table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tel` (`tel`);

--
-- Index pour la table `pays`
--
ALTER TABLE `pays`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `indicatif` (`indicatif`);

--
-- Index pour la table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pays` (`id_pays`);

--
-- Index pour la table `ville`
--
ALTER TABLE `ville`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_reg` (`id_reg`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `adresse`
--
ALTER TABLE `adresse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;

--
-- AUTO_INCREMENT pour la table `commune`
--
ALTER TABLE `commune`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `gestionnaire`
--
ALTER TABLE `gestionnaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `patient`
--
ALTER TABLE `patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `pays`
--
ALTER TABLE `pays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT pour la table `region`
--
ALTER TABLE `region`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT pour la table `ville`
--
ALTER TABLE `ville`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `adresse`
--
ALTER TABLE `adresse`
  ADD CONSTRAINT `adresse_ibfk_1` FOREIGN KEY (`id_commune`) REFERENCES `commune` (`id`),
  ADD CONSTRAINT `adresse_ibfk_2` FOREIGN KEY (`id_pat`) REFERENCES `patient` (`id`);

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`id_pat`) REFERENCES `patient` (`id`),
  ADD CONSTRAINT `commande_ibfk_2` FOREIGN KEY (`id_gest`) REFERENCES `gestionnaire` (`id`);

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `commentaire_ibfk_1` FOREIGN KEY (`id_pat`) REFERENCES `patient` (`id`),
  ADD CONSTRAINT `commentaire_ibfk_2` FOREIGN KEY (`id_com`) REFERENCES `commande` (`id`),
  ADD CONSTRAINT `commentaire_ibfk_3` FOREIGN KEY (`id_gest`) REFERENCES `gestionnaire` (`id`);

--
-- Contraintes pour la table `commune`
--
ALTER TABLE `commune`
  ADD CONSTRAINT `commune_ibfk_1` FOREIGN KEY (`id_vil`) REFERENCES `ville` (`id`);

--
-- Contraintes pour la table `gestionnaire`
--
ALTER TABLE `gestionnaire`
  ADD CONSTRAINT `gestionnaire_ibfk_1` FOREIGN KEY (`id_pat`) REFERENCES `patient` (`id`);

--
-- Contraintes pour la table `region`
--
ALTER TABLE `region`
  ADD CONSTRAINT `region_ibfk_1` FOREIGN KEY (`id_pays`) REFERENCES `pays` (`id`);

--
-- Contraintes pour la table `ville`
--
ALTER TABLE `ville`
  ADD CONSTRAINT `ville_ibfk_1` FOREIGN KEY (`id_reg`) REFERENCES `region` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
