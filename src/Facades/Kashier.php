<?php

namespace Madarit\LaravelKashier\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string generateOrderHash(string $orderId, string $amount, string $currency, string|null $customerReference = null)
 * @method static bool validateSignature(array $queryParams)
 * @method static string getHppUrl(string $orderId, string $amount, string $currency, string $callbackUrl, string $allowedMethods = 'card,wallet,bank_installments')
 * @method static array getConfig()
 * @method static string getMode()
 * @method static string getMid()
 * @method static string getBaseUrl()
 *
 * @see \Madarit\LaravelKashier\KashierService
 */
class Kashier extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'kashier';
    }
}
