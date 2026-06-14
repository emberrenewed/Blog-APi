<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login – {{ config('app.name', 'Blog API') }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: ui-sans-serif, system-ui, sans-serif;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 12px rgba(0,0,0,.1);
            padding: 2rem;
            width: 100%;
            max-width: 380px;
        }
        h1 { font-size: 1.4rem; font-weight: 600; margin-bottom: 1.5rem; color: #1b1b18; }
        label { display: block; font-size: .875rem; font-weight: 500; color: #374151; margin-bottom: .3rem; }
        input {
            width: 100%;
            padding: .6rem .75rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: .95rem;
            margin-bottom: 1rem;
            outline: none;
            transition: border-color .15s;
        }
        input:focus { border-color: #6366f1; }
        button {
            width: 100%;
            padding: .65rem;
            background: #1b1b18;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: .95rem;
            font-weight: 500;
            cursor: pointer;
            transition: background .15s;
        }
        button:hover { background: #3a3a36; }
        button:disabled { opacity: .6; cursor: not-allowed; }
        .error {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            color: #b91c1c;
            border-radius: 6px;
            padding: .6rem .75rem;
            font-size: .875rem;
            margin-bottom: 1rem;
            display: none;
        }
        .success {
            background: #f0fdf4;
            border: 1px solid #86efac;
            color: #15803d;
            border-radius: 6px;
            padding: .6rem .75rem;
            font-size: .875rem;
            margin-bottom: 1rem;
            display: none;
        }
        .footer { text-align: center; margin-top: 1rem; font-size: .875rem; color: #6b7280; }
        .footer a { color: #1b1b18; font-weight: 500; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Log in</h1>

        <div class="error" id="error-msg"></div>
        <div class="success" id="success-msg"></div>

        <form id="login-form">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="you@example.com" required autofocus>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="••••••••" required>

            <button type="submit" id="submit-btn">Log in</button>
        </form>

        <p class="footer">
            No account? <a href="{{ route('register') }}">Register</a>
        </p>
    </div>

    <script>
        document.getElementById('login-form').addEventListener('submit', async function (e) {
            e.preventDefault();

            const btn = document.getElementById('submit-btn');
            const errorEl = document.getElementById('error-msg');
            const successEl = document.getElementById('success-msg');

            errorEl.style.display = 'none';
            successEl.style.display = 'none';
            btn.disabled = true;
            btn.textContent = 'Logging in…';

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            try {
                const response = await fetch('/api/login', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({ email, password }),
                });

                const data = await response.json();

                if (!response.ok) {
                    errorEl.textContent = data.message || 'Invalid credentials.';
                    errorEl.style.display = 'block';
                } else {
                    localStorage.setItem('api_token', data.token);
                    localStorage.setItem('user', JSON.stringify(data.user));
                    successEl.textContent = 'Logged in successfully! Redirecting…';
                    successEl.style.display = 'block';
                    setTimeout(() => { window.location.href = '/blog'; }, 1000);
                }
            } catch (err) {
                errorEl.textContent = 'Something went wrong. Please try again.';
                errorEl.style.display = 'block';
            }

            btn.disabled = false;
            btn.textContent = 'Log in';
        });
    </script>
</body>
</html>
