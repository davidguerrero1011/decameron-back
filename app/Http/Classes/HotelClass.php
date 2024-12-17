<?php

namespace App\Http\Classes\HotelClass;

use App\Models\Cities;
use App\Models\Hotels;

class HotelClass
{

    public function __construct() {}

    public function obtainData()
    {
        $hotels = Hotels::select('cities.city', 'hotels.*')->join('cities', 'hotels.city_id', 'cities.id')->where('cities.state', '1')->get();
        return response()->json($hotels);
    }

    public function getAllCities()
    {
        $cities = Cities::where('state', '1')->get();
        return response()->json($cities);
    }

    public function storeRegistersHotel($request) 
    {
        $response = [];
        $errors = [];

        if (empty($request->hotel)) {
            array_push($errors, "El nombre del hotel es obligatorio");
        }
        if (empty($request->address)) {
            array_push($errors, "La dirección del hotel es obligatoria");
        }
        if (empty($request->cityId)) {
            array_push($errors, "La ciudad del hotel es obligatoria");
        }
        if (empty($request->nit)) {
            array_push($errors, "El Nit del hotel es obligatorio");
        }
        if (empty($request->rooms)) {
            array_push($errors, "El número de cuartos del hotel es obligatorio");
        }

        if (count($errors) > 0) {
            
            $response["state"] = ["error"];
            $response["messages"] = $errors;
            return response()->json($response);

        }

        $hotelName = Hotels::where('name', 'LIKE', $request->name)->get();
        if (count($hotelName) > 0) {
            
            $response["state"] = ["error"];
            $response["messages"] = "El hotel ya fue creado por favor verifique";
            return response()->json($response);

        }

        $newHotel = new Hotels();
        $newHotel->name       = $request->name;
        $newHotel->address    = $request->address;
        $newHotel->city_id    = $request->cityId;
        $newHotel->nit_number = $request->nit;
        $newHotel->rooms      = $request->rooms;
        $newHotel->state      = $request->state;
        $newHotel->save();
        
        $response["state"] = ["success"];
        $response["messages"] = "El hotel fue almacenado exitosamente.";
        return response()->json($response);

    }
}
