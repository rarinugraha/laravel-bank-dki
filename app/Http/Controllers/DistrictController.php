<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index(Request $request, $id)
    {
        $search = $request->input('search');

        $query = District::where('regency_id', $id);

        if ($search) {
            $query->whereRaw('LOWER(name) like ?', ['%' . strtolower($search) . '%']);
        }

        $collection = $query->get();

        if ($collection->isNotEmpty()) {
            return response()->json($collection, 200);
        }

        return response()->json(['message' => 'Kecamatan tidak ditemukan'], 200);
    }
}
