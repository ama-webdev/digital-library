<?php

namespace Database\Seeders;

use App\Models\BookCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Adventure stories',
            'Classics',
            'Crime',
            'Fairy tales',
            'Fables',
            'Folk tales',
            'Fantasy',
            'Historical fiction',
            'Horror',
            'Humour',
            'satire',
        ];

        foreach ($categories as $category) {
            BookCategory::create([
                'name' => $category
            ]);
        }
    }
}