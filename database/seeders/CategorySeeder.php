<?php

namespace Database\Seeders;

use App\Models\Category;
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
        //
        Category::create([
            'name' => 'Cursos',
            'image' => 'https://dummyimage.com/300x300/000d96/fff.jpg',
        ]);

        Category::create([
            'name' => 'Tenis',
            'image' => 'https://dummyimage.com/300x300/000d96/fff.jpg',
        ]);

        Category::create([
            'name' => 'Celulares',
            'image' => 'https://dummyimage.com/300x300/000d96/fff.jpg',
        ]);

        Category::create([
            'name' => 'Computadoras',
            'image' => 'https://dummyimage.com/300x300/000d96/fff.jpg',
        ]);
    }
}
