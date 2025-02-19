<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Madimi+One&display=swap');
        body {
            font-family: "Madimi One", serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #ffffff;
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand img {
            width: 100px;
            height: auto;
        }

        .container {
            max-width: 900px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
        }

        h2 {
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #ddd;
            background: #f9f9f9;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .cart-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .cart-item h5 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .cart-item p {
            margin: 0;
            font-size: 14px;
            color: #555;
        }

        .cart-item .price {
            font-weight: bold;
            color: #28a745;
            font-size: 16px;
        }

        .btn-checkout {
            background: #28a745;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            padding: 10px 20px;
            border: none;
            width: 100%;
            margin-top: 20px;
        }

        .btn-checkout:hover {
            background: #218838;
        }

        .btn-remove {
            background: #dc3545;
            color: white;
            font-size: 14px;
            padding: 5px 10px;
            border-radius: 5px;
            border: none;
        }

        .btn-remove:hover {
            background: #c82333;
        }

        .empty-cart-message {
            text-align: center;
            color: #777;
            font-size: 18px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/logo-1.png') }}" alt="Logo">
        </a>
    </nav>

    <div class="container mt-5">
        <h2>Your Cart</h2>
        @if(session('cart'))
            @foreach(session('cart') as $item)
                <div class="cart-item">
                    <div>
                        <h5>{{ $item['title'] }}</h5>
                        <p>{{ $item['description'] }}</p>
                    </div>
                    <div>
                        <p class="price">{{ $item['price'] }}</p>
                        <button class="btn-remove">Remove</button>
                    </div>
                </div>
            @endforeach
            <button class="btn-checkout">Checkout</button>
        @else
            <p class="empty-cart-message">Your cart is empty.</p>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>