<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;

class AIController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = OpenAI::client(config('app.openai_api_key'));
    }

    public function index()
    {
        return view('app');
    }

    public function analyze(Request $request)
{
    $material = $request->input('material');

    try {
        $response = $this->client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful assistant specializing in material science.'],
                ['role' => 'user', 'content' => "Analyze the material: $material. Provide information about its density, melting point, and tensile strength if possible."],
            ],
        ]);

        $analysis = $response->choices[0]->message->content;
    } catch (\Exception $e) {
        $analysis = "Error: " . $e->getMessage();
    }

    return response()->json([
        'material' => $material,
        'analysis' => $analysis
    ]);
}
}