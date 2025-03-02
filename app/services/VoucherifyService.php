<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class VoucherifyService
{
    protected $appId;
    protected $secretKey;
    protected $apiUrl;

    public function __construct()
    {
        $this->appId = config('services.voucherify.app_id');
        $this->secretKey = config('services.voucherify.secret_key');
        $this->apiUrl = config('services.voucherify.api_url');
    }

    public function createVoucher(array $data)
    {
        $response = Http::withHeaders([
            'X-App-Id' => $this->appId,
            'X-App-Token' => $this->secretKey,
        ])->post("{$this->apiUrl}/vouchers", $data);

        return $response->json();
    }

    public function getPerks()
{
    $response = Http::withBasicAuth($this->clientId, $this->clientSecret)
        ->get("{$this->apiUrl}/rewards"); // Check endpoint in Voucherify docs

    if ($response->successful()) {
        return $response->json();
    }

    \Log::error("Voucherify API error:", ['response' => $response->body()]);
    return null;
}

}
