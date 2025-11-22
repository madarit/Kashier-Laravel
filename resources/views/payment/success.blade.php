<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            text-align: center;
        }
        .success-container {
            border: 2px solid #2da44e;
            padding: 40px;
            border-radius: 8px;
            background: #f0fff4;
        }
        .checkmark {
            font-size: 60px;
            color: #2da44e;
            margin-bottom: 20px;
        }
        h1 {
            color: #2da44e;
            margin-bottom: 20px;
        }
        .details {
            text-align: left;
            background: white;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .details p {
            margin: 10px 0;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }
        .details p:last-child {
            border-bottom: none;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #2da44e;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-link:hover {
            background: #268d3e;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="checkmark">✓</div>
        <h1>Payment Successful!</h1>
        <p>Your payment has been processed successfully.</p>
        
        <div class="details">
            <h3>Transaction Details</h3>
            <p><strong>Transaction ID:</strong> {{ $data['transactionId'] ?? 'N/A' }}</p>
            <p><strong>Order ID:</strong> {{ $data['merchantOrderId'] ?? 'N/A' }}</p>
            <p><strong>Kashier Order ID:</strong> {{ $data['orderId'] ?? 'N/A' }}</p>
            <p><strong>Card Brand:</strong> {{ $data['cardBrand'] ?? 'N/A' }}</p>
            <p><strong>Masked Card:</strong> {{ $data['maskedCard'] ?? 'N/A' }}</p>
            <p><strong>Currency:</strong> {{ $data['currency'] ?? 'N/A' }}</p>
            <p><strong>Status:</strong> {{ $data['paymentStatus'] ?? 'N/A' }}</p>
        </div>
        
        <a href="{{ route('payment.checkout') }}" class="back-link">Make Another Payment</a>
    </div>
</body>
</html>
