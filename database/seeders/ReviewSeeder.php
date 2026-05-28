<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Review::create([
            'name' => 'Raka Dimas',
            'role' => 'Kapten Garuda Futsal',
            'content' => 'Jersey dari AMERYGO benar-benar luar biasa! Detail warna printing sangat tajam dan bahannya adem. Bakal langganan terus nih buat tim kita.',
            'rating' => 5.0,
            'is_active' => true,
        ]);

        \App\Models\Review::create([
            'name' => 'Bima Anugrah',
            'role' => 'Manajer SSB Tunas',
            'content' => 'Pelayanan CS sangat ramah dan sabar merevisi desain. Jahitannya rapi dan ukurannya pas semua. Pengiriman juga sangat cepat dan aman.',
            'rating' => 5.0,
            'is_active' => true,
        ]);

        \App\Models\Review::create([
            'name' => 'Deni Ramdani',
            'role' => 'Corporate Sports Team',
            'content' => 'Kualitas logo 3D-nya gila sih, mewah banget kelihatannya! Untuk harga segini, kualitas yang didapat jauh di atas ekspektasi.',
            'rating' => 4.5,
            'is_active' => true,
        ]);

        \App\Models\Review::create([
            'name' => 'Siska Indah',
            'role' => 'Kapten Voli Putri',
            'content' => 'Sempat ragu pesan online tapi ternyata pengerjaannya presisi. Warna merah mudanya keluar banget sesuai desain asli! Puas banget!',
            'rating' => 5.0,
            'is_active' => true,
        ]);
    }
}
