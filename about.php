<?php
include 'config/database.php';
include 'includes/header.php'; 
?>

<div class="fixed inset-0 pointer-events-none -z-10 overflow-hidden bg-white">
    <div class="absolute inset-0 opacity-[0.05]" style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>
    <div class="absolute top-[-10%] right-[-5%] w-[600px] h-[600px] bg-[#FFD700] rounded-full blur-[150px] opacity-10"></div>
    <div class="absolute inset-0" style="background-image: radial-gradient(#1a1a1a 1px, transparent 1px); background-size: 50px 50px; opacity: 0.05;"></div>
</div>

<main class="container mx-auto px-6 py-20">
    
    <div class="flex flex-col md:flex-row gap-16 items-center mb-32">
        <div class="md:w-1/2">
            <h1 class="text-7xl md:text-9xl font-black italic text-[#1a1a1a] leading-[0.8] tracking-tighter uppercase mb-8">
                Old <br> <span class="text-[#FFD700] drop-shadow-[4px_4px_0px_#1a1a1a]">Soul</span> <br> New Story.
            </h1>
            <p class="text-xl font-bold text-gray-700 leading-relaxed max-w-md">
                Kami tidak hanya menjual barang bekas. <br> Kami menyajikan potongan sejarah untuk kamu bawa pulang.
            </p>
        </div>
        
        <div class="md:w-1/2 relative">
            <div class="absolute inset-0 border-8 border-[#1a1a1a] translate-x-6 translate-y-6 -z-10"></div>
            <div class="aspect-[4/5] overflow-hidden border-4 border-[#1a1a1a] bg-gray-200">
                <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=2070&auto=format&fit=crop" 
                     alt="Vintage Story" 
                     class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-1000">
            </div>
        </div>
    </div>

    <div class="bg-[#1a1a1a] text-white p-12 md:p-24 mb-32 relative overflow-hidden shadow-[20px_20px_0px_0px_#FFD700]">
        <div class="relative z-10 grid md:grid-cols-2 gap-16">
            <div>
                <h2 class="text-[#FFD700] text-4xl font-black italic uppercase mb-6 tracking-tighter">Manifesto Kami</h2>
                <div class="h-2 w-32 bg-[#FFD700] mb-10"></div>
            </div>
            <div class="space-y-6 text-lg text-white-300 font-serif italic">
                <p>"Setiap goresan pada jam tangan tua, atau pudarnya warna pada pakaian adalah bukti bahwa benda tersebut telah 'hidup'."</p>
                <p>Di <span class="text-white font-bold tracking-widest uppercase">Vintage Store</span>, misi kami sederhana: Menyelamatkan benda-benda berkualitas dari masa lalu agar tidak berakhir jadi sampah, dan memberikannya panggung baru di tanganmu.</p>
                <p>Kualitas adalah harga mati. Karakter adalah nilai tambah.</p>
            </div>
        </div>          
        <div class="absolute -bottom-10 -right-2 text-[15vw] font-black opacity-5 select-none pointer-events-none">VINTAGE</div>
    </div>

    <div class="grid md:grid-cols-3 gap-8 mb-32">
            <div class="p-10 border-4 border-[#1a1a1a] bg-white hover:bg-[#FFD700] transition-all group shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1">
                <i data-lucide="shield-check" class="w-12 h-12 mb-6 group-hover:scale-110 transition-transform"></i>
                <h3 class="text-2xl font-black uppercase mb-4 tracking-tighter">100% Original</h3>
                <p class="font-bold text-sm text-gray-600 uppercase leading-relaxed">Kami benci barang palsu. Semua koleksi kami melewati proses yang ketat untuk menjamin keasliannya.</p>
            </div>

            <div class="p-10 border-4 border-[#1a1a1a] bg-white hover:bg-[#FFD700] transition-all group shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1">
                <i data-lucide="package" class="w-12 h-12 mb-6 group-hover:scale-110 transition-transform"></i>
                <h3 class="text-2xl font-black uppercase mb-4 tracking-tighter">Packaging Aman</h3>
                <p class="font-bold text-sm text-gray-600 uppercase leading-relaxed">Barang bersejarah butuh perlindungan ekstra. Kami menggunakan kemasan ramah lingkungan yang aman.</p>
            </div>

            <div class="p-10 border-4 border-[#1a1a1a] bg-white hover:bg-[#FFD700] transition-all group shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1">
                <i data-lucide="history" class="w-12 h-12 mb-6 group-hover:scale-110 transition-transform"></i>
                <h3 class="text-2xl font-black uppercase mb-4 tracking-tighter">Rare Items</h3>
                <p class="font-bold text-sm text-gray-600 uppercase leading-relaxed">Barang yang kamu beli di sini mungkin tidak akan pernah kamu temukan lagi di tempat lain.</p>
            </div>
    </div>
</main>         
<?php include 'includes/footer.php'; 