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
        $this->apiKey            = (string) config('services.gemini.key');
        $this->model             = (string) config('services.gemini.model', 'gemini-2.5-flash');
        $this->endpoint          = rtrim((string) config('services.gemini.endpoint', 'https://generativelanguage.googleapis.com/v1beta'), '/');
        $this->defaultGeneration = (array) config('services.gemini.generation', []);

        if (empty($this->apiKey)) {
            throw new RuntimeException('Gemini API key is not configured. Set GEMINI_API_KEY in your environment.');
        }
    }

    public function generateJsonForCar(array $promptLines, ?string $systemInstruction = null): array
    {
        $payload = [
            'contents' => [[ 'parts' => [['text' => implode("\n", $promptLines)]] ]],
            'generationConfig' => array_merge($this->defaultGeneration, [
                'temperature'      => 0.2,
                'maxOutputTokens'  => (int) env('GEMINI_MAX_TOKENS', 8192),

                'responseMimeType' => 'application/json',
                'responseSchema'   => [
                    'type'       => 'OBJECT',
                    'properties' => [

                        'name_ar' => ['type' => 'STRING'],
                        'name_en' => ['type' => 'STRING'],
                        'name_ru' => ['type' => 'STRING'],

                        'description_ar' => ['type' => 'STRING'],
                        'description_en' => ['type' => 'STRING'],
                        'description_ru' => ['type' => 'STRING'],

                        'content_title_ar' => ['type' => 'STRING'],
                        'content_title_en' => ['type' => 'STRING'],
                        'content_title_ru' => ['type' => 'STRING'],
                        'content_description_ar' => ['type' => 'STRING'],
                        'content_description_en' => ['type' => 'STRING'],
                        'content_description_ru' => ['type' => 'STRING'],

                        'seo_meta_title_ar'  => ['type' => 'STRING'],
                        'seo_meta_title_en'  => ['type' => 'STRING'],
                        'seo_meta_title_ru'  => ['type' => 'STRING'],

                        'seo_description_ar' => ['type' => 'STRING'],
                        'seo_description_en' => ['type' => 'STRING'],
                        'seo_description_ru' => ['type' => 'STRING'],

                        'seo_keywords_ar' => ['type' => 'ARRAY', 'items' => ['type' => 'STRING']],
                        'seo_keywords_en' => ['type' => 'ARRAY', 'items' => ['type' => 'STRING']],
                        'seo_keywords_ru' => ['type' => 'ARRAY', 'items' => ['type' => 'STRING']],

                        'engine_capacity' => ['type' => 'STRING'],
                        'doors'           => ['type' => 'INTEGER'],
                        'bags'            => ['type' => 'INTEGER'],
                        'passengers'      => ['type' => 'INTEGER'],

                        'price_per_day'   => ['type' => 'NUMBER'],
                        'price_per_week'  => ['type' => 'NUMBER'],
                        'price_per_month' => ['type' => 'NUMBER'],
                        'km_per_day'      => ['type' => 'NUMBER'],
                        'km_per_week'     => ['type' => 'NUMBER'],
                        'km_per_month'    => ['type' => 'NUMBER'],

                        'price_per_hour'  => ['type' => 'NUMBER'],
                        'price_3_hours'   => ['type' => 'NUMBER'],
                        'price_8_hours'   => ['type' => 'NUMBER'],

                        'extra_price'          => ['type' => 'NUMBER'],
                        'minimum_day_booking'  => ['type' => 'NUMBER'],

                    ],
                    'required' => [
                        'name_en',
                        'passengers',
                        'extra_price',
                        'minimum_day_booking'
                    ],
                ],
            ]),
        ];

        if ($systemInstruction) {
            $payload['systemInstruction'] = [
                'role'  => 'system',
                'parts' => [['text' => $systemInstruction]],
            ];
        }

        $url = $this->endpoint.'/models/'.urlencode($this->model).':generateContent?key='.urlencode($this->apiKey);
        $response = Http::asJson()->acceptJson()->timeout(180)->post($url, $payload);

        if ($response->failed()) {
            $body = $response->json();
            $message = $body['error']['message'] ?? ('Gemini API request failed with status ' . $response->status());
            throw new RuntimeException($message);
        }

        $data   = $response->json();
        $finish = data_get($data, 'candidates.0.finishReason');

        if ($finish === 'MAX_TOKENS') {
            throw new RuntimeException('Gemini stopped early (MAX_TOKENS). Increase GEMINI_MAX_TOKENS or reduce requested content length.');
        }

        $raw = '';
        foreach ((array) data_get($data, 'candidates.0.content.parts', []) as $part) {
            if (isset($part['text'])) $raw .= $part['text'];
        }
        if ($raw === '') {
            $raw = (string) data_get($data, 'candidates.0.output_text', '');
        }
        if ($raw === '') {
            throw new RuntimeException('Empty JSON from Gemini.');
        }

        $json = json_decode($raw, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException('Gemini returned malformed JSON: ' . json_last_error_msg());
        }

        return $json;
    }
}
