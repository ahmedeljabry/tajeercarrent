<?php

namespace Modules\Admin\App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class GeminiService
{
    protected string $apiKey;
    protected string $model;
    protected string $endpoint;
    protected array $defaultGeneration;

    public function __construct()
    {
        $this->apiKey = (string) config('services.gemini.key');
        $this->model = (string) config('services.gemini.model', 'gemini-1.5-flash');
        $this->endpoint = rtrim((string) config('services.gemini.endpoint', 'https://generativelanguage.googleapis.com/v1beta'), '/');
        $this->defaultGeneration = (array) config('services.gemini.generation', []);

        if (empty($this->apiKey)) {
            throw new RuntimeException('Gemini API key is not configured. Set GEMINI_API_KEY in your environment.');
        }
    }

    /**
     * Generate plain text from a prompt using Gemini.
     *
     * @param string $prompt The user prompt to send.
     * @param string|null $systemInstruction Optional system guidance.
     * @param array $options Optional generation overrides (temperature, maxOutputTokens, etc.).
     * @return string The generated text.
     */
    public function generateText(string $prompt, ?string $systemInstruction = null, array $options = []): string
    {
        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt],
                    ],
                ],
            ],
            'generationConfig' => array_merge($this->defaultGeneration, $options),
        ];

        if ($systemInstruction) {
            $payload['systemInstruction'] = [
                'role' => 'system',
                'parts' => [ ['text' => $systemInstruction] ],
            ];
        }

        $url = $this->endpoint . '/models/' . urlencode($this->model) . ':generateContent?key=' . urlencode($this->apiKey);

        $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
            ->timeout(60)
            ->post($url, $payload);

        if ($response->failed()) {
            $body = $response->json();
            $message = $body['error']['message'] ?? ('Gemini API request failed with status ' . $response->status());
            throw new RuntimeException($message);
        }

        $data = $response->json();

        // Extract first candidate text
        $text = '';
        if (!empty($data['candidates'][0]['content']['parts'])) {
            foreach ($data['candidates'][0]['content']['parts'] as $part) {
                if (isset($part['text'])) {
                    $text .= $part['text'];
                }
            }
        }

        if ($text === '') {
            // Fallback to safety: sometimes the text may be under 'candidates[0][output_text]' or blocked
            $text = $data['candidates'][0]['output_text'] ?? '';
        }

        return trim((string) $text);
    }
}

