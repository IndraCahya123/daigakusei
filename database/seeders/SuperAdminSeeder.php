<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Indra Cahya Bali',
            'email' => 'indracahya51@gmail.com',
            'password' => bcrypt('indracahya')
        ])->assignRole('super-admin');
    }
}
