<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $catTips = \App\Models\ArticleCategory::create(['name' => 'TIPS & TRIK', 'slug' => 'tips-trik']);
        $catPanduan = \App\Models\ArticleCategory::create(['name' => 'PANDUAN', 'slug' => 'panduan']);
        $catTren = \App\Models\ArticleCategory::create(['name' => 'TREN DESAIN', 'slug' => 'tren-desain']);

        \App\Models\Article::create([
            'article_category_id' => $catTips->id,
            'title' => 'Cara Tepat Merawat Jersey Printing Agar Warna Tetap Tajam Bertahun-tahun',
            'slug' => \Illuminate\Support\Str::slug('Cara Tepat Merawat Jersey Printing Agar Warna Tetap Tajam Bertahun-tahun'),
            'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDy_Hrgnduk01cZ3ltC5SfYSIhomKP-T04j7Egrzd0GY52dFgnn3w5DPF-46_LmC8LIH3BH4Knj53XySYqRXYU8bfbN7kVPUWBsIxrimBEzeXX4NpIkVvrLrajmFCUP8PEMVkL--jVtwen_2F_YMUrVXe3gQ6ogpfXLS0qafkEQF97kJqqbbl0lFmeRj2UwgHpyRep3JoT0rnPwZXoNworJXGM4KtxAzGa8KLJEj3gpIitbwMnrwxDCP9h7ZhAGxJjYHpzc57wsRxfd',
            'content' => '<p>Jersey printing memang terkenal awet, namun perawatan yang tepat sangat penting. Jangan gunakan mesin cuci dan deterjen keras.</p>',
            'is_published' => true,
            'published_at' => \Carbon\Carbon::parse('2024-10-12'),
        ]);

        \App\Models\Article::create([
            'article_category_id' => $catPanduan->id,
            'title' => 'Mengenal Jenis Bahan Jersey Olahraga: Mana yang Paling Cocok Untuk Tim Anda?',
            'slug' => \Illuminate\Support\Str::slug('Mengenal Jenis Bahan Jersey Olahraga: Mana yang Paling Cocok Untuk Tim Anda?'),
            'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC1X3gF5RHtBJEIi_2NQcZly2f5E9TeQ5o9mtOm19ghuV-NjyIl4jCvum85Dna_sycqkzFtd7PfGixm0YI1--1ErzT07d0QPmgQYtFEMjZ2PGX_YUSSdw5NBF-miTCzAyMdBOPTMJy6JUIEraq22NbFSGtXXNqsXOZXnto3BqSC_RkpM9cp8k_qHBZDXtaGm3cOqauIxBOyYctYPYKdZNwGWjIuC68NLdT9GC0eF1Tv7DxlrjCIRWcpb1qRLuvIMYhxZpsXegBVavL9',
            'content' => '<p>Dryfit Milano sangat cocok untuk sepakbola, sedangkan Benzema lebih cocok untuk olahraga indoor seperti bulutangkis atau voli.</p>',
            'is_published' => true,
            'published_at' => \Carbon\Carbon::parse('2024-10-05'),
        ]);

        \App\Models\Article::create([
            'article_category_id' => $catTren->id,
            'title' => '5 Tren Desain Jersey Futsal & Sepakbola yang Paling Diminati di Tahun 2024',
            'slug' => \Illuminate\Support\Str::slug('5 Tren Desain Jersey Futsal & Sepakbola yang Paling Diminati di Tahun 2024'),
            'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCVbKXuyKyMvkSx6IZiAJ3Yr5dg1oxgg_EVgOanImGLgBEG4m-XQ2GVSxGp-EFNmzZvu8hgWU9xCLCkLiZWDjiXMvX8nl_MBSrhLHL6su16fclp15Q5cqdwDk3x7iJ6ugwlKRDJ00m3hXmSaTSkXf0y0nXyLWUm5hXbly_k7g4rPufDlMT9DuErTcDgrj1jQHmF-cTz4dzEXcubwVFYvkiHZ5Qcpcp_RbbdikrRv1tURrXsSU9PLbl_3iWtbOB4NJn6cLVgny-rLNhJ',
            'content' => '<p>Desain klasik retro dengan sentuhan modern warna pastel sangat mendominasi tahun ini.</p>',
            'is_published' => true,
            'published_at' => \Carbon\Carbon::parse('2024-09-28'),
        ]);
    }
}
