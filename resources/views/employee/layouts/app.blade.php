<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Employee Portal')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>
<body>
<nav class="container-fluid">
    <ul>
        <li><strong>Hotel Employee Portal</strong></li>
        <li><a href="{{ route('employee.dashboard') }}">Dashboard</a></li>
        <li><a href="{{ route('employee.bookings.index') }}">Bookings</a></li>
        <li><a href="{{ route('employee.services.index') }}">Services</a></li>
        <li><a href="{{ route('employee.alerts.index') }}">Alerts</a></li>
    </ul>
    <ul>
        <li>{{ auth('employee')->user()->name }}</li>
        <li>
            <form action="{{ route('employee.logout') }}" method="POST">
                @csrf
                <button type="submit" class="contrast outline">Logout</button>
            </form>
        </li>
    </ul>
</nav>

<main class="container">
    @if (session('success'))
        <article role="alert">{{ session('success') }}</article>
    @endif

    @yield('content')
</main>

@stack('scripts')
</body>
</html>
