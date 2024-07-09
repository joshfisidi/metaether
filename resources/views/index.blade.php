<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AIController extends Controller
{
    public function index()
    {
        return view('ai.index');
    }

    public function analyze(Request $request)
    {
        // Simulated AI analysis
        $material = $request->input('material');
        $properties = [
            'Density' => rand(1, 20) . ' g/cm³',
            'Melting Point' => rand(500, 3000) . ' °C',
            'Tensile Strength' => rand(50, 1000) . ' MPa',
        ];

        return view('ai.results', compact('material', 'properties'));
    }
}