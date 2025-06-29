-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 29 juin 2025 à 23:21
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet_web`
--

-- --------------------------------------------------------

--
-- Structure de la table `profiles`
--

CREATE TABLE `profiles` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `profiles`
--

INSERT INTO `profiles` (`user_id`, `name`, `bio`, `photo`) VALUES
(4, 'Enzo Di Pietro', 'Étudiant à ESGI', 'user_3_1751230104.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `projects`
--

INSERT INTO `projects` (`id`, `user_id`, `title`, `description`, `link`, `image`, `created_at`) VALUES
(2, 4, 'Portfolio en ligne', '# Projet Portfolio - Gestion des Utilisateurs et des Compétences\r\n\r\n## Présentation du Projet\r\nCe projet est une application web développée en PHP & MySQL permettant aux utilisateurs de :\r\n- [x] Gérer leur profil (inscription, connexion, mise à jour des informations).\r\n- [x] Ajouter et modifier leurs compétences parmi celles définies par un administrateur.\r\n- [x] Ajouter et gérer leurs projets (titre, description, image et lien).\r\n- [x] Un administrateur peut gérer les compétences disponibles.', 'http://localhost:8000', 'proj_6861a71760c695.34112184.png', '2025-06-27 11:42:05');

-- --------------------------------------------------------

--
-- Structure de la table `skill_types`
--

CREATE TABLE `skill_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `difficulty` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=débutant → 5=expert'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `skill_types`
--

INSERT INTO `skill_types` (`id`, `name`, `difficulty`) VALUES
(1, 'HTML', 3),
(2, 'CSS', 3),
(3, 'JavaScript', 4),
(4, 'PHP', 4),
(5, 'MySQL', 3),
(6, 'Git', 2),
(7, 'Bootstrap', 3),
(8, 'Symfony', 4);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`, `created_at`) VALUES
(3, 'admin@example.com', '$2y$10$gNxLtPM91j/STNBafVq73O.rTRZFBSYKDimN2mdfRDAa2tG5Rb7O.', 'admin', '2025-06-27 11:35:08'),
(4, 'user@example.com', '$2y$10$o/mCGSJ5KK6S3ziTcWR34.nL4vnL71jqSxV72uMW8kZ3/bXLJdBQK', 'user', '2025-06-27 11:36:39'),
(5, 'user2@gmail.com', '$2y$10$ROdpq6egCRuVp9ydw9dAMONlYWqMAHHbd.Dn8UtBCR6E/b7d1Vcna', 'user', '2025-06-29 23:12:16'),
(6, 'user3@gmail.com', '$2y$10$oG0xLj2jK3qrppsXvIsW.OU2eHhoNbN9EjqfeNIxPkYevNAQs7RCy', 'user', '2025-06-29 23:12:36');

-- --------------------------------------------------------

--
-- Structure de la table `user_skills`
--

CREATE TABLE `user_skills` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `skill_type_id` int(11) NOT NULL,
  `level` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user_skills`
--

INSERT INTO `user_skills` (`id`, `user_id`, `skill_type_id`, `level`) VALUES
(3, 4, 1, 3);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`user_id`);

--
-- Index pour la table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `skill_types`
--
ALTER TABLE `skill_types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `user_skills`
--
ALTER TABLE `user_skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `skill_type_id` (`skill_type_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `skill_types`
--
ALTER TABLE `skill_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `user_skills`
--
ALTER TABLE `user_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `user_skills`
--
ALTER TABLE `user_skills`
  ADD CONSTRAINT `user_skills_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_skills_ibfk_2` FOREIGN KEY (`skill_type_id`) REFERENCES `skill_types` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
