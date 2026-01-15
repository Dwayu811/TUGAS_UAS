<?php
include 'config/database.php';
include 'includes/header.php';


if (!isset($_SESSION['user_id']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user_query = mysqli_query($db, "SELECT * FROM users WHERE id = '$user_id'");
$user_data = mysqli_fetch_assoc($user_query);


$total_bayar = 0;
foreach ($_SESSION['cart'] as $id => $qty) {
    $res = mysqli_query($db, "SELECT new_price FROM products WHERE id = '$id'");
    $p = mysqli_fetch_assoc($res);
    $total_bayar += ($p['new_price'] * $qty);
}
?>

<main class="container mx-auto px-6 py-20 flex-grow">
    <div class="mb-12">
        <h1 class="text-6xl font-black uppercase italic tracking-tighter leading-none">
            Final <span class="text-[#FFD700] drop-shadow-[3px_3px_0px_#1a1a1a]">Step.</span>
        </h1>   
        <p class="font-bold text-gray-500 uppercase tracking-widest text-xs mt-4">Isi data pengiriman untuk memproses pesananmu.</p>
    </div>

    <form action="checkout_api.php" method="POST" class="grid lg:grid-cols-3 gap-12">
        
        <div class="lg:col-span-2 space-y-10">
            <section class="border-t-8 border-[#1a1a1a] pt-8">
                <h2 class="text-2xl font-black uppercase italic mb-6 flex items-center gap-3">
                    <span class="bg-[#1a1a1a] text-white w-8 h-8 flex items-center justify-center not-italic text-sm">01</span>
                    Shipping Info
                </h2>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block font-black uppercase text-[10px] tracking-widest text-gray-400">Nama Penerima</label>
                        <input type="text" name="nama" value="<?= $user_data['nama'] ?? '' ?>" required
                               class="w-full border-4 border-[#1a1a1a] p-4 font-bold focus:bg-[#FFD700] outline-none transition-colors shadow-[4px_4px_0px_0px_#eeeeee]">
                    </div>
                    <div class="space-y-2">
                        <label class="block font-black uppercase text-[10px] tracking-widest text-gray-400">WhatsApp</label>
                        <input type="tel" name="telepon" placeholder="0812..." required
                               class="w-full border-4 border-[#1a1a1a] p-4 font-bold focus:bg-[#FFD700] outline-none transition-colors shadow-[4px_4px_0px_0px_#eeeeee]">
                    </div>
                    <div class="md:col-span-2 space-y-2">
                        <label class="block font-black uppercase text-[10px] tracking-widest text-gray-400">Alamat Lengkap</label>
                        <textarea name="alamat" rows="3" required
                                  class="w-full border-4 border-[#1a1a1a] p-4 font-bold focus:bg-[#FFD700] outline-none transition-colors shadow-[4px_4px_0px_0px_#eeeeee]"></textarea>
                    </div>
                </div>
            </section>

            <section class="border-t-8 border-[#1a1a1a] pt-8">
                <h2 class="text-2xl font-black uppercase italic mb-6 flex items-center gap-3">
                    <span class="bg-[#1a1a1a] text-white w-8 h-8 flex items-center justify-center not-italic text-sm">02</span>
                    Payment Method
                </h2>
                
                <div class="grid md:grid-cols-2 gap-4">
                    <label class="relative cursor-pointer group">
                        <input type="radio" name="payment_method" value="BCA" class="peer sr-only" required>
                        <div class="bg-white border-4 border-[#1a1a1a] p-6 font-black uppercase text-sm flex justify-between items-center 
                                    transition-all duration-200 peer-checked:bg-[#FFD700] peer-checked:shadow-[6px_6px_0px_0px_#1a1a1a]">
                            <span>Transfer BCA</span>
                            <i data-lucide="credit-card"></i>
                        </div>
                    </label>
                    <label class="relative cursor-pointer group">
                        <input type="radio" name="payment_method" value="QRIS" class="peer sr-only">
                        <div class="bg-white border-4 border-[#1a1a1a] p-6 font-black uppercase text-sm flex justify-between items-center 
                                    transition-all duration-200 peer-checked:bg-[#FFD700] peer-checked:shadow-[6px_6px_0px_0px_#1a1a1a]">
                            <span>QRIS / E-Wallet</span>
                            <i data-lucide="qr-code"></i>
                        </div>
                    </label>
                </div>
            </section>
        </div>

        <div class="relative">
            <div class="bg-[#1a1a1a] text-white p-8 border-4 border-[#1a1a1a] shadow-[12px_12px_0px_0px_#FFD700] sticky top-10">
                <h3 class="text-xl font-black uppercase italic mb-6 border-b border-gray-800 pb-4">Summary</h3>
                
                <div class="space-y-4 mb-8">
                    <div class="flex justify-between text-xs font-black uppercase">
                        <span class="text-gray-500">Items</span>
                        <span><?= count($_SESSION['cart']) ?> Products</span>
                    </div>
                    <div class="flex justify-between items-end">
                        <span class="text-[10px] font-black uppercase text-gray-500">Total</span>
                        <span class="text-3xl font-black text-[#FFD700]">Rp <?= number_format($total_bayar, 0, ',', '.') ?></span>
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#FFD700] text-black py-5 font-black uppercase tracking-widest text-sm hover:bg-white transition-all border-4 border-black shadow-[6px_6px_0px_0px_#000] active:shadow-none active:translate-x-1 active:translate-y-1">
                    Process to Payment
                </button>
            </div>
        </div>
    </form>
</main>

<script>lucide.createIcons();</script>
<?php include 'includes/footer.php'; ?>