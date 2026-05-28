<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use App\Models\Menu;

class FooterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Settings
        Setting::updateOrCreate(['key' => 'footer_description'], ['value' => 'Produsen pakaian olahraga custom premium terpercaya di Indonesia. Berkomitmen menghadirkan jersey kualitas terbaik untuk mendukung performa maksimal tim Anda di lapangan.']);
        Setting::updateOrCreate(['key' => 'footer_menu_1_title'], ['value' => 'Produk Kami']);
        Setting::updateOrCreate(['key' => 'footer_menu_2_title'], ['value' => 'Informasi']);
        Setting::updateOrCreate(['key' => 'footer_contact_title'], ['value' => 'Hubungi Kami']);

        // Menu 1
        $menu1 = [
            ['label' => 'Jersey Sepakbola / Futsal', 'url' => '#'],
            ['label' => 'Jersey Basket', 'url' => '#'],
            ['label' => 'Jersey Esports', 'url' => '#'],
            ['label' => 'Jersey Sepeda', 'url' => '#'],
            ['label' => 'Tracksuit & Jaket Tim', 'url' => '#'],
        ];

        Menu::where('location', 'footer_1')->delete();
        foreach ($menu1 as $index => $item) {
            Menu::create([
                'location' => 'footer_1',
                'label' => $item['label'],
                'url' => $item['url'],
                'order' => $index + 1,
            ]);
        }

        // Menu 2
        $menu2 = [
            ['label' => 'Tentang Kami', 'url' => '#'],
            ['label' => 'FAQ (Pertanyaan Umum)', 'url' => '/faq'],
            ['label' => 'Cara Pemesanan', 'url' => '#'],
            ['label' => 'Syarat & Ketentuan', 'url' => '#'],
            ['label' => 'Kebijakan Privasi', 'url' => '#'],
            ['label' => 'Lacak Pesanan', 'url' => '#'],
        ];

        Menu::where('location', 'footer_2')->delete();
        foreach ($menu2 as $index => $item) {
            Menu::create([
                'location' => 'footer_2',
                'label' => $item['label'],
                'url' => $item['url'],
                'order' => $index + 1,
            ]);
        }

        // Contact Menu
        $contact = [
            ['icon' => 'location_on', 'label' => 'Jl. Olahraga No. 88, Sport District, Jakarta Pusat 10210, Indonesia', 'url' => '#'],
            ['icon' => 'phone', 'label' => '+62 812 3456 7890', 'url' => '#'],
            ['icon' => 'mail', 'label' => 'hello@amerygosport.com', 'url' => '#'],
        ];

        Menu::where('location', 'footer_contact')->delete();
        foreach ($contact as $index => $item) {
            Menu::create([
                'location' => 'footer_contact',
                'icon' => $item['icon'],
                'label' => $item['label'],
                'url' => $item['url'],
                'order' => $index + 1,
            ]);
        }
    }
}
