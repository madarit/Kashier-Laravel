<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Error</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            text-align: center;
        }
        .error-container {
            border: 2px solid #d73a49;
            padding: 40px;
            border-radius: 8px;
            background: #fff5f5;
        }
        .error-icon {
            font-size: 60px;
            color: #d73a49;
            margin-bottom: 20px;
        }
        h1 {
            color: #d73a49;
            margin-bottom: 20px;
        }
        .message {
            background: white;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
            color: #666;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #d73a49;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-link:hover {
            background: #b52a3a;
        }
        .details {
            text-align: left;
            background: white;
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">✕</div>
        <h1>Payment Failed</h1>
        
        <div class="message">
            <p>{{ $message ?? 'An error occurred while processing your payment.' }}</p>
        </div>

        @if(isset($data) && !empty($data))
        <div class="details">
            <h4>Error Details:</h4>
            @foreach($data as $key => $value)
                @if($key !== 'signature')
                <p><strong>{{ ucfirst($key) }}:</strong> {{ $value }}</p>
                @endif
            @endforeach
        </div>
        @endif
        
        <a href="{{ route('payment.checkout') }}" class="back-link">Try Again</a>
    </div>
</body>
</html>
