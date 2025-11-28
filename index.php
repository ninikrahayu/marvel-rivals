<?php
require_once 'config/db.php';
require_once 'functions/auth.php';

// Redirect to login if not logged in
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
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    
    <!-- Header -->
    <header class="bg-white border-b-2 border-black">
        <div class=" mx-auto px-4 py-4 flex items-center justify-between bg-[#D9D9D9]">
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold">MARVEL RIVALS</h1>
            <nav class="flex gap-3 sm:gap-4 md:gap-6 text-xs sm:text-sm md:text-base">
                <a href="#" class="hover:underline py-3">Stage Level</a>
                <a href="#" class="hover:underline bg-[#FFFFFF] p-3 rounded-2xl">Choose Character</a>
                <a href="#" class="hover:underline py-3">About Character</a>
            </nav>
        </div>
    </header>

    <main class=" mx-auto px-4 py-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4 md:gap-6">
            
            <!-- Character Card 1 -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-lg">
                <!-- Character Image Area -->
                <div class="bg-[#D9D9D9] h-80 sm:h-96 md:h-[600px] flex items-end justify-center p-4 relative">
                    <button class="absolute bottom-4 px-4 py-2 bg-gray-400 hover:bg-gray-500 rounded-lg text-xs sm:text-sm transition">
                        learn more
                    </button>
                </div>
                
                <!-- Character Name -->
                <div class="p-4 text-center">
                    <h2 class="text-lg sm:text-xl font-bold mb-3">IRON MAN</h2>
                    
                    <!-- Skills Grid -->
                    <div class="grid grid-cols-2 gap-2">
                        <button class="px-3 py-2 bg-[#D9D9D9] hover:bg-gray-400 rounded-full text-xs sm:text-sm transition">Skill 1</button>
                        <button class="px-3 py-2 bg-[#D9D9D9] hover:bg-gray-400 rounded-full text-xs sm:text-sm transition">Skill 2</button>
                        <button class="px-3 py-2 bg-[#D9D9D9] hover:bg-gray-400 rounded-full text-xs sm:text-sm transition">Skill 3</button>
                        <button class="px-3 py-2 bg-[#D9D9D9] hover:bg-gray-400 rounded-full text-xs sm:text-sm transition">Skill 4</button>
                    </div>
                </div>
            </div>

            <!-- Character Card 2 -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-lg">
                <div class="bg-[#D9D9D9] h-80 sm:h-96 md:h-[600px] flex items-end justify-center p-4 relative">
                    <button class="absolute bottom-4 px-4 py-2 bg-gray-400 hover:bg-gray-500 rounded-lg text-xs sm:text-sm transition">
                        learn more
                    </button>
                </div>
                <div class="p-4 text-center">
                    <h2 class="text-lg sm:text-xl font-bold mb-3">IRON MAN</h2>
                    <div class="grid grid-cols-2 gap-2">
                        <button class="px-3 py-2 bg-[#D9D9D9] hover:bg-gray-400 rounded-full text-xs sm:text-sm transition">Skill 1</button>
                        <button class="px-3 py-2 bg-[#D9D9D9] hover:bg-gray-400 rounded-full text-xs sm:text-sm transition">Skill 2</button>
                        <button class="px-3 py-2 bg-[#D9D9D9] hover:bg-gray-400 rounded-full text-xs sm:text-sm transition">Skill 3</button>
                        <button class="px-3 py-2 bg-[#D9D9D9] hover:bg-gray-400 rounded-full text-xs sm:text-sm transition">Skill 4</button>
                    </div>
                </div>
            </div>

            <!-- Character Card 3 -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-lg">
                <div class="bg-[#D9D9D9] h-80 sm:h-96 md:h-[600px] flex items-end justify-center p-4 relative">
                    <button class="absolute bottom-4 px-4 py-2 bg-gray-400 hover:bg-gray-500 rounded-lg text-xs sm:text-sm transition">
                        learn more
                    </button>
                </div>
                <div class="p-4 text-center">
                    <h2 class="text-lg sm:text-xl font-bold mb-3">IRON MAN</h2>
                    <div class="grid grid-cols-2 gap-2">
                        <button class="px-3 py-2 bg-[#D9D9D9] hover:bg-gray-400 rounded-full text-xs sm:text-sm transition">Skill 1</button>
                        <button class="px-3 py-2 bg-[#D9D9D9] hover:bg-gray-400 rounded-full text-xs sm:text-sm transition">Skill 2</button>
                        <button class="px-3 py-2 bg-[#D9D9D9] hover:bg-gray-400 rounded-full text-xs sm:text-sm transition">Skill 3</button>
                        <button class="px-3 py-2 bg-[#D9D9D9] hover:bg-gray-400 rounded-full text-xs sm:text-sm transition">Skill 4</button>
                    </div>
                </div>
            </div>

            <!-- Character Card 4 -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-lg">
                <div class="bg-[#D9D9D9] h-80 sm:h-96 md:h-[600px] flex items-end justify-center p-4 relative">
                    <button class="absolute bottom-4 px-4 py-2 bg-gray-400 hover:bg-gray-500 rounded-lg text-xs sm:text-sm transition">
                        learn more
                    </button>
                </div>
                <div class="p-4 text-center">
                    <h2 class="text-lg sm:text-xl font-bold mb-3">IRON MAN</h2>
                    <div class="grid grid-cols-2 gap-2">
                        <button class="px-3 py-2 bg-[#D9D9D9] hover:bg-gray-400 rounded-full text-xs sm:text-sm transition">Skill 1</button>
                        <button class="px-3 py-2 bg-[#D9D9D9] hover:bg-gray-400 rounded-full text-xs sm:text-sm transition">Skill 2</button>
                        <button class="px-3 py-2 bg-[#D9D9D9] hover:bg-gray-400 rounded-full text-xs sm:text-sm transition">Skill 3</button>
                        <button class="px-3 py-2 bg-[#D9D9D9] hover:bg-gray-400 rounded-full text-xs sm:text-sm transition">Skill 4</button>
                    </div>
                </div>
            </div>

            <!-- Character Card 5 -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-lg">
                <div class="bg-[#D9D9D9] h-80 sm:h-96 md:h-[600px] flex items-end justify-center p-4 relative">
                    <button class="absolute bottom-4 px-4 py-2 bg-gray-400 hover:bg-gray-500 rounded-lg text-xs sm:text-sm transition">
                        learn more
                    </button>
                </div>
                <div class="p-4 text-center">
                    <h2 class="text-lg sm:text-xl font-bold mb-3">IRON MAN</h2>
                    <div class="grid grid-cols-2 gap-2">
                        <button class="px-3 py-2 bg-[#D9D9D9] hover:bg-gray-400 rounded-full text-xs sm:text-sm transition">Skill 1</button>
                        <button class="px-3 py-2 bg-[#D9D9D9] hover:bg-gray-400 rounded-full text-xs sm:text-sm transition">Skill 2</button>
                        <button class="px-3 py-2 bg-[#D9D9D9] hover:bg-gray-400 rounded-full text-xs sm:text-sm transition">Skill 3</button>
                        <button class="px-3 py-2 bg-[#D9D9D9] hover:bg-gray-400 rounded-full text-xs sm:text-sm transition">Skill 4</button>
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>
</html>