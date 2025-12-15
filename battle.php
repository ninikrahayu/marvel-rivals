<?php
require_once 'config/db.php';
require_once 'functions/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$levelId = isset($_GET['level_id']) ? intval($_GET['level_id']) : 1;
$charId = isset($_GET['character_id']) ? intval($_GET['character_id']) : 1;

// 1. Ambil Data Player
$player = $conn->query("SELECT * FROM characters WHERE id = $charId")->fetch_assoc();

// 2. Ambil Data Level & Musuh
$levelQuery = "SELECT l.*, c.name as enemy_name, c.base_health as enemy_hp, c.base_energy as enemy_energy, c.portrait_image as enemy_image, c.id as enemy_id 
               FROM levels l JOIN characters c ON l.enemy_character_id = c.id WHERE l.id = $levelId";
$levelData = $conn->query($levelQuery)->fetch_assoc();

if (!$player || !$levelData) {
    header('Location: index.php');
    exit;
}

// 3. Ambil Skill Player
$skillsQuery = "SELECT * FROM skills WHERE character_id = $charId ORDER BY id ASC";
$skillsResult = $conn->query($skillsQuery);
$playerSkills = [];
while ($row = $skillsResult->fetch_assoc()) {
    $playerSkills[] = $row;
}

// 4. Ambil Skill Musuh
$enemyId = $levelData['enemy_id'];
$enemySkillsQuery = "SELECT * FROM skills WHERE character_id = $enemyId";
$enemySkillsResult = $conn->query($enemySkillsQuery);
$enemySkills = [];
while ($row = $enemySkillsResult->fetch_assoc()) {
    $enemySkills[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Marvel Rivals - Battle</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            margin: 0; 
            font-family: 'Arial', sans-serif;
            background: url('assets/backgrounds/battle-bg.png') no-repeat center center fixed;
            background-size: cover; 
            height: 100vh; 
            overflow: hidden; 
            color: white;
        }

        /* === TOP BAR === */
        .top-bar {
            display: flex; 
            justify-content: space-between; 
            padding: 25px 50px; 
            align-items: center;
        }

        .level-badge {
            background: #3c3846;
            color: #ffd700;
            border: 2px solid #ffffff;
            border-radius: 50px;
            padding: 10px 50px;
            font-size: 20px; 
            font-weight: normal;
            letter-spacing: 1px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .surrender-btn {
            background: #3c3846;
            color: #ff4d4d;
            border: 2px solid #ff4d4d;
            border-radius: 50px;
            padding: 10px 40px;
            font-size: 20px;
            cursor: pointer; 
            transition: 0.3s;
            text-decoration: none;
            letter-spacing: 1px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        .surrender-btn:hover {
            background: #ff4d4d; 
            color: white;
        }

        /* === BATTLE AREA === */
        .battle-area {
            display: flex; 
            justify-content: space-between; 
            align-items: flex-start;
            height: calc(100vh - 120px);
            padding: 0 50px; 
            gap: 40px;
        }

        /* === BATTLE CARD === */
        .battle-card {
            width: 350px; 
            height: 520px;
            background-color: #676490;
            border-radius: 0 0 175px 175px;
            position: relative;
            border: 3px solid #ffd700; 
            border-top: none; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            display: flex; 
            flex-direction: column; 
            justify-content: flex-end;
        }
        
        /* CARD IMAGE */
        .card-img {
            position: absolute; 
            bottom: 0; 
            left: 0;
            width: 100%; 
            height: 100%;
            background-size: cover; 
            background-position: top center; 
            background-repeat: no-repeat;
            z-index: 0;
            border-radius: 0 0 172px 172px; 
            filter: drop-shadow(0 5px 10px rgba(0,0,0,0.4));
        }

        /* Gradient Overlay */
        .card-gradient {
            position: absolute; 
            bottom: 0; 
            left: 0; 
            width: 100%; 
            height: 55%;
            background: linear-gradient(to top, rgba(45, 47, 72, 0.95) 20%, transparent 100%);
            border-radius: 0 0 172px 172px;
            z-index: 1;
        }

        .stats-box { 
            padding: 20px 25px 75px 25px; 
            position: relative; 
            z-index: 2; 
        }
        
        .char-name { 
            font-size: 28px; 
            font-weight: bold; 
            text-transform: uppercase; 
            margin-bottom: 15px; 
            text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
        }
        
        /* === HP & ENERGY BARS === */
        .bar-container { 
            margin-bottom: 12px; 
        }
        
        .bar-label { 
            font-size: 13px; 
            margin-bottom: 5px; 
            color: #ddd; 
            display: flex; 
            justify-content: space-between; 
            font-weight: bold; 
        }
        
        .segments-wrapper { 
            display: flex; 
            gap: 3px; 
            height: 16px; 
            width: 100%; 
        }
        
        .segment { 
            flex: 1; 
            height: 100%; 
            background: rgba(0, 0, 0, 0.4); 
            border-radius: 2px; 
            border: 1px solid rgba(255,255,255,0.1); 
        }
        
        .segment.filled.hp { 
            background: #ff4d4d; 
            box-shadow: 0 0 4px #ff4d4d; 
            border-color: #ff8080; 
        }
        
        .segment.filled.energy { 
            background: #00aaff; 
            box-shadow: 0 0 4px #00aaff; 
            border-color: #80d4ff; 
        }

        /* === SKILL BUTTONS === */
        .skills-row {
            display: flex; 
            gap: 12px; 
            justify-content: center;
            position: absolute; 
            bottom: -70px; 
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
        }
        
        .skill-btn {
            width: 58px; 
            height: 58px; 
            background: rgba(60, 56, 70, 0.9);
            color: #ffd700; 
            font-size: 24px; 
            font-weight: bold;
            border: 2px solid #ffd700; 
            clip-path: polygon(20% 0, 100% 0, 100% 80%, 80% 100%, 0 100%, 0 20%);
            cursor: pointer; 
            transition: 0.2s;
            box-shadow: 0 5px 15px rgba(0,0,0,0.5);
        }
        
        .skill-btn:hover:not(:disabled) { 
            background: #ffd700; 
            color: #2d2f48; 
            transform: translateY(-5px); 
        }
        
        .skill-btn:disabled { 
            opacity: 0.5; 
            cursor: not-allowed; 
            background: #333; 
        }

        /* === TURN SYSTEM === */
        .turn-system { 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            gap: 20px; 
            padding-top: 30px;
        }
        
        .turn-title { 
            font-size: 30px; 
            font-weight: bold; 
            text-transform: uppercase; 
            text-shadow: 0 0 10px rgba(255,215,0,0.5); 
        }
        
        .turn-box {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 190px;
            height: 420px;
            background: #4a4c6f; 
            border-radius: 40px; 
            padding: 20px 12px;
            display: flex; 
            flex-direction: column; 
            gap: 25px; 
            border: 3px solid #2d2f48; 
            box-shadow: 0 10px 20px rgba(0,0,0,0.5);
        }
        
        .avatar-circle {
            width: 80%; 
            height: 160px; 
            border-radius: 50%;
            background-size: cover; 
            background-position: top center;
            border: 4px solid transparent; 
            opacity: 0.4; 
            transition: 0.4s; 
            filter: grayscale(100%);
        }
        
        .active-turn {
            border-color: #ffd700; 
            opacity: 1; 
            transform: scale(1.15); 
            box-shadow: 0 0 20px rgba(255,215,0,0.6); 
            filter: grayscale(0%);
        }

        /* Enemy card image flip */
        .battle-card.enemy .card-img {
            transform: scaleX(-1);
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .battle-area {
                gap: 20px;
                padding: 0 30px;
            }
            
            .battle-card {
                width: 300px;
                height: 450px;
            }
        }
    </style>
</head>
<body>

    <div class="top-bar">
        <div class="level-badge"><?php echo $levelData['level_name']; ?></div>
        <button class="surrender-btn" onclick="surrender()">surrendered</button>
    </div>

    <div class="battle-area">
        
        <!-- PLAYER CARD -->
        <div class="battle-card">
            <div class="card-img" style="background-image: url('<?php echo $player['portrait_image']; ?>');"></div>
            <div class="card-gradient"></div>
            
            <div class="stats-box">
                <div class="char-name"><?php echo $player['name']; ?></div>
                <div class="bar-container">
                    <div class="bar-label"><span>Health</span> <span id="p-hp-text">100%</span></div>
                    <div id="p-hp-bar" class="segments-wrapper"></div>
                </div>
                <div class="bar-container">
                    <div class="bar-label"><span>Energy</span> <span id="p-energy-text">100%</span></div>
                    <div id="p-energy-bar" class="segments-wrapper"></div>
                </div>
            </div>
            
            <div class="skills-row" id="player-skills">
                <button class="skill-btn" onclick="playerAttack(1)">1</button>
                <button class="skill-btn" onclick="playerAttack(2)">2</button>
                <button class="skill-btn" onclick="playerAttack(3)">3</button>
                <button class="skill-btn" onclick="playerAttack(4)">4</button>
            </div>
        </div>

        <!-- TURN SYSTEM -->
        <div class="turn-system">
            <div class="turn-title">TURN GAME</div>
            <div class="turn-box">
                <div id="turn-p" class="avatar-circle active-turn" style="background-image: url('<?php echo $player['card_image']; ?>');"></div>
                <div id="turn-e" class="avatar-circle" style="background-image: url('<?php echo $levelData['card_image']; ?>');"></div>
            </div>
        </div>

        <!-- ENEMY CARD -->
        <div class="battle-card enemy">
            <div class="card-img" style="background-image: url('<?php echo $levelData['enemy_image']; ?>');"></div>
            <div class="card-gradient"></div>

            <div class="stats-box">
                <div class="char-name"><?php echo $levelData['enemy_name']; ?></div>
                <div class="bar-container">
                    <div class="bar-label"><span>Health</span> <span id="e-hp-text">100%</span></div>
                    <div id="e-hp-bar" class="segments-wrapper"></div>
                </div>
                <div class="bar-container">
                    <div class="bar-label"><span>Energy</span> <span id="e-energy-text">100%</span></div>
                    <div id="e-energy-bar" class="segments-wrapper"></div>
                </div>
            </div>

             <div class="skills-row" style="opacity: 0.5; pointer-events: none;">
                <button class="skill-btn">1</button>
                <button class="skill-btn">2</button>
                <button class="skill-btn">3</button>
                <button class="skill-btn">4</button>
            </div>
        </div>
    </div>
    <script>
        const playerMaxHp = <?php echo $player['base_health']; ?>;
        
        // --- PERUBAHAN DI SINI: HP MUSUH DIKURANGI 20% ---
        const enemyMaxHp = Math.floor(<?php echo $levelData['enemy_hp']; ?> * 0.8);
        
        const maxEnergy = 100;
        
        // Data Skill dari PHP ke JS
        const heroSkills = <?php echo json_encode($playerSkills); ?>;
        const enemySkillsData = <?php echo json_encode($enemySkills); ?>;

        let playerHp = playerMaxHp;
        let enemyHp = enemyMaxHp;
        let playerEnergy = 100;
        let enemyEnergy = 100;
        let isPlayerTurn = true;

        window.onload = function () {
            createSegments('p-hp-bar', 20); createSegments('p-energy-bar', 10);
            createSegments('e-hp-bar', 20); createSegments('e-energy-bar', 10);
            updateUI();
        };

        function setHpSafe(target, newValue) {
            if (target === 'player') {
                if (newValue > playerHp) return;
                playerHp = Math.max(0, newValue);
            } else if (target === 'enemy') {
                if (newValue > enemyHp) return;
                enemyHp = Math.max(0, newValue);
            }
        }

        function createSegments(id, count) {
            const container = document.getElementById(id);
            container.innerHTML = '';
            for (let i = 0; i < count; i++) {
                let div = document.createElement('div');
                div.className = 'segment';
                container.appendChild(div);
            }
        }

        function updateSegmentColor(id, current, max, type) {
            const container = document.getElementById(id);
            const segments = container.children;
            if (current < 0) current = 0;

            const percentage = current / max;
            const activeCount = Math.ceil(percentage * segments.length);

            document.getElementById(id.replace('-bar', '-text')).innerText = Math.floor(percentage * 100) + '%';
            for (let i = 0; i < segments.length; i++) {
                segments[i].className = i < activeCount ? `segment filled ${type}` : 'segment';
            }
        }

        function updateUI() {
            updateSegmentColor('p-hp-bar', playerHp, playerMaxHp, 'hp');
            updateSegmentColor('e-hp-bar', enemyHp, enemyMaxHp, 'hp');
            updateSegmentColor('p-energy-bar', playerEnergy, maxEnergy, 'energy');
            updateSegmentColor('e-energy-bar', enemyEnergy, maxEnergy, 'energy');
            checkSkillAvailability();
        }

        function checkSkillAvailability() {
            for (let i = 1; i <= 4; i++) {
                const btn = document.querySelectorAll('#player-skills .skill-btn')[i - 1];
                const skill = heroSkills[i - 1];
                
                if (btn && skill) {
                    const cost = parseInt(skill.energy_cost);
                    btn.title = `${skill.skill_name} (Cost: ${cost})`;
                    if (playerEnergy < cost) {
                        btn.style.opacity = "0.5";
                        btn.style.cursor = "not-allowed";
                    } else {
                        btn.style.opacity = "1";
                        btn.style.cursor = "pointer";
                    }
                }
            }
        }

        function playerAttack(skillIndex) {
            if (!isPlayerTurn) return;

            const skillData = heroSkills[skillIndex - 1];
            if (!skillData) return;

            const cost = parseInt(skillData.energy_cost);
            const baseDamage = parseInt(skillData.damage_value);

            if (playerEnergy < cost) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Low Energy!',
                    text: `Need ${cost} energy for ${skillData.skill_name}`,
                    timer: 1000,
                    showConfirmButton: false,
                    background: '#2d2f48',
                    color: '#fff'
                });
                return;
            }

            playerEnergy -= cost;
            let damage = baseDamage + Math.floor(Math.random() * 20); // Variasi kecil
            
            setHpSafe('enemy', enemyHp - damage);
            updateUI();

            if (enemyHp <= 0) { handleVictory(); return; }

            isPlayerTurn = false;
            toggleTurnIndicator();
            disableSkills(true);
            setTimeout(enemyAttack, 1500);
        }

        function enemyAttack() {
            // Filter skill yang energinya cukup
            const affordableSkills = enemySkillsData.filter(skill => parseInt(skill.energy_cost) <= enemyEnergy);
            
            let damage = 0;

            if (affordableSkills.length > 0) {
                // Pilih skill acak dari yang tersedia
                const randomSkill = affordableSkills[Math.floor(Math.random() * affordableSkills.length)];
                
                const cost = parseInt(randomSkill.energy_cost);
                const rawDamage = parseInt(randomSkill.damage_value);
                
                // Kurangi Energy
                enemyEnergy -= cost;

                // --- PERUBAHAN: DAMAGE MUSUH DIKURANGI 20% ---
                damage = Math.floor(rawDamage * 0.8);
                
                console.log(`Enemy used ${randomSkill.skill_name}: ${damage} dmg (Base: ${rawDamage})`);

                // Efek Visual Serangan
                const enemyCard = document.querySelectorAll('.battle-card')[1];
                enemyCard.style.transform = "translateY(10px)";
                setTimeout(() => enemyCard.style.transform = "translateY(0)", 200);

            } else {
                // Serangan lemah jika energi habis
                damage = 20;
                console.log("Enemy used basic weak attack");
            }
            
            setHpSafe('player', playerHp - damage);
            updateUI();

            if (playerHp <= 0) {
                Swal.fire({ title: 'DEFEATED', text: 'You lost!', icon: 'error', background: '#2d2f48', color: '#fff' })
                    .then(() => window.location.href = 'index.php');
                return;
            }

            isPlayerTurn = true; 
            toggleTurnIndicator(); 
            disableSkills(false);
        }

        function toggleTurnIndicator() {
            document.getElementById('turn-p').classList.toggle('active-turn');
            document.getElementById('turn-e').classList.toggle('active-turn');
        }

        function disableSkills(disable) {
            document.querySelectorAll('#player-skills .skill-btn').forEach(btn => btn.disabled = disable);
        }

        function handleVictory() {
            fetch('api/game_over.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'status=win&level_id=<?php echo $levelId; ?>'
            }).then(() => {
                Swal.fire({ title: 'VICTORY!', text: 'Next level unlocked!', icon: 'success', background: '#2d2f48', color: '#fff' })
                    .then(() => window.location.href = 'index.php');
            });
        }

        function surrender() {
            Swal.fire({ title: 'Surrender?', text: "You will lose progress!", icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', background: '#2d2f48', color: '#fff' })
                .then((res) => { if (res.isConfirmed) window.location.href = 'index.php'; });
        }
    </script>
</body>
</html>