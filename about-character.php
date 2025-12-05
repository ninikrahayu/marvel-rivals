<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Marvel Rivals - About Character</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: url('assets/backgrounds/character-bg.png') repeat;
            background-attachment: fixed; 
            min-height: 100vh;
            padding-top: 74px;
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

        .content-wrapper, .content-wrapper-second {
            max-width: 1200px;
            margin: 40px auto;
            background: #ffffff;
            padding: 35px;
            border-radius: 25px;
            display: grid;
            gap: 35px;
            width: calc(100% - 80px);
            align-items: center;
        }

        .content-wrapper {
            grid-template-columns: 320px 1fr 500px;
        }

        .content-wrapper-second {
            grid-template-columns: 500px 1fr 320px;
        }

        .portrait {
            width: 100%;
            height: 380px;
            background-color: #4a4c6f;
            border: 6px solid #ffd700;
            border-radius: 18px;
            background-size: cover;
            background-position: center;
        }

        .char-title {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .description {
            color: #333;
            line-height: 1.6;
            font-size: 15px;
            margin-bottom: 25px;
        }

        .content-wrapper-second .char-title,
        .content-wrapper-second .description {
            text-align: right;
        }

        .skill-box {
            background: #2d2f48;
            color: white;
            padding: 20px;
            border-radius: 15px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .skill {
            background: #3c3f63;
            padding: 18px;
            border-radius: 12px;
        }

        .skill h3 {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .label {
            color: #ffd700;
            font-size: 12px;
            margin-top: 6px;
            display: block;
        }
    </style>
</head>

<body>
<header>
    <div class="logo"></div>
    <nav>
        <a href="levels.php">Stage Level</a>
        <a href="index.php">Choose Character</a>
        <a href="about-character.php" class="active">About Character</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<div class="content-wrapper">
    <div class="portrait" style="background-image:url('ironman.png')"></div>

    <div>
        <div class="char-title">IRON MAN</div>
        <div class="description">
            Armed with superior intellect and a nanotech battlesuit of his own design, Tony Stark
            stands alongside gods as the Invincible Iron Man. His state of the art armor turns any
            battlefield into his personal playground, allowing him to steal the spotlight he so
            desperately desires.
        </div>
    </div>

    <div class="skill-box">
        <div class="skill">
            <h3>Skill 1</h3>
            <p>Lorem ipsum dolor sit amet.</p>
            <div style="display:flex; justify-content:space-between; font-size:13px; margin-top:10px;">
                <span style="color:#00aaff;">Energy: 20</span>
                <span style="color:#ff4d4d;">Damage: 40</span>
            </div>
        </div>
        <div class="skill">
            <h3>Skill 2</h3>
            <p>Lorem ipsum dolor sit amet.</p>
            <div style="display:flex; justify-content:space-between; font-size:13px; margin-top:10px;">
                <span style="color:#00aaff;">Energy: 20</span>
                <span style="color:#ff4d4d;">Damage: 40</span>
            </div>
        </div>
        <div class="skill">
            <h3>Skill 3</h3>
            <p>Lorem ipsum dolor sit amet.</p>
            <div style="display:flex; justify-content:space-between; font-size:13px; margin-top:10px;">
                <span style="color:#00aaff;">Energy: 20</span>
                <span style="color:#ff4d4d;">Damage: 40</span>
            </div>
        </div>
        <div class="skill">
            <h3>Skill 4</h3>
            <p>Lorem ipsum dolor sit amet.</p>
            <div style="display:flex; justify-content:space-between; font-size:13px; margin-top:10px;">
                <span style="color:#00aaff;">Energy: 20</span>
                <span style="color:#ff4d4d;">Damage: 40</span>
            </div>
        </div>
    </div>
</div>

<div class="content-wrapper-second">
    <div class="skill-box">
        <div class="skill">
            <h3>Skill 1</h3>
            <p>Lorem ipsum dolor sit amet.</p>
            <div style="display:flex; justify-content:space-between; font-size:13px; margin-top:10px;">
                <span style="color:#00aaff;">Energy: 20</span>
                <span style="color:#ff4d4d;">Damage: 40</span>
            </div>
        </div>
        <div class="skill">
            <h3>Skill 2</h3>
            <p>Lorem ipsum dolor sit amet.</p>
            <div style="display:flex; justify-content:space-between; font-size:13px; margin-top:10px;">
                <span style="color:#00aaff;">Energy: 20</span>
                <span style="color:#ff4d4d;">Damage: 40</span>
            </div>
        </div>
        <div class="skill">
            <h3>Skill 3</h3>
            <p>Lorem ipsum dolor sit amet.</p>
            <div style="display:flex; justify-content:space-between; font-size:13px; margin-top:10px;">
                <span style="color:#00aaff;">Energy: 20</span>
                <span style="color:#ff4d4d;">Damage: 40</span>
            </div>
        </div>
        <div class="skill">
            <h3>Skill 4</h3>
            <p>Lorem ipsum dolor sit amet.</p>
            <div style="display:flex; justify-content:space-between; font-size:13px; margin-top:10px;">
                <span style="color:#00aaff;">Energy: 20</span>
                <span style="color:#ff4d4d;">Damage: 40</span>
            </div>
        </div>
    </div>

    <div>
        <div class="char-title">HULK</div>
        <div class="description">
            Brilliant scientist Dr. Bruce Banner has finally found a way to coexist with his monstrous alter ego, 
            the Hulk. By accumulating gamma energy over multiple transformations, he can become a wise and strong 
            Hero Hulk or a fierce and destructive Monster Hulk – a true force of fury on the battlefield!
        </div>
    </div>

    <div class="portrait" style="background-image:url('ironman.png')"></div>
</div>
</body>
</html>
