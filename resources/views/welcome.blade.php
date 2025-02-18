<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gadizah Homemade Food</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Madimi+One&display=swap');

        body {
            font-family: "Madimi One", serif;
            font-weight: 400;
            font-style: normal;
        }

        .navbar {
            background-color: #D9D9D9;
        }

        .navbar-nav {
            display: flex;
            justify-content: center;
            width: 100%;
            margin-left: -50px;
        }

        .ms-4 {
            margin-right: -550px !important;
            margin-left: 500px !important;
        }

        /* HERO SECTION */
        .hero-section {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            width: 100%;
            min-height: 500px;
            background: linear-gradient(to right, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.3)), url('../images/food-1.png') center/cover no-repeat;
            color: white;
            padding: 60px 5%;
            position: relative;
        }

        /* HERO TEXT */
        .hero-text {
            max-width: 50%;
            z-index: 2;
        }

        .hero-text h1 {
            font-size: 2.8rem;
            font-weight: bold;
        }

        .hero-text p {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .hero-buttons .btn {
            margin-right: 10px;
            font-size: 1rem;
            padding: 10px 20px;
            border-radius: 25px;
        }

        /* HERO BUTTONS */
        .hero-buttons {
            display: flex;
            gap: 15px;
        }

        .hero-buttons .btn {
            font-size: 1rem;
            padding: 12px 24px;
            border-radius: 25px;
            font-weight: bold;
        }

        .register-button {
            background-color: #D85A2D;
            color: white;
        }

        .login-button {
            background-color: #D9D9D9;
            color: black;
        }

        /* HERO IMAGE */
        .hero-image {
            position: absolute;
            right: 0;
            top: 0;
            width: 50%;
            height: 100%;
            overflow: hidden;
        }

        .hero-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* MENU SECTION */
        .menu-section {
            margin-top: 5rem;
            width: 100%;
        }

        .menu-title-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            margin-bottom: 20px;
            position: relative;
        }

        .menu-title {
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 0 20px;
            background-color: white;
            z-index: 1;
        }

        .menu-line {
            flex-grow: 1;
            height: 5px;
            background-color: #D85A2D;
        }

        .menu-category {
            text-align: left;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .underline {
            width: 100px;
            height: 5px;
            background-color: #D85A2D;
            margin-top: 5px;
        }

        .menu-item {
            border-radius: 10px;
            overflow: hidden;
            transition: 0.3s;
            background-color: #f8f9fa;
            text-align: center;
            padding: 15px;
            cursor: pointer;
            margin-bottom: 20px;
            position: relative;
        }

        .menu-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }

        .menu-item .card-title {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            padding: 20px;
            text-align: center;
        }

        .menu-item:hover .overlay {
            opacity: 1;
        }

        .overlay-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .overlay-description {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .overlay-price {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #D85A2D;
            border: none;
        }

        .btn-primary:hover {
            background-color: #c54a1d;
        }

        /* FOOTER */
        footer {
            background-color: #f5f5f5;
            text-align: center;
            padding: 20px 0;
        }

        /* RESPONSIVE FIX */
        @media (max-width: 768px) {
            .hero-section {
                flex-direction: column;
                text-align: center;
                padding: 40px 10%;
            }

            .hero-text {
                max-width: 100%;
            }

            .hero-image {
                position: relative;
                width: 100%;
                height: auto;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/logo-1.png') }}" alt="Logo" style="width: 100px; height: auto;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                    @auth
                        <li class="nav-item ms-4">
                            <button class="btn btn-outline-dark" data-bs-toggle="offcanvas"
                                data-bs-target="#profileSidebar">
                                <i class="bi bi-person-circle"></i>
                            </button>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6 hero-text">
                    <h1>Selamat Datang di Gadizah Homemade Food!</h1>
                    <p>Sudah punya akun? Silakan masuk atau daftar untuk pengalaman terbaik.</p>
                    <div class="d-flex hero-buttons">
                        @guest
                            <a href="{{ route('register') }}" class="btn register-button">Daftar</a>
                            <a href="{{ route('login') }}" class="btn login-button">Masuk</a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Profile Sidebar -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="profileSidebar" aria-labelledby="profileSidebarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="profileSidebarLabel">Profile</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body text-center Sidebar">
            <!-- User Info -->
            <i class="bi bi-person-circle" style="font-size: 4rem;"></i>
            @if(Auth::check())
                <h4 class="mt-2">{{ Auth::user()->name }}</h4>
            @else
                <h4 class="mt-2">Guest</h4>
            @endif

            <!-- Buttons -->
            <div class="button">
                <a href="{{ route('profile.settings') }}" class="btn btn-warning w-100 my-2">Settings</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100 mt-5">Log Out</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Menu Section -->
    <section class="menu-section">
        <div class="container">
            <!-- Title -->
            <div class="menu-title-wrapper">
                <span class="menu-line"></span>
                <h2 class="menu-title">MENU KAMI</h2>
                <span class="menu-line"></span>
            </div>

            <!-- FOOD Category -->
            <div class="menu-category">
                <h3>FOOD</h3>
                <div class="underline"></div>
            </div>

            <!-- Food Items -->
            <div class="row">
                @foreach($foodItems as $item)
                    <div class="col-md-3">
                        <div class="menu-item card" data-title="{{ $item->name }}" data-desc="{{ $item->description }}"
                            data-price="{{ $item->price }}">
                            <img src="{{ asset('storage/uploads/' . $item->photo) }}" class="card-img-top"
                                alt="{{ $item->name }}" style="width: 100%; height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->name }}</h5>
                            </div>
                            <div class="overlay">
                                <h2 class="overlay-title">{{ $item->name }}</h2>
                                <p class="overlay-description">{{ $item->description }}</p>
                                <p class="overlay-price"><strong>HARGA:</strong> {{ $item->price }}</p>
                                <button class="btn btn-primary">Masukkan ke Keranjang</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- BEVERAGE Category -->
            <div class="menu-category">
                <h3>BEVERAGE</h3>
                <div class="underline"></div>
            </div>

            <!-- Beverage Items -->
            <div class="row">
                @foreach($beverageItems as $item)
                    <div class="col-md-3">
                        <div class="menu-item card" data-title="{{ $item->name }}" data-desc="{{ $item->description }}"
                            data-price="{{ $item->price }}">
                            <img src="{{ asset('storage/uploads/' . $item->photo) }}" class="card-img-top"
                                alt="{{ $item->name }}" style="width: 100%; height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->name }}</h5>
                            </div>
                            <div class="overlay">
                                <h2 class="overlay-title">{{ $item->name }}</h2>
                                <p class="overlay-description">{{ $item->description }}</p>
                                <p class="overlay-price"><strong>HARGA:</strong> {{ $item->price }}</p>
                                <button class="btn btn-primary">Masukkan ke Keranjang</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div>&copy; 2025 Gadizah Homemade Food. All rights reserved.</div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add to Cart Functionality
        document.addEventListener("DOMContentLoaded", function () {
            const addToCartButtons = document.querySelectorAll(".btn-primary");

            addToCartButtons.forEach(button => {
                button.addEventListener("click", function (event) {
                    event.stopPropagation();
                    const card = button.closest(".menu-item");
                    const item = {
                        title: card.getAttribute("data-title"),
                        description: card.getAttribute("data-desc"),
                        price: card.getAttribute("data-price"),
                        image: card.querySelector("img").src
                    };

                    let cart = JSON.parse(localStorage.getItem("cart")) || [];
                    cart.push(item);
                    localStorage.setItem("cart", JSON.stringify(cart));

                    alert(`${item.title} telah ditambahkan ke keranjang!`);
                });
            });
        });
    </script>
</body>

</html>