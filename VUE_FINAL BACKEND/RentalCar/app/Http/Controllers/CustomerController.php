<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy('id')->get();
        return response()->json(['customers' => $customers]);
    }

    public function show(Customer $customer)
    {
        return response()->json($customer);
    }

    public function store(Request $request)
    {
        // Validate the form data
        $fields = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            // Add more fields as needed
        ]);

        $customer = Customer::create($fields);

        return response()->json(['status' => "OK", 'message' => 'Customer with ID#' . $customer->id . ' created successfully']);
    }

    public function update(Request $request, Customer $customer)
    {
        // Validate the form data
        $fields = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            // Add more fields as needed
        ]);

        $customer->update($fields);

        // Return JSON response
        return response()->json(['status' => "OK", 'message' => 'Customer with ID#' . $customer->id . ' updated successfully']);
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        // Return JSON response
        return response()->json(['status' => "OK", 'message' => 'Customer ' . $customer->first_name . ' deleted successfully']);
    }
}
