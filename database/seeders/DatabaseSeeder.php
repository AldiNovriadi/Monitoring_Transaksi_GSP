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
        // \App\Models\User::factory(10)->create();
        User::create([
            "name" => 'Admin GSP',
            "email" => 'admin@gsp.co.id',
            "password" => bcrypt('password'),
            "role" => 'Admin',
        ]);

        User::create([
            "name" => 'Bank',
            "email" => 'bank@gsp.co.id',
            "password" => bcrypt('password'),
            "role" => 'Bank',
        ]);

        User::create([
            "name" => 'Mitra',
            "email" => 'mitra@gsp.co.id',
            "password" => bcrypt('password'),
            "role" => 'Mitra',
        ]);

        User::create([
            "name" => 'Bag Keuangan',
            "email" => 'accounting@gsp.co.id',
            "password" => bcrypt('password'),
            "role" => 'Accounting',
        ]);
    }
}
