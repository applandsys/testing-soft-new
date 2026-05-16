<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LabCare Laboratory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            padding-top: 80px;
        }
        .hero {
            background: linear-gradient(rgba(0,0,0,.6), rgba(0,0,0,.6)),
            url('https://images.unsplash.com/photo-1581092160607-ee22621dd758') center/cover;
            color: white;
            padding: 120px 0;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
    <div class="container">

        <!-- Brand -->
        <a class="navbar-brand fw-bold text-primary" href="#">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" height="40">
        </a>

        <!-- Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navMenu">

            <!-- Left Nav -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
            </ul>

            <!-- RIGHT AUTH -->
            @if (Route::has('login'))
                <div class="d-flex gap-2">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="btn btn-outline-primary btn-sm">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="btn btn-link btn-sm text-dark">
                            Log in
                        </a>
                    @endauth
                </div>
            @endif

        </div>
    </div>
</nav>

<!-- HERO -->
<section class="hero text-center">
    <div class="container">
        <h1 class="display-5 fw-bold">SGS Advanced  Laboratory Services</h1>
        <p class="lead mt-3">Accurate, reliable & fast diagnostic solutions</p>
        <a href="#contact" class="btn btn-primary btn-lg mt-4">Book a Test</a>
    </div>
</section>

<!-- MID CONTENT / HIGHLIGHTS -->
<section class="py-5 bg-light">
    <div class="container">

        <!-- Intro -->
        <div class="row mb-5 text-center">
            <div class="col">
                <h2 class="fw-bold">Trusted Diagnostic Laboratory</h2>
                <p class="text-muted mt-2">
                    Providing accurate, fast, and affordable diagnostic services with modern technology.
                </p>
            </div>
        </div>

        <!-- Highlights -->
        <div class="row g-4 text-center">

            <div class="col-md-4">
                <div class="p-4 bg-white shadow-sm rounded h-100">
                    <div class="fs-1 mb-3 text-primary">🧪</div>
                    <h5 class="fw-semibold">Accurate Results</h5>
                    <p class="text-muted mb-0">
                        State-of-the-art equipment ensuring precise and reliable test results.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-4 bg-white shadow-sm rounded h-100">
                    <div class="fs-1 mb-3 text-primary">⏱️</div>
                    <h5 class="fw-semibold">Quick Reports</h5>
                    <p class="text-muted mb-0">
                        Same-day and next-day reports available for most tests.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-4 bg-white shadow-sm rounded h-100">
                    <div class="fs-1 mb-3 text-primary">👨‍⚕️</div>
                    <h5 class="fw-semibold">Expert Team</h5>
                    <p class="text-muted mb-0">
                        Experienced pathologists and technicians you can trust.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Rest of sections here -->

<footer class="bg-dark text-white text-center py-4">
    <p class="mb-0">© 2026 SGS Testing Laboratory</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
