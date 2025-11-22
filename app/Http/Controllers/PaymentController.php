<?php

namespace App\Http\Controllers;

use App\Services\KashierService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $kashier;

    public function __construct(KashierService $kashier)
    {
        $this->kashier = $kashier;
    }

    /**
     * Show checkout page with iFrame and HPP options
     *
     * @return \Illuminate\View\View
     */
    public function checkout()
    {
        $orderId = time();
        $amount = '20';
        $currency = 'EGP';
        $allowedMethods = 'card,wallet,bank_installments';
        
        $hash = $this->kashier->generateOrderHash($orderId, $amount, $currency);
        $config = $this->kashier->getConfig();
        $mode = $this->kashier->getMode();
        
        $hppUrl = $this->kashier->getHppUrl(
            $orderId, 
            $amount, 
            $currency, 
            route('payment.hpp.callback')
        );

        return view('payment.checkout', compact(
            'orderId', 
            'amount', 
            'currency', 
            'hash', 
            'config', 
            'mode', 
            'hppUrl',
            'allowedMethods'
        ));
    }

    /**
     * Handle iFrame payment callback
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function iframeCallback(Request $request)
    {
        if ($request->get('paymentStatus') === 'SUCCESS') {
            if ($this->kashier->validateSignature($request->all())) {
                // Payment successful and signature valid
                // Here you can save transaction to database
                // Update order status, etc.
                
                return view('payment.success', ['data' => $request->all()]);
            } else {
                // Signature validation failed - possible fraud attempt
                \Log::warning('Kashier signature validation failed', $request->all());
                return view('payment.error', ['message' => 'Invalid signature']);
            }
        }
        
        // Payment failed
        return view('payment.error', [
            'message' => 'Payment failed',
            'data' => $request->all()
        ]);
    }

    /**
     * Handle Hosted Payment Page callback
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function hppCallback(Request $request)
    {
        if ($this->kashier->validateSignature($request->all())) {
            if ($request->get('paymentStatus') === 'SUCCESS') {
                // Payment successful
                return view('payment.success', ['data' => $request->all()]);
            } else {
                // Payment failed but signature is valid
                return view('payment.error', [
                    'message' => 'Payment was not successful',
                    'data' => $request->all()
                ]);
            }
        } else {
            // Signature validation failed
            \Log::warning('Kashier HPP signature validation failed', $request->all());
            return view('payment.error', ['message' => 'Invalid signature']);
        }
    }
}
