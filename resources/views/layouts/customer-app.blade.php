<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-g">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Tuan Coffee') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    @livewireStyles

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fdfaf6;
            /* Warna latar belakang yang hangat */
        }

        .hero-section {
            background-color: #ffe8e9;
            /* Warna pink lembut seperti di contoh */
            border-radius: 1.5rem;
        }

        .card {
            border: none;
            border-radius: 1rem;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .card-img-top {
            width: 75%;
            margin: -40px auto 0 auto;
            filter: drop-shadow(0 10px 8px rgba(0, 0, 0, 0.2));
            transition: transform 0.3s ease;
        }

        .card:hover .card-img-top {
            transform: translateY(-10px) scale(1.05);
        }

        .btn-primary {
            background-color: #ff69b4;
            /* Warna pink yang lebih kuat */
            border-color: #ff69b4;
            border-radius: 50rem;
            /* Tombol bulat */
        }

        .nav-pills .nav-link.active {
            background-color: #ff69b4;
        }

        .best-seller-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            font-size: 0.8rem;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="antialiased">

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">Tuan Coffee</a>
            <div class="d-flex">
                {{-- GANTI TOMBOL LAMA DENGAN INI --}}
                @livewire('cart-counter')
            </div>
        </div>
    </nav>

    {{-- Konten dari Livewire akan dimuat di sini --}}
    <main>
        {{ $slot }}
    </main>

    @livewire('notifications')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    @livewireScripts

    {{-- Script untuk interaksi modal --}}
    @stack('scripts')

    @include('sweetalert::alert')
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])

</body>

</html>
