<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CompanyPerksService
{
    protected $apiUrl;
    protected $clientId;
    protected $clientSecret;

    public function __construct()
    {
        $this->apiUrl = config('services.tango.api_url');
        $this->clientId = config('services.tango.client_id');
        $this->clientSecret = config('services.tango.client_secret');
    }

    /**
     * Fetch available perks from the third-party API.
     */
    public function getPerks()
    {
        $response = Http::withBasicAuth($this->clientId, $this->clientSecret)
            ->get("{$this->apiUrl}/rewards"); // This endpoint is hypothetical

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}
