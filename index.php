<?php
require_once 'config/db.php';
require_once 'functions/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$currentUser = getCurrentUser();
$userId = $currentUser['id'];

$progressQuery = "SELECT unlocked_level_id FROM user_progress WHERE user_id = ?";
$stmt = $conn->prepare($progressQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();
$progressResult = $stmt->get_result();

$unlockedLevelId = 1; 
if ($progressResult->num_rows > 0) {
    $row = $progressResult->fetch_assoc();
    $unlockedLevelId = $row['unlocked_level_id'];
} else {
    $conn->query("INSERT INTO user_progress (user_id, unlocked_level_id) VALUES ($userId, 1)");
}

$levelsQuery = "SELECT * FROM levels ORDER BY id ASC";
$levelsResult = $conn->query($levelsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marvel Rivals - Select Level</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }

        body {
            background: url('assets/backgrounds/level-bg.png') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            overflow-x: hidden;
        }

        header {
            background: #2d2f48;
            padding: 12px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed; top: 0; left: 0; width: 100%; z-index: 100;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }

        .logo {
            width: 50px; height: 50px;
            background: url('assets/logo/logo-header.png') no-repeat center/contain;
        }

        nav { display: flex; gap: 15px; }
        nav a {
            color: #fff; text-decoration: none; padding: 8px 18px;
            font-size: 14px; border-radius: 5px; transition: background 0.3s;
        }
        nav a.active { color: #ffd700; }
        nav a:hover { background: rgba(255, 215, 0, 0.1); }

        main {
            padding-top: 100px; padding-bottom: 50px;
            display: flex; flex-direction: column; align-items: center;
        }

        h1 {
            color: #ffd700; font-size: 36px; margin-bottom: 50px;
            text-transform: capitalize; text-shadow: 0 4px 4px rgba(0,0,0,0.5);
            letter-spacing: 1px;
        }

        .levels-container {
            display: flex; justify-content: center; gap: 40px;
            flex-wrap: wrap; max-width: 1200px;
        }

        .level-card {
            width: 300px; height: 550px;
            border-radius: 30px; position: relative;
            cursor: pointer; overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: rgba(45, 47, 72, 0.8);
            border-style: solid; border-width: 4px 0 4px 4px; border-color: #ffd700;
        }

        .level-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.6);
        }

        .card-overlay {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1;
            background: linear-gradient(to bottom, rgba(0,0,0,0) 50%, rgba(0,0,0,0.6) 80%, rgba(0,0,0,0.9) 100%);
        }

        .card-image {
            width: 100%; height: 100%;
            background-size: cover; background-position: top center;
            transition: transform 0.5s ease;
        }
        
        .level-card:hover .card-image { transform: scale(1.05); }

        .level-btn {
            position: absolute; bottom: 30px; left: 50%;
            transform: translateX(-50%); width: 80%; padding: 15px 0;
            border-radius: 50px; font-size: 20px; font-weight: bold;
            color: #fff; text-align: center; z-index: 2; text-decoration: none;
            background: rgba(60, 56, 70, 0.95); border: 2px solid #ffd700;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3); transition: background 0.3s;
        }

        .level-card:hover .level-btn { background: #fff; color: #333; }

        .level-card.locked {
            cursor: not-allowed;
            border-color: #555;
        }

        .level-card.locked .card-image {
            filter: grayscale(100%) brightness(0.4); 
        }

        .level-card.locked .level-btn {
            background: #333;
            border-color: #555;
            color: #888;
        }

        .level-card.locked:hover {
            transform: none;
            box-shadow: none;
        }

        .lock-icon-container {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
            width: 80px; height: 80px;
            display: flex; justify-content: center; align-items: center;
        }

        .lock-svg {
            width: 60px; height: 60px;
            fill: #fff;
            opacity: 0.7;
            filter: drop-shadow(0 0 10px rgba(0,0,0,0.8));
        }

        @media (max-width: 768px) {
            header { flex-direction: column; gap: 10px; }
            .level-card { width: 90%; height: 400px; }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo"></div>
        <nav>
            <a href="index.php" class="active">Stage Level</a>
            <a href="#" onclick="alert('Pilih Level Terlebih Dahulu!')">Choose Character</a>
            <a href="about-character.php">About Character</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <h1>Be Aware For Your Level</h1>
        <div class="levels-container">
            <?php if ($levelsResult->num_rows > 0): ?>
                <?php while($level = $levelsResult->fetch_assoc()): ?>
                    <?php 
                        $isLocked = $level['id'] > $unlockedLevelId; 
                    ?>

                    <div class="level-card <?php echo $isLocked ? 'locked' : ''; ?>" 
                         onclick="<?php echo $isLocked ? "showLockedAlert()" : "selectLevel(" . $level['id'] . ")"; ?>">
                        
                        <div class="card-image" style="background-image: url('<?php echo $level['card_image']; ?>');"></div>
                        <div class="card-overlay"></div>
                        
                        <?php if ($isLocked): ?>
                            <div class="lock-icon-container">
                                <svg class="lock-svg" viewBox="0 0 24 24">
                                    <path d="M12 2C9.243 2 7 4.243 7 7v3H6c-1.103 0-2 .897-2 2v8c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-8c0-1.103-.897-2-2-2h-1V7c0-2.757-2.243-5-5-5zm6 10v8H6v-8h12zm-9-2V7c0-1.654 1.346-3 3-3s3 1.346 3 3v3H9z"/>
                                </svg>
                            </div>
                        <?php endif; ?>

                        <div class="level-btn">
                            <?php echo $isLocked ? 'Locked' : $level['level_name']; ?>
                        </div>
                    </div>

                <?php endwhile; ?>
            <?php else: ?>
                <p style="color:white;">Level data not found.</p>
            <?php endif; ?>
        </div>
    </main>

    <script>
        function selectLevel(levelId) {
            window.location.href = 'choose-character.php?level_id=' + levelId;
        }

        function showLockedAlert() {
            Swal.fire({
                icon: 'error',
                title: 'Level Terkunci!',
                text: 'Selesaikan level sebelumnya untuk membuka stage ini.',
                confirmButtonColor: '#d33'
            });
        }
    </script>
</body>
</html>