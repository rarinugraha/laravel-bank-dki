<?php

namespace App\Http\Controllers;

use App\Models\Village;
use Illuminate\Http\Request;

class VillageController extends Controller
{
    public function index(Request $request, $id)
    {
        $search = $request->input('search');

        $query = Village::where('district_id', $id);

        if ($search) {
            $query->whereRaw('LOWER(name) like ?', ['%' . strtolower($search) . '%']);
        }

        $collection = $query->get();

        if ($collection->isNotEmpty()) {
            return response()->json($collection, 200);
        }

        return response()->json(['message' => 'Kelurahan tidak ditemukan'], 200);
    }
}
