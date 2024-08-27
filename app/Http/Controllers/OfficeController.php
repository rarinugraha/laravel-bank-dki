<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Office::query()->where('id', '!=', 1);

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
