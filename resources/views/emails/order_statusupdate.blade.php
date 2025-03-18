<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Status Update</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .email-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }
        h2 {
            color: #333;
        }
        p {
            color: #555;
            font-size: 16px;
        }
        .order-info {
            font-weight: bold;
            color: #222;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
        .contact-link {
            color: #007BFF;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h2>Order Status Update</h2>
        <p>Dear Customer,</p>
        <p>Your order <span class="order-info">#{{ $order->id }}</span> status has been updated to <span class="order-info">{{ $order->status }}</span>.</p>
        <p>If you have any questions or need assistance, feel free to <a href="mailto:support@example.com" class="contact-link">contact us</a>.</p>
        <p>Thank you for shopping with us!</p>
        <p class="footer">Best regards,<br>Online Store Team</p>
    </div>
</body>
</html>
