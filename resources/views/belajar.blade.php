<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Belajar Laravel</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <h1 class="page-title">{{ $title ?? 'Kalkulator Sederhana' }}</h1>

    <div class="nav-container">
        <a href="{{ route('penjumlahan') }}" class="nav-link">tambah</a>
        <a href="{{ route('pengurangan') }}" class="nav-link">kurang</a>
        <a href="{{ route('perkalian') }}" class="nav-link">kali</a>
        <a href="{{ route('pembagian') }}" class="nav-link">bagi</a>
    </div>

    <div class="calculator-card">
        @hasSection('content')
            @yield('content')
        @else
            <div style="text-align: center; padding: 10px 0;">
                <h2 style="font-size: 20px; color: #1e293b; margin-bottom: 10px;">Selamat Datang!</h2>
                <p style="font-size: 14px; color: #64748b; line-height: 1.5;">
                    Silakan pilih salah satu menu operasi matematika di atas untuk mulai melakukan perhitungan.
                </p>
            </div>
        @endif
    </div>
</body>
</html>
