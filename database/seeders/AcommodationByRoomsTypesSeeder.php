<?php

namespace Database\Seeders;

use App\Models\AcommodationByRoomsTypes;
use App\Models\AcommodationType;
use App\Models\RoomsType;
use Illuminate\Database\Seeder;

class AcommodationByRoomsTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roomsType = RoomsType::all();
        $accomodation = AcommodationType::all();

        foreach ($accomodation as $item) {
            if ($item->id == 1 || $item->id == 2) {
                $accommodation = new AcommodationByRoomsTypes();
                $accommodation->room_type_id         = $roomsType[0]->id;
                $accommodation->acommodation_type_id = $item->id;
                $accommodation->created_at           = date('Y-m-d H:i:s');
                $accommodation->updated_at           = date('Y-m-d H:i:s');
                $accommodation->save();
            }

            if ($item->id == 3 || $item->id == 4) {
                $accommodation = new AcommodationByRoomsTypes();
                $accommodation->room_type_id         = $roomsType[1]->id;
                $accommodation->acommodation_type_id = $item->id;
                $accommodation->created_at           = date('Y-m-d H:i:s');
                $accommodation->updated_at           = date('Y-m-d H:i:s');
                $accommodation->save();
            }

            if ($item->id == 1 || $item->id == 2 || $item->id == 3) {
                $accommodation = new AcommodationByRoomsTypes();
                $accommodation->room_type_id         = $roomsType[2]->id;
                $accommodation->acommodation_type_id = $item->id;
                $accommodation->created_at           = date('Y-m-d H:i:s');
                $accommodation->updated_at           = date('Y-m-d H:i:s');
                $accommodation->save();
            }
        }
    }
}
