<?php
include 'config/database.php';
include 'includes/header.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];


$user_query = mysqli_query($db, "SELECT * FROM users WHERE id = '$user_id'");
$user_data = mysqli_fetch_assoc($user_query);


$seller_check = mysqli_query($db, "SELECT id FROM sellers WHERE user_id = '$user_id'");
$seller_info = mysqli_fetch_assoc($seller_check);
$seller_id = $seller_info['id'] ?? 0;


$products_query = mysqli_query($db, "SELECT p.*, c.name as category_label 
                                    FROM products p 
                                    LEFT JOIN categories c ON p.category_id = c.id 
                                    WHERE p.seller_id = '$seller_id' 
                                    ORDER BY p.id DESC");


$orders_query = mysqli_query($db, "SELECT o.*, p.name as product_name, p.image 
                                    FROM orders o 
                                    LEFT JOIN products p ON o.product_id = p.id 
                                    WHERE o.buyer_id = '$user_id' 
                                    ORDER BY o.id DESC");


if (!$orders_query) {
    $orders_count = 0;
} else {
    $orders_count = mysqli_num_rows($orders_query);
}
?>

<main class="w-full min-h-screen bg-white">
    <div class="w-full bg-black text-white px-6 md:px-10 py-16 border-b-8 border-[#FFD700]">
        <div class="flex flex-col md:flex-row justify-between items-center gap-8 max-w-7xl mx-auto">
            <div class="flex items-center gap-8">
                <div class="w-24 h-24 md:w-32 md:h-32 border-4 border-[#FFD700] bg-gray-800 shrink-0 overflow-hidden shadow-[8px_8px_0px_0px_rgba(255,215,0,0.3)]">
                    <?php if(!empty($user_data['profile_image'])): ?>
                        <img src="uploads/profiles/<?= $user_data['profile_image'] ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center bg-[#1a1a1a]">
                            <i data-lucide="user" class="w-12 h-12 text-[#FFD700]"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <div>
                    <p class="text-[#FFD700] font-black uppercase tracking-[0.3em] text-[10px] mb-2">Member Profile</p>
                    <h1 class="text-5xl md:text-7xl font-black uppercase italic tracking-tighter leading-none">
                        <?= htmlspecialchars($user_data['username'] ?? 'User') ?>
                    </h1>
                </div>
            </div>
            <a href="jual_produk.php" class="bg-[#FFD700] text-black px-10 py-5 font-black uppercase italic tracking-widest text-sm hover:bg-white transition-all shadow-[6px_6px_0px_0px_rgba(255,255,255,0.2)] hover:shadow-none">
                List New Item
            </a>
        </div>
    </div>

    <div class="px-6 md:px-10 py-20 max-w-7xl mx-auto">
        <div class="grid lg:grid-cols-2 gap-20">
            
            <section>
                <div class="flex items-center gap-4 mb-10">
                    <span class="text-4xl font-black italic text-[#FFD700] drop-shadow-[2px_2px_0px_#000]">01</span>
                    <h2 class="text-4xl font-black uppercase tracking-tighter italic">My Listings</h2>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <?php if($products_query && mysqli_num_rows($products_query) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($products_query)): ?>
                            <div class="border-4 border-black p-4 hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all bg-white shadow-[8px_8px_0px_0px_#000] group">
                                <div class="aspect-square border-2 border-black overflow-hidden mb-4 bg-gray-100">
                                    <img src="uploads/products/<?= $row['image'] ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                                <h3 class="font-black uppercase text-sm truncate"><?= $row['name'] ?></h3>
                                <p class="font-black text-xl mt-1 italic text-black">Rp <?= number_format($row['price'], 0, ',', '.') ?></p>
                                
                                <div class="mt-4 flex justify-between items-center">
                                    <span class="text-[9px] font-black uppercase px-2 py-1 bg-black text-[#FFD700] italic">
                                        <?= $row['status'] ?? 'Active' ?>
                                    </span>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-span-2 border-4 border-dashed border-gray-200 py-16 text-center">
                            <i data-lucide="package-search" class="w-12 h-12 text-gray-200 mx-auto mb-4"></i>
                            <p class="font-black uppercase text-gray-300 italic text-sm">No items listed yet.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <section>
                <div class="flex items-center gap-4 mb-10">
                    <span class="text-4xl font-black italic text-[#FFD700] drop-shadow-[2px_2px_0px_#000]">02</span>
                    <h2 class="text-4xl font-black uppercase tracking-tighter italic">Purchase History</h2>
                </div>

                <div class="space-y-8">
                    <?php if($orders_count > 0): ?>
                        <?php while($order = mysqli_fetch_assoc($orders_query)): ?>
                            <div class="border-4 border-black bg-white p-6 relative shadow-[10px_10px_0px_0px_#f0f0f0]">
                                <div class="absolute -top-4 -right-2 bg-black text-[#FFD700] px-4 py-1 text-[10px] font-black uppercase tracking-widest shadow-[4px_4px_0px_0px_#FFD700] border-2 border-black">
                                    <?= $order['status'] ?>
                                </div>

                                <div class="flex gap-6">
                                    <div class="w-24 h-24 border-2 border-black shrink-0 overflow-hidden bg-gray-50 shadow-[4px_4px_0px_0px_#000]">
                                        <?php if(!empty($order['image'])): ?>
                                            <img src="uploads/products/<?= $order['image'] ?>" class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <div class="w-full h-full flex items-center justify-center text-[10px] font-bold text-gray-400">N/A</div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="w-full">
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">ORDER #<?= $order['id'] ?></p>
                                        <h3 class="font-black uppercase text-lg leading-tight mt-1"><?= $order['product_name'] ?? 'Product Deleted' ?></h3>
                                        <p class="font-black text-sm italic text-black/60 mt-1">Total: Rp <?= number_format($order['total_price'], 0, ',', '.') ?></p>
                                        
                                        <div class="mt-6">
                                            <div class="w-full h-3 border-2 border-black bg-gray-100 flex overflow-hidden">
                                                <div class="h-full bg-black border-r border-gray-600 w-1/4"></div>
                                                <div class="h-full bg-black border-r border-gray-600 <?= in_array($order['status'], ['Proses','Kirim','Selesai']) ? 'w-1/4' : 'w-0' ?>"></div>
                                                <div class="h-full bg-black border-r border-gray-600 <?= in_array($order['status'], ['Kirim','Selesai']) ? 'w-1/4' : 'w-0' ?>"></div>
                                                <div class="h-full bg-[#FFD700] <?= ($order['status'] == 'Selesai') ? 'w-1/4' : 'w-0' ?>"></div>
                                            </div>
                                            <div class="flex justify-between mt-2 text-[8px] font-black uppercase tracking-tighter italic">
                                                <span class="text-black">Pending</span>
                                                <span class="<?= in_array($order['status'], ['Proses','Kirim','Selesai']) ? 'text-black' : 'text-gray-300' ?>">Processing</span>
                                                <span class="<?= in_array($order['status'], ['Kirim','Selesai']) ? 'text-black' : 'text-gray-300' ?>">Shipped</span>
                                                <span class="<?= ($order['status'] == 'Selesai') ? 'text-black' : 'text-gray-300' ?>">Delivered</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="border-4 border-dashed border-gray-200 py-16 text-center">
                            <i data-lucide="shopping-bag" class="w-12 h-12 text-gray-200 mx-auto mb-4"></i>
                            <p class="font-black uppercase text-gray-300 italic text-sm">No purchases found.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </div>
</main>

<script>
    lucide.createIcons();
</script>

<?php include 'includes/footer.php'; ?>