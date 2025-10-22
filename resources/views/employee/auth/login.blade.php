<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>
<body>
<main class="container">
    <article>
        <header><h1>Employee Login</h1></header>
        <form method="POST" action="{{ route('employee.login.attempt') }}">
            @csrf
            <label>
                Username
                <input type="text" name="username" value="{{ old('username') }}" required autofocus>
            </label>
            <label>
                Password
                <input type="password" name="password" required>
            </label>
            <label>
                <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                Remember me
            </label>

            @if ($errors->any())
                <article role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </article>
            @endif

            <button type="submit">Log in</button>
        </form>
    </article>
</main>
</body>
</html>
