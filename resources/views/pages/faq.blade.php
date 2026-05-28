@extends('layouts.app')

@section('content')
<main class="flex-grow pt-28 md:pt-32 pb-24">
    <div class="max-w-container-max mx-auto px-4 md:px-12">
        <!-- Hero -->
        <div class="text-center mb-16">
            <h1 class="font-headline-lg text-4xl md:text-5xl font-black italic text-on-surface leading-tight mb-4">Pertanyaan <span class="text-primary-container">Umum</span></h1>
            <p class="text-on-secondary-container max-w-2xl mx-auto">Temukan jawaban atas pertanyaan yang paling sering diajukan seputar produk, pemesanan, dan layanan AMERYGO.</p>
        </div>

        <!-- Category Pills -->
        <div class="flex gap-3 overflow-x-auto snap-x pb-4 mb-12 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:'none'] [scrollbar-width:'none']">
            <button class="faq-cat-btn px-5 py-2.5 rounded-full font-bold text-sm whitespace-nowrap transition-all duration-300 bg-primary-container text-background" data-cat="all">Semua</button>
            <button class="faq-cat-btn px-5 py-2.5 rounded-full font-bold text-sm whitespace-nowrap transition-all duration-300 bg-surface-container text-on-secondary-container border border-surface-container-highest hover:border-primary-container/50" data-cat="pemesanan">Pemesanan</button>
            <button class="faq-cat-btn px-5 py-2.5 rounded-full font-bold text-sm whitespace-nowrap transition-all duration-300 bg-surface-container text-on-secondary-container border border-surface-container-highest hover:border-primary-container/50" data-cat="produk">Produk & Bahan</button>
            <button class="faq-cat-btn px-5 py-2.5 rounded-full font-bold text-sm whitespace-nowrap transition-all duration-300 bg-surface-container text-on-secondary-container border border-surface-container-highest hover:border-primary-container/50" data-cat="desain">Desain</button>
            <button class="faq-cat-btn px-5 py-2.5 rounded-full font-bold text-sm whitespace-nowrap transition-all duration-300 bg-surface-container text-on-secondary-container border border-surface-container-highest hover:border-primary-container/50" data-cat="pengiriman">Pengiriman</button>
            <button class="faq-cat-btn px-5 py-2.5 rounded-full font-bold text-sm whitespace-nowrap transition-all duration-300 bg-surface-container text-on-secondary-container border border-surface-container-highest hover:border-primary-container/50" data-cat="pembayaran">Pembayaran</button>
        </div>

        <!-- FAQ Accordion -->
        <div class="max-w-3xl mx-auto space-y-4" id="faq-list">

            <!-- Pemesanan -->
            <div class="faq-item bg-surface-container border border-surface-container-highest rounded-2xl overflow-hidden shadow-lg hover:border-primary-container/30 transition-colors" data-cat="pemesanan">
                <button class="faq-toggle w-full flex items-center justify-between gap-4 p-6 md:p-8 text-left" aria-expanded="false">
                    <span class="font-headline-md font-bold text-lg">Berapa jumlah minimum pemesanan jersey?</span>
                    <span class="material-symbols-rounded faq-icon text-primary-container text-2xl shrink-0">expand_more</span>
                </button>
                <div class="faq-answer px-6 md:px-8">
                    <p class="text-on-secondary-container leading-relaxed pb-6 md:pb-8">Minimum order di AMERYGO adalah <strong class="text-on-surface">12 pcs</strong> per desain. Jumlah ini berlaku untuk semua paket, baik <em>Basic</em>, <em>Semi Pro</em>, maupun <em>Professional</em>. Semakin banyak jumlah pesanan, semakin besar diskon yang bisa Anda dapatkan.</p>
                </div>
            </div>

            <div class="faq-item bg-surface-container border border-surface-container-highest rounded-2xl overflow-hidden shadow-lg hover:border-primary-container/30 transition-colors" data-cat="pemesanan">
                <button class="faq-toggle w-full flex items-center justify-between gap-4 p-6 md:p-8 text-left" aria-expanded="false">
                    <span class="font-headline-md font-bold text-lg">Berapa lama proses pengerjaan jersey?</span>
                    <span class="material-symbols-rounded faq-icon text-primary-container text-2xl shrink-0">expand_more</span>
                </button>
                <div class="faq-answer px-6 md:px-8">
                    <p class="text-on-secondary-container leading-relaxed pb-6 md:pb-8">Estimasi waktu pengerjaan adalah <strong class="text-on-surface">7–14 hari kerja</strong> setelah desain final disetujui dan pembayaran diterima. Untuk paket <em>Professional</em> dengan opsi Fast Track, pengerjaan bisa selesai dalam <strong class="text-on-surface">5–7 hari kerja</strong>.</p>
                </div>
            </div>

            <div class="faq-item bg-surface-container border border-surface-container-highest rounded-2xl overflow-hidden shadow-lg hover:border-primary-container/30 transition-colors" data-cat="pemesanan">
                <button class="faq-toggle w-full flex items-center justify-between gap-4 p-6 md:p-8 text-left" aria-expanded="false">
                    <span class="font-headline-md font-bold text-lg">Bagaimana cara melakukan pemesanan?</span>
                    <span class="material-symbols-rounded faq-icon text-primary-container text-2xl shrink-0">expand_more</span>
                </button>
                <div class="faq-answer px-6 md:px-8">
                    <p class="text-on-secondary-container leading-relaxed pb-6 md:pb-8">Pemesanan bisa dilakukan melalui WhatsApp atau formulir di halaman <a href="{{ route('contact') }}" class="text-primary-container font-bold hover:underline">Kontak</a>. Langkahnya: (1) Konsultasikan desain dengan tim kami, (2) Setujui mockup desain, (3) Lakukan pembayaran, (4) Proses produksi dimulai, (5) Jersey dikirim ke alamat Anda.</p>
                </div>
            </div>

            <!-- Produk -->
            <div class="faq-item bg-surface-container border border-surface-container-highest rounded-2xl overflow-hidden shadow-lg hover:border-primary-container/30 transition-colors" data-cat="produk">
                <button class="faq-toggle w-full flex items-center justify-between gap-4 p-6 md:p-8 text-left" aria-expanded="false">
                    <span class="font-headline-md font-bold text-lg">Apa saja jenis bahan jersey yang tersedia?</span>
                    <span class="material-symbols-rounded faq-icon text-primary-container text-2xl shrink-0">expand_more</span>
                </button>
                <div class="faq-answer px-6 md:px-8">
                    <p class="text-on-secondary-container leading-relaxed pb-6 md:pb-8">Kami menyediakan beberapa pilihan bahan premium: <strong class="text-on-surface">Hyget Serena</strong> (paket Basic), <strong class="text-on-surface">Dryfit Milano / Benzema</strong> (paket Semi Pro), dan <strong class="text-on-surface">Ultra-Breathable / Spandex Import</strong> (paket Professional). Semua bahan memiliki daya serap keringat yang baik dan nyaman dipakai saat beraktivitas.</p>
                </div>
            </div>

            <div class="faq-item bg-surface-container border border-surface-container-highest rounded-2xl overflow-hidden shadow-lg hover:border-primary-container/30 transition-colors" data-cat="produk">
                <button class="faq-toggle w-full flex items-center justify-between gap-4 p-6 md:p-8 text-left" aria-expanded="false">
                    <span class="font-headline-md font-bold text-lg">Apakah warna jersey bisa sesuai dengan desain di layar?</span>
                    <span class="material-symbols-rounded faq-icon text-primary-container text-2xl shrink-0">expand_more</span>
                </button>
                <div class="faq-answer px-6 md:px-8">
                    <p class="text-on-secondary-container leading-relaxed pb-6 md:pb-8">Kami menggunakan teknologi <strong class="text-on-surface">sublimation printing</strong> berkualitas tinggi yang mampu menghasilkan warna dengan akurasi sangat baik. Namun, perbedaan warna minimal (±5%) bisa terjadi dikarenakan perbedaan kalibrasi antara layar monitor dan hasil cetak. Kami selalu mengirimkan preview mockup sebelum produksi dimulai.</p>
                </div>
            </div>

            <!-- Desain -->
            <div class="faq-item bg-surface-container border border-surface-container-highest rounded-2xl overflow-hidden shadow-lg hover:border-primary-container/30 transition-colors" data-cat="desain">
                <button class="faq-toggle w-full flex items-center justify-between gap-4 p-6 md:p-8 text-left" aria-expanded="false">
                    <span class="font-headline-md font-bold text-lg">Apakah bisa request desain custom?</span>
                    <span class="material-symbols-rounded faq-icon text-primary-container text-2xl shrink-0">expand_more</span>
                </button>
                <div class="faq-answer px-6 md:px-8">
                    <p class="text-on-secondary-container leading-relaxed pb-6 md:pb-8">Tentu saja! Semua paket kami sudah termasuk <strong class="text-on-surface">layanan desain custom gratis</strong>. Anda cukup memberikan referensi warna, logo, dan konsep yang diinginkan, lalu tim desainer kami yang akan membuatkan mockup-nya. Revisi desain juga tidak dibatasi hingga Anda benar-benar puas.</p>
                </div>
            </div>

            <div class="faq-item bg-surface-container border border-surface-container-highest rounded-2xl overflow-hidden shadow-lg hover:border-primary-container/30 transition-colors" data-cat="desain">
                <button class="faq-toggle w-full flex items-center justify-between gap-4 p-6 md:p-8 text-left" aria-expanded="false">
                    <span class="font-headline-md font-bold text-lg">Apakah bisa menggunakan desain sendiri?</span>
                    <span class="material-symbols-rounded faq-icon text-primary-container text-2xl shrink-0">expand_more</span>
                </button>
                <div class="faq-answer px-6 md:px-8">
                    <p class="text-on-secondary-container leading-relaxed pb-6 md:pb-8">Bisa! Jika Anda sudah memiliki file desain sendiri, silakan kirimkan dalam format <strong class="text-on-surface">AI, PSD, CDR, atau PNG resolusi tinggi</strong>. Tim kami akan melakukan pengecekan file dan menyesuaikannya dengan template pola jersey agar hasil cetaknya sempurna.</p>
                </div>
            </div>

            <!-- Pengiriman -->
            <div class="faq-item bg-surface-container border border-surface-container-highest rounded-2xl overflow-hidden shadow-lg hover:border-primary-container/30 transition-colors" data-cat="pengiriman">
                <button class="faq-toggle w-full flex items-center justify-between gap-4 p-6 md:p-8 text-left" aria-expanded="false">
                    <span class="font-headline-md font-bold text-lg">Apakah bisa dikirim ke seluruh Indonesia?</span>
                    <span class="material-symbols-rounded faq-icon text-primary-container text-2xl shrink-0">expand_more</span>
                </button>
                <div class="faq-answer px-6 md:px-8">
                    <p class="text-on-secondary-container leading-relaxed pb-6 md:pb-8">Ya, kami melayani pengiriman ke <strong class="text-on-surface">seluruh wilayah Indonesia</strong> melalui ekspedisi terpercaya seperti JNE, J&T, SiCepat, dan Anteraja. Ongkos kirim ditanggung oleh pembeli, namun untuk pemesanan di atas 50 pcs, kami memberikan <strong class="text-on-surface">subsidi ongkir</strong>.</p>
                </div>
            </div>

            <div class="faq-item bg-surface-container border border-surface-container-highest rounded-2xl overflow-hidden shadow-lg hover:border-primary-container/30 transition-colors" data-cat="pengiriman">
                <button class="faq-toggle w-full flex items-center justify-between gap-4 p-6 md:p-8 text-left" aria-expanded="false">
                    <span class="font-headline-md font-bold text-lg">Bagaimana jika jersey yang diterima cacat / tidak sesuai?</span>
                    <span class="material-symbols-rounded faq-icon text-primary-container text-2xl shrink-0">expand_more</span>
                </button>
                <div class="faq-answer px-6 md:px-8">
                    <p class="text-on-secondary-container leading-relaxed pb-6 md:pb-8">Kami memberikan <strong class="text-on-surface">garansi produksi 100%</strong>. Jika terdapat cacat produksi (jahitan rusak, salah cetak, ukuran tidak sesuai pesanan), kami akan mengganti jersey tersebut tanpa biaya tambahan. Klaim garansi bisa dilakukan dalam waktu 7 hari setelah barang diterima.</p>
                </div>
            </div>

            <!-- Pembayaran -->
            <div class="faq-item bg-surface-container border border-surface-container-highest rounded-2xl overflow-hidden shadow-lg hover:border-primary-container/30 transition-colors" data-cat="pembayaran">
                <button class="faq-toggle w-full flex items-center justify-between gap-4 p-6 md:p-8 text-left" aria-expanded="false">
                    <span class="font-headline-md font-bold text-lg">Metode pembayaran apa saja yang diterima?</span>
                    <span class="material-symbols-rounded faq-icon text-primary-container text-2xl shrink-0">expand_more</span>
                </button>
                <div class="faq-answer px-6 md:px-8">
                    <p class="text-on-secondary-container leading-relaxed pb-6 md:pb-8">Kami menerima pembayaran melalui <strong class="text-on-surface">Transfer Bank</strong> (BCA, Mandiri, BNI, BRI), <strong class="text-on-surface">e-Wallet</strong> (OVO, GoPay, DANA), dan <strong class="text-on-surface">Virtual Account</strong>. Untuk pesanan dalam jumlah besar, kami juga menyediakan opsi pembayaran bertahap (DP 50%).</p>
                </div>
            </div>

            <div class="faq-item bg-surface-container border border-surface-container-highest rounded-2xl overflow-hidden shadow-lg hover:border-primary-container/30 transition-colors" data-cat="pembayaran">
                <button class="faq-toggle w-full flex items-center justify-between gap-4 p-6 md:p-8 text-left" aria-expanded="false">
                    <span class="font-headline-md font-bold text-lg">Apakah bisa membayar dengan sistem DP?</span>
                    <span class="material-symbols-rounded faq-icon text-primary-container text-2xl shrink-0">expand_more</span>
                </button>
                <div class="faq-answer px-6 md:px-8">
                    <p class="text-on-secondary-container leading-relaxed pb-6 md:pb-8">Bisa! Sistem pembayaran kami mendukung <strong class="text-on-surface">DP 50%</strong> di awal untuk memulai proses produksi. Pelunasan sisa 50% dilakukan setelah jersey selesai diproduksi dan foto hasil jadi dikirimkan ke Anda untuk review, sebelum proses pengiriman.</p>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="mt-20 text-center bg-surface-container border border-surface-container-highest rounded-3xl p-10 md:p-16 max-w-3xl mx-auto shadow-xl">
            <span class="material-symbols-rounded text-5xl text-primary-container mb-4 block">help_center</span>
            <h2 class="font-headline-md font-bold text-2xl md:text-3xl mb-4">Masih Punya Pertanyaan?</h2>
            <p class="text-on-secondary-container mb-8 max-w-lg mx-auto">Jangan ragu untuk menghubungi tim kami. Kami dengan senang hati akan membantu menjawab semua pertanyaan Anda.</p>
            <a href="{{ route('contact') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-primary-container text-background font-bold rounded-full hover:bg-[#e65c00] active:scale-[0.98] transition-all duration-300 glow-primary">
                <span class="material-symbols-rounded">chat</span> Hubungi Kami
            </a>
        </div>
    </div>
</main>
@endsection
