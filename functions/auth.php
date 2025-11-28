<?php
session_start();

// Function to register user
function registerUser($username, $email, $password, $confirmPassword, $conn) {
    // Validation
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        return ['success' => false, 'message' => 'Semua field harus diisi!'];
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['success' => false, 'message' => 'Format email tidak valid!'];
    }

    if ($password !== $confirmPassword) {
        return ['success' => false, 'message' => 'Password tidak cocok!'];
    }

    if (strlen($password) < 6) {
        return ['success' => false, 'message' => 'Password minimal 6 karakter!'];
    }

    if (strlen($username) < 3) {
        return ['success' => false, 'message' => 'Username minimal 3 karakter!'];
    }

    // Check if username already exists
    $checkQuery = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stmt->close();
        return ['success' => false, 'message' => 'Username sudah terdaftar!'];
    }

    // Check if email already exists
    $checkEmailQuery = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($checkEmailQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stmt->close();
        return ['success' => false, 'message' => 'Email sudah terdaftar!'];
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert user into database
    $insertQuery = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        return ['success' => true, 'message' => 'Registrasi berhasil! Silakan login.'];
    } else {
        return ['success' => false, 'message' => 'Terjadi kesalahan saat registrasi.'];
    }
}

// Function to login user
function loginUser($username, $password, $conn) {
    // Validation
    if (empty($username) || empty($password)) {
        return ['success' => false, 'message' => 'Username dan password harus diisi!'];
    }

    // Get user from database
    $query = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return ['success' => false, 'message' => 'Username tidak ditemukan!'];
    }

    $user = $result->fetch_assoc();

    // Verify password
    if (!password_verify($password, $user['password'])) {
        return ['success' => false, 'message' => 'Password salah!'];
    }

    // Set session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];

    return ['success' => true, 'message' => 'Login berhasil!'];
}

// Function to logout user
function logoutUser() {
    session_destroy();
    return ['success' => true, 'message' => 'Logout berhasil!'];
}

// Function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Function to get current user
function getCurrentUser() {
    if (isLoggedIn()) {
        return ['id' => $_SESSION['user_id'], 'username' => $_SESSION['username']];
    }
    return null;
}

?>
