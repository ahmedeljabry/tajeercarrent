<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Admin\App\Services\GeminiService;

class AIController extends Controller
{
    public function generate(Request $request): JsonResponse
    {
        $request->validate([
            'prompt' => 'required|string|max:12000',
        ]);

        $system = 'You are a helpful assistant for an admin CMS. Respond with STRICT JSON that matches the responseSchema. No code fences, no comments.';

        try {
            $svc  = new GeminiService();
            $json = $svc->generateJsonForCar([ (string) $request->input('prompt') ], $system);
            return response()->json(['json' => $json]);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
