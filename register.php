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
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-white min-h-screen">
    <div class="flex items-center justify-center min-h-screen p-4 sm:p-6 md:p-8">
        <div class="bg-[#D9D9D9] rounded-2xl sm:rounded-3xl p-6 sm:p-8 md:p-12 w-full max-w-sm sm:max-w-md">
            <h1 class="text-3xl sm:text-4xl font-bold text-center mb-6 sm:mb-8">REGISTER</h1>

            <form class="space-y-3 sm:space-y-4" action="register.php" method="POST">

                <input type="text" name="username" placeholder="Username"
                    class="w-full px-4 sm:px-6 py-3 sm:py-4 rounded-full bg-[#C0C0C0] placeholder-black text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-gray-500" required>

                <input type="email" name="email" placeholder="Email"
                    class="w-full px-4 sm:px-6 py-3 sm:py-4 rounded-full bg-[#C0C0C0] placeholder-black text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-gray-500" required>

                <input type="password" name="password" placeholder="Password"
                    class="w-full px-4 sm:px-6 py-3 sm:py-4 rounded-full bg-[#C0C0C0] placeholder-black text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-gray-500" required>

                <input type="password" name="confirm_password" placeholder="Confirm Password"
                    class="w-full px-4 sm:px-6 py-3 sm:py-4 rounded-full bg-[#C0C0C0] placeholder-black text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-gray-500" required>

                <div class="flex justify-end pt-3 sm:pt-4">
                    <button type="submit"
                        class="px-6 sm:px-8 py-2.5 sm:py-3 bg-[#C0C0C0] hover:bg-gray-500 rounded-full text-black font-medium transition text-sm sm:text-base inline-block">
                        Buat Akun
                    </button>
                </div>

                <div class="flex justify-center pt-2">
                    <a href="login.php" class="text-black text-sm hover:underline">
                        Sudah punya akun? Login di sini
                    </a>
                </div>
            </form>
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