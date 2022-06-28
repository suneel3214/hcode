<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipingAddress extends Model
{
    use HasFactory;

    protected $table = 'shiping_address';
    protected $guarded = [];
}
