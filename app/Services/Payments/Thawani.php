<?php

namespace App\Services\Payments;

use Exception;
use Illuminate\Support\Facades\Http;

class Thawani
{

    const TEST_BASE_URL = 'https://uatcheckout.thawani.om/api/v1';
    const LIVE_BASE_URL = 'https://checkout.thawani.om/api/v1';

    protected $secretKey;

    protected $publishableKey;

    protected $baseUrl;

    protected $mode;

    public function __construct($secretKey, $publishableKey, $mode = 'test')
    {
        $this->mode = $mode;
        $this->secretKey = $secretKey;
        $this->publishableKey = $publishableKey;

        if ($mode == 'test') {
            $this->baseUrl = self::TEST_BASE_URL;
        } else {
            $this->baseUrl = self::LIVE_BASE_URL;
        }
    }

    public function createCheckoutSession($data)
    {
        $response = Http::baseUrl($this->baseUrl)
            ->withHeaders([
                'thawani-api-key' => $this->secretKey,
            ])
            ->asJson()
            ->post('checkout/session', $data);

        $body = $response->json();

        if ($body['success'] == true && $body['code'] == 2004) {
            return $body['data']['session_id'];
        }

        throw new Exception($body['description'], $body['code']);
    }

    public function getCheckoutSession($session_id)
    {
        $response = Http::baseUrl($this->baseUrl)
            ->withHeaders([
                'thawani-api-key' => $this->secretKey,
            ])
            ->get('checkout/session/' . $session_id)
            ->json();

        if ($response['success'] == true && $response['code'] == 2000) {
            return $response;
        }

        throw new Exception($response['description'], $response['code']);
    }

    public function getPayUrl($session_id)
    {
        if ($this->mode == 'test') {
            return "https://uatcheckout.thawani.om/pay/{$session_id}?key={$this->publishableKey}";
        }
        
        return "https://checkout.thawani.om/pay/{$session_id}?key={$this->publishableKey}";
    }

}