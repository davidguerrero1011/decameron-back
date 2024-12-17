<?php

namespace Database\Seeders;

use App\Models\AcommodationType;
use Illuminate\Database\Seeder;

class AcommodationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $acommodations = ['Sencilla', 'Doble', 'Triple', 'Cuadruple'];
        foreach ($acommodations as $type) {
            AcommodationType::insert([
                'type_acommodation' => $type,
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s')
            ]);
        }
    }
}
