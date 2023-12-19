<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::orderBy('id')->get();
        return response()->json($cars);
    }

    public function show(Car $car)
{
    return response()->json($car);
}

    public function store(Request $request, Car $car)
    {
        // Validate the form data
        $fields = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900',
            'rental_rate' => 'required|numeric|min:0',
        ]);

        $car = Car::create($fields);

        return response()->json(['status' => "OK", 'message' => 'Car with ID#' . $car->id . 'created successfully']);
    }


    public function update(Request $request, Car $car)
    {
        $fields = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900',
            'rental_rate' => 'required|numeric|min:0',
        ]);

        $car->update($fields);

        // Return JSON response
        return response()->json(['status' => "OK", 'message' => 'Car with ID#' . $car->id . 'updated successfully']);
    }

    public function destroy(Car $car)
    {
        $car->delete();

        // Return JSON response
        return response()->json(['status' => "OK", 'message' => 'Car ' .  $car->brand . 'deleted successfully']);
    }
}
