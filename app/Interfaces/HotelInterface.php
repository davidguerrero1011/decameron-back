<?php
namespace App\Interfaces;

use Illuminate\Http\Client\Request;

interface HotelInterface
{
    public function obtein();
    public function getCities();
    public function storeHotels(Request $request);
    public function show();
    public function edit();
    public function update();
    public function destroy();
}
