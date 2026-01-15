<?php
include 'config/database.php';
include 'includes/header.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$check_seller = mysqli_query($db, "SELECT id FROM sellers WHERE user_id = '$user_id'");
$seller_data = mysqli_fetch_assoc($check_seller);

if (!$seller_data) {

    $user_query = mysqli_query($db, "SELECT username FROM users WHERE id = '$user_id'");
    $u_data = mysqli_fetch_assoc($user_query);
    $seller_name = $u_data['username'] ?? 'User_' . $user_id;

  
    $insert_seller = mysqli_query($db, "INSERT INTO sellers (user_id, name) VALUES ('$user_id', '$seller_name')");
    
   
    if ($insert_seller) {
        $seller_id = mysqli_insert_id($db);
    } else {
    
        die("Gagal simpan seller: " . mysqli_error($db)); 
    }
} else {
    $seller_id = $seller_data['id'];
}

$query_kategori = mysqli_query($db, "SELECT * FROM categories ORDER BY name ASC");
?>

<main class="container mx-auto px-6 py-20 min-h-[75vh] flex flex-col justify-center">
    <div class="max-w-6xl mx-auto w-full">
        
        <div class="text-center mb-16">
            <h1 class="text-6xl md:text-8xl font-black italic uppercase tracking-tighter mb-4">
                List Your <span class="text-[#FFD700] drop-shadow-[4px_4px_0px_#1a1a1a]">Classic.</span>
            </h1>
            <p class="font-bold text-gray-400 uppercase tracking-[0.3em] text-[10px] md:text-xs">
                Berikan cerita baru untuk koleksi lamamu. Listing sebagai Seller #<?= $seller_id ?>
            </p>
        </div>

        <form action="proses_jual.php" method="POST" enctype="multipart/form-data" class="grid lg:grid-cols-2 gap-16">
            
            <div class="space-y-8">
                <div>
                    <label class="block font-black uppercase text-[10px] tracking-widest text-gray-500 mb-4 italic">01. Gambar Utama (Thumbnail)</label>
                    <div id="dropzone_utama" class="border-8 border-[#1a1a1a] bg-gray-50 hover:bg-[#FFD700]/5 transition-all relative aspect-square flex flex-col justify-center items-center overflow-hidden shadow-[15px_15px_0px_0px_#1a1a1a]">
                        <input type="file" name="gambar_utama" id="input_utama" class="absolute inset-0 opacity-0 cursor-pointer z-50" accept="image/*" required>
                        <div id="preview_utama" class="text-center p-4">
                            <i data-lucide="image-plus" class="w-20 h-20 mx-auto text-gray-200"></i>
                            <p class="font-black uppercase text-[10px] tracking-widest text-gray-400 mt-4">Tarik atau Klik untuk Upload</p>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block font-black uppercase text-[10px] tracking-widest text-gray-500 mb-4 italic">02. Detail Tambahan (Max 4)</label>
                    <div class="grid grid-cols-4 gap-4">
                        <input type="file" name="gambar_detail[]" id="input_detail" class="hidden" multiple accept="image/*">
                        
                        <div onclick="document.getElementById('input_detail').click()" class="cursor-pointer border-4 border-dashed border-gray-300 aspect-square flex flex-col items-center justify-center hover:border-black hover:bg-gray-50 transition-all group">
                            <i data-lucide="camera" class="w-6 h-6 text-gray-300 group-hover:text-black"></i>
                        </div>

                        <div id="preview_detail_container" class="contents"></div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="block font-black uppercase text-[10px] tracking-widest mb-2 text-gray-400 italic">03. Judul Listing</label>
                    <input type="text" name="nama_produk" placeholder="Contoh: Rare 1990 Levi's Trucker Jacket" required
                           class="w-full border-4 border-black p-5 font-black text-lg focus:outline-none focus:bg-[#FFD700]/10 transition-colors placeholder:text-gray-200">
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block font-black uppercase text-[10px] tracking-widest mb-2 text-gray-400 italic">04. Harga (IDR)</label>
                        <input type="number" name="harga" placeholder="500000" required
                               class="w-full border-4 border-black p-5 font-black text-lg focus:outline-none focus:bg-[#FFD700]/10 transition-colors">
                    </div>
                    <div>
                        <label class="block font-black uppercase text-[10px] tracking-widest mb-2 text-gray-400 italic">05. Kondisi</label>
                        <div class="relative">
                            <select name="kondisi" class="w-full border-4 border-black p-5 font-black text-sm appearance-none bg-white cursor-pointer focus:outline-none uppercase italic">
                                <option>Mint (Like New)</option>
                                <option>Excellent (Used)</option>
                                <option>Good (Vintage Condition)</option>
                                <option>Fair (Well Worn)</option>
                            </select>
                            <i data-lucide="chevron-down" class="absolute right-5 top-1/2 -translate-y-1/2 w-5 h-5 pointer-events-none"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block font-black uppercase text-[10px] tracking-widest mb-2 text-gray-400 italic">06. Kategori</label>
                    <div class="relative">
                        <select name="category_id" class="w-full border-4 border-black p-5 font-black text-sm appearance-none bg-white cursor-pointer focus:outline-none uppercase" required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            <?php while($cat = mysqli_fetch_assoc($query_kategori)): ?>
                                <option value="<?= $cat['id']; ?>"><?= htmlspecialchars($cat['name']); ?></option>
                            <?php endwhile; ?>
                        </select>
                        <i data-lucide="layers" class="absolute right-5 top-1/2 -translate-y-1/2 w-5 h-5 pointer-events-none"></i>
                    </div>
                </div>

                <div>
                    <label class="block font-black uppercase text-[10px] tracking-widest mb-2 text-gray-400 italic">07. Deskripsi & Dimensi</label>
                    <textarea name="deskripsi" rows="6" placeholder="Sebutkan ukuran (P x L) dan detail minus jika ada..." required
                              class="w-full border-4 border-black p-5 font-black text-sm focus:outline-none focus:bg-[#FFD700]/10 transition-colors resize-none"></textarea>
                </div>

                <button type="submit" name="submit"
                        class="w-full bg-black text-[#FFD700] py-8 font-black uppercase tracking-[0.4em] text-xl
                               hover:bg-[#FFD700] hover:text-black transition-all 
                               shadow-[12px_12px_0px_0px_#FFD700] hover:shadow-none hover:translate-x-2 hover:translate-y-2 border-4 border-black mt-4">
                    Publish Listing
                </button>
            </div>
        </form>
    </div>
</main>

<script>
    lucide.createIcons();

  
    const inputUtama = document.getElementById('input_utama');
    const previewUtama = document.getElementById('preview_utama');

    inputUtama.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewUtama.innerHTML = `
                    <img src="${e.target.result}" class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute top-6 left-6 bg-black text-[#FFD700] px-4 py-1 font-black text-[10px] uppercase border-2 border-[#FFD700]">Cover Image</div>
                `;
            }
            reader.readAsDataURL(file);
        }
    });

    const inputDetail = document.getElementById('input_detail');
    const previewDetailContainer = document.getElementById('preview_detail_container');

    inputDetail.addEventListener('change', function() {
        previewDetailContainer.innerHTML = ''; 
        const files = Array.from(this.files).slice(0, 4); 

        files.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const box = document.createElement('div');
                box.className = "aspect-square border-4 border-black relative overflow-hidden bg-white shadow-[4px_4px_0px_0px_#000]";
                box.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-full object-cover">
                    <div class="absolute bottom-0 right-0 bg-black text-white text-[8px] font-black px-2 py-0.5">${index + 1}</div>
                `;
                previewDetailContainer.appendChild(box);
            }
            reader.readAsDataURL(file);
        });
    });
</script>

<?php include 'includes/footer.php'; ?>