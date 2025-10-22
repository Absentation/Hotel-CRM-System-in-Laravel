<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>
<body>
<nav class="container-fluid">
    <ul>
        <li><strong>Hotel Admin</strong></li>
        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li><a href="{{ route('admin.employees.index') }}">Employees</a></li>
        <li><a href="{{ route('admin.bookings.index') }}">Bookings</a></li>
        <li><a href="{{ route('admin.services.index') }}">Services</a></li>
        <li><a href="{{ route('admin.media.index') }}">Media</a></li>
        <li><a href="{{ route('admin.alerts.index') }}">Alerts</a></li>
        <li><a href="{{ route('admin.inventory.items.index') }}">Inventory</a></li>
        <li><a href="{{ route('admin.inventory.transactions.index') }}">Transactions</a></li>
    </ul>
    <ul>
        <li>{{ auth('admin')->user()->name }}</li>
        <li>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="contrast outline">Logout</button>
            </form>
        </li>
    </ul>
</nav>

<main class="container">
    @if (session('success'))
        <article role="alert">
            {{ session('success') }}
        </article>
    @endif

    @yield('content')
</main>
@stack('scripts')
</body>
</html>
