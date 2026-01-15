<?php
include 'config/database.php';
include 'includes/header.php';


$query_new = mysqli_query($db, "SELECT * FROM products ORDER BY id DESC LIMIT 8");


$query_promo = mysqli_query($db, "SELECT * FROM products WHERE is_promo = 1 ORDER BY id DESC");
$promo_items = mysqli_fetch_all($query_promo, MYSQLI_ASSOC);


function getProductImage($imageName) {
    if (strpos($imageName, 'http') !== false) return $imageName; 
    $pathBaru = 'uploads/products/' . $imageName;
    $pathLama = 'uploads/' . $imageName;
    
    
    return (file_exists($pathBaru) && !empty($imageName)) ? $pathBaru : $pathLama;
}
?>

<section class="w-full">
    <div class="w-full py-32 md:py-52 flex flex-col items-center justify-center text-center relative overflow-hidden bg-cover bg-center "
         style="background-image: linear-gradient(to bottom, rgba(255, 215, 0, 0.15), rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 1)), url('https://i.pinimg.com/1200x/22/b7/df/22b7df0e50962be7caf50b10faa26a2e.jpg');">
        <div class="absolute inset-0 bg-black/15 pointer-events-none"></div>
        <div class="relative px-6">
            <h2 class="text-6xl md:text-[100px] font-black uppercase italic tracking-tighter leading-[0.85] mb-6">
              <span class="text-[#1a1a1a] drop-shadow-[5px_5px_0px_#FFD700]">Cerita</span> <span class="text-white drop-shadow-[5px_5px_0px_#1a1a1a]">Lama</span><br>
            <span class="text-[#1a1a1a] drop-shadow-[5px_5px_0px_#FFD700]">Pemilik Baru.</span>
            </h2>
            <div class="flex items-center justify-center gap-4 mt-8">
                <div class="h-[2px] w-8 md:w-16 bg-black"></div>
                <p class="font-bold uppercase tracking-[0.3em] md:tracking-[0.5em] text-[10px] md:text-xs text-black">Authentic Vintage Experience</p>
                <div class="h-[2px] w-8 md:w-16 bg-black"></div>
            </div>
        </div>
    </div>
</section>

<main class="container mx-auto px-6 py-20 relative z-10">
    <div class="flex justify-between items-end mb-10 border-b-4 border-[#1a1a1a] pb-4">
        <div>
            <h2 class="text-4xl font-black uppercase italic tracking-tighter">New Arrivals</h2>
            <p class="text-gray-500 font-medium">Koleksi terbaru minggu ini</p>
        </div>
        <a href="katalog.php" class="group flex items-center gap-2 font-black uppercase tracking-widest text-[#1a1a1a] hover:text-gray-600 transition-all text-sm">
            Lihat Semua 
            <span class="bg-[#1a1a1a] text-white p-1 group-hover:translate-x-2 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </span>
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-32">
        <?php if (mysqli_num_rows($query_new) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($query_new)) : ?>
                <a href="product.php?id=<?= $row['id']; ?>" class="block group relative">
                    <?php if (isset($row['is_promo']) && $row['is_promo'] == 1 && $row['discount_percent'] > 0): ?>
                        <div class="absolute -top-2 -right-2 bg-red-600 text-white font-black text-[10px] px-2 py-1 z-20 shadow-[2px_2px_0px_0px_#000]">-<?= $row['discount_percent']; ?>%</div>
                    <?php endif; ?>

                    <div class="aspect-square bg-gray-200 mb-4 overflow-hidden shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                        <img src="<?= getProductImage($row['image']); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="<?= htmlspecialchars($row['name']); ?>" loading="lazy">
                    </div>
                    
                    <h4 class="font-bold text-[#1a1a1a] uppercase text-sm truncate"><?= htmlspecialchars($row['name']); ?></h4>
                    <div class="flex items-center gap-2 mt-1">
                        <p class="text-[#1a1a1a] font-black">
                            <?php 
                                $harga_skrg = ($row['new_price'] > 0) ? $row['new_price'] : $row['price'];
                                echo "Rp " . number_format($harga_skrg, 0, ',', '.'); 
                            ?>
                        </p>
                        <?php if (isset($row['is_promo']) && $row['is_promo'] == 1): ?>
                            <p class="text-gray-400 font-bold line-through text-[10px]">Rp <?= number_format($row['price'], 0, ',', '.'); ?></p>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

    <?php if (count($promo_items) > 0): ?>
    <section class="bg-[#1a1a1a] text-white p-8 md:p-20 relative overflow-hidden mb-20 shadow-[15px_15px_0px_0px_#FFD700]">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <span class="bg-[#FFD700] text-[#1a1a1a] px-3 py-1 font-black text-xs uppercase mb-6 inline-block">Special Deals</span>
                <h2 class="text-5xl md:text-7xl font-black italic mb-6 uppercase tracking-tighter">VINTAGE <br> <span class="text-[#FFD700]">DISCOUNT</span> <br> COLLECTOR</h2>
                <a href="katalog.php?promo=1" class="inline-block bg-[#FFD700] text-[#1a1a1a] px-8 py-3 font-black uppercase tracking-widest hover:bg-white transition-all shadow-[5px_5px_0px_0px_rgba(255,255,255,0.3)]">Lihat Semua Promo</a>
            </div>

            <div class="relative">
                <button id="prevBtn" class="absolute -left-5 top-1/2 -translate-y-1/2 z-30 bg-[#FFD700] text-[#1a1a1a] p-2 border-2 border-[#1a1a1a] shadow-[3px_3px_0px_0px_black]"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg></button>
                <button id="nextBtn" class="absolute -right-5 top-1/2 -translate-y-1/2 z-30 bg-[#FFD700] text-[#1a1a1a] p-2 border-2 border-[#1a1a1a] shadow-[3px_3px_0px_0px_black]"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></button>

                <div class="relative aspect-[3/4] overflow-hidden border-2 border-white">
                    <div id="slider" class="flex h-full" style="transform: translateX(-100%);">
                        <?php 
                        $first = $promo_items[0];
                        $last = end($promo_items);
                        ?>
                        <div class="min-w-full h-full relative"><img src="<?= getProductImage($last['image']); ?>" class="w-full h-full object-cover opacity-50"></div>
                        
                        <?php foreach ($promo_items as $item): ?>
                            <div class="min-w-full h-full relative">
                                <img src="<?= getProductImage($item['image']); ?>" class="w-full h-full object-cover">
                                <div class="absolute top-4 right-4 bg-red-600 text-white font-black px-4 py-1 rotate-12 shadow-[4px_4px_0px_0px_#1a1a1a]">SAVE <?= $item['discount_percent']; ?>%</div>
                                <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-black to-transparent">
                                    <p class="font-black text-[#FFD700] uppercase italic text-2xl leading-none"><?= htmlspecialchars($item['name']); ?></p>
                                    <p class="text-white font-black text-xl mt-1">Rp <?= number_format($item['new_price'], 0, ',', '.'); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <div class="min-w-full h-full relative"><img src="<?= getProductImage($first['image']); ?>" class="w-full h-full object-cover"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
</main>

<script>
    const slider = document.getElementById('slider');
    const totalSlides = <?= count($promo_items); ?>;
    let counter = 1;
    let isMoving = false;
    function move(anim = true) {
        slider.style.transition = anim ? "transform 0.5s cubic-bezier(0.77, 0, 0.175, 1)" : "none";
        slider.style.transform = `translateX(${-counter * 100}%)`;
    }
    document.getElementById('nextBtn').onclick = () => { if(!isMoving) { isMoving=true; counter++; move(); } };
    document.getElementById('prevBtn').onclick = () => { if(!isMoving) { isMoving=true; counter--; move(); } };
    slider.ontransitionend = () => {
        isMoving = false;
        if (counter > totalSlides) { counter = 1; move(false); }
        if (counter < 1) { counter = totalSlides; move(false); }
    };
    setInterval(() => { if(!isMoving && totalSlides > 0) { counter++; move(); } }, 4000);
</script>

<?php include 'includes/footer.php'; ?>