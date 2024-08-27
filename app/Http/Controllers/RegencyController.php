<?php

namespace App\Http\Controllers;

use App\Models\Regency;
use Illuminate\Http\Request;

class RegencyController extends Controller
{
    public function index(Request $request, $id)
    {
        $search = $request->input('search');

        $query = Regency::where('province_id', $id);

        if ($search) {
            $query->whereRaw('LOWER(name) like ?', ['%' . strtolower($search) . '%']);
        }

        $collection = $query->get();

        if ($collection->isNotEmpty()) {
            return response()->json($collection, 200);
        }

        return response()->json(['message' => 'Kabupaten/kota tidak ditemukan'], 200);
    }
}
