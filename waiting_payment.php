<?php
include 'config/database.php';
include 'includes/header.php';

$order_id = $_GET['order_id'] ?? 'ORD-UNKNOWN';
$total = $_GET['total'] ?? '0';
?>

<main class="container mx-auto px-6 py-20 text-center min-h-[70vh] flex flex-col items-center justify-center">
    <div class="border-8 border-black p-10 shadow-[15px_15px_0px_0px_#FFD700] max-w-lg w-full bg-white">
        <h1 class="text-5xl font-black italic uppercase tracking-tighter mb-4">Awaiting Payment</h1>
        <p class="font-bold text-gray-500 uppercase text-xs tracking-widest mb-8">Segera selesaikan pembayaran pesanan Anda</p>
        
        <div class="bg-gray-100 p-6 border-4 border-black mb-8 text-left">
            <span class="block text-[10px] font-black text-gray-400 uppercase">Total Tagihan</span>
            <span class="text-3xl font-black italic">Rp <?= number_format($total, 0, ',', '.') ?></span>
            
            <div class="mt-6 pt-4 border-t-2 border-dashed border-gray-300">
                <span class="block text-[10px] font-black text-gray-400 uppercase">Transfer ke BCA</span>
                <span class="text-xl font-black">1234 567 890</span>
                <span class="block text-[10px] font-bold">A/N CLASSIC VINTAGE STORE</span>
            </div>
        </div> 
        <div class="grid gap-4">
            <a href="profile.php" class="bg-black text-[#FFD700] py-4 font-black uppercase text-sm hover:bg-[#FFD700] hover:text-black transition-all border-4 border-black">Cek Status Pesanan</a>
            <a href="index.php" class="text-black py-2 font-black uppercase text-xs underline">Kembali Belanja</a>
        </div>
    </div>
</main>

<script>lucide.createIcons();</script>
<?php include 'includes/footer.php'; ?>