<?php
require_once 'config/db.php';
require_once 'functions/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$currentUser = getCurrentUser();

// Tangkap ID Level dari URL (default ke 1 jika tidak ada)
$levelId = isset($_GET['level_id']) ? intval($_GET['level_id']) : 1;

// Ambil semua karakter dari database
$charsQuery = "SELECT * FROM characters";
$charsResult = $conn->query($charsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marvel Rivals - Choose Character</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }

        body {
            background: url('assets/backgrounds/character-bg.png') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            overflow-x: hidden;
        }

        header {
            background: #2d2f48; padding: 12px 30px; display: flex;
            justify-content: space-between; align-items: center;
            position: fixed; top: 0; width: 100%; z-index: 100;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .logo { width: 50px; height: 50px; background: url('assets/logo/logo-header.png') no-repeat center/contain; }

        nav { display: flex; gap: 15px; }
        nav a {
            color: #fff; text-decoration: none; padding: 8px 18px;
            font-size: 14px; border-radius: 5px; transition: 0.3s;
        }
        nav a.active { color: #ffd700; }
        nav a:hover { background: rgba(255, 215, 0, 0.1); }

        main {
            padding-top: 90px; padding-bottom: 30px;
            display: flex; flex-direction: column; align-items: center; width: 100%;
        }

        h1 {
            color: #ffd700; font-size: 32px; margin-bottom: 30px;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.5); letter-spacing: 1px; font-weight: bold;
        }

        .characters-container {
            display: flex; justify-content: center; gap: 15px;
            width: 95%; max-width: 1600px;
        }

        .character-wrapper {
            flex: 1; max-width: 20%; min-width: 200px;
            display: flex; flex-direction: column; align-items: center;
        }

        .card-visual {
            width: 100%; height: 700px; border-radius: 20px;
            position: relative; cursor: pointer; overflow: hidden;
            transition: transform 0.3s ease; background-color: #676490;
            border-style: solid; border-width: 3px 0 3px 3px; border-color: #ffd700;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.3);
        }

        .card-visual:hover {
            transform: translateY(-8px); background-color: #7a76a3;
        }

        .card-image {
            width: 100%; height: 85%; background-size: cover;
            background-position: top center; background-repeat: no-repeat;
            mask-image: linear-gradient(to bottom, black 70%, transparent 100%);
            -webkit-mask-image: linear-gradient(to bottom, black 70%, transparent 100%);
        }

        .hero-name-container {
            position: absolute; bottom: 15px; left: 0;
            width: 100%; text-align: center; z-index: 2;
        }

        .character-name {
            font-size: 18px; color: white; text-transform: uppercase;
            letter-spacing: 1px; margin: 0; font-weight: 500;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.8);
        }

        .learn-more-btn {
            position: absolute; bottom: 45px; right: 15px;
            background: #3c3846; color: #ffd700; padding: 5px 16px;
            border-radius: 50px; font-size: 11px; border: none;
            cursor: pointer; box-shadow: 2px 2px 0px #ffffff;
            transition: all 0.2s ease; z-index: 10;
        }
        .learn-more-btn:hover {
            transform: translate(1px, 1px); box-shadow: 1px 1px 0px #ffffff;
            background: #2d2f48;
        }

        .skills-container { margin-top: 15px; width: 100%; padding: 0 10px; }
        .skills-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        
        .skill-item {
            display: flex; align-items: center; gap: 8px;
            font-size: 12px; color: #fff; font-weight: normal;
            cursor: pointer; transition: color 0.3s;
        }
        .skill-item:hover { color: #ffd700; }

        .skill-circle {
            width: 18px; height: 18px; background: #fff;
            border-radius: 50%; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        /* Modal Styles */
        .video-modal {
            display: none; position: fixed; z-index: 2000; left: 0; top: 0;
            width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.85);
            justify-content: center; align-items: center; backdrop-filter: blur(5px);
        }

        .modal-content {
            background-color: #2d2f48; padding: 20px; border: 2px solid #ffd700;
            border-radius: 15px; width: 90%; max-width: 700px;
            position: relative; text-align: center; box-shadow: 0 0 20px rgba(255, 215, 0, 0.3);
        }

        .modal-content h3 { color: #ffd700; margin-bottom: 15px; text-transform: uppercase; }

        .close-btn {
            position: absolute; top: 10px; right: 20px; color: #fff;
            font-size: 30px; font-weight: bold; cursor: pointer; transition: 0.3s;
        }
        .close-btn:hover { color: #ff4d4d; }
    </style>
</head>

<body>
    <header>
        <div class="logo"></div>
        <nav>
            <a href="index.php">Stage Level</a>
            <a href="index.php" class="active">Choose Character</a>
            <a href="about-character.php">About Character</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <h1>Choose Your Character</h1>

        <div class="characters-container">
            <?php if ($charsResult->num_rows > 0): ?>
                <?php while ($char = $charsResult->fetch_assoc()): ?>
                    
                    <div class="character-wrapper">
                        <div class="card-visual" onclick="selectCharacter('<?php echo $char['name']; ?>', <?php echo $char['id']; ?>)">
                            <div class="card-image" style="background-image: url('<?php echo $char['card_image']; ?>');"></div>
                            
                            <button class="learn-more-btn" onclick="event.stopPropagation(); window.location.href='about-character.php?id=<?php echo $char['id']; ?>'">
                                learn more
                            </button>
                            
                            <div class="hero-name-container">
                                <h3 class="character-name"><?php echo $char['name']; ?></h3>
                            </div>
                        </div>

                        <div class="skills-container">
                            <div class="skills-grid">
                                <?php 
                                // Query Skill per Karakter
                                $charId = $char['id'];
                                $skillsQuery = "SELECT * FROM skills WHERE character_id = $charId LIMIT 4";
                                $skillsResult = $conn->query($skillsQuery);
                                
                                if ($skillsResult->num_rows > 0):
                                    while ($skill = $skillsResult->fetch_assoc()):
                                ?>
                                    <div class="skill-item" onclick="event.stopPropagation(); playSkillVideo('<?php echo $skill['video_url']; ?>', '<?php echo $skill['skill_name']; ?>')">
                                        <div class="skill-circle"></div> 
                                        <?php echo $skill['skill_name']; ?>
                                    </div>
                                <?php 
                                    endwhile;
                                endif; 
                                ?>
                            </div>
                        </div>
                    </div>

                <?php endwhile; ?>
            <?php else: ?>
                <p style="color:white">Data karakter tidak ditemukan. Jalankan database.sql dulu.</p>
            <?php endif; ?>
        </div>

        <div id="videoModal" class="video-modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeVideo()">&times;</span>
                <h3 id="skillTitle">Skill Preview</h3>
                <video id="skillVideoPlayer" controls width="100%" height="400px">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </main>

    <script>
        // Simpan Level ID dari PHP ke variabel JS
        const currentLevelId = <?php echo $levelId; ?>;

        function selectCharacter(name, charId) {
            Swal.fire({
                title: 'Selected!',
                text: 'You chose ' + name,
                icon: 'success',
                confirmButtonColor: '#ffd700',
                confirmButtonText: 'Start Battle'
            }).then(() => {
                // Redirect ke Battle membawa Level ID dan Character ID
                window.location.href = `battle.php?level_id=${currentLevelId}&character_id=${charId}`;
            });
        }

        function playSkillVideo(videoUrl, skillName) {
            const modal = document.getElementById('videoModal');
            const videoPlayer = document.getElementById('skillVideoPlayer');
            const title = document.getElementById('skillTitle');
            
            title.innerText = skillName;
            videoPlayer.src = videoUrl; // Load video hanya saat diklik
            modal.style.display = 'flex';
            videoPlayer.play();
        }

        function closeVideo() {
            const modal = document.getElementById('videoModal');
            const videoPlayer = document.getElementById('skillVideoPlayer');
            
            modal.style.display = 'none';
            videoPlayer.pause();
            videoPlayer.src = ""; // Stop buffering
        }

        window.onclick = function (event) {
            const modal = document.getElementById('videoModal');
            if (event.target == modal) closeVideo();
        }
    </script>
</body>
</html>