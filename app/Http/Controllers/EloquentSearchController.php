<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NestedEloquentFilter;
use App\Models\Appointment;

class EloquentSearchController extends Controller
{

    public function index()
    {
        return view('eloquent-search');
    }

    public function search(Request $request)
    {
        $filters = $request->input('filters', []);
        $query = Appointment::query();
        $filtered = NestedEloquentFilter::apply($query, $filters);

        return response()->json($filtered->get(), 200);
    }
}
