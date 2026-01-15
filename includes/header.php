<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vintage Store - Koleksi Klasik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap');
        body { font-family: 'Inter', sans-serif; overflow-x: hidden; }
        .brutal-shadow { shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]; }
    </style>
</head>
<body class="min-h-screen flex flex-col bg-white font-sans text-[#1a1a1a]">

<header class="bg-[#1a1a1a] text-white sticky top-0 z-50 px-6 md:px-10 py-5 border-b-4 border-[#FFD700] shadow-xl">
    <nav class="flex items-center justify-between w-full">

        <div class="flex gap-8 items-center shrink-0">
            <a href="index.php" class="font-black hover:text-[#FFD700] uppercase tracking-widest text-xs transition-colors">
                Beranda
            </a>
            <a href="katalog.php" class="font-black hover:text-[#FFD700] uppercase tracking-widest text-xs transition-colors">
                Katalog
            </a>
            <a href="about.php" class="font-black hover:text-[#FFD700] uppercase tracking-widest text-xs transition-colors">
                Tentang
            </a>
        </div>

        <div class="hidden lg:block w-full max-w-md px-10">
            <form action="katalog.php" method="GET" class="relative group">
                <input
                    type="text"
                    name="search"
                    placeholder="Cari Barang..."
                    class="w-full bg-white border-4 border-transparent group-hover:border-[#FFD700] py-2 pl-12 pr-4
                           text-[10px] font-black tracking-widest text-[#1a1a1a]
                           focus:outline-none focus:border-[#FFD700] transition-all">
                <button type="submit" class="absolute left-4 top-1/2 -translate-y-1/2">
                    <i data-lucide="search" class="w-5 h-5 text-[#1a1a1a]"></i>
                </button>
            </form>
        </div>

        <div class="flex items-center gap-6 shrink-0">
            
            <a href="cart.php" class="relative group p-1">
                <i data-lucide="shopping-cart" class="w-6 h-6 group-hover:text-[#FFD700] transition-all"></i>
                <?php 
                $cart_count = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
                if ($cart_count > 0): 
                ?>
                    <span class="absolute -top-2 -right-2 bg-[#FFD700] text-[#1a1a1a] text-[10px] font-black w-5 h-5 flex items-center justify-center rounded-full border-2 border-[#1a1a1a]">
                        <?= $cart_count ?>
                    </span>
                <?php endif; ?>
            </a>

            <a href="<?= isset($_SESSION['user_id']) ? 'jual_produk.php' : 'login.php' ?>" 
               class="hidden sm:flex items-center gap-2 bg-[#FFD700] text-[#1a1a1a] px-5 py-2 text-xs font-black uppercase
                      border-2 border-[#FFD700] hover:bg-transparent hover:text-[#FFD700] transition-all">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>Jual</span>
            </a>

            <?php if(isset($_SESSION['user_id'])): ?>
                <div class="flex items-center gap-4 border-l border-gray-700 pl-6">
                    <a href="profile.php" class="flex items-center gap-3 group">
                        <div class="text-right hidden sm:block">
                            <p class="text-[11px] font-black uppercase text-[#FFD700] tracking-tighter">
                                <?= htmlspecialchars($_SESSION['username']) ?>
                            </p>
                        </div>
                        <div class="w-10 h-10 border-2 border-[#FFD700] rounded-full overflow-hidden bg-gray-800">
                            <?php if(!empty($_SESSION['user_image'])): ?>
                                <img src="uploads/profiles/<?= $_SESSION['user_image'] ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center bg-gray-700">
                                    <i data-lucide="user" class="w-5 h-5 text-gray-400"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                    </a>
                    <a href="logout.php" class="text-gray-500 hover:text-red-500 transition-colors">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                    </a>
                </div>
            <?php else: ?>
                <div class="flex items-center gap-4 border-l border-gray-700 pl-6">
                    <a href="login.php" class="text-xs font-black uppercase tracking-widest hover:text-[#FFD700]">Login</a>
                    <a href="register.php" class="text-xs font-black uppercase tracking-widest hover:text-[#FFD700]">Daftar</a>
                </div>
            <?php endif; ?>
        </div>
    </nav>
</header>

<script>lucide.createIcons();</script>