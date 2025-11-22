<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kashier Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }
        .payment-container {
            border: 1px solid #ddd;
            padding: 30px;
            border-radius: 8px;
            background: #f9f9f9;
        }
        h1 {
            color: #333;
        }
        .hpp-link {
            display: inline-block;
            margin: 20px 0;
            padding: 12px 24px;
            background: #2da44e;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .hpp-link:hover {
            background: #268d3e;
        }
        .divider {
            margin: 30px 0;
            text-align: center;
            position: relative;
        }
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #ddd;
        }
        .divider span {
            background: #f9f9f9;
            padding: 0 15px;
            position: relative;
            z-index: 1;
        }
    </style>
    <script>
        function responseCallBack(e) { 
            if(e.data.message == "success") {
                console.log("Success payment", e.data);
            } else if(e.data.message == "failure") {
                console.log("Failure payment", e.data);
            } else {
                console.log("Other Actions", e.data);
            }
        }
        
        if (window.addEventListener) {
            addEventListener("message", responseCallBack, false);
        } else {
            attachEvent("onmessage", responseCallBack);
        }
    </script>
</head>
<body>
    <div class="payment-container">
        <h1>Kashier Payment Integration</h1>
        
        <div>
            <h2>Option 1: Hosted Payment Page (HPP)</h2>
            <p>Redirect to Kashier hosted payment page</p>
            <a class="hpp-link" target="_blank" href="{{ $hppUrl }}">Pay with Hosted Payment Page</a>
        </div>

        <div class="divider">
            <span>OR</span>
        </div>

        <div>
            <h2>Option 2: iFrame Payment (Same Page)</h2>
            <p>Pay directly on this page using Kashier popup</p>
            
            <script id="kashier-iFrame"
                src="{{ $config['base_url'] }}/kashier-checkout.js"
                data-amount="{{ $amount }}"
                data-description="Payment for Order #{{ $orderId }}"
                data-hash="{{ $hash }}"
                data-currency="{{ $currency }}"
                data-orderId="{{ $orderId }}"
                data-merchantId="{{ $config['mid'] }}"
                data-allowedMethods="{{ $allowedMethods }}"
                data-merchantRedirect="{{ route('payment.iframe.callback') }}"
                data-mode="{{ $mode }}"
                data-type="external"
                data-display="en">
            </script>
        </div>

        <div style="margin-top: 30px; padding: 15px; background: #fff; border-radius: 5px;">
            <h3>Test Cards</h3>
            <ul>
                <li><strong>Success:</strong> 5111 1111 1111 1118 - 06/22 - 100</li>
                <li><strong>Success 3D Secure:</strong> 5123 4500 0000 0008 - 06/22 - 100</li>
                <li><strong>Failure:</strong> 5111 1111 1111 1118 - 05/20 - 102</li>
            </ul>
        </div>
    </div>
</body>
</html>
