<?php

namespace Database\Seeders;

use App\Models\ArrayTest;
use Illuminate\Database\Seeder;

class ArraySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Testing' => [
                'name' => 'Indra',
                'role' => 'super-admin'
            ]
        ];

        ArrayTest::create([
            'data' => $data
        ]);
    }
}
