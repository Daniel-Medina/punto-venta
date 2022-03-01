<?php

namespace Database\Seeders;


use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(5)->create();

        User::create([
            'name' => 'Danny',
            'email' => 'danny_2003@ovi.com',
            'password' => bcrypt('password'),
            'profile' => 'ADMIN',
            'image' => 'iconos/60f982ce8afdf08_.jpg',
        ]);

        /* User::create([
            'name' => 'Lorem',
            'phone' => '9911002233',
            'email' => 'danny_2002@ovi.com',
            'password' => bcrypt('password'),
            'profile' => 'EMPLEADO',
        ]); */

        $this->call([
            DenominationSeeder::class,
            //CategorySeeder::class,
            //ProductSeeder::class,
        ]);

    }
}
