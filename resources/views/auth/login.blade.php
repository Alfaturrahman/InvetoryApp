<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventaris MTI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            background:
                radial-gradient(circle at 8% 12%, rgba(46, 155, 107, 0.3), transparent 22%),
                radial-gradient(circle at 92% 8%, rgba(212, 135, 10, 0.25), transparent 18%),
                linear-gradient(142deg, #e9efe2, #dbe8d8 45%, #f5f7f2);
            font-family: "Sora", sans-serif;
            color: #1f2f24;
        }
        .card {
            width: min(420px, 92vw);
            background: rgba(255,255,255,0.9);
            border: 1px solid #d3ddce;
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 22px 38px rgba(42, 59, 38, .18);
            backdrop-filter: blur(5px);
        }
        h1 {
            margin: 0 0 6px;
            font-size: 1.24rem;
            letter-spacing: .2px;
        }
        p { margin: 0 0 16px; color: #55685a; }
        label { display: block; margin-bottom: 10px; font-size: .9rem; }
        input {
            width: 100%;
            margin-top: 4px;
            border: 1px solid #d3ddce;
            border-radius: 10px;
            padding: 10px;
            font: inherit;
        }
        input:focus {
            outline: 2px solid rgba(46, 155, 107, 0.24);
            border-color: #76bf9b;
        }
        button {
            width: 100%;
            border: none;
            border-radius: 10px;
            padding: 11px;
            background: linear-gradient(135deg, #1c7c54, #2e9b6b);
            color: #fff;
            font-weight: 600;
            cursor: pointer;
        }
        .help {
            margin-top: 12px;
            font-size: .82rem;
            color: #4f6254;
            background: #edf5ed;
            border: 1px solid #d4e4d2;
            border-radius: 10px;
            padding: 10px;
        }
        .error { color: #a8291d; font-size: .85rem; margin-bottom: 8px; }
        .logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, #1c7c54, #2e9b6b);
            color: #f6fff9;
            margin-bottom: 10px;
            font-family: "JetBrains Mono", monospace;
            font-weight: 600;
            font-size: .84rem;
        }
    </style>
</head>
<body>
<div class="card">
    <div class="logo">MTI</div>
    <h1>Login Inventaris MTI</h1>
    <p>Masuk sebagai Admin atau Teknisi.</p>

    @if($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <label>Email
            <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@multitech.test" required>
        </label>
        <label>Password
            <input type="password" name="password" placeholder="******" required>
        </label>
        <button type="submit">Masuk</button>
    </form>

    <div class="help">
        Demo admin: admin@multitech.test / password
        <br>
        Demo teknisi: teknisi1@multitech.test / password
    </div>
</div>
</body>
</html>
