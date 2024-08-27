<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Province::query();

        if ($search) {
            $query->whereRaw('LOWER(name) like ?', ['%' . strtolower($search) . '%']);
        }

        $collection = $query->select('id', 'name')->get();

        if ($collection->isNotEmpty()) {
            return response()->json($collection, 200);
        }

        return response()->json(['message' => 'Provinsi tidak ditemukan'], 200);
    }
}
