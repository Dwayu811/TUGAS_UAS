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

$batas = 12; 
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

$where = [];


if (!empty($_GET['search'])) {
    $search = mysqli_real_escape_string($db, $_GET['search']);
    $where[] = "products.name LIKE '%$search%'";
}


if (!empty($_GET['min'])) {
    $min = (int) $_GET['min'];
    $where[] = "(CASE WHEN products.new_price > 0 THEN products.new_price ELSE products.price END) >= $min";
}
if (!empty($_GET['max'])) {
    $max = (int) $_GET['max'];
    $where[] = "(CASE WHEN products.new_price > 0 THEN products.new_price ELSE products.price END) <= $max";
}


if (!empty($_GET['category'])) {
    $cat_id = (int)$_GET['category'];
    $where[] = "products.category_id = $cat_id";
}


if (isset($_GET['promo']) && $_GET['promo'] == '1') {
    $where[] = "products.is_promo = 1";
}

$base_sql = "SELECT products.*, categories.name AS category_name 
             FROM products 
             LEFT JOIN categories ON products.category_id = categories.id"; 

if ($where) {
    $base_sql .= " WHERE " . implode(" AND ", $where);
}


$query_total = mysqli_query($db, $base_sql);
$jumlah_data = mysqli_num_rows($query_total);
$total_halaman = ceil($jumlah_data / $batas);


$sql_limit = $base_sql . " ORDER BY products.id DESC LIMIT $halaman_awal, $batas";
$query = mysqli_query($db, $sql_limit);
$query_all_cat = mysqli_query($db, "SELECT * FROM categories ORDER BY name ASC");
?>
<main class="container mx-auto px-6 py-20 min-h-screen">
    
    <div class="mb-16">
        <h1 class="text-7xl font-black uppercase tracking-tighter italic">
             <span class="text-[#1a1a1a] drop-shadow-[2px_2px_0px_#FFD700]">Katalog.</span>
        </h1>
        <p class="font-bold text-gray-500 uppercase tracking-widest mt-2">
            Menemukan pemilik baru untuk setiap cerita lama.
        </p>
    </div>

    <form action="katalog.php" method="GET" 
          class="mb-8 grid grid-cols-1 md:grid-cols-4 gap-0 border-4 border-[#1a1a1a] shadow-[5px_5px_0px_0px_#1a1a1a]">
        
        <input type="text" name="search" placeholder="Cari Koleksi..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
               class="border-r-4 border-[#1a1a1a] p-5 font-bold uppercase text-xs focus:bg-[#FFD700] focus:outline-none transition-colors">
        
        <input type="number" name="min" placeholder="Harga Min (Rp)" value="<?= $_GET['min'] ?? '' ?>"
               class="border-r-4 border-[#1a1a1a] p-5 font-bold uppercase text-xs focus:bg-[#FFD700] focus:outline-none transition-colors">
        
        <input type="number" name="max" placeholder="Harga Max (Rp)" value="<?= $_GET['max'] ?? '' ?>"
               class="border-r-4 border-[#1a1a1a] p-5 font-bold uppercase text-xs focus:bg-[#FFD700] focus:outline-none transition-colors">
        
        <button type="submit" class="bg-[#1a1a1a] text-[#FFD700] font-black uppercase tracking-widest hover:bg-[#FFD700] hover:text-[#1a1a1a] transition-all py-5 md:py-0">
            Apply Filter
        </button>
    </form>
        
    <div class="flex flex-wrap gap-3 mb-16"> 
        <a href="katalog.php" 
           class="px-6 py-2 border-2 border-[#1a1a1a] font-black text-xs uppercase transition-all 
           <?= !isset($_GET['category']) ? 'bg-[#FFD700] text-black' : 'bg-white text-[#1a1a1a] hover:bg-gray-100' ?>">
            All Items
        </a>

        <?php while($cat = mysqli_fetch_assoc($query_all_cat)): ?>
            <a href="katalog.php?category=<?= $cat['id']; ?>" 
               class="px-6 py-2 border-2 border-[#1a1a1a] font-black text-xs uppercase transition-all 
               <?= (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'bg-[#FFD700] text-[#1a1a1a]' : 'bg-white text-[#1a1a1a] hover:bg-gray-100' ?>">
                <?= $cat['name']; ?>
            </a>
        <?php endwhile; ?>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
        <?php if (mysqli_num_rows($query) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($query)): ?>
                
                <a href="product.php?id=<?= $row['id']; ?>" 
                   class="group relative border-4 border-[#1a1a1a] bg-white hover:shadow-[12px_12px_0px_0px_#FFD700] transition-all duration-300 block">
                    
                    <?php if ($row['is_promo'] == 1 && $row['discount_percent'] > 0): ?>
                        <div class="absolute -top-3 -left-3 bg-red-600 text-white font-black px-3 py-1 z-20 shadow-[3px_3px_0px_0px_#000] rotate-[-5deg]">
                            SAVE <?= $row['discount_percent']; ?>%
                        </div>
                    <?php endif; ?>

                    <div class="aspect-square overflow-hidden border-b-4 border-[#1a1a1a] bg-gray-100">
                        <img src="<?= getProductImage($row['image']) ?>" 
                             alt="<?= htmlspecialchars($row['name']); ?>" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>

                    <div class="p-6">
                        <span class="text-[10px] font-black uppercase tracking-widest text-gray-400 border border-gray-200 px-2 py-0.5 mb-2 inline-block">
                            <?= $row['category_name'] ?? 'Uncategorized'; ?>
                        </span>

                        <h4 class="font-black uppercase text-sm mb-2 truncate group-hover:text-red-600 transition-colors">
                            <?= htmlspecialchars($row['name']); ?>
                        </h4>
                        
                        <div class="flex flex-col gap-1">
                            <p class="font-black text-[#1a1a1a] text-lg leading-none">
                                <?php 
                                    $harga_final = ($row['new_price'] > 0) ? $row['new_price'] : $row['price'];
                                    echo "Rp " . number_format($harga_final, 0, ',', '.'); 
                                ?>
                            </p>
                            
                            <?php if ($row['is_promo'] == 1 && $row['new_price'] > 0): ?>
                                <p class="font-bold text-gray-400 text-xs line-through italic">
                                    Rp <?= number_format($row['price'], 0, ',', '.'); ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <div class="bg-[#1a1a1a] text-white p-2 group-hover:bg-[#FFD700] group-hover:text-[#1a1a1a] transition-colors">
                                <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                            </div>
                        </div>
                    </div>
                </a>

            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-span-full py-20 text-center border-4 border-dashed border-gray-300">
                <i data-lucide="package-search" class="w-16 h-16 mx-auto text-gray-300 mb-4"></i>
                <p class="font-black uppercase text-gray-400 tracking-[0.3em]">Produk tidak ditemukan</p>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($total_halaman > 1): ?>
    <div class="mt-20 flex justify-center gap-2">
        <?php 
        $params = $_GET; 
        for($i=1; $i<=$total_halaman; $i++): 
            $params['halaman'] = $i;
            $url = "katalog.php?" . http_build_query($params);
        ?>
            <a href="<?= $url; ?>" 
               class="w-12 h-12 flex items-center justify-center border-4 border-[#1a1a1a] font-black transition-all
               <?= ($halaman == $i) ? 'bg-[#FFD700] shadow-none translate-x-1 translate-y-1' : 'bg-white shadow-[4px_4px_0px_0px_#1a1a1a] hover:bg-gray-100' ?>">
                <?= $i; ?>
            </a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>

</main>

<script>
    lucide.createIcons();
</script>

<?php include 'includes/footer.php'; ?>