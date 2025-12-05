<?php
require_once 'config/db.php';
require_once 'functions/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$currentUser = getCurrentUser();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marvel Rivals - Choose Character</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: url('assets/backgrounds/character-bg.png') repeat;
            min-height: 100vh;
        }

        header {
            background: #2d2f48;
            padding: 12px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed; 
            top: 0;
            left: 0;
            width: 100%;
            z-index: 100;
        }

        .logo {
            width: 50px;
            height: 50px;
            background: url('assets/logo/logo-header.png') no-repeat center;
            background-size: contain;
        }

        nav {
            display: flex;
            gap: 15px;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            padding: 8px 18px;
            font-size: 14px;
            border-radius: 5px;
        }

        nav a.active {
            color: #ffd700;
        }

        nav a:hover {
            background: rgba(255, 215, 0, 0.1);
        }

        main {
            padding: 30px 20px;
        }

        h1 {
            text-align: center;
            color: #ffd700;
            font-size: 32px;
            margin-bottom: 35px;
            text-transform: uppercase;
        }

        .characters-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
            max-width: 1300px;
            margin: 0 auto;
        }

        .character-card {
            background: #4a4c6f;
            border: 3px solid #ffd700;
            border-radius: 30px;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .character-card:hover {
            transform: translateY(-8px);
        }

        .character-image {
            width: 100%;
            height: 350px;
            background: linear-gradient(135deg, #5a5c7f 0%, #7a7c9f 100%);
            position: relative;
        }

        .learn-more-btn {
            position: absolute;
            bottom: 12px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(100, 100, 120, 0.85);
            color: white;
            border: none;
            padding: 6px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 11px;
        }

        .character-info {
            padding: 12px;
            text-align: center;
        }

        .character-name {
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .skills-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
        }

        .skill-btn {
            background: rgba(200, 200, 220, 0.7);
            border: none;
            padding: 6px;
            border-radius: 15px;
            font-size: 10px;
            cursor: pointer;
            color: #2d2f48;
        }

        @media (max-width: 1200px) {
            .characters-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .characters-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            header {
                flex-direction: column;
                gap: 10px;
            }
        }

        @media (max-width: 480px) {
            .characters-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo"></div>
        
        <nav>
            <a href="levels.php">Stage Level</a>
            <a href="index.php" class="active">Choose Character</a>
            <a href="about-character.php">About Character</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <h1>Choose Your Character</h1>

        <div class="characters-grid">
            <div class="character-card" onclick="selectCharacter(1, 'Captain America')">
                <div class="character-image captain-america">
                    <button class="learn-more-btn" onclick="event.stopPropagation(); learnMore(1)">learn more</button>
                </div>
                <div class="character-info">
                    <div class="character-name">CAPTAIN AMERICA</div>
                    <div class="skills-grid">
                        <button class="skill-btn">Skill 1</button>
                        <button class="skill-btn">Skill 2</button>
                        <button class="skill-btn">Skill 3</button>
                        <button class="skill-btn">Skill 4</button>
                    </div>
                </div>
            </div>

            <div class="character-card" onclick="selectCharacter(2, 'Hawkeye')">
                <div class="character-image hawkeye">
                    <button class="learn-more-btn" onclick="event.stopPropagation(); learnMore(2)">learn more</button>
                </div>
                <div class="character-info">
                    <div class="character-name">HAWKEYE</div>
                    <div class="skills-grid">
                        <button class="skill-btn">Skill 1</button>
                        <button class="skill-btn">Skill 2</button>
                        <button class="skill-btn">Skill 3</button>
                        <button class="skill-btn">Skill 4</button>
                    </div>
                </div>
            </div>

            <div class="character-card" onclick="selectCharacter(3, 'Iron Man')">
                <div class="character-image iron-man">
                    <button class="learn-more-btn" onclick="event.stopPropagation(); learnMore(3)">learn more</button>
                </div>
                <div class="character-info">
                    <div class="character-name">IRON MAN</div>
                    <div class="skills-grid">
                        <button class="skill-btn">Skill 1</button>
                        <button class="skill-btn">Skill 2</button>
                        <button class="skill-btn">Skill 3</button>
                        <button class="skill-btn">Skill 4</button>
                    </div>
                </div>
            </div>

            <div class="character-card" onclick="selectCharacter(4, 'Hulk')">
                <div class="character-image hulk">
                    <button class="learn-more-btn" onclick="event.stopPropagation(); learnMore(4)">learn more</button>
                </div>
                <div class="character-info">
                    <div class="character-name">HULK</div>
                    <div class="skills-grid">
                        <button class="skill-btn">Skill 1</button>
                        <button class="skill-btn">Skill 2</button>
                        <button class="skill-btn">Skill 3</button>
                        <button class="skill-btn">Skill 4</button>
                    </div>
                </div>
            </div>

            <div class="character-card" onclick="selectCharacter(5, 'Spider-Man')">
                <div class="character-image spider-man">
                    <button class="learn-more-btn" onclick="event.stopPropagation(); learnMore(5)">learn more</button>
                </div>
                <div class="character-info">
                    <div class="character-name">SPIDER-MAN</div>
                    <div class="skills-grid">
                        <button class="skill-btn">Skill 1</button>
                        <button class="skill-btn">Skill 2</button>
                        <button class="skill-btn">Skill 3</button>
                        <button class="skill-btn">Skill 4</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>