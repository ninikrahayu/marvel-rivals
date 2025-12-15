<?php
require_once 'config/db.php';
require_once 'functions/auth.php';

if (!isLoggedIn()) { header('Location: login.php'); exit; }

$charId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($charId > 0) {
    $stmt = $conn->prepare("SELECT * FROM characters WHERE id = ?");
    $stmt->bind_param("i", $charId);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM characters ORDER BY id ASC");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Marvel Rivals - About Character</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }

        body {
            background: url('assets/backgrounds/character-bg.png') repeat;
            background-attachment: fixed; min-height: 100vh; padding-top: 74px;
        }

        header {
            background: #2d2f48; padding: 12px 30px; display: flex;
            justify-content: space-between; align-items: center;
            position: fixed; top: 0; left: 0; width: 100%; z-index: 100;
        }

        .logo { width: 50px; height: 50px; background: url('assets/logo/logo-header.png') no-repeat center/contain; }

        nav { display: flex; gap: 15px; }
        nav a { color: #fff; text-decoration: none; padding: 8px 18px; font-size: 14px; border-radius: 5px; }
        nav a.active { color: #ffd700; }

        .content-wrapper {
            max-width: 1200px; margin: 40px auto; background: #ffffff; padding: 35px;
            border-radius: 25px; display: grid; gap: 35px; width: calc(100% - 80px);
            align-items: center; 
            grid-template-columns: 320px 1fr 500px; 
        }

        .content-wrapper-second {
            max-width: 1200px; margin: 40px auto; background: #ffffff; padding: 35px;
            border-radius: 25px; display: grid; gap: 35px; width: calc(100% - 80px);
            align-items: center;
            grid-template-columns: 500px 1fr 320px; 
        }

        .portrait {
            width: 100%; height: 380px; background-color: #4a4c6f;
            border: 6px solid #ffd700; border-radius: 18px;
            background-size: cover; background-position: center;
        }

        .char-title { font-size: 32px; font-weight: bold; margin-bottom: 15px; text-transform: uppercase; }
        
        .description { color: #333; line-height: 1.6; font-size: 15px; margin-bottom: 25px; }

        .content-wrapper-second .char-title,
        .content-wrapper-second .description { text-align: right; }

        .skill-box {
            background: #2d2f48; color: white; padding: 20px; border-radius: 15px;
            display: grid; grid-template-columns: 1fr 1fr; gap: 20px;
        }

        .skill { background: #3c3f63; padding: 18px; border-radius: 12px; }
        .skill h3 { font-size: 16px; margin-bottom: 5px; }
        
        .stats-row { display: flex; justify-content: space-between; font-size: 13px; margin-top: 10px; }

        @media (max-width: 1024px) {
            .content-wrapper, .content-wrapper-second { grid-template-columns: 1fr; }
            .portrait { height: 400px; order: -1; } /* Gambar selalu di atas di mobile */
            .content-wrapper-second .char-title, .content-wrapper-second .description { text-align: left; }
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

<?php 
$counter = 0; 

if ($result->num_rows > 0):
    while ($char = $result->fetch_assoc()):
        $counter++;
        
        $skillQuery = $conn->query("SELECT * FROM skills WHERE character_id = " . $char['id']);
        
        $isLayoutLeft = ($counter % 2 != 0); 
?>

    <?php if ($isLayoutLeft): ?>
        <div class="content-wrapper">
            <div class="portrait" style="background-image:url('<?php echo $char['portrait_image']; ?>')"></div>

            <div>
                <div class="char-title"><?php echo $char['name']; ?></div>
                <div class="description">
                    <?php echo !empty($char['description']) ? nl2br($char['description']) : "No description available."; ?>
                </div>
            </div>

            <div class="skill-box">
                <?php while($skill = $skillQuery->fetch_assoc()): ?>
                <div class="skill">
                    <h3><?php echo $skill['skill_name']; ?></h3>
                    <p><?php echo substr($skill['description'] ?? '', 0, 50) . '...'; ?></p>
                    <div class="stats-row">
                        <span style="color:#00aaff;">Energy: <?php echo $skill['energy_cost']; ?></span>
                        <span style="color:#ff4d4d;">Damage: <?php echo $skill['damage_value']; ?></span>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>

    <?php else: ?>
        <div class="content-wrapper-second">
            <div class="skill-box">
                <?php while($skill = $skillQuery->fetch_assoc()): ?>
                <div class="skill">
                    <h3><?php echo $skill['skill_name']; ?></h3>
                    <p><?php echo substr($skill['description'] ?? '', 0, 50) . '...'; ?></p>
                    <div class="stats-row">
                        <span style="color:#00aaff;">Energy: <?php echo $skill['energy_cost']; ?></span>
                        <span style="color:#ff4d4d;">Damage: <?php echo $skill['damage_value']; ?></span>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>

            <div>
                <div class="char-title"><?php echo $char['name']; ?></div>
                <div class="description">
                    <?php echo !empty($char['description']) ? nl2br($char['description']) : "No description available."; ?>
                </div>
            </div>

            <div class="portrait" style="background-image:url('<?php echo $char['portrait_image']; ?>')"></div>
        </div>
    <?php endif; ?>

<?php 
    endwhile;
else:
    echo "<p style='text-align:center; color:white; margin-top:100px;'>Character not found.</p>";
endif; 
?>

</body>
</html>