<?php

namespace Database\Seeders;

use App\Models\RoomsType;
use Illuminate\Database\Seeder;

class RoomsTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['Estandar', 'Junior', 'Suite'];
        foreach ($types as $type) {
            RoomsType::insert([
                'type' => $type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
