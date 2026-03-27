-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 27 mars 2026 à 14:14
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
-- Base de données : `partage_de_recettes`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`comment_id`, `recipe_id`, `user_id`, `comment`, `created_at`) VALUES
(7, 8, 4, 'deliceiux', '2026-03-23 10:50:12'),
(8, 8, 4, 'deliceiux', '2026-03-23 10:50:19');

-- --------------------------------------------------------

--
-- Structure de la table `recipes`
--

CREATE TABLE `recipes` (
  `recipe_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `recipe` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `is_enabled` tinyint(1) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `recipes`
--

INSERT INTO `recipes` (`recipe_id`, `title`, `recipe`, `author`, `is_enabled`, `image`) VALUES
(1, 'Tiramisu', 'INGRÉDIENTS (6 personnes) :\n- 250g de mascarpone\n- 3 œufs\n- 100g de sucre\n- 200ml de café fort refroidi\n- 24 biscuits à la cuillère\n- Cacao en poudre non sucré\n- 2 cuillères à soupe de Marsala (optionnel)\n\nPRÉPARATION :\n1. Séparer les blancs des jaunes d\'œufs\n2. Fouetter les jaunes avec 75g de sucre jusqu\'à blanchiment\n3. Incorporer le mascarpone délicatement\n4. Monter les blancs en neige avec le reste du sucre\n5. Mélanger délicatement les blancs à la préparation mascarpone\n6. Tremper rapidement les biscuits dans le café\n7. Alterner couches de biscuits et de crème dans un plat\n8. Réfrigérer 4h minimum\n9. Saupoudrer généreusement de cacao avant de servir', 'mickael.andrieu@exemple.com', 1, 'layered-chocolate-tiramisu-cake-with-mascarpone-cream-generated-by-ai.jpg'),
(2, 'Fondant au Chocolat', 'INGRÉDIENTS (6 personnes) :\n- 200g de chocolat noir\n- 100g de beurre\n- 100g de sucre\n- 3 œufs\n- 50g de farine\n\nPRÉPARATION :\n1. Préchauffer le four à 180°C\n2. Faire fondre le chocolat et le beurre au bain-marie\n3. Battre les œufs avec le sucre jusqu\'à blanchiment\n4. Incorporer le chocolat fondu au mélange œufs-sucre\n5. Ajouter la farine tamisée et mélanger délicatement\n6. Beurrer et fariner des ramequins individuels\n7. Verser la pâte aux 3/4 de chaque ramequin\n8. Cuire 12-15 minutes (le cœur doit rester coulant)\n9. Démouler tiède et servir avec une boule de glace vanille', 'mathieu.nebra@exemple.com', 1, 'delicious-volcano-chocolate-cake.jpg'),
(3, 'Crème Brûlée', 'INGRÉDIENTS (4 personnes) :\n- 500ml de crème liquide entière\n- 6 jaunes d\'œufs\n- 100g de sucre + cassonade pour le dessus\n- 1 gousse de vanille\n\nPRÉPARATION :\n1. Préchauffer le four à 150°C\n2. Faire chauffer la crème avec la gousse de vanille fendue\n3. Fouetter les jaunes avec le sucre\n4. Retirer la vanille, verser la crème chaude sur les jaunes\n5. Mélanger délicatement sans faire mousser\n6. Verser dans des ramequins\n7. Cuire au bain-marie 40-45 minutes (la crème doit être prise mais tremblotante)\n8. Réfrigérer 4h minimum\n9. Saupoudrer de cassonade et caraméliser au chalumeau avant de servir', 'laurene.castor@exemple.com', 1, 'delicious-creme-brulee-delight.jpg'),
(4, 'Tarte au Citron Meringuée', 'INGRÉDIENTS (8 personnes) :\n- 1 pâte sablée\n- 4 citrons (jus et zeste)\n- 4 œufs\n- 150g de sucre\n- 100g de beurre\n- 3 blancs d\'œufs\n- 150g de sucre (pour la meringue)\n\nPRÉPARATION :\n1. Cuire la pâte à blanc 15 min à 180°C\n2. Mélanger jus de citron, zestes, œufs entiers et 150g de sucre\n3. Cuire à feu doux en remuant jusqu\'à épaississement\n4. Hors du feu, ajouter le beurre en morceaux\n5. Verser la crème sur le fond de tarte refroidi\n6. Monter les blancs en neige, ajouter progressivement 150g de sucre\n7. Étaler la meringue sur la crème au citron\n8. Faire dorer 5-10 minutes à 180°C\n9. Laisser refroidir avant de déguster', 'abdelkaderfofanaa@gmail.com', 1, 'freshly-baked-yellow-cheesecake-rustic-wood-table-generated-by-ai (1).jpg'),
(5, 'Brownies', 'INGRÉDIENTS (12 pièces) :\n- 200g de chocolat noir\n- 150g de beurre\n- 200g de sucre\n- 3 œufs\n- 100g de farine\n- 1 pincée de sel\n- 100g de noix (optionnel)\n\nPRÉPARATION :\n1. Préchauffer le four à 180°C\n2. Faire fondre le chocolat et le beurre ensemble\n3. Fouetter les œufs avec le sucre\n4. Mélanger le chocolat fondu avec les œufs\n5. Ajouter la farine et le sel, mélanger\n6. Incorporer les noix concassées si désiré\n7. Verser dans un moule beurré (20x20cm)\n8. Cuire 25-30 minutes (le brownie doit rester moelleux)\n9. Laisser refroidir et découper en carrés', 'zfd@gmail.com', 1, 'indulgent-homemade-chocolate-brownie-fresh-sweet-generated-by-ai.jpg'),
(6, 'Panna Cotta', 'INGRÉDIENTS (4 personnes) :\n- 500ml de crème liquide entière\n- 50g de sucre\n- 1 gousse de vanille\n- 3 feuilles de gélatine\n- Coulis de fruits rouges pour servir\n\nPRÉPARATION :\n1. Faire tremper la gélatine dans l\'eau froide 5 minutes\n2. Faire chauffer la crème avec le sucre et la vanille fendue\n3. Retirer du feu juste avant ébullition\n4. Essorer la gélatine et l\'ajouter à la crème chaude\n5. Bien mélanger jusqu\'à dissolution complète\n6. Retirer la gousse de vanille\n7. Verser dans des verrines\n8. Réfrigérer au moins 4 heures\n9. Servir avec un coulis de fruits rouges', 'mickael.andrieu@exemple.com', 1, 'Panna-cota-aux-fruits-rouges.jpg'),
(7, 'Mousse au Chocolat', 'INGRÉDIENTS (6 personnes) :\n- 200g de chocolat noir\n- 6 œufs\n- 1 pincée de sel\n- 30g de sucre (optionnel)\n\nPRÉPARATION :\n1. Faire fondre le chocolat au bain-marie\n2. Séparer les blancs des jaunes\n3. Mélanger les jaunes au chocolat fondu tiède\n4. Monter les blancs en neige ferme avec une pincée de sel\n5. Ajouter le sucre en fin de montage si désiré\n6. Incorporer 1/3 des blancs au chocolat pour détendre\n7. Ajouter le reste des blancs en soulevant délicatement\n8. Répartir dans des verrines\n9. Réfrigérer 3h minimum avant de servir', 'mathieu.nebra@exemple.com', 1, 'delicious-chocolate-mousse-with-close-up.jpg'),
(8, 'Cheesecake', 'INGRÉDIENTS (8 personnes) :\n- 200g de biscuits digestifs\n- 80g de beurre fondu\n- 500g de Philadelphia (cream cheese)\n- 150g de sucre\n- 3 œufs\n- 200ml de crème liquide\n- 1 citron (jus et zeste)\n\nPRÉPARATION :\n1. Émietter les biscuits et mélanger avec le beurre fondu\n2. Tasser au fond d\'un moule à charnière, réfrigérer\n3. Battre le cream cheese avec le sucre\n4. Ajouter les œufs un par un\n5. Incorporer la crème, le jus et le zeste de citron\n6. Verser sur la base de biscuits\n7. Cuire 50 minutes à 160°C (le centre doit trembler légèrement)\n8. Laisser refroidir dans le four éteint porte entrouverte\n9. Réfrigérer 6h minimum avant de démouler', 'laurene.castor@exemple.com', 1, 'fresh-raspberry-cheesecake.jpg'),
(9, 'Macarons', 'INGRÉDIENTS (40 coques) :\n- 150g de poudre d\'amandes\n- 150g de sucre glace\n- 110g de blancs d\'œufs (divisés en 2x55g)\n- 150g de sucre en poudre\n- 40ml d\'eau\n- Colorant alimentaire\n\nPRÉPARATION :\n1. Mixer poudre d\'amandes et sucre glace, tamiser\n2. Mélanger 55g de blancs avec la poudre (pâte épaisse)\n3. Cuire 150g sucre + eau à 118°C (sirop)\n4. Monter 55g de blancs en neige, verser le sirop chaud\n5. Incorporer délicatement à la pâte d\'amandes (macaronage)\n6. Ajouter le colorant\n7. Dresser des ronds sur plaque avec tapis silicone\n8. Laisser croûter 30 min\n9. Cuire 12-14 min à 150°C, laisser refroidir et garnir de ganache', 'abdelkaderfofanaa@gmail.com', 1, 'delicious-macarons-table.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(64) NOT NULL DEFAULT '',
  `last_name` varchar(64) NOT NULL DEFAULT '',
  `username` varchar(64) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `username`, `email`, `password`) VALUES
(1, 'Mickaël', 'Andrieu', 'mickael.andrieu', 'mickael.andrieu@exemple.com', '$2y$10$n0yqT/X.8vn0HxFvGrK88eUhlGp/Qsm.k7NSw/PvPlrbPchPocDIO'),
(2, 'Mathieu', 'Nebra', 'mathieu.nebra', 'mathieu.nebra@exemple.com', '$2y$10$YJj.l.NGui6HMRcxtj9l7O.YRZ2hWknXG8xd0Lzo.VYefaCSHIPuW'),
(3, 'Laurène', 'Castor', 'laurene.castor', 'laurene.castor@exemple.com', '$2y$10$o2dgn635naOLMLcJwtzGU.lKKj/2vhUcIC/TDctT2NSHbTnHOIjZO'),
(4, 'abdelkader', 'fofana', 'abdelkaderfofanaa', 'abdelkaderfofanaa@gmail.com', '$2y$10$xLuWFYyscPuibrDYTsVgw.VjtG45sBlPEI2fYFU4tiW0e9m4BFxv6'),
(5, 'jkkdsf', 'sqfdqsf', 'dsfqfdsq', 'zfd@gmail.com', '$2y$10$kdb8DeaG4HIfztN/Zl65luhOSf36WWu1asYQnV2rsQL9civI0vRO6');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `recipe_id` (`recipe_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`recipe_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `recipe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
