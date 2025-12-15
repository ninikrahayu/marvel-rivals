-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 15, 2025 at 08:25 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `marvel_rivals_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `characters`
--

CREATE TABLE `characters` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` varchar(50) DEFAULT 'Duelist',
  `description` text,
  `base_health` int DEFAULT '1000',
  `base_energy` int DEFAULT '100',
  `card_image` varchar(255) DEFAULT NULL,
  `portrait_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `characters`
--

INSERT INTO `characters` (`id`, `name`, `role`, `description`, `base_health`, `base_energy`, `card_image`, `portrait_image`) VALUES
(1, 'Captain America', 'Vanguard', 'Enhanced by the Super-Soldier Serum, Steven Rogers uses his Vibranium shield and extensive combat training to confront any threat to justice. When Captain America rallies his troops, a wave of courage sweeps across the battlefield!', 1200, 100, 'assets/chars/cap_card.png', 'assets/chars/cap_pose.png'),
(2, 'Hawkeye', 'Duelist', 'Despite his lack of superpowers, Hawkeye\'s unparalleled skills as a marksman have earned him a spot alongside earth\'s mightiest heroes. With a cool head and steady hand, Clint Barton never misses a target… so enemies best stay out of his sights!', 900, 100, 'assets/chars/hawkeye_card.png', 'assets/chars/hawkeye_pose.png'),
(3, 'Iron Man', 'Duelist', 'Armed with superior intellect and a nanotech battlesuit of his own design, Tony Stark stands alongside gods as the Invincible Iron Man. His state of the art armor turns any battlefield into his personal playground, allowing him to steal the spotlight he so desperately desires.', 1000, 120, 'assets/chars/ironman_card.png', 'assets/chars/ironman_pose.png'),
(4, 'Hulk', 'Vanguard', 'Brilliant scientist Dr. Bruce Banner has finally found a way to coexist with his monstrous alter ego, the Hulk. By accumulating gamma energy over multiple transformations, he can become a wise and strong Hero Hulk or a fierce and destructive Monster Hulk – a true force of fury on the battlefield!', 1500, 100, 'assets/chars/hulk_card.png', 'assets/chars/hulk_pose.png'),
(5, 'Spider-Man', 'Duelist', 'Swinging around the arena on his signature weblines, your friendly neighborhood Spider-Man, AKA Peter Parker, catches his rivals by surprise with sneaky, sticky bursts of webbing and unexpected attacks from above. Look out… here comes the Spider-Man!', 950, 110, 'assets/chars/spidey_card.png', 'assets/chars/spidey_pose.png');

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `id` int NOT NULL,
  `level_name` varchar(100) NOT NULL,
  `difficulty` enum('Easy','Medium','Hard') DEFAULT 'Easy',
  `background_image` varchar(255) DEFAULT NULL,
  `card_image` varchar(255) DEFAULT NULL,
  `enemy_character_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`id`, `level_name`, `difficulty`, `background_image`, `card_image`, `enemy_character_id`) VALUES
(1, 'Level 1', 'Easy', 'assets/backgrounds/level1_bg.png', 'assets/chars/hulk_silhouette.png', 4),
(2, 'Level 2', 'Medium', 'assets/backgrounds/level2_bg.png', 'assets/chars/spiderman_silhouette.png', 5);

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int NOT NULL,
  `character_id` int DEFAULT NULL,
  `skill_name` varchar(100) NOT NULL,
  `description` text,
  `damage_value` int DEFAULT '100',
  `energy_cost` int DEFAULT '20',
  `video_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `character_id`, `skill_name`, `description`, `damage_value`, `energy_cost`, `video_url`) VALUES
(1, 1, 'Sentinel Strike', 'This is Captain America\'s primary fire. With it, you can punch enemies a couple of times.', 10, 0, 'assets/videos/cap_skill1.mp4'),
(2, 1, 'Freedom Charge', 'Shield held high, carve a path forward, granting both himself and allies along the path continuous Bonus Health and Movement Boosts', 200, 30, 'assets/videos/cap_skill2.mp4'),
(3, 1, 'Vibranium Energy', 'Hurl the energy-charged shield to strike enemies in a path.', 180, 25, 'assets/videos/cap_skill3.mp4'),
(4, 1, 'Liberty Rush', 'Raise the shield and charge forward.', 400, 80, 'assets/videos/cap_ult.mp4'),
(5, 2, 'Piercing Arrow', 'With it, you can shoot arrows that inflict damage. You can charge this ability to inflict extra damage.', 10, 0, 'assets/videos/hawk_skill1.mp4'),
(6, 2, 'Blast Arrow', 'With it, you can shoot a set of three arrows that explode upon contact and inflict damage in an area.', 220, 30, 'assets/videos/hawk_skill2.mp4'),
(7, 2, 'Crescent Slash', 'This ability lets Hawkeye perform a powerful horizontal sweep with his katana that can Launch Up enemies.', 100, 20, 'assets/videos/hawk_skill3.mp4'),
(8, 2, 'Ronin Slash', 'This ability is Hawkeye\'s main melee attack. With it, you can inflict damage by swinging the Wakizashi and deflect incoming projectiles.', 450, 90, 'assets/videos/hawk_ult.mp4'),
(9, 3, 'Repulsor Blast', 'With this ability, Iron Man shoots projectiles that inflict damage and explode in an area.', 10, 0, 'assets/videos/iron_skill1.mp4'),
(10, 3, 'Unibeam', 'With this ability, Iron Man shoots a beam of energy that inflicts constant damage upon contact.', 250, 40, 'assets/videos/iron_skill2.mp4'),
(11, 3, 'Armor Overdrive', 'Activate Armor Overdrive state, enhancing the damage of Repulsor Blast and Unibeam.', 190, 30, 'assets/videos/iron_skill3.mp4'),
(12, 3, 'Max Pulse', 'Fire a devastating pulse cannon in teh targeted direction, delivering catastrophic damage to the targeted area upon impact.', 500, 100, 'assets/videos/iron_ult.mp4'),
(13, 4, 'Heavy Blow', 'This is Hulk\'s primary fire. With it, you\'ll perform powerful punches in rapid succession.', 10, 0, 'assets/videos/hulk_skill1.mp4'),
(14, 4, 'Guard', 'Generate gamma shields for Hero Hulk and nearby allies, absorbing and converting damage into energy for HULK SMASH.', 180, 30, 'assets/videos/hulk_skill2.mp4'),
(15, 4, 'Lockdown', 'Emit gamma energy to irradiate enemies and render them immobilized and immune to all ability effects.', 0, 40, 'assets/videos/hulk_skill3.mp4'),
(16, 4, 'World Breaker', 'This ability makes Hulk perform a clap charged with gamma energy, creating a projectile that inflicts damage and can through enemies.', 600, 100, 'assets/videos/hulk_ult.mp4'),
(17, 5, 'Spider-Power', 'Swing fists forward to strike, dealing extra damage to the enemy with a Spider-Tracer.', 10, 0, 'assets/videos/spidey_skill1.mp4'),
(18, 5, 'Web-Cluster', 'Shoot a Web-Cluster that deals damage and attaches a Spider-Tracer to the hit enemy.', 0, 30, 'assets/videos/spidey_skill2.mp4'),
(19, 5, 'Get Over Here', 'Shoot webbing to reel in the hit enemy. If the enemy is tagged with a Spider-Tracer, Spider-Man will get pulled to them instead.', 210, 35, 'assets/videos/spidey_skill3.mp4'),
(20, 5, 'Amazing Combo', 'Launch an enemy upward, dealing extra damage to the enemy with a Spider-Tracer.', 480, 90, 'assets/videos/spidey_ult.mp4');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'heru', 'heru@mail.com', '$2y$10$qxPN63D3ldYuIs3e5zsxMu8/UDmyTVR6kSLpSeJ2fjnG8n.iDyZ0G', '2025-12-09 15:50:58'),
(2, 'Ninik Rahayu', 'ninik@gmail.com', '$2y$10$8xSz6HMEZux.M0.vkrSnXeypY1xOvv8WnHObCRURiOk7cqfRtRHnO', '2025-12-15 02:47:59');

-- --------------------------------------------------------

--
-- Table structure for table `user_progress`
--

CREATE TABLE `user_progress` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `active_character_id` int DEFAULT NULL,
  `unlocked_level_id` int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_progress`
--

INSERT INTO `user_progress` (`id`, `user_id`, `active_character_id`, `unlocked_level_id`) VALUES
(1, 1, NULL, 3),
(2, 2, NULL, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `characters`
--
ALTER TABLE `characters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enemy_character_id` (`enemy_character_id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `character_id` (`character_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_progress`
--
ALTER TABLE `user_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `active_character_id` (`active_character_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `characters`
--
ALTER TABLE `characters`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_progress`
--
ALTER TABLE `user_progress`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `levels`
--
ALTER TABLE `levels`
  ADD CONSTRAINT `levels_ibfk_1` FOREIGN KEY (`enemy_character_id`) REFERENCES `characters` (`id`);

--
-- Constraints for table `skills`
--
ALTER TABLE `skills`
  ADD CONSTRAINT `skills_ibfk_1` FOREIGN KEY (`character_id`) REFERENCES `characters` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_progress`
--
ALTER TABLE `user_progress`
  ADD CONSTRAINT `user_progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_progress_ibfk_2` FOREIGN KEY (`active_character_id`) REFERENCES `characters` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
