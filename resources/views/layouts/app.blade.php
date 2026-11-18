<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Klinik Sehat')</title>
    <link rel="stylesheet" href="{{ asset('public/css/style.css') }}">
</head>
<body>

<nav class="navbar">
    <div class="container lebar" style="display:flex;justify-content:space-between;align-items:center;">
        <a href="{{ route('dokter.index') }}">Klinik Sehat</a>

        @auth
            <form method="POST" action="{{ route('logout') }}" style="display:flex;align-items:center;gap:10px;margin:0;">
                @csrf
                <span>{{ auth()->user()->name }} ({{ auth()->user()->role }})</span>
                <button type="submit" class="btn btn-sm btn-secondary">Logout</button>
            </form>
        @endauth
    </div>
</nav>

<div class="container @yield('lebar')">
    @yield('content')
</div>

@stack('scripts')
</body>
</html>
