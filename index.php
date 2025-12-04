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
    <title>Marvel Rivals</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #fff;
            min-height: 100vh;
        }

        header {
            background: #4a4458;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            color: #000;
            font-size: 24px;
            font-weight: bold;
        }

        nav {
            display: flex;
            gap: 15px;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            padding: 8px 20px;
            border-radius: 5px;
            transition: all 0.3s;
        }

        nav a:hover {
            background: #f4d03f;
            color: #000;
        }

        nav a.active {
            background: #f4d03f;
            color: #000;
        }

        main {
            padding: 30px;
        }

        h1 {
            text-align: center;
            color: #f4d03f;
            font-size: 32px;
            margin-bottom: 40px;
        }

        .characters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .character-card {
            background: #6b6679;
            border: 3px solid #f4d03f;
            border-radius: 20px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .character-card:hover {
            transform: scale(1.05);
        }

        .character-image {
            background: #8b8499;
            height: 300px;
            border-radius: 15px;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            margin-bottom: 15px;
            position: relative;
        }

        .learn-more-btn {
            background: #c0c0c0;
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .learn-more-btn:hover {
            background: #a0a0a0;
        }

        .character-name {
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .skills-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .skill-btn {
            background: #c0c0c0;
            border: none;
            padding: 8px;
            border-radius: 20px;
            font-size: 12px;
            cursor: pointer;
        }

        .skill-btn:hover {
            background: #a0a0a0;
        }

        @media (max-width: 768px) {
            .characters-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            header {
                flex-direction: column;
                gap: 15px;
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
        <div class="logo">MARVEL RIVALS</div>
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
            <div class="character-card" onclick="selectCharacter(1, 'Iron Man')">
                <div class="character-image">
                    <button class="learn-more-btn" onclick="event.stopPropagation(); learnMore(1, 'Iron Man')">learn more</button>
                </div>
                <div class="character-name">IRON MAN</div>
                <div class="skills-grid">
                    <button class="skill-btn">Skill 1</button>
                    <button class="skill-btn">Skill 2</button>
                    <button class="skill-btn">Skill 3</button>
                    <button class="skill-btn">Skill 4</button>
                </div>
            </div>

            <div class="character-card" onclick="selectCharacter(2, 'Spider-Man')">
                <div class="character-image">
                    <button class="learn-more-btn" onclick="event.stopPropagation(); learnMore(2, 'Spider-Man')">learn more</button>
                </div>
                <div class="character-name">SPIDER-MAN</div>
                <div class="skills-grid">
                    <button class="skill-btn">Skill 1</button>
                    <button class="skill-btn">Skill 2</button>
                    <button class="skill-btn">Skill 3</button>
                    <button class="skill-btn">Skill 4</button>
                </div>
            </div>

            <div class="character-card" onclick="selectCharacter(3, 'Thor')">
                <div class="character-image">
                    <button class="learn-more-btn" onclick="event.stopPropagation(); learnMore(3, 'Thor')">learn more</button>
                </div>
                <div class="character-name">THOR</div>
                <div class="skills-grid">
                    <button class="skill-btn">Skill 1</button>
                    <button class="skill-btn">Skill 2</button>
                    <button class="skill-btn">Skill 3</button>
                    <button class="skill-btn">Skill 4</button>
                </div>
            </div>

            <div class="character-card" onclick="selectCharacter(4, 'Hulk')">
                <div class="character-image">
                    <button class="learn-more-btn" onclick="event.stopPropagation(); learnMore(4, 'Hulk')">learn more</button>
                </div>
                <div class="character-name">HULK</div>
                <div class="skills-grid">
                    <button class="skill-btn">Skill 1</button>
                    <button class="skill-btn">Skill 2</button>
                    <button class="skill-btn">Skill 3</button>
                    <button class="skill-btn">Skill 4</button>
                </div>
            </div>

            <div class="character-card" onclick="selectCharacter(5, 'Black Widow')">
                <div class="character-image">
                    <button class="learn-more-btn" onclick="event.stopPropagation(); learnMore(5, 'Black Widow')">learn more</button>
                </div>
                <div class="character-name">BLACK WIDOW</div>
                <div class="skills-grid">
                    <button class="skill-btn">Skill 1</button>
                    <button class="skill-btn">Skill 2</button>
                    <button class="skill-btn">Skill 3</button>
                    <button class="skill-btn">Skill 4</button>
                </div>
            </div>
        </div>
    </main>

</body>
</html>