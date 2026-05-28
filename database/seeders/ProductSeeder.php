<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Sepakbola',
            'Futsal',
            'Esports',
            'Sepeda',
            'Kasual',
            'Accessories'
        ];

        $catMap = [];
        foreach ($categories as $cat) {
            $catMap[$cat] = ProductCategory::firstOrCreate([
                'slug' => Str::slug($cat)
            ], [
                'name' => $cat,
                'is_active' => true
            ]);
        }

        $products = [
            [
                'name' => 'Custom Jersey Printing',
                'category' => 'Kasual',
                'price' => 160000,
                'discount_price' => 120000,
                'description' => '<p>Jersey printing custom berkualitas tinggi. Nyaman dipakai untuk sehari-hari maupun berolahraga.</p>',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD8mhvzYy3I8f0EvV5sDrAMVgsYXO8uitB9mhg9sfxoJNR36R7rcw0j-fbldgpUrHho1eQ0r34ZZtjYL1AXqphbeWriXC0UvACZuZUKfkKOrnYtU09HkuwkSryR-BpLu5ic-Mb_pDz38xLw0nD1snTJb5g23oIuaNZNOBe2qKaoGaOvt_H_0qtWSHhLa9SzhL3gmRP0mmrYYMGCsoF4BSU4-5K3eoz9UY_OkExqs7WgGioKD4GO5xOly53AhWURSmgt6ktKSdqlDVAc'
            ],
            [
                'name' => 'Jersey Futsal & Soccer',
                'category' => 'Futsal',
                'price' => 160000,
                'discount_price' => 136000,
                'description' => '<p>Jersey futsal dan soccer seri pro. Bahan menyerap keringat dan sangat ringan.</p>',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCHSI26Ir0KULFTQ_uVlPRXTCNoqskDhpDAdnhEYkf4mQAvpOzDxuUXQC5b3CXno9xcKqJQN6Qd4xgGEfvcqFTUNfewXp8sX_dfBRf0F7eNu-w8KQWX-LGQgIeLuMp8b2VM3yIKcNsxjYwa57qxfTFF59P8jCMRy6y8o6_d9MtTN4k23LAyepnz-0RXxVoWr4pyPqI4CJDpW6ip1yQN2A6zvf8lJfR8hJZrxAXiPjlmQQH9QQw9AKPuR58pbC2u4kJu2Q9amm8WDMAq'
            ],
            [
                'name' => 'Jersey Esports Pro',
                'category' => 'Esports',
                'price' => 200000,
                'discount_price' => 150000,
                'description' => '<p>Jersey tim esports khusus didesain untuk kenyamanan gaming maraton Anda.</p>',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBoB5FGvmuV4jzstq84J7t_5GSsJS9rRQgHXY-H9P7Z_4Hzart9FDi8_Ld8YMx1PaS8ALnMXcmL7JupfheWwr0q1oNWBj-rSOg_DQxDRiPHHekp7EvdbONPyZf9mlW5X1Y_HmAclRvhEgQgMMxzovHLwg_jty0TamDpEZvyQ8vTXmoE_R1aqKHPkZINdEBYyTcHDpBUJWVBHwaBf6_QuYLPP__PTV4vkYY0mb7munYgTwhM5_9-AqEV4jkxW6kBD67l-wlhsnrwyrVs'
            ],
            [
                'name' => 'Cycling Jersey Elite',
                'category' => 'Sepeda',
                'price' => 240000,
                'discount_price' => 180000,
                'description' => '<p>Jersey sepeda elit aero fit untuk meningkatkan performa bersepeda Anda ke tingkat selanjutnya.</p>',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBGQTEQbZzXjQJFtR55LY3iSuXfWO6HPxLAVF7XIdEba3hJozYFdu7DN63R8E8Io1VihRzIQfZOO2hBbVfxtZH2wekwdYv3jtptFspRm54HxCrHNWfXzVAjpGb4y0cKlbNQYJMpd-RnJ67uKG8pIxPeg_HXGxnYRIlZGj1yEYykBY8EjFSZ76D0oVkBiUYF3ZwVp-VzCMwEJaqLF7YQSQDpClMB2eo39f0ivgk_J0fXlxOgdOGcDPGSSAwWL4faExLwg-yjMVd1Qmca'
            ],
            [
                'name' => 'Casual Sport Tee',
                'category' => 'Kasual',
                'price' => 100000,
                'discount_price' => null,
                'description' => '<p>Kaos olahraga kasual bergaya streetwear.</p>',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD8mhvzYy3I8f0EvV5sDrAMVgsYXO8uitB9mhg9sfxoJNR36R7rcw0j-fbldgpUrHho1eQ0r34ZZtjYL1AXqphbeWriXC0UvACZuZUKfkKOrnYtU09HkuwkSryR-BpLu5ic-Mb_pDz38xLw0nD1snTJb5g23oIuaNZNOBe2qKaoGaOvt_H_0qtWSHhLa9SzhL3gmRP0mmrYYMGCsoF4BSU4-5K3eoz9UY_OkExqs7WgGioKD4GO5xOly53AhWURSmgt6ktKSdqlDVAc'
            ],
            [
                'name' => 'Team Training Bibs',
                'category' => 'Accessories',
                'price' => 450000, // typo in my previous note? It was 45.000 in HTML
                'discount_price' => null,
                'description' => '<p>Rompi latihan untuk tim.</p>',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCHSI26Ir0KULFTQ_uVlPRXTCNoqskDhpDAdnhEYkf4mQAvpOzDxuUXQC5b3CXno9xcKqJQN6Qd4xgGEfvcqFTUNfewXp8sX_dfBRf0F7eNu-w8KQWX-LGQgIeLuMp8b2VM3yIKcNsxjYwa57qxfTFF59P8jCMRy6y8o6_d9MtTN4k23LAyepnz-0RXxVoWr4pyPqI4CJDpW6ip1yQN2A6zvf8lJfR8hJZrxAXiPjlmQQH9QQw9AKPuR58pbC2u4kJu2Q9amm8WDMAq'
            ]
        ];

        // fix 45k
        $products[5]['price'] = 45000;

        foreach ($products as $p) {
            $product = Product::firstOrCreate([
                'slug' => Str::slug($p['name'])
            ], [
                'name' => $p['name'],
                'product_category_id' => $catMap[$p['category']]->id,
                'description' => $p['description'],
                'price' => $p['price'],
                'discount_price' => $p['discount_price'],
                'is_active' => true,
                'is_featured' => true // mark all as featured to show on home
            ]);

            if ($product->wasRecentlyCreated || $product->images()->count() == 0) {
                ProductImage::firstOrCreate([
                    'product_id' => $product->id,
                    'image_path' => $p['image'],
                    'sort_order' => 0
                ]);
            }
        }

        // Tambahkan beberapa gambar ekstra untuk produk pertama sebagai contoh
        $firstProduct = Product::where('name', 'Custom Jersey Printing')->first();
        if ($firstProduct && $firstProduct->images()->count() == 1) {
            ProductImage::create([
                'product_id' => $firstProduct->id,
                'image_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCHSI26Ir0KULFTQ_uVlPRXTCNoqskDhpDAdnhEYkf4mQAvpOzDxuUXQC5b3CXno9xcKqJQN6Qd4xgGEfvcqFTUNfewXp8sX_dfBRf0F7eNu-w8KQWX-LGQgIeLuMp8b2VM3yIKcNsxjYwa57qxfTFF59P8jCMRy6y8o6_d9MtTN4k23LAyepnz-0RXxVoWr4pyPqI4CJDpW6ip1yQN2A6zvf8lJfR8hJZrxAXiPjlmQQH9QQw9AKPuR58pbC2u4kJu2Q9amm8WDMAq',
                'sort_order' => 1
            ]);
            ProductImage::create([
                'product_id' => $firstProduct->id,
                'image_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBoB5FGvmuV4jzstq84J7t_5GSsJS9rRQgHXY-H9P7Z_4Hzart9FDi8_Ld8YMx1PaS8ALnMXcmL7JupfheWwr0q1oNWBj-rSOg_DQxDRiPHHekp7EvdbONPyZf9mlW5X1Y_HmAclRvhEgQgMMxzovHLwg_jty0TamDpEZvyQ8vTXmoE_R1aqKHPkZINdEBYyTcHDpBUJWVBHwaBf6_QuYLPP__PTV4vkYY0mb7munYgTwhM5_9-AqEV4jkxW6kBD67l-wlhsnrwyrVs',
                'sort_order' => 2
            ]);
            ProductImage::create([
                'product_id' => $firstProduct->id,
                'image_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBGQTEQbZzXjQJFtR55LY3iSuXfWO6HPxLAVF7XIdEba3hJozYFdu7DN63R8E8Io1VihRzIQfZOO2hBbVfxtZH2wekwdYv3jtptFspRm54HxCrHNWfXzVAjpGb4y0cKlbNQYJMpd-RnJ67uKG8pIxPeg_HXGxnYRIlZGj1yEYykBY8EjFSZ76D0oVkBiUYF3ZwVp-VzCMwEJaqLF7YQSQDpClMB2eo39f0ivgk_J0fXlxOgdOGcDPGSSAwWL4faExLwg-yjMVd1Qmca',
                'sort_order' => 3
            ]);
        }
    }
}
