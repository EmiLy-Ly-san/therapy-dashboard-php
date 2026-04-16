-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : mysql
-- Généré le : mar. 14 avr. 2026 à 17:01
-- Version du serveur : 8.0.45
-- Version de PHP : 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `therapy_dashboard_php`
--

-- --------------------------------------------------------

--
-- Structure de la table `notes`
--

CREATE TABLE `notes` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `is_shared` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `notes`
--

INSERT INTO `notes` (`id`, `user_id`, `title`, `content`, `is_shared`, `created_at`) VALUES
(4, 1, 'Souvenir important', 'Je repense souvent à ce moment de mon enfance, ça influence encore mes décisions.', 1, '2026-04-08 13:22:44'),
(5, 1, 'Objectif semaine', 'Essayer de prendre du temps pour moi chaque jour, même 10 minutes.', 0, '2026-04-08 13:22:44'),
(6, 1, 'Note rapide', 'Ne pas oublier de parler du sommeil au prochain rendez-vous.', 1, '2026-04-08 13:22:44'),
(7, 1, 'État émotionnel', 'Un peu fatiguée mais motivée. Beaucoup de pensées aujourd’hui.', 0, '2026-04-08 13:22:44'),
(8, 1, 'Réflexion', 'J’ai remarqué que je m’auto-sabote parfois sans m’en rendre compte.', 1, '2026-04-08 13:22:44'),
(9, 1, 'Gratitude', 'Aujourd’hui je suis reconnaissante pour les petites choses simples.', 0, '2026-04-08 13:22:44'),
(10, 1, 'test', 'pupu', 1, '2026-04-09 13:17:58'),
(11, 3, 'Première séance', 'Aujourd’hui j’ai parlé de mes émotions, c’était difficile mais libérateur.', 1, '2026-04-13 20:34:11'),
(12, 3, 'Objectif semaine', 'Essayer de prendre du temps pour moi chaque jour, même 10 minutes.', 0, '2026-04-13 20:34:11'),
(13, 3, 'Pensées du soir', 'Je me sens un peu anxieuse mais aussi fière des efforts que je fais.', 1, '2026-04-13 20:34:11'),
(14, 3, 'Gratitude', 'Je suis reconnaissante pour le soutien que je reçois en ce moment.', 0, '2026-04-13 20:34:11'),
(15, 3, 'Réflexion personnelle', 'Je remarque que je me mets beaucoup de pression inutilement.', 1, '2026-04-13 20:34:11'),
(16, 3, 'État émotionnel', 'Fatiguée mais motivée à continuer.', 0, '2026-04-13 20:34:11'),
(17, 3, 'Note rapide', 'Penser à parler du sommeil au prochain rendez-vous.', 1, '2026-04-13 20:34:11'),
(18, 6, 'Séance 1', 'Je me sens un peu stressée en ce moment, mais j’essaie de mieux identifier ce qui me déclenche.', 1, '2026-04-14 16:46:40'),
(19, 6, 'Pensées du soir', 'J’ai encore du mal à couper mes pensées avant de dormir.', 0, '2026-04-14 16:46:40'),
(20, 6, 'Petit progrès', 'J’ai réussi à prendre un moment pour moi cette semaine sans culpabiliser.', 1, '2026-04-14 16:46:40'),
(21, 7, 'Objectif semaine', 'Essayer de sortir marcher au moins deux fois cette semaine.', 1, '2026-04-14 16:46:40'),
(22, 7, 'Note privée', 'Je me sens parfois bloqué sans réussir à expliquer pourquoi.', 0, '2026-04-14 16:46:40'),
(23, 7, 'Réflexion', 'Quand je parle, je me rends compte que je suis souvent plus dur avec moi-même qu’avec les autres.', 1, '2026-04-14 16:46:40'),
(24, 8, 'État émotionnel', 'Je me sens fatiguée mais un peu plus stable que la semaine dernière.', 1, '2026-04-14 16:46:40'),
(25, 8, 'Sommeil', 'Mon sommeil reste irrégulier, surtout quand je suis stressée.', 0, '2026-04-14 16:46:40'),
(26, 8, 'Gratitude', 'Je suis reconnaissante pour le soutien de mes proches ces derniers jours.', 1, '2026-04-14 16:46:40'),
(27, 9, 'Travail', 'La pression au travail est forte et j’ai du mal à décrocher mentalement le soir.', 1, '2026-04-14 16:46:40'),
(28, 9, 'Note personnelle', 'Je n’ai pas envie que cette note soit partagée pour le moment.', 0, '2026-04-14 16:46:40'),
(29, 9, 'Prise de conscience', 'Je commence à voir que je repousse souvent mes besoins au second plan.', 1, '2026-04-14 16:46:40'),
(30, 10, 'Séance 2', 'J’ai mieux dormi cette semaine et ça a eu un vrai impact sur mon humeur.', 1, '2026-04-14 16:46:40'),
(31, 10, 'Pensées', 'Je ressens encore de l’anxiété dans certaines situations sociales.', 1, '2026-04-14 16:46:40'),
(32, 10, 'Note privée', 'Je garde cette note pour moi car elle me semble encore difficile à formuler.', 0, '2026-04-14 16:46:40');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `role` enum('patient','therapist') NOT NULL DEFAULT 'patient',
  `therapist_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `therapist_id`, `created_at`, `password`) VALUES
(1, 'Emilie', 'emilie@test.com', 'patient', NULL, '2026-04-07 14:51:12', 'testpatient'),
(2, 'Dr Martin', 'martin@test.com', 'therapist', NULL, '2026-04-13 20:05:11', '$2y$10$abcdefghijklmnopqrstuvABCDEFGHIJKLMN0123456789abcd'),
(3, 'Emilie', 'test@test.com', 'patient', 2, '2026-04-13 20:10:01', '$2y$12$fwn4TtOX8hbKwPrSkyLKku0gmmb75c7M1gjdb8K3TxXJymwDHVvcq'),
(4, 'Dr Lemoine', 'lemoine.t1@therapy.dev', 'therapist', NULL, '2026-04-14 16:10:56', '$2y$12$oMYaRn7t615yUNAUmE411uSw2Ht1cMOY4No0Jpm6K7uwnh26Sx31y'),
(5, 'Dr Caron', 'caron.t2@therapy.dev', 'therapist', NULL, '2026-04-14 16:13:24', '$2y$12$WrHLz4lfUA9SMqAn4NcVNO5XmBNeL1UCoQ0AXO85DuXQE7eZ9gaSK'),
(6, 'Alice Bernard', 'alice.p1@therapy.dev', 'patient', 4, '2026-04-14 16:14:21', '$2y$12$7PgGxRHNnpXt16jxcbTKIO4E8QDF4Re3Je9gEgiqYpSGBar6OYze.'),
(7, 'Hugo Petit', 'hugo.p2@therapy.dev', 'patient', 5, '2026-04-14 16:16:19', '$2y$12$27cz1l9UKBxyQQAYFBWw4em.OB5.//dKsgG9YwAHkSDLbx2Lzscpe'),
(8, 'Clara Dubois', 'clara.p3@therapy.dev', 'patient', 4, '2026-04-14 16:17:12', '$2y$12$1oIdDmCcCB93kuBn.SRMxOw1WXgcbWyCzuWJr1Q9i5PEU2D.v8WCy'),
(9, 'Maxime Leroy', 'maxime.p4@therapy.dev', 'patient', 5, '2026-04-14 16:18:02', '$2y$12$eatbl2K.ApB5s/XQpUuGHe0JqqN4A5Eq2ekwXRKL0dBsluUL38d0u'),
(10, 'Léa Moreau', 'lea.p5@therapy.dev', 'patient', 5, '2026-04-14 16:18:48', '$2y$12$NB9Ir0l5zLIzwrztp11SL.KlrBao4Dj7VmSdq2gtCUSUqrxZxVLhK');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_users_therapist` (`therapist_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_therapist` FOREIGN KEY (`therapist_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
