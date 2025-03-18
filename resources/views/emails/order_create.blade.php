<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
</head>
<body>
    <p>Your order ID: <strong>{{ $order->id }}</strong></p>
    <p>Total Price: <strong>${{ number_format($order->price, 2) }}</strong></p>
    <p>Status: <strong>{{ $order->status }}</strong></p>
    <p>We are processing your order and will notify you once it ships.</p>

    <p>Thanks for shopping with Qoot Store!</p>
</body>
</html>
