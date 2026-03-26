<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ApiReduce
{
    protected $baseUrl = 'https://api.yakoafricassur.com/enov';

    /**
     * 🔥 GET générique
     */
    public function get($endpoint, $params = [], $useCache = true, $ttl = 3600)
    {
        $url = $this->baseUrl . '/' . $endpoint;

        $cacheKey = 'api_' . md5($url . json_encode($params));

        if ($useCache) {
            return Cache::remember($cacheKey, $ttl, function () use ($url, $params) {
                return $this->callGet($url, $params);
            });
        }

        return $this->callGet($url, $params);
    }

    /**
     * 🔁 appel GET réel
     */
    protected function callGet($url, $params)
    {
        try {
            $response = Http::timeout(10)->get($url, $params);

            if ($response->successful()) {
                return $response->json();
            }

            return [
                'error' => true,
                'status' => $response->status(),
                'message' => 'Erreur API'
            ];

        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * 🔥 POST générique
     */
    public function post($endpoint, $data = [])
    {
        $url = $this->baseUrl . '/' . $endpoint;

        try {
            $response = Http::timeout(10)->post($url, $data);

            return $response->json();

        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }


}
