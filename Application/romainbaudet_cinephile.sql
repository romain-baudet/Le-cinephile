-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : db.3wa.io
-- Généré le : dim. 16 juil. 2023 à 08:50
-- Version du serveur :  5.7.33-0ubuntu0.18.04.1-log
-- Version de PHP : 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `romainbaudet_cinephile`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `ID_admin` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`ID_admin`, `firstName`, `lastName`, `email`, `password`) VALUES
(3, 'Admin', 'Admin', 'admin@gmail.com', '$2y$10$/1SbaHjlDuOv50e358xpwe7Wk0zThtnUlcGaO80DLDwvw9o.MVtHW');

-- --------------------------------------------------------

--
-- Structure de la table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `price` int(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `price`, `date`) VALUES
(17, 63, 60, '2023-07-10 18:22:47'),
(18, 63, 60, '2023-07-13 01:25:12'),
(19, 67, 20, '2023-07-13 15:25:28'),
(20, 68, 30, '2023-07-15 11:25:49'),
(21, 63, 10, '2023-07-15 11:36:33');

-- --------------------------------------------------------

--
-- Structure de la table `bookings_details`
--

CREATE TABLE `bookings_details` (
  `booking_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `date` varchar(10) COLLATE utf8_bin NOT NULL,
  `time` varchar(10) COLLATE utf8_bin NOT NULL,
  `session_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `bookings_details`
--

INSERT INTO `bookings_details` (`booking_id`, `user_id`, `movie_id`, `title`, `date`, `time`, `session_id`, `quantity`) VALUES
(17, 63, 1, 'THE AMAZING SPIDER-MAN', '2023-07-20', '15:00:00', 2, 3),
(17, 63, 2, 'HUNGER GAMES - L\'EMBRASEMENT', '2023-07-20', '16:00:00', 5, 3),
(18, 63, 1, 'THE AMAZING SPIDER-MAN', '2023-07-20', '18:00:00', 3, 6),
(19, 67, 19, 'BABYLON', '2023-07-20', '18:30:00', 10, 2),
(20, 68, 20, 'The Dark Knight, Le Chevalier Noir', '2023-07-20', '21:30:00', 17, 1),
(20, 68, 2, 'HUNGER GAMES - L\'EMBRASEMENT', '2023-07-20', '12:00:00', 4, 2),
(21, 63, 1, 'THE AMAZING SPIDER-MAN', '2023-07-20', '11:00:00', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `date` date NOT NULL,
  `type` varchar(250) NOT NULL,
  `duration` text NOT NULL,
  `realisator` varchar(250) NOT NULL,
  `resume` text NOT NULL,
  `actors` text NOT NULL,
  `teaser` text NOT NULL,
  `poster` varchar(250) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `movies`
--

INSERT INTO `movies` (`id`, `title`, `date`, `type`, `duration`, `realisator`, `resume`, `actors`, `teaser`, `poster`, `status`) VALUES
(1, 'THE AMAZING SPIDER-MAN', '2012-04-07', 'Action, Fantastique, Aventure', '1h47', 'James Vanderbilt, Alvin Sargent', 'Abandonné par ses parents lorsqu’il était enfant, Peter Parker a été élevé par son oncle Ben et sa tante May. Il est aujourd’hui au lycée, mais il a du mal à s’intégrer. Comme la plupart des adolescents de son âge, Peter essaie de comprendre qui il est et d’accepter son parcours. Amoureux pour la première fois, lui et Gwen Stacy découvrent les sentiments, l’engagement et les secrets. En retrouvant une mystérieuse mallette ayant appartenu à son père, Peter entame une quête pour élucider la disparition de ses parents, ce qui le conduit rapidement à Oscorp et au laboratoire du docteur Curt Connors, l’ancien associé de son père. Spider-Man va bientôt se retrouver face au Lézard, l’alter ego de Connors. En décidant d’utiliser ses pouvoirs, il va choisir son destin…', 'Andrew Garfield, Emma Stone, Rhys Ifans', '<iframe src=\"https://www.youtube.com/embed/5DIzJOKh_kY\" title=\"YouTube video player\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>', 'spiderman.jpg', 1),
(2, 'HUNGER GAMES - L\'EMBRASEMENT', '2011-11-27', 'Action, Drame, Science fiction', '2h26min', 'Francis Lawrence', 'Katniss Everdeen est rentrée chez elle saine et sauve après avoir remporté la 74e édition des Hunger Games avec son partenaire Peeta Mellark.Puisqu’ils ont gagné, ils sont obligés de laisser une fois de plus leur famille et leurs amis pour partir faire la Tournée de la victoire dans tous les districts. Au fil de son voyage, Katniss sent que la révolte gronde, mais le Capitole exerce toujours un contrôle absolu sur les districts tandis que le Président Snow prépare la 75e édition des Hunger Games, les Jeux de l’Expiation – une compétition qui pourrait changer Panem à jamais…', 'Jennifer Lawrence, Josh Hutcherson, Liam Hemsworth', '<iframe src=\"https://www.youtube.com/embed/nbzjLhsmVXc\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>', 'hunger_games.jpg', 1),
(17, 'Bienvenu chez les Ch\'tis', '2008-02-20', 'Comédie', '1h46', 'Dany Boon', 'Philippe Abrams est directeur de la poste de Salon-de-Provence. Il est marié à Julie, dont le caractère dépressif lui rend la vie impossible. Pour lui faire plaisir, Philippe fraude afin d\'obtenir une mutation sur la Côte d\'Azur. Mais il est démasqué: il sera muté à Bergues, petite ville du Nord.\r\nPour les Abrams, sudistes pleins de préjugés, le Nord c\'est l\'horreur, une région glacée, peuplée d\'êtres rustres, éructant un langage incompréhensible, le \"cheutimi\". Philippe ira seul. A sa grande surprise, il découvre un endroit charmant, une équipe chaleureuse, des gens accueillants, et se fait un ami : Antoine, le facteur et le carillonneur du village, à la mère possessive et aux amours contrariées. Quand Philippe revient à Salon, Julie refuse de croire qu\'il se plait dans le Nord. Elle pense même qu\'il lui ment pour la ménager. Pour la satisfaire et se simplifier la vie, Philippe lui fait croire qu\'en effet, il vit un enfer à Bergues. Dès lors, sa vie s\'enfonce dans un mensonge confortable...', 'Kad Merad, Dany Boon, Zoé Félix', '<iframe src=\"https://www.youtube.com/embed/OycTfchnopU\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>', 'chtis.jpg', 2),
(18, 'INCEPTION', '2010-07-21', 'Science fiction, Thriller', '2h28', 'Christopher Nolan', 'Dom Cobb est un voleur expérimenté – le meilleur qui soit dans l’art périlleux de l’extraction : sa spécialité consiste à s’approprier les secrets les plus précieux d’un individu, enfouis au plus profond de son subconscient, pendant qu’il rêve et que son esprit est particulièrement vulnérable. Très recherché pour ses talents dans l’univers trouble de l’espionnage industriel, Cobb est aussi devenu un fugitif traqué dans le monde entier qui a perdu tout ce qui lui est cher. Mais une ultime mission pourrait lui permettre de retrouver sa vie d’avant – à condition qu’il puisse accomplir l’impossible : l’inception. Au lieu de subtiliser un rêve, Cobb et son équipe doivent faire l’inverse : implanter une idée dans l’esprit d’un individu. S’ils y parviennent, il pourrait s’agir du crime parfait. Et pourtant, aussi méthodiques et doués soient-ils, rien n’aurait pu préparer Cobb et ses partenaires à un ennemi redoutable qui semble avoir systématiquement un coup d’avance sur eux. Un ennemi dont seul Cobb aurait pu soupçonner l’existence.', 'Leonardo DiCaprio, Marion Cotillard, Elliot Page', '<iframe src=\"https://www.youtube.com/embed/CPTIgILtna8\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>', 'inception.jpg', 1),
(19, 'BABYLON', '2023-01-18', 'Historique, Drame', '3h09', 'Damien Chazelle', 'Los Angeles des années 1920. Récit d’une ambition démesurée et d’excès les plus fous, BABYLON retrace l’ascension et la chute de différents personnages lors de la création d’Hollywood, une ère de décadence et de dépravation sans limites.', 'Brad Pitt, Margot Robbie, Diego Calva', '<iframe src=\"https://www.youtube.com/embed/50P1-oPvZOg\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>', 'babylon.webp', 1),
(20, 'The Dark Knight, Le Chevalier Noir', '2006-08-13', 'ActionAction, Thriller', '2h32', 'Christopher Nolan', 'Dans ce nouveau volet, Batman augmente les mises dans sa guerre contre le crime. Avec l\'appui du lieutenant de police Jim Gordon et du procureur de Gotham, Harvey Dent, Batman vise à éradiquer le crime organisé qui pullule dans la ville. Leur association est très efficace mais elle sera bientôt bouleversée par le chaos déclenché par un criminel extraordinaire que les citoyens de Gotham connaissent sous le nom de Joker.', 'Christian Bale, Philippe Valmont, Heath Ledger', '<iframe  src=\"https://www.youtube.com/embed/wrcaivEjWCo\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>', 'thedarknight.jpg', 1),
(21, 'QU\'EST-CE QU\'ON A FAIT AU BON DIEU?', '2014-04-16', 'Comédie', '1h37', 'Philippe de Chauveron', 'Claude et Marie Verneuil, issus de la grande bourgeoisie catholique provinciale sont des parents plutôt ', 'Christian Clavier, Chantal Lauby, Ary Abittan', '<iframe  src=\"https://www.youtube.com/embed/QerOPic11Tk\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>', 'bondieu', 2),
(22, 'VERY BAD TRIP', '2009-04-24', 'Comédie', '1h30', 'Todd Phillips', 'Au réveil d\'un enterrement de vie de garçon bien arrosé, les trois amis du fiancé se rendent compte qu\'il a disparu 40 heures avant la cérémonie de mariage. Ils vont alors devoir faire fi de leur gueule de bois et rassembler leurs bribes de souvenirs pour comprendre ce qui s\'est passé.', 'Bradley Cooper, Ed Helms, Zach Galifianakis', '<iframe  src=\"https://www.youtube.com/embed/hHqR9Tq16_E\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>', 'vbt.jpg', 2),
(23, 'AVATAR : LA VOIE DE L\'EAU', '2022-12-14', 'Science fiction, Aventure,', '3h12', 'James Cameron', 'Se déroulant plus d’une décennie après les événements relatés dans le premier film, AVATAR : LA VOIE DE L’EAU raconte l\'histoire des membres de la famille Sully (Jake, Neytiri et leurs enfants), les épreuves auxquelles ils sont confrontés, les chemins qu’ils doivent emprunter pour se protéger les uns les autres, les batailles qu’ils doivent mener pour rester en vie et les tragédies qu\'ils endurent.', 'Sam Worthington, Zoe Saldana, Sigourney Weaver', '<iframe  src=\"https://www.youtube.com/embed/2UEkizpGKDU\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>', 'avatar2.jpeg', 2),
(24, 'BUDAPEST', '2018-06-27', 'Comédie', '1h37', 'Xavier Gens', 'Vincent et Arnaud, deux amis qui s’ennuient dans leur travail, décident de tout plaquer pour créer « Crazy Trips » : une agence qui organise des enterrements de vie de garçon à Budapest. Sur place, ils sont guidés par Georgio, un expatrié français qui leur dévoile tous les secrets de la ville… Les activités insolites proposées par Crazy Trips (balade en tank, soirée déjantée, stripteaseuses, stand de tir…) attirent rapidement la clientèle. Mais la situation dégénère et les deux amis perdent vite le contrôle…', 'Manu Payet, Jonathan Cohen, Alice Belaïdi', '<iframe  src=\"https://www.youtube.com/embed/F8aWLD-Mk2g\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>', 'budapest.jpg', 2);

-- --------------------------------------------------------

--
-- Structure de la table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `seats` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `rooms`
--

INSERT INTO `rooms` (`room_id`, `name`, `seats`) VALUES
(1, 'Room 1', 100),
(2, 'Room 2', 90),
(3, 'Room 3', 80),
(4, 'Room 4', 50),
(5, 'Room 5', 60);

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `session_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`session_id`, `movie_id`, `room_id`, `date`, `time`, `price`) VALUES
(1, 1, 1, '2023-07-20', '11:00:00', 10),
(2, 1, 1, '2023-07-20', '15:00:00', 10),
(3, 1, 1, '2023-07-20', '18:00:00', 10),
(4, 2, 2, '2023-07-20', '12:00:00', 10),
(5, 2, 2, '2023-07-20', '16:00:00', 10),
(7, 19, 3, '2023-08-20', '15:00:00', 10),
(9, 2, 2, '2023-07-20', '21:00:00', 10),
(10, 19, 3, '2023-07-20', '18:30:00', 10),
(11, 19, 3, '2023-07-20', '22:00:00', 10),
(12, 18, 4, '2023-07-20', '11:30:00', 10),
(13, 18, 4, '2023-07-20', '16:00:00', 10),
(14, 18, 4, '2023-07-20', '21:00:00', 10),
(15, 20, 5, '2023-07-20', '12:00:00', 10),
(16, 20, 5, '2023-07-20', '15:30:00', 10),
(17, 20, 5, '2023-07-20', '21:30:00', 10),
(18, 20, 5, '2023-07-20', '22:30:00', 10);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `surname` varchar(250) NOT NULL,
  `birthdate` date NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `birthdate`, `email`, `password`) VALUES
(63, 'Romain', 'Baudet', '2000-01-01', 'user@gmail.com', '$2y$10$/1SbaHjlDuOv50e358xpwe7Wk0zThtnUlcGaO80DLDwvw9o.MVtHW'),
(67, 'Juliette', 'Gerbaud', '1995-12-15', 'user2@gmail.com', '$2y$10$ItCufAXSKFKujy0Gd9EgSu8wZ7Qb9Q6Qp/UqTswLHdPUXX5uZbqdW'),
(68, 'Juliette', 'Gerbaud', '1993-11-16', 'juliette.gerbaud1993@gmail.com', '$2y$10$O92lGN9H3ygtKfm1LZa2WeJYP2PvRHnxfAWFOG1f8w1RG0iaItVmu');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID_admin`);

--
-- Index pour la table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `bookings_details`
--
ALTER TABLE `bookings_details`
  ADD KEY `fk_delete_booking` (`booking_id`),
  ADD KEY `fk_delete_movieiD` (`movie_id`),
  ADD KEY `fk_delete_sessionID` (`session_id`),
  ADD KEY `fk_delete_userID` (`user_id`);

--
-- Index pour la table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `sessions_ibfk_1` (`movie_id`),
  ADD KEY `sessions_ibfk_2` (`room_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `ID_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `bookings_details`
--
ALTER TABLE `bookings_details`
  ADD CONSTRAINT `fk_delete_booking` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_delete_movieiD` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_delete_sessionID` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`session_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_delete_userID` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sessions_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
