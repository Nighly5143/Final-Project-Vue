<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Car;
use App\Models\Customer;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with(['car', 'customer'])->orderBy('id')->get();
        return response()->json(['rentals' => $rentals]);
    }

    public function show(Rental $rental)
    {
        return response()->json($rental);
    }

    public function store(Request $request, Car $car)
    {
        // Validate the form data
        $fields = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'customer_id' => 'required|exists:customers,id',
            'rental_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:rental_date',
            'total_cost' => 'required|numeric|min:0',
            // Add more fields as needed
        ]);

        $rental = Rental::create($fields);

        return response()->json(['status' => "OK", 'message' => 'Rental with ID#' . $rental->id . ' created successfully']);
    }

    public function update(Request $request, Rental $rental)
    {
        $fields = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'customer_id' => 'required|exists:customers,id',
            'rental_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:rental_date',
            'total_cost' => 'required|numeric|min:0',
            // Add more fields as needed
        ]);

        $rental->update($fields);

        // Return JSON response
        return response()->json(['status' => "OK", 'message' => 'Rental with ID#' . $rental->id . ' updated successfully']);
    }

    public function destroy(Rental $rental)
    {
        $rental->delete();

        // Return JSON response
        return response()->json(['status' => "OK", 'message' => 'Rental ' . $rental->id . ' deleted successfully']);
    }
}
