<?php

namespace Database\Seeders;

use App\Models\Cities;
use App\Models\Countries;
use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = ["Bogota", "Medellin", "Cali", "Manizales", "Pereira", "Barranquilla", "Cartagena", "Santa Marta", "San Andres", "Tolima", "Boyaca", "Pasto"];
        $country = Countries::where('country', 'Colombia')->get();
        foreach ($cities as $city) {
            Cities::insert([
                'city' => $city,
                'country_id' => $country[0]->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
