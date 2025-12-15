<?php
require_once '../config/db.php';
require_once '../functions/auth.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$userId = $_SESSION['user_id']; 
$status = $_POST['status'] ?? '';
$levelId = intval($_POST['level_id'] ?? 0);

if ($status === 'win' && $levelId > 0) {
    $nextLevelId = $levelId + 1;

    $checkQuery = "SELECT unlocked_level_id FROM user_progress WHERE user_id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentUnlocked = $row['unlocked_level_id'];

        if ($nextLevelId > $currentUnlocked) {
            $updateQuery = "UPDATE user_progress SET unlocked_level_id = ? WHERE user_id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("ii", $nextLevelId, $userId);
            $updateStmt->execute();
        }
    } else {
        $insertQuery = "INSERT INTO user_progress (user_id, unlocked_level_id) VALUES (?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("ii", $userId, $nextLevelId);
        $insertStmt->execute();
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>