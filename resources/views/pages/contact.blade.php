@extends('layouts.app')

@section('content')
<main class="flex-grow pt-28 md:pt-32 pb-24">
    <div class="max-w-container-max mx-auto px-4 md:px-12">
        <h1 class="font-headline-lg text-4xl md:text-5xl font-black italic text-on-surface leading-tight mb-4 text-center">Hubungi <span class="text-primary-container">Kami</span></h1>
        <p class="text-on-secondary-container text-center mb-16 max-w-2xl mx-auto">Kami siap membantu Anda mewujudkan jersey impian tim Anda. Jangan ragu untuk menghubungi tim AMERYGO melalui formulir di bawah ini atau melalui kontak langsung.</p>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-24">
            <!-- Contact Info -->
            <div class="space-y-8">
                <div class="bg-surface-container p-8 rounded-2xl border border-surface-container-highest shadow-lg hover:shadow-primary-container/20 transition-all duration-300">
                    <div class="flex items-start gap-4 mb-6">
                        <span class="material-symbols-rounded text-primary-container text-3xl">location_on</span>
                        <div>
                            <h3 class="font-headline-md font-bold text-xl mb-2">Alamat</h3>
                            <p class="text-on-secondary-container leading-relaxed">Jl. Olahraga No. 88, Kebayoran Baru<br>Jakarta Selatan, 12190<br>Indonesia</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4 mb-6">
                        <span class="material-symbols-rounded text-primary-container text-3xl">mail</span>
                        <div>
                            <h3 class="font-headline-md font-bold text-xl mb-2">Email</h3>
                            <a href="mailto:halo@amerygo.id" class="text-on-secondary-container hover:text-primary-container transition-colors">halo@amerygo.id</a>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <span class="material-symbols-rounded text-primary-container text-3xl">phone</span>
                        <div>
                            <h3 class="font-headline-md font-bold text-xl mb-2">Telepon / WhatsApp</h3>
                            <a href="tel:+6281234567890" class="text-on-secondary-container hover:text-primary-container transition-colors font-medium">+62 812-3456-7890</a>
                        </div>
                    </div>
                </div>

                <!-- Maps Placeholder -->
                <div class="w-full aspect-video bg-surface-container-high rounded-2xl border border-surface-container-highest flex items-center justify-center flex-col text-on-secondary-container shadow-lg relative overflow-hidden group">
                    <div class="absolute inset-0 bg-pattern opacity-30"></div>
                    <span class="material-symbols-rounded text-5xl mb-2 opacity-70 group-hover:scale-110 group-hover:text-primary-container transition-all duration-300">map</span>
                    <span class="text-sm font-medium z-10">Peta Lokasi AMERYGO</span>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-surface-container p-8 md:p-10 rounded-2xl border border-surface-container-highest shadow-lg">
                <h2 class="font-headline-md font-bold text-2xl mb-8">Kirim Pesan</h2>
                <form class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-on-secondary-container mb-2" for="name">Nama Lengkap</label>
                            <input type="text" id="name" class="w-full bg-background border border-surface-container-highest rounded-lg px-4 py-3.5 text-on-surface focus:outline-none focus:border-primary-container focus:ring-1 focus:ring-primary-container transition-colors" placeholder="Masukkan nama Anda">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-on-secondary-container mb-2" for="email">Email</label>
                            <input type="email" id="email" class="w-full bg-background border border-surface-container-highest rounded-lg px-4 py-3.5 text-on-surface focus:outline-none focus:border-primary-container focus:ring-1 focus:ring-primary-container transition-colors" placeholder="Alamat email Anda">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-on-secondary-container mb-2" for="subject">Subjek</label>
                        <select id="subject" class="w-full bg-background border border-surface-container-highest rounded-lg px-4 py-3.5 text-on-surface focus:outline-none focus:border-primary-container focus:ring-1 focus:ring-primary-container transition-colors appearance-none">
                            <option value="" disabled selected>Pilih subjek pesan</option>
                            <option value="Tanya Produk">Pertanyaan Produk / Bahan</option>
                            <option value="Pesanan Custom">Pemesanan Jersey Custom</option>
                            <option value="Kerjasama">Kerjasama & Sponsorship</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-on-secondary-container mb-2" for="message">Pesan Anda</label>
                        <textarea id="message" rows="5" class="w-full bg-background border border-surface-container-highest rounded-lg px-4 py-3 text-on-surface focus:outline-none focus:border-primary-container focus:ring-1 focus:ring-primary-container transition-colors resize-none" placeholder="Tuliskan pertanyaan atau detail pesanan Anda secara lengkap di sini..."></textarea>
                    </div>
                    <button type="button" class="w-full py-4 mt-4 bg-primary-container text-background font-bold rounded-lg hover:bg-[#e65c00] active:scale-[0.98] transition-all duration-300 glow-primary flex items-center justify-center gap-3">
                        Kirim Pesan <span class="material-symbols-rounded">send</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
