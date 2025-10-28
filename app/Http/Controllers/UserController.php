<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->city) {
            $query->where('city', $request->city);
        }

        if ($request->state) {
            $query->where('state', $request->state);
        }

        // Fetch data with filters applied
        $users = $query->paginate(10);

        // For dropdown filters (distinct values)
        $cities = Customer::select('city')->distinct()->pluck('city');
        $categories = Customer::select('category')->distinct()->pluck('category');
       /*  $states = Customer::select('state')->distinct()->pluck('state'); */

        return view('users.index', compact('users','categories', 'cities'));
    }
}
