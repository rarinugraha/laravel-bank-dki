<?php

namespace App\Http\Controllers;

use App\Models\Occupation;
use Illuminate\Http\Request;

class OccupationController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Occupation::query();

        if ($search) {
            $query->whereRaw('LOWER(name) like ?', ['%' . strtolower($search) . '%']);
        }

        $occupations = $query->select('id', 'name')->get();

        if ($occupations->isNotEmpty()) {
            return response()->json($occupations, 200);
        }

        return response()->json(['message' => 'Kecamatan tidak ditemukan'], 200);
    }
}
