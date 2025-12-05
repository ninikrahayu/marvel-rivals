<?php
require_once 'config/db.php';
require_once 'functions/auth.php';

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

    $result = registerUser($username, $email, $password, $confirmPassword, $conn);
    $message = $result['message'];
    $messageType = $result['success'] ? 'success' : 'error';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marvel Rivals - Register</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #e0dfe6 0%, #c8c7cf 100%);
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: repeating-conic-gradient(
                from 0deg at 50% 50%,
                transparent 0deg,
                rgba(255, 255, 255, 0.3) 2deg,
                transparent 4deg,
                transparent 8deg
            );
            animation: rotate 60s linear infinite;
            z-index: 0;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .logo-container {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            z-index: 5;
        }

        .marvel-logo {
            width: 250px;
            object-fit: contain;
            filter: drop-shadow(0 2px 6px rgba(0,0,0,0.4));
        }

        .container {
            position: relative;
            z-index: 2;
            background: #3c3846;
            padding: 40px 50px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 440px;
            margin-top: 120px;
        }

        h1 {
            color: #f4d03f;
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 30px;
            text-align: center;
            letter-spacing: 2px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 15px 20px;
            background: #6b6679;
            border: 2px solid #f4d03f;
            border-radius: 50px;
            color: #fff;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        input:focus {
            background: #7a7687;
            border-color: #f4d03f;
        }

        button {
            width: auto;
            padding: 12px 40px;
            background: #f4d03f;
            border: none;
            border-radius: 50px;
            color: #3c3846;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            display: block;
            margin: 25px auto 0;
        }

        button:hover {
            background: #f5e04a;
            transform: scale(1.05);
        }

        button:active {
            transform: scale(0.98);
        }

        .link {
            text-align: center;
            margin-top: 20px;
        }

        .link a {
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .link a:hover {
            color: #f4d03f;
        }

        @media (max-width: 480px) {
            .container {
                padding: 30px 25px;
            }
            
            h1 {
                font-size: 28px;
            }
            
            input {
                padding: 12px 18px;
                font-size: 13px;
            }
            
            button {
                padding: 10px 30px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="logo-container">
        <img src="assets/logo/marvel-logo.png" class="marvel-logo">
    </div>

    <div class="container">
        <h1>REGISTER</h1>

        <form action="register.php" method="POST">
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <div class="form-group">
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            </div>

            <button type="submit">Buat akun</button>
        </form>

        <div class="link">
            <a href="login.php">Sudah punya akun? Login di sini</a>
        </div>
    </div>


    <?php if ($message): ?>
    <script>
        Swal.fire({
            icon: '<?php echo $messageType; ?>',
            title: '<?php echo $messageType === 'success' ? 'Berhasil' : 'Gagal'; ?>',
            text: '<?php echo $message; ?>',
            confirmButtonText: 'OK'
        }).then(() => {
            <?php if ($messageType === 'success'): ?>
                window.location.href = 'login.php';
            <?php endif; ?>
        });
    </script>
    <?php endif; ?>
</body>

</html>