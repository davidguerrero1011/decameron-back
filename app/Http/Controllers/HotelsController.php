<?php

namespace App\Http\Controllers;

use App\Interfaces\HotelInterface;
use App\Http\Classes\HotelClass;
use App\Models\AcommodationByRoomsTypes;
use App\Models\AcommodationType;
use App\Models\Cities;
use App\Models\Hotels;
use App\Models\RoomsConfiguration;
use App\Models\RoomsType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HotelsController extends Controller
{
    private $hotel;

    public function __construct()
    {
        // $this->hotel = new HotelClass();
    }


    /**
     * Display a listing of the resource.
     */
    public function obtein()
    {
        $hotels = Hotels::select('cities.city', 'hotels.*')->join('cities', 'hotels.city_id', 'cities.id')->where('cities.state', '1')->get();
        return response()->json($hotels);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getCities()
    {
        $cities = Cities::where('state', '1')->get();
        return response()->json($cities);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeHotels(Request $request)
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

        $hotelName = Hotels::where('name', 'LIKE', $request->hotel)->get();
        if (count($hotelName) > 0) {
            
            $response["state"] = ["error"];
            $response["messages"] = "El hotel ya fue creado por favor verifique";
            return response()->json($response);

        }

        $newHotel = new Hotels();
        $newHotel->name       = $request->hotel;
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


    public function activateHotels(Request $request) 
    {
        try {
            $activate = Hotels::find($request->id);
            $activate->state = '1';
            $activate->save();

            return response()->json([ ["state" => "success"], ["message" => "Hotel Activado de forma exitosa"] ]);
        } catch (Exception $e) {
            return response()->json([ ["state" => "error"], ["message" => "El Hotel no pude ser activado, por favor comunicarse con el administrador"] ]);
        }
    }
   

    /**
     * Display the specified resource.
     */
    public function getRooms(Request $request)
    {
        $hotel = Hotels::where('id', $request->id)->first();
        $configuration = RoomsConfiguration::all();
        $typeRooms = RoomsType::where('state', '1')->get();
        $acommodations = AcommodationType::where('state', '1')->get();

        $response = [];
        $response["hotel"]         = $hotel;
        $response["type"]          = $typeRooms;
        $response["acommodation"]  = $acommodations;
        $response["conf"]          = $configuration;

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function getAcommodations(Request $request)
    {   
        $acommodationRoom = AcommodationByRoomsTypes::join('acommodation_types', function($query) {
                                    $query->on('acommodation_by_rooms_types.acommodation_type_id', 'acommodation_types.id');
                            })
                            ->select('acommodation_types.type_acommodation', 'acommodation_types.id', 'acommodation_by_rooms_types.room_type_id', 'acommodation_by_rooms_types.acommodation_type_id')
                            ->where('room_type_id', $request->roomId)
                            ->where('acommodation_types.state', '1')
                            ->get();

        $response = [];
        $response["acommodations"] = $acommodationRoom; 
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function storeRoomsConf(Request $request)
    {
        $typeRooms = RoomsType::where('state', '1')->get();
        return response()->json($typeRooms);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function getRoomConf(Request $request)
    {
        $conf = RoomsConfiguration::join('hotels', function($query) {
                $query->on('rooms_configurations.hotel_id', 'hotels.id');
        })
        ->join('rooms_types', function($query) {
                $query->on('rooms_configurations.rooms_type_id', 'rooms_types.id');
        })
        ->join('acommodation_types', function($query) {
                $query->on('rooms_configurations.acommodation_type_id', 'acommodation_types.id');
        })
        ->select('rooms_configurations.*', 'hotels.name', 'hotels.rooms', 'acommodation_types.type_acommodation', 'rooms_types.type')
        ->where([ ['hotels.state', '1'], ['acommodation_types.state', '1'], ['rooms_types.state', '1'], ['hotels.id', $request->id] ])
        ->get();

        return response()->json($conf);

    }


    public function storeConfiguration(Request $request) 
    {

        $rooms = Hotels::where('state', '1')->get();
        $assign = RoomsConfiguration::where('hotel_id', $request->hotelId)->get();

        if ($request->room == 0 || $request->typeAcommodation == 0) {
            return response()->json(["status" => "warning", "message" => "El tipo de cuarto o el tipo de acomodación se recibio vacio, verifique!"]);
        }

        if ($rooms->count() == $assign->count()) {
            return response()->json(["status" => "warning", "message" => "Usted alcanzo el número maximo de cuartos para configurar!"]);
        } else {
            $confRoom = new RoomsConfiguration();
            $confRoom->rooms_number         = $request->roomConf;
            $confRoom->rooms_type_id        = $request->room;
            $confRoom->acommodation_type_id = $request->typeAcommodation;
            $confRoom->hotel_id             = $request->hotelId;
            $confRoom->created_at           = date('Y-m-d H:i:s');
            $confRoom->updated_at           = date('Y-m-d H:i:s');
            $confRoom->save();

            return response()->json(["status" => "success", "message" => "Cuarto No ". $request->roomConf ." fue configurado con su tipo y su acomodación!"]);

        }
    }


    public function getRoomConfiguration(Request $request)
    {
        $roomConfig = RoomsConfiguration::where('id', $request->id)->first();
        return response()->json($roomConfig); 
    }


    public function deleteRoomConfiguration($id)
    {
        try {
            RoomsConfiguration::where('id', $id)->delete();
            $response = ["status", "success"];
        } catch (Exception $e) {
            Log::info("Error: ". $e);
            $response = ["status", "error"];
        }
        return response()->json($response);
    }
}
