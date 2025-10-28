<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers'; // Change if your table name is different

    // protected $fillable = [
    //     'name',
    //     'email',
    //     'phone',
    //     'city',
    //     'state',
    //     'address',
    // ];
}
