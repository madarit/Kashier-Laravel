# Laravel Kashier Payment Integration

This folder contains all the files needed to integrate Kashier payment gateway into your Laravel project.

## Installation Steps

### 1. Copy Configuration File
Copy `config/kashier.php` to your Laravel project's `config/` directory:
```bash
cp config/kashier.php /path/to/your/laravel/project/config/
```

### 2. Copy Service Class
Copy `app/Services/KashierService.php` to your Laravel project:
```bash
cp app/Services/KashierService.php /path/to/your/laravel/project/app/Services/
```

If the `Services` directory doesn't exist, create it first:
```bash
mkdir -p /path/to/your/laravel/project/app/Services
```

### 3. Copy Controller
Copy `app/Http/Controllers/PaymentController.php` to your Laravel project:
```bash
cp app/Http/Controllers/PaymentController.php /path/to/your/laravel/project/app/Http/Controllers/
```

### 4. Copy Views
Copy all view files to your Laravel project:
```bash
cp -r resources/views/payment /path/to/your/laravel/project/resources/views/
```

### 5. Add Routes
Open the `routes/web.php` file and add the routes from `routes/web.php` to your Laravel project's routes file.

### 6. Configure Environment Variables
Add the following to your Laravel project's `.env` file:
```env
KASHIER_MODE=test
KASHIER_TEST_API_KEY=your-test-api-key
KASHIER_TEST_MID=your-test-mid
KASHIER_LIVE_API_KEY=
KASHIER_LIVE_MID=
```

Replace the test credentials with your actual Kashier test credentials from your merchant dashboard.

### 7. Register Service Provider (Optional)
If you want to use dependency injection, the service is automatically resolved by Laravel.
You can also bind it in `app/Providers/AppServiceProvider.php`:

```php
use App\Services\KashierService;

public function register()
{
    $this->app->singleton(KashierService::class, function ($app) {
        return new KashierService();
    });
}
```

## Usage

### Access Payment Page
Navigate to: `http://your-laravel-app.test/payment/checkout`

### Test Cards
- **Success:** 5111 1111 1111 1118 - 06/22 - 100
- **Success 3D Secure:** 5123 4500 0000 0008 - 06/22 - 100
- **Failure:** 5111 1111 1111 1118 - 05/20 - 102

## File Structure

```
laravel-kashier/
├── config/
│   └── kashier.php                    # Configuration file
├── app/
│   ├── Services/
│   │   └── KashierService.php         # Main service class
│   └── Http/
│       └── Controllers/
│           └── PaymentController.php   # Payment controller
├── resources/
│   └── views/
│       └── payment/
│           ├── checkout.blade.php      # Checkout page
│           ├── success.blade.php       # Success page
│           └── error.blade.php         # Error page
├── routes/
│   └── web.php                        # Routes to add
├── .env.example                       # Environment variables example
└── README.md                          # This file
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

## License

This integration code is provided as-is for use with Kashier payment gateway.
