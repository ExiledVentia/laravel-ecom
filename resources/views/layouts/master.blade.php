<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel E-Commerce')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <!-- Navbar -->
    <nav style="background:#f97316; padding:10px; color:white;">
        <a href="{{ url('/') }}" style="margin-right:15px; color:white;">Home</a>
        <a href="{{ url('/orders') }}" style="margin-right:15px; color:white;">Orders</a>

        @auth
            <span style="margin-right:15px;">Hi, {{ Auth::user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" style="display:inline">
                @csrf
                <button type="submit">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" style="margin-right:15px; color:white;">Login</a>
            <a href="{{ route('register') }}" style="color:white;">Register</a>
        @endauth
    </nav>

    <!-- Konten utama -->
    <main style="padding:20px;">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer style="background:#f97316; color:white; text-align:center; padding:10px; margin-top:20px;">
        &copy; {{ date('Y') }} Laravel E-Commerce
    </footer>
</body>
</html>
