<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Front Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-brand {
            font-weight: bold;
        }

        .hero-section {
            background: linear-gradient(135deg, #ed5e29, #f6b042), url('https://via.placeholder.com/1920x600');
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
            padding: 100px 0;
        }

        .product-card {
            transition: transform 0.3s;
        }

        .product-card:hover {
            transform: scale(1.05);
        }

        .profile-sidebar {
            width: 250px;
        }

        .profile-picture {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 20px auto;
            display: block;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">ShopNow</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-3">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                                <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
                            </svg>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16">
                                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l.84 4.479 9.144-.459L13.89 4zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                            </svg>
                        </a>
                    </li>
                </ul>
                <div class="d-flex">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">Login</a>
                    @else
                    <button class="btn btn-outline-primary" data-bs-toggle="offcanvas" data-bs-target="#profileSidebar" aria-controls="profileSidebar">
                        Profile
                    </button>

                    @endguest
                </div>
            </div>
        </div>
    </nav>

<!-- Profile Sidebar -->
<div class="offcanvas offcanvas-end profile-sidebar" tabindex="-1" id="profileSidebar" aria-labelledby="profileSidebarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="profileSidebarLabel">Profile</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body text-center">
        @auth
            <img src="https://via.placeholder.com/80" alt="Profile Picture" class="profile-picture">
            <h5>{{ Auth::user()->name }}</h5>
            <p>{{ Auth::user()->email }}</p>
            <a href="#" class="btn btn-secondary mb-3">Profile Settings</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        @endauth

        @guest
            <p>Please log in to view your profile.</p>
        @endguest
    </div>
</div>



    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="display-4">Selamat Datang di <br> Gadizah HomemadeFood</h1>
            <p class="lead">Find the best products at unbeatable prices.</p>
            <button type="button" class="btn btn-outline-light">Shop Now!</button>
        </div>
    </section>
<!-- menu -->

    <section class="container mt-4">
    <h2 class="text-center mb-4">Our Menu</h2>
    <div class="row">
    @if(isset($menu))
    @foreach($menus as $menu)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <img src="{{ asset('storage/' . $menu->photo) }}" class="card-img-top" alt="{{ $menu->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $menu->name }}</h5>
                        <p class="card-text">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                        <button class="btn btn-primary">Order Now</button>
                    </div>
                </div>
            </div>
        @endforeach
        @endif
    </div>
</section>

    <!-- Footer -->
    <footer class="bg-light py-4">
        <div class="container text-center">
            <p>&copy; 2025 ShopNow. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
