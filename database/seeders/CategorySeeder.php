<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar kategori yang akan dibuat
        $categories = [
            'Teknologi & IT',
            'Bisnis & Marketing',
            'Desain & Seni',
            'Kesehatan',
            'Pendidikan',
            'Musik & Hiburan',
            'Olahraga',
            'Pengembangan Diri',
        ];

        // Looping untuk menyimpan ke database
        foreach ($categories as $categoryName) {
            Category::create([
                'name' => $categoryName,
            ]);
        }
    }
}