<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'name' => 'Salman',
            'email' => 'salmanpatni92@gmail.com',
            'password' => 'password'
        ]);

        User::factory()->create([
            'name' => 'Saif',
            'email' => 'saif@gmail.com',
            'password' => 'password'
        ]);

        \App\Models\Category::factory()->create([
            'name' => 'Uncategorized'
        ]);

        PaymentMethod::create([
            'name' => 'Cash'
        ]);

        PaymentMethod::create([
            'name' => 'Credit/Debit Card'
        ]);

        \App\Models\Product::factory(10)->create();
    }
}
