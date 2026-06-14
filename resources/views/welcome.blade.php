<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Blog API') }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: ui-sans-serif, system-ui, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        nav {
            width: 100%;
            max-width: 1100px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 1.5rem;
        }
        .brand { font-size: 1.25rem; font-weight: 700; color: #1b1b18; }
        .nav-links { display: flex; gap: 1rem; }
        .btn {
            padding: .5rem 1.2rem;
            border-radius: 6px;
            font-size: .9rem;
            font-weight: 500;
            text-decoration: none;
            transition: background .15s;
        }
        .btn-outline {
            border: 1px solid #d1d5db;
            color: #1b1b18;
            background: #fff;
        }
        .btn-outline:hover { background: #f3f4f6; }
        .btn-solid {
            background: #1b1b18;
            color: #fff;
            border: 1px solid #1b1b18;
        }
        .btn-solid:hover { background: #3a3a36; }
        .hero {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 4rem 1.5rem;
        }
        .hero h1 { font-size: 2.5rem; font-weight: 700; color: #1b1b18; margin-bottom: .75rem; }
        .hero p { font-size: 1.1rem; color: #6b7280; margin-bottom: 2rem; }
        .hero-actions { display: flex; gap: 1rem; }
    </style>
</head>
<body>
    <nav>
        <span class="brand">Blog API</span>
        <div class="nav-links">
            <a href="{{ route('login') }}" class="btn btn-outline">Log in</a>
            <a href="{{ route('register') }}" class="btn btn-solid">Register</a>
        </div>
    </nav>

    <div class="hero">
        <h1>Welcome to Blog API</h1>
        <p>A simple platform to read, write, and share blog posts.</p>
        <div class="hero-actions">
            <a href="{{ route('login') }}" class="btn btn-solid">Log in</a>
            <a href="{{ route('register') }}" class="btn btn-outline">Create account</a>
        </div>
    </div>
</body>
</html>
