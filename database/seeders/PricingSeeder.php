<?php

namespace Database\Seeders;

use App\Models\Pricing;
use Illuminate\Database\Seeder;

class PricingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pricing::create([
            'name' => 'Basic',
            'description' => 'Cocok untuk tim pemula atau acara sekali pakai.',
            'original_price' => 150000,
            'discounted_price' => 120000,
            'is_best_seller' => false,
            'features' => [
                ['name' => 'Bahan Dryfit Standard', 'included' => true],
                ['name' => 'Full Printing (Depan & Belakang)', 'included' => true],
                ['name' => 'Gratis Nama & Nomor Punggung', 'included' => true],
                ['name' => 'Desain Custom 100%', 'included' => false],
            ],
            'cta_text' => 'Pilih Paket Basic',
            'cta_link' => '#',
        ]);

        Pricing::create([
            'name' => 'Semi Pro',
            'description' => 'Kualitas andalan untuk tim amatir dan komunitas.',
            'original_price' => 200000,
            'discounted_price' => 160000,
            'is_best_seller' => true,
            'features' => [
                ['name' => 'Bahan Dryfit Premium (Milano/Benzema)', 'included' => true],
                ['name' => 'Full Printing Detail Tajam', 'included' => true],
                ['name' => 'Gratis Desain Custom 100%', 'included' => true],
                ['name' => 'Logo 3D / DTF Print', 'included' => true],
            ],
            'cta_text' => 'Pilih Paket Semi Pro',
            'cta_link' => '#',
        ]);

        Pricing::create([
            'name' => 'Professional',
            'description' => 'Spesifikasi tertinggi layaknya jersey pro player.',
            'original_price' => 280000,
            'discounted_price' => 220000,
            'is_best_seller' => false,
            'features' => [
                ['name' => 'Bahan Ultra-Breathable / Spandex Import', 'included' => true],
                ['name' => 'Cutting Pola Ergonomis', 'included' => true],
                ['name' => 'Logo Emblem TPU / Silicone', 'included' => true],
                ['name' => 'Prioritas Produksi (Fast Track)', 'included' => true],
            ],
            'cta_text' => 'Pilih Paket Professional',
            'cta_link' => '#',
        ]);
    }
}
