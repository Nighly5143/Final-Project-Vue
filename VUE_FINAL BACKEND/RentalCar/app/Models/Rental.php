<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = ['car_id', 'customer_id', 'rental_date', 'return_date', 'total_cost'];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public static function list(){
        return Rental::orderBy('id')->pluck('id', 'id');
    }
}
