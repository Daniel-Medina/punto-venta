<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Product::create([
            'name' => 'Laravel',
            'cost' => 200,
            'price' => 350,
            'barcode' => '2343435329',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 1,
            'image' => 'curso.png'
        ]);

        Product::create([
            'name' => 'Livewire',
            'cost' => 100,
            'price' => 250,
            'barcode' => '2343975329',
            'stock' => 100,
            'alerts' => 10,
            'category_id' => 1,
            'image' => 'curso.png'
        ]);

        Product::create([
            'name' => 'lorem',
            'cost' => 100,
            'price' => 250,
            'barcode' => '234567843',
            'stock' => 100,
            'alerts' => 10,
            'category_id' => 2,
            'image' => 'curso.png'
        ]);
    }
}
