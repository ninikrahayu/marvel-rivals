CREATE DATABASE IF NOT EXISTS marvel_rivals_db;
USE marvel_rivals_db;

CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS characters (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    role VARCHAR(50) DEFAULT 'Duelist',
    description TEXT,
    base_health INT DEFAULT 1000,
    base_energy INT DEFAULT 100,
    card_image VARCHAR(255),
    portrait_image VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS skills (
    id INT PRIMARY KEY AUTO_INCREMENT,
    character_id INT,
    skill_name VARCHAR(100) NOT NULL,
    description TEXT,
    damage_value INT DEFAULT 100,
    energy_cost INT DEFAULT 20,
    video_url VARCHAR(255),
    FOREIGN KEY (character_id) REFERENCES characters(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS levels (
    id INT PRIMARY KEY AUTO_INCREMENT,
    level_name VARCHAR(100) NOT NULL,
    difficulty ENUM('Easy', 'Medium', 'Hard') DEFAULT 'Easy',
    background_image VARCHAR(255),
    card_image VARCHAR(255), -- Kolom baru untuk gambar siluet di index.php
    enemy_character_id INT,
    FOREIGN KEY (enemy_character_id) REFERENCES characters(id)
);

CREATE TABLE IF NOT EXISTS user_progress (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    active_character_id INT,
    unlocked_level_id INT DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (active_character_id) REFERENCES characters(id)
);

-- INSERT DATA
INSERT INTO characters (id, name, role, base_health, base_energy, card_image, portrait_image) VALUES
(1, 'Captain America', 'Vanguard', 1200, 100, 'assets/chars/cap_card.png', 'assets/chars/cap_pose.png'),
(2, 'Hawkeye', 'Duelist', 900, 100, 'assets/chars/hawkeye_card.png', 'assets/chars/hawkeye_pose.png'),
(3, 'Iron Man', 'Duelist', 1000, 120, 'assets/chars/ironman_card.png', 'assets/chars/ironman_pose.png'),
(4, 'Hulk', 'Vanguard', 1500, 100, 'assets/chars/hulk_card.png', 'assets/chars/hulk_pose.png'),
(5, 'Spider-Man', 'Duelist', 950, 110, 'assets/chars/spidey_card.png', 'assets/chars/spidey_pose.png');

INSERT INTO skills (character_id, skill_name, damage_value, energy_cost, video_url) VALUES
(1, 'Shield Throw', 150, 20, 'assets/videos/cap_skill1.mp4'),
(1, 'Liberty Rush', 200, 30, 'assets/videos/cap_skill2.mp4'),
(1, 'Vibranium Bash', 180, 25, 'assets/videos/cap_skill3.mp4'),
(1, 'Avengers Assemble', 400, 80, 'assets/videos/cap_ult.mp4'),
(2, 'Piercing Shot', 180, 15, 'assets/videos/hawk_skill1.mp4'),
(2, 'Blast Arrow', 220, 30, 'assets/videos/hawk_skill2.mp4'),
(2, 'Grappling Hook', 100, 20, 'assets/videos/hawk_skill3.mp4'),
(2, 'Hunter\'s Sight', 450, 90, 'assets/videos/hawk_ult.mp4'),
(3, 'Repulsor Blast', 160, 20, 'assets/videos/iron_skill1.mp4'),
(3, 'Unibeam', 250, 40, 'assets/videos/iron_skill2.mp4'),
(3, 'Micro Missiles', 190, 30, 'assets/videos/iron_skill3.mp4'),
(3, 'Invincible Pulse', 500, 100, 'assets/videos/iron_ult.mp4'),
(4, 'Heavy Smash', 200, 20, 'assets/videos/hulk_skill1.mp4'),
(4, 'Gamma Wave', 180, 30, 'assets/videos/hulk_skill2.mp4'),
(4, 'Indestructible', 0, 40, 'assets/videos/hulk_skill3.mp4'),
(4, 'World Breaker', 600, 100, 'assets/videos/hulk_ult.mp4'),
(5, 'Web Shooter', 140, 15, 'assets/videos/spidey_skill1.mp4'),
(5, 'Spider-Sense', 0, 30, 'assets/videos/spidey_skill2.mp4'),
(5, 'Web Swing Kick', 210, 35, 'assets/videos/spidey_skill3.mp4'),
(5, 'Spectacular Spin', 480, 90, 'assets/videos/spidey_ult.mp4');

-- INSERT LEVEL (Update path gambar sesuai kebutuhan)
INSERT INTO levels (level_name, difficulty, background_image, card_image, enemy_character_id) VALUES
('Level 1', 'Easy', 'assets/backgrounds/level1_bg.png', 'assets/chars/hulk_silhouette.png', 4),
('Level 2', 'Medium', 'assets/backgrounds/level2_bg.png', 'assets/chars/spiderman_silhouette.png', 5);