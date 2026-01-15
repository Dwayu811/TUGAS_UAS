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


$id = isset($_GET['id']) ? mysqli_real_escape_string($db, $_GET['id']) : 0;

$query = mysqli_query($db, "SELECT p.*, c.name AS category_name 
                            FROM products p 
                            LEFT JOIN categories c ON p.category_id = c.id 
                            WHERE p.id = '$id'");
$product = mysqli_fetch_assoc($query);

$daftar_foto = [];
if ($product) {
    $daftar_foto[] = getProductImage($product['image']);

    $query_detail = mysqli_query($db, "SELECT image_name FROM product_images WHERE product_id = '$id' LIMIT 4");
    while ($row = mysqli_fetch_assoc($query_detail)) {
        $daftar_foto[] = getProductImage($row['image_name']);
    }
}
?>

<main class="container mx-auto px-6 py-20 flex-grow">
    <?php if ($product): ?>
        <div class="grid md:grid-cols-2 gap-12 items-start">    

            <div class="space-y-4">
                <div class="relative group aspect-square bg-white overflow-hidden border-4 border-[#1a1a1a] shadow-[12px_12px_0px_0px_#1a1a1a]">
                    
                    <?php if (isset($product['is_promo']) && $product['is_promo'] == 1 && $product['discount_percent'] > 0): ?>
                        <div class="absolute top-4 left-4 bg-red-600 text-white font-black px-4 py-2 z-20 shadow-[4px_4px_0px_0px_#000] rotate-[-5deg]">
                            SAVE <?= $product['discount_percent']; ?>% OFF
                        </div>
                    <?php endif; ?>

                    <button type="button" onclick="geser(-1)" class="absolute left-4 top-1/2 -translate-y-1/2 z-30 bg-[#FFD700] p-3 border-2 border-[#1a1a1a] shadow-[4px_4px_0px_0px_#1a1a1a] opacity-0 group-hover:opacity-100 transition-all hover:bg-white">
                        <i data-lucide="chevron-left"></i>
                    </button>
                    
                    <img id="imgDisplay" src="<?= $daftar_foto[0]; ?>" class="w-full h-full object-cover transition-opacity duration-300">
                    
                    <button type="button" onclick="geser(1)" class="absolute right-4 top-1/2 -translate-y-1/2 z-30 bg-[#FFD700] p-3 border-2 border-[#1a1a1a] shadow-[4px_4px_0px_0px_#1a1a1a] opacity-0 group-hover:opacity-100 transition-all hover:bg-white">
                        <i data-lucide="chevron-right"></i>
                    </button>
                </div>

                <div class="grid grid-cols-5 gap-2">
                    <?php foreach ($daftar_foto as $index => $foto): ?>
                        <div onclick="gantiKe(<?= $index ?>)" 
                             class="tombol-thumb cursor-pointer aspect-square overflow-hidden transition-all 
                                    <?= ($index === 0) ? 'border-4 border-[#1a1a1a] shadow-[2px_2px_0px_0px_#1a1a1a]' : 'border-2 border-gray-200 opacity-60' ?>">
                            <img src="<?= $foto ?>" class="w-full h-full object-cover">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="flex flex-col justify-between h-full">
                <div class="space-y-6">
                    <div>
                        <span class="bg-[#1a1a1a] text-[#FFD700] px-3 py-1 text-xs font-black uppercase tracking-widest mb-4 inline-block">
                            <?= $product['category_name'] ?? 'General Collection'; ?>
                        </span>

                        <h1 class="text-5xl md:text-7xl font-black uppercase italic tracking-tighter mb-2 leading-none text-[#1a1a1a]">
                            <?= htmlspecialchars($product['name']); ?>
                        </h1>
                        <div class="h-2 w-24 bg-[#FFD700]"></div>
                    </div>

                    <div class="flex flex-col gap-1">
                        <p class="text-5xl font-black text-[#1a1a1a]">
                            <?php 
                                $harga_tampil = (!empty($product['new_price']) && $product['new_price'] != 0) ? $product['new_price'] : $product['price'];
                                echo "Rp " . number_format($harga_tampil, 0, ',', '.'); 
                            ?>
                        </p>
                        
                        <?php if (isset($product['is_promo']) && $product['is_promo'] == 1 && $product['new_price'] > 0): ?>
                            <p class="text-2xl font-bold text-gray-400 line-through italic">
                                Rp <?= number_format($product['price'], 0, ',', '.'); ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <div class="border-t-4 border-[#1a1a1a] pt-6">
                        <label class="block font-black uppercase text-sm tracking-widest mb-3 text-gray-400 italic">Curator's Note</label>
                        <div class="text-lg leading-relaxed font-medium text-gray-700 max-h-[300px] overflow-y-auto pr-4 custom-scrollbar">
                            <?= nl2br(htmlspecialchars($product['description'])); ?>
                        </div>
                    </div>
                </div>

                <div class="pt-10">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4 text-right">
                        * 1-of-1 Collection. Stock is limited to one item only.
                    </p>
                    <a href="tambah_keranjang.php?id=<?= $product['id']; ?>" 
                       class="block text-center bg-[#1a1a1a] text-[#FFD700] px-16 py-6 font-black uppercase tracking-[0.2em] text-xl
                              hover:bg-[#FFD700] hover:text-[#1a1a1a] transition-all 
                              shadow-[12px_12px_0px_0px_#FFD700] hover:shadow-none hover:translate-x-1 hover:translate-y-1 border-4 border-[#1a1a1a]">
                        Grab This Piece
                    </a>
                </div>
            </div>
        </div>

        <section class="mt-32 pt-20 border-t-4 border-[#1a1a1a]">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-4xl font-black uppercase italic tracking-tighter">More <span class="text-[#FFD700] drop-shadow-[2px_2px_0px_#1a1a1a]">Treasures.</span></h2>
                    <p class="font-bold text-gray-500 uppercase tracking-widest text-xs mt-2">Recommended for your collection</p>
                </div>
                <a href="katalog.php" class="font-black uppercase text-xs tracking-widest border-b-4 border-[#FFD700] hover:bg-[#FFD700] transition-all p-1">View All</a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <?php
                $recommend_query = mysqli_query($db, "SELECT * FROM products WHERE id != '$id' ORDER BY RAND() LIMIT 4");
                while($rec = mysqli_fetch_assoc($recommend_query)):
                    $rec_img = getProductImage($rec['image']);
                ?>
                    <a href="product.php?id=<?= $rec['id']; ?>" class="group">
                        <div class="relative aspect-square mb-4 border-4 border-[#1a1a1a] shadow-[4px_4px_0px_0px_#1a1a1a] group-hover:shadow-[8px_8px_0px_0px_#FFD700] group-hover:-translate-x-1 group-hover:-translate-y-1 transition-all overflow-hidden bg-white">
                            <img src="<?= $rec_img; ?>" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                        </div>
                        <h3 class="font-black uppercase italic text-sm tracking-tight group-hover:text-red-600 transition-colors"><?= htmlspecialchars($rec['name']); ?></h3>
                        <p class="font-bold text-xs mt-1">
                            <?php 
                                $rec_price = ($rec['new_price'] > 0) ? $rec['new_price'] : $rec['price'];
                                echo "Rp " . number_format($rec_price, 0, ',', '.');
                            ?>
                        </p>
                    </a>
                <?php endwhile; ?>
            </div>
        </section>

    <?php else: ?>
        <div class="text-center py-20">
            <h2 class="text-4xl font-black uppercase italic tracking-tighter">Koleksi Tidak Ditemukan</h2>
            <a href="katalog.php" class="inline-block mt-6 px-8 py-3 bg-[#1a1a1a] text-white font-black uppercase text-xs tracking-widest">Kembali ke Katalog</a>
        </div>
    <?php endif; ?>
</main>

<script>
    lucide.createIcons();
    const daftarGambar = <?= json_encode($daftar_foto); ?>;
    let urutanSekarang = 0;
    const layarGambar = document.getElementById('imgDisplay');
    const semuaThumb = document.querySelectorAll('.tombol-thumb');

    function gantiKe(index) {
        if (!daftarGambar[index]) return;
        urutanSekarang = index;
        layarGambar.style.opacity = '0';
        setTimeout(() => {
            layarGambar.src = daftarGambar[urutanSekarang];
            layarGambar.style.opacity = '1';
        }, 150);

        semuaThumb.forEach((kotak, i) => {
            kotak.className = i === index 
                ? "tombol-thumb cursor-pointer aspect-square border-4 border-[#1a1a1a] shadow-[2px_2px_0px_0px_#1a1a1a] overflow-hidden transition-all opacity-100"
                : "tombol-thumb cursor-pointer aspect-square border-2 border-gray-200 opacity-60 hover:opacity-100 transition-all overflow-hidden";
        });
    }

    function geser(arah) {
        urutanSekarang += arah;
        if (urutanSekarang >= daftarGambar.length) urutanSekarang = 0;
        if (urutanSekarang < 0) urutanSekarang = daftarGambar.length - 1;
        gantiKe(urutanSekarang);
    }
</script>

<?php include 'includes/footer.php'; ?>