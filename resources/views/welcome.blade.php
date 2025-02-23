<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        .ms-2 {
            margin-right: -480px !important;
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
                        <a class="nav-link" href="#menu">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    @auth
                        <!-- Cart Button -->
                        <li class="nav-item ms-2">
                            <a class="btn btn-outline-dark" href="{{ route('cart.index') }}">
                                <i class="bi bi-cart"></i> Cart
                            </a>
                        </li>

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
    <section id="menu" class="menu-section">
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
                    <div class="menu-item card" 
     data-id="{{ $item->id }}"
     data-title="{{ $item->name }}"
     data-price="{{ $item->price }}"
     data-stock="{{ $item->stock }}">
                            <img src="{{ asset('storage/uploads/' . $item->photo) }}" class="card-img-top"
                                alt="{{ $item->name }}" style="width: 100%; height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->name }}</h5>
                                <p class="card-text text-muted">
                                    Stock: <span class="stock-indicator">{{ $item->stock }}</span>
                                </p>
                            </div>
                            <div class="overlay">
                                <h2 class="overlay-title">{{ $item->name }}</h2>
                                <p class="overlay-description">{{ $item->description }}</p>
                                <p class="overlay-price"><strong>HARGA:</strong> {{ $item->price }}</p>
                                <p class="overlay-stock"><strong>STOCK:</strong> {{ $item->stock }}</p>
                                <button class="btn btn-primary">
                                    Masukkan ke Keranjang
                                </button>
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
            <!-- Beverage Items -->
            <div class="row">
                @foreach($beverageItems as $item)
                    <div class="col-md-3">
                    <div class="menu-item card" 
     data-id="{{ $item->id }}"
     data-title="{{ $item->name }}"
     data-price="{{ $item->price }}"
     data-stock="{{ $item->stock }}">
                            <img src="{{ asset('storage/uploads/' . $item->photo) }}" class="card-img-top"
                                alt="{{ $item->name }}" style="width: 100%; height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->name }}</h5>
                                <p class="card-text"><strong>Stock:</strong> {{ $item->stock }}</p> <!-- Display Stock -->
                            </div>
                            <div class="overlay">
                                <h2 class="overlay-title">{{ $item->name }}</h2>
                                <p class="overlay-description">{{ $item->description }}</p>
                                <p class="overlay-price"><strong>HARGA:</strong> {{ $item->price }}</p>
                                <p class="overlay-stock"><strong>STOCK:</strong> {{ $item->stock }}</p>
                                <!-- Display Stock in Overlay -->
                                <button class="btn btn-primary">Masukkan ke Keranjang</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

<!-- Footer -->
<footer id="contact" class="text-white py-4 mt-5" style="background-color:#D85A2D;">
    <div class="container">
        <div class="row">
            <!-- Alamat dan Peta -->
            <div class="col-md-4 mb-4">
                <h5 class="mb-3">Lokasi Kami</h5>
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.348208147937!2d110.41935257508076!3d-7.005782392975915!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708c2d28f9e9a3%3A0x4d4d5e5a9b87e0e8!2sJl.%20Cinde%20Utara%20VII%20No.6%2C%20Jomblang%2C%20Kec.%20Candisari%2C%20Kota%20Semarang%2C%20Jawa%20Tengah%2050256!5e0!3m2!1sen!2sid!4v1717407164226!5m2!1sen!2sid" 
                        width="100%" 
                        height="200" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
                <p class="mt-2 mb-0">
                    Jl. Cinde Utara VII No.6, Jomblang, Kec. Candisari,<br>
                    Kota Semarang, Jawa Tengah 50256
                </p>
            </div>

            <!-- Kontak -->
            <div class="col-md-4 mb-4">
                <h5 class="mb-3">Hubungi Kami</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="https://wa.me/6282136027920" class="text-white text-decoration-none">
                            <i class="bi bi-whatsapp me-2"></i>
                            +62 821 3602 7920
                        </a>
                    </li>
                    <li>
                        <a href="tel:+6282136027920" class="text-white text-decoration-none">
                            <i class="bi bi-telephone me-2"></i>
                            +62 821 3602 7920
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Sosial Media -->
            <div class="col-md-4">
                <h5 class="mb-3">Ikuti Kami</h5>
                <a href="https://www.instagram.com/gadiza.homemadefood" 
                   class="text-white text-decoration-none"
                   target="_blank">
                    <i class="bi bi-instagram me-2"></i>
                    @gadiza.homemadefood
                </a>
            </div>
        </div>

        <!-- Copyright -->
        <div class="text-center mt-4 pt-3 border-top">
            &copy; 2025 Gadizah Homemade Food. Seluruh hak cipta dilindungi.
        </div>
    </div>
</footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const addToCartButtons = document.querySelectorAll(".btn-primary");

            addToCartButtons.forEach(button => {
                button.addEventListener("click", function (event) {
                    event.stopPropagation();

                    @auth
                        const card = button.closest(".menu-item");
                        const item = {
                            id: card.dataset.id, // Use dataset instead of getAttribute
                            name: card.dataset.title,
                            price: card.dataset.price,
                            stock: card.dataset.stock,
                            quantity: 1 // Default quantity
                        };

                        if (item.stock <= 0) {
                            alert(`${item.name} is out of stock!`);
                            return;
                        }

                        fetch('{{ route("cart.add") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(item) // item contains the id, name, price, stock, and quantity
                        })
                            .then(response => {
                                if (!response.ok) throw new Error('Network error');
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    alert(`${item.name} added to cart!`);
                                    window.location.href = '{{ route("cart.index") }}';
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Failed to add item to cart');
                            });
                    @else
                        window.location.href = '{{ route("login") }}';
                    @endauth
                });
            });
        });
    </script>
</body>

</html>