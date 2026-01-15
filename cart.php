<?php
include 'config/database.php';
include 'includes/header.php';


function getProductImage($imageName) {
    if (empty($imageName)) return 'https://placehold.co/600x600?text=No+Image';
    if (strpos($imageName, 'http') !== false) return $imageName; 
    
    $pathBaru = 'uploads/products/' . $imageName;
    $pathLama = 'uploads/' . $imageName;
    

    return (file_exists($pathBaru)) ? $pathBaru : $pathLama;
}


if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php?status=need_login';</script>";
    exit;
}

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>

<main class="container mx-auto px-6 py-20 flex-grow">
    <div class="mb-12">
        <h1 class="text-6xl font-black uppercase italic tracking-tighter">
            Keranjang <span class="text-[#FFD700] drop-shadow-[3px_3px_0px_#1a1a1a]">Kamu.</span>
        </h1>
        <p class="font-bold text-gray-500 uppercase tracking-widest text-xs mt-2">Periksa kembali barang buruanmu sebelum checkout.</p>
    </div>

    <?php if (empty($cart)): ?>
        <div class="border-4 border-dashed border-[#1a1a1a] p-20 text-center bg-gray-50 shadow-[10px_10px_0px_0px_#eeeeee]">
            <i data-lucide="shopping-bag" class="w-16 h-16 mx-auto text-gray-300 mb-4"></i>
            <p class="font-black uppercase tracking-widest text-gray-400">Keranjangmu Kosong, Bos!</p>
            <a href="katalog.php" class="inline-block mt-6 bg-[#1a1a1a] text-white px-10 py-4 font-black uppercase text-xs tracking-[0.2em] hover:bg-[#FFD700] hover:text-black transition-all shadow-[5px_5px_0px_0px_#FFD700]">Mulai Berburu</a>
        </div>
    <?php else: ?>
        <div class="grid lg:grid-cols-3 gap-12">
            <div class="lg:col-span-2 space-y-6">
                <?php 
                $total_bayar = 0;
                foreach ($cart as $id => $qty): 
                    $id_safe = mysqli_real_escape_string($db, $id);
                    $query = mysqli_query($db, "SELECT * FROM products WHERE id = $id_safe");
                    $item = mysqli_fetch_assoc($query);
                    
                    if (!$item) continue;

                    $harga_satuan = $item['new_price']; 
                    $subtotal = $harga_satuan;
                    $total_bayar += $subtotal;
                    
                    // PERBAIKAN DI SINI: Menggunakan fungsi pendeteksi path
                    $img_src = getProductImage($item['image']);
                ?>
                <div class="flex flex-col md:flex-row items-center border-4 border-[#1a1a1a] p-6 bg-white shadow-[8px_8px_0px_0px_#1a1a1a] relative group">
                    <div class="w-full md:w-32 aspect-square border-4 border-black overflow-hidden flex-shrink-0 bg-gray-100">
                        <img src="<?= $img_src ?>" class="w-full h-full object-cover" onerror="this.src='https://placehold.co/300x300?text=Error+Image'">
                    </div>

                    <div class="mt-4 md:mt-0 md:ml-8 flex-grow">
                        <h3 class="text-2xl font-black uppercase italic leading-none mb-1 group-hover:text-red-600 transition-colors">
                            <?= htmlspecialchars($item['name']) ?>
                        </h3>
                        <div class="flex items-center gap-2">
                            <p class="font-black text-[#1a1a1a]">Rp <?= number_format($harga_satuan, 0, ',', '.') ?></p>
                            <?php if ($item['is_promo'] == 1): ?>
                                <span class="text-[10px] bg-red-600 text-white px-1 font-bold italic">-<?= $item['discount_percent'] ?>%</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mt-6 md:mt-0 text-right w-full md:w-auto border-t-2 md:border-t-0 pt-4 md:pt-0 border-dashed border-gray-200">
                        <p class="text-[10px] font-black uppercase text-gray-400 mb-1">Subtotal</p>
                        <p class="text-3xl font-black mb-2 leading-none">Rp <?= number_format($subtotal, 0, ',', '.') ?></p>
                        <a href="hapus_item.php?id=<?= $id ?>" class="inline-block text-[10px] font-black uppercase tracking-tighter text-red-500 border-b-2 border-red-500 hover:bg-red-500 hover:text-white transition-all px-1">
                            Remove Item [X]
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="relative">
                <div class="bg-[#1a1a1a] text-white p-8 shadow-[12px_12px_0px_0px_#FFD700] sticky top-10 border-4 border-[#1a1a1a]">
                    <h2 class="text-3xl font-black uppercase italic mb-8 border-b-4 border-gray-800 pb-4 tracking-tighter">Ringkasan <span class="text-[#FFD700]">Order</span></h2>
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between font-bold uppercase text-xs tracking-widest">
                            <span class="text-gray-500">Total Unit</span>
                            <span class="text-white"><?= array_sum($cart) ?> Pcs</span>
                        </div>
                        <div class="flex justify-between font-bold uppercase text-xs tracking-widest">
                            <span class="text-gray-500">Pajak (PPN)</span>
                            <span class="text-green-500 italic">Included</span>
                        </div>
                    </div>
                    <div class="pt-6 border-t-4 border-gray-800">
                        <p class="text-[10px] font-black uppercase text-gray-500 tracking-widest mb-1">Total Yang Dibayar</p>
                        <p class="text-5xl font-black text-[#FFD700] tracking-tighter leading-none">
                            Rp <?= number_format($total_bayar, 0, ',', '.') ?>
                        </p>
                    </div>
                    <a href="checkout.php" class="block text-center w-full mt-10 bg-[#FFD700] text-black py-6 font-black uppercase tracking-[0.2em] text-lg hover:bg-white transition-all border-4 border-black shadow-[8px_8px_0px_0px_#000]">
                        Lanjut ke Pengiriman ⚡
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</main>