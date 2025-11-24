# Laravel Kashier Payment Integration

A Laravel package for integrating Kashier payment gateway into your Laravel application with ease.

## Features

- ✅ Easy installation via Composer
- ✅ Auto-discovery for Laravel 5.5+
- ✅ Support for both test and live modes
- ✅ iFrame and Hosted Payment Page (HPP) integration
- ✅ Automatic signature validation
- ✅ Customizable views
- ✅ Facade support for easy access

## Requirements

- PHP 8.0 or higher
- Laravel 9.0, 10.0, or 11.0

## Installation

### 1. Install via Composer

```bash
composer require madarit/laravel-kashier
```

The package will automatically register itself via Laravel's package auto-discovery.

### 2. Publish Configuration

Publish the configuration file to customize settings:

```bash
php artisan vendor:publish --tag=kashier-config
```

This will create `config/kashier.php` in your application.

### 3. Publish Views (Optional)

If you want to customize the payment views:

```bash
php artisan vendor:publish --tag=kashier-views
```

Views will be published to `resources/views/vendor/kashier/`.

### 4. Configure Environment Variables

Add the following to your `.env` file:

```env
KASHIER_MODE=test
KASHIER_TEST_API_KEY=your-test-api-key
KASHIER_TEST_MID=your-test-mid
KASHIER_LIVE_API_KEY=
KASHIER_LIVE_MID=
```

Replace the test credentials with your actual Kashier credentials from your merchant dashboard.

## Usage

### Using the Facade

```php
use Madarit\LaravelKashier\Facades\Kashier;

// Generate order hash
$hash = Kashier::generateOrderHash($orderId, $amount, $currency);

// Get HPP URL
$hppUrl = Kashier::getHppUrl($orderId, $amount, $currency, $callbackUrl);

// Validate callback signature
$isValid = Kashier::validateSignature($request->all());

// Get configuration
$config = Kashier::getConfig();
$mode = Kashier::getMode();
$mid = Kashier::getMid();
```

### Using Dependency Injection

```php
use Madarit\LaravelKashier\KashierService;

class YourController extends Controller
{
    private $kashier;

    public function __construct(KashierService $kashier)
    {
        $this->kashier = $kashier;
    }

    public function processPayment()
    {
        $hash = $this->kashier->generateOrderHash('123', '100', 'EGP');
        // ...
    }
}
```

### Default Routes

The package automatically registers these routes:

- `GET /kashier/checkout` - Display checkout page
- `GET /kashier/iframe/callback` - iFrame payment callback
- `GET /kashier/hpp/callback` - Hosted Payment Page callback

### Accessing the Demo

After installation, visit:

```
http://your-app.test/kashier/checkout
```

### Test Cards

- **Success:** 5111 1111 1111 1118 - 06/28 - 100
- **Success 3D Secure:** 5123 4500 0000 0008 - 06/28 - 100
- **Failure:** 5111 1111 1111 1118 - 05/28 - 102

## Customization

### Custom Views

After publishing views, you can customize them in `resources/views/vendor/kashier/`:

- `payment/checkout.blade.php` - Checkout page
- `payment/success.blade.php` - Success page
- `payment/error.blade.php` - Error page

### Custom Controller

You can create your own controller and use the KashierService:

```php
use Madarit\LaravelKashier\KashierService;
use Illuminate\Http\Request;

class CustomPaymentController extends Controller
{
    public function initiatePayment(KashierService $kashier)
    {
        $orderId = uniqid('order_');
        $amount = '100.00';
        $currency = 'EGP';
        
        $hppUrl = $kashier->getHppUrl(
            $orderId, 
            $amount, 
            $currency, 
            route('payment.callback')
        );
        
        return redirect($hppUrl);
    }
    
    public function handleCallback(Request $request, KashierService $kashier)
    {
        if ($kashier->validateSignature($request->all())) {
            if ($request->get('paymentStatus') === 'SUCCESS') {
                // Handle successful payment
                return view('payment-success');
            }
        }
        
        return view('payment-failed');
    }
}
```

## Package Structure

```
laravel-kashier/
├── src/
│   ├── Http/
│   │   └── Controllers/
│   │       └── PaymentController.php
│   ├── Facades/
│   │   └── Kashier.php
│   ├── KashierService.php
│   └── KashierServiceProvider.php
├── config/
│   └── kashier.php
├── resources/
│   └── views/
│       └── payment/
│           ├── checkout.blade.php
│           ├── success.blade.php
│           └── error.blade.php
├── routes/
│   └── web.php
├── composer.json
└── README.md
```



## API Reference

### KashierService Methods

#### `generateOrderHash($orderId, $amount, $currency, $customerReference = null)`
Generate hash for order verification.

#### `validateSignature($queryParams)`
Validate callback signature for security.

#### `getHppUrl($orderId, $amount, $currency, $callbackUrl, $allowedMethods = 'card,wallet,bank_installments')`
Generate Hosted Payment Page URL.

#### `getConfig()`
Get current configuration (test/live).

#### `getMode()`
Get current mode (test/live).

#### `getMid()`
Get merchant ID.

#### `getBaseUrl()`
Get Kashier base URL.

## Payment Flow

### iFrame Payment
1. User visits `/payment/checkout`
2. Clicks the Kashier payment button
3. Payment popup opens on the same page
4. After payment, redirects to `/payment/iframe/callback`
5. Signature is validated
6. User sees success or error page

### Hosted Payment Page (HPP)
1. User visits `/payment/checkout`
2. Clicks "Pay with Hosted Payment Page" link
3. Redirected to Kashier's hosted page
4. After payment, redirected back to `/payment/hpp/callback`
5. Signature is validated
6. User sees success or error page

## Security

- All callbacks validate the signature using HMAC SHA256
- Never expose your API keys in frontend code
- Always validate signatures before processing payments
- Log failed signature validations for security monitoring

## Going Live

1. Obtain live credentials from Kashier merchant dashboard
2. Update `.env` file with live credentials
3. Change `KASHIER_MODE` to `live`
4. Test thoroughly before processing real payments

## Support

For issues or questions:
- Kashier Documentation: https://developers.kashier.io/
- Kashier Support: Contact through merchant dashboard

## About the Developer

This package is developed and maintained by **Madar IT** - a software development company specializing in creating robust and scalable solutions for businesses.

### Madar IT

**Madar IT** provides professional software development services with expertise in:
- Laravel & PHP Development
- Payment Gateway Integration
- API Development & Integration
- Enterprise Application Development
- Custom Software Solutions

We are committed to delivering high-quality, secure, and well-documented packages that make developers' lives easier.

### Connect With Us

- **GitHub:** [github.com/madarit](https://github.com/madarit)
- **Website:** Contact us for custom development and integration services

For package-related issues, please open an issue on the GitHub repository. For custom development or integration services, feel free to reach out directly.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
