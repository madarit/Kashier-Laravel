<?php

namespace Madarit\LaravelKashier;

class KashierService
{
    private $config;
    private $mode;

    public function __construct()
    {
        $this->mode = config('kashier.mode');
        $this->config = config("kashier.{$this->mode}");
    }

    /**
     * Generate order hash for Kashier payment
     *
     * @param string $orderId
     * @param string $amount
     * @param string $currency
     * @param string|null $customerReference
     * @return string
     */
    public function generateOrderHash($orderId, $amount, $currency, $customerReference = null)
    {
        $mid = $this->config['mid'];
        $secret = $this->config['api_key'];
        
        $path = "/?payment={$mid}.{$orderId}.{$amount}.{$currency}";
        if ($customerReference) {
            $path .= ".{$customerReference}";
        }
        
        return hash_hmac('sha256', $path, $secret, false);
    }

    /**
     * Validate callback signature
     *
     * @param array $queryParams
     * @return bool
     */
    public function validateSignature($queryParams)
    {
        $queryString = '';
        $secret = $this->config['api_key'];
        
        foreach ($queryParams as $key => $value) {
            if ($key === 'signature' || $key === 'mode') {
                continue;
            }
            $queryString .= "&{$key}={$value}";
        }
        
        $queryString = ltrim($queryString, '&');
        $signature = hash_hmac('sha256', $queryString, $secret, false);
        
        return $signature === ($queryParams['signature'] ?? '');
    }

    /**
     * Generate Hosted Payment Page URL
     *
     * @param string $orderId
     * @param string $amount
     * @param string $currency
     * @param string $callbackUrl
     * @param string $allowedMethods
     * @return string
     */
    public function getHppUrl($orderId, $amount, $currency, $callbackUrl, $allowedMethods = 'card,wallet,bank_installments')
    {
        $hash = $this->generateOrderHash($orderId, $amount, $currency);
        $mid = $this->config['mid'];
        $baseUrl = $this->config['base_url'];
        $encodedCallback = urlencode($callbackUrl);
        
        return "{$baseUrl}?merchantId={$mid}&orderId={$orderId}&mode={$this->mode}" .
               "&amount={$amount}&currency={$currency}&hash={$hash}" .
               "&merchantRedirect={$encodedCallback}&allowedMethods={$allowedMethods}&display=en";
    }

    /**
     * Get current configuration
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Get current mode (test/live)
     *
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Get merchant ID
     *
     * @return string
     */
    public function getMid()
    {
        return $this->config['mid'];
    }

    /**
     * Get base URL
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->config['base_url'];
    }
}
