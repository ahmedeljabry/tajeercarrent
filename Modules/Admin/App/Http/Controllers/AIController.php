<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AIController extends Controller
{
    public function generate(Request $request): JsonResponse
    {
        $request->validate([
            'prompt' => 'required|string|max:5000',
            'lang' => 'nullable|string',
        ]);

        $prompt = (string) $request->input('prompt');
        $lang = $request->input('lang');

        $system = 'You are a helpful assistant for an admin CMS. Respond with plain text only.';

        if ($lang) {
            $locales = (array) config('app.locales', []);
            $languageName = $locales[$lang] ?? $lang;
            $system .= ' Respond strictly in ' . $languageName . '.';
        }

        try {
            $service = new \Modules\Admin\App\Services\GeminiService();
            $text = $service->generateText($prompt, $system);
            return response()->json(['text' => $text]);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}

