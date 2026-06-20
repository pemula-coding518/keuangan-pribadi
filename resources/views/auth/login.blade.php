<!DOCTYPE html>
<html lang="id">
 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Keuangan Pribadi</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
 
    <style>
        *, *::before, *::after { box-sizing: border-box; }
 
        :root {
            --bg-page:    #03080f;
            --bg-card:    #06101e;
            --bg-input:   #051019;
            --border:     rgba(59,130,246,0.14);
            --border-md:  rgba(59,130,246,0.26);
            --border-hi:  rgba(59,130,246,0.48);
            --blue-700:   #1d4ed8;
            --blue-500:   #3b82f6;
            --blue-400:   #60a5fa;
            --blue-300:   #93c5fd;
            --text-1:     #eef2ff;
            --text-2:     #94a3b8;
            --text-3:     #475569;
            --danger-dim: rgba(239,68,68,0.12);
            --danger-bdr: rgba(239,68,68,0.28);
            --ease:       all 0.22s cubic-bezier(0.4,0,0.2,1);
            --r-md:       12px;
            --r-sm:       8px;
        }
 
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--bg-page);
            background-image:
                radial-gradient(ellipse 70% 50% at 20% 15%, rgba(29,78,216,0.10) 0%, transparent 60%),
                radial-gradient(ellipse 60% 40% at 80% 85%, rgba(37,99,235,0.07) 0%, transparent 55%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            -webkit-font-smoothing: antialiased;
        }
 
        .login-wrap {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }
 
        /* Logo */
        .login-logo {
            text-align: center;
            margin-bottom: 32px;
        }
 
        .login-logo-icon {
            font-size: 36px;
            display: block;
            margin-bottom: 10px;
        }
 
        .login-logo-title {
            font-size: 20px;
            font-weight: 800;
            color: var(--text-1);
            letter-spacing: -0.4px;
        }
 
        .login-logo-sub {
            font-size: 13px;
            color: var(--text-3);
            margin-top: 4px;
        }
 
        /* Card */
        .login-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--r-md);
            padding: 32px 28px;
            position: relative;
            overflow: hidden;
        }
 
        .login-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--blue-700), var(--blue-400), transparent);
        }
 
        .login-heading {
            font-size: 17px;
            font-weight: 700;
            color: var(--text-1);
            margin: 0 0 6px;
        }
 
        .login-sub {
            font-size: 13px;
            color: var(--text-3);
            margin: 0 0 24px;
        }
 
        /* Alert */
        .alert-err {
            background: var(--danger-dim);
            border: 1px solid var(--danger-bdr);
            border-radius: var(--r-sm);
            color: #f87171;
            font-size: 13px;
            padding: 10px 14px;
            margin-bottom: 20px;
        }
 
        /* Label & Input */
        .form-group {
            margin-bottom: 18px;
        }
 
        .form-label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-2);
            margin-bottom: 7px;
            letter-spacing: 0.2px;
        }
 
        .form-control {
            display: block;
            width: 100%;
            background: var(--bg-input);
            border: 1px solid var(--border-md);
            border-radius: var(--r-sm);
            color: var(--text-1);
            font-size: 13.5px;
            font-family: inherit;
            padding: 11px 14px;
            outline: none;
            transition: var(--ease);
        }
 
        .form-control::placeholder { color: var(--text-3); }
 
        .form-control:focus {
            border-color: var(--blue-500);
            box-shadow: 0 0 0 3px rgba(59,130,246,0.18);
            background: rgba(4,14,28,0.95);
        }
 
        /* Submit button */
        .btn-submit {
            display: block;
            width: 100%;
            padding: 12px 20px;
            background: linear-gradient(135deg, var(--blue-700), var(--blue-500));
            color: #fff;
            font-family: inherit;
            font-size: 14px;
            font-weight: 700;
            border: none;
            border-radius: var(--r-sm);
            cursor: pointer;
            transition: var(--ease);
            box-shadow: 0 4px 16px rgba(37,99,235,0.38);
            margin-top: 8px;
            letter-spacing: 0.1px;
        }
 
        .btn-submit:hover {
            background: linear-gradient(135deg, #2563eb, var(--blue-400));
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(37,99,235,0.50);
        }
 
        .btn-submit:active {
            transform: translateY(0);
        }
 
        /* Footer note */
        .login-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: var(--text-3);
        }
    </style>
</head>
 
<body>
 
<div class="login-wrap">
 
    <div class="login-logo">
        <span class="login-logo-icon">💰</span>
        <div class="login-logo-title">Keuangan Pribadi</div>
        <div class="login-logo-sub">Personal Finance Manager</div>
    </div>
 
    <div class="login-card">
 
        <h1 class="login-heading">Masuk ke Akun</h1>
        <p class="login-sub">Silakan masukkan email dan password Anda.</p>
 
        @if($errors->any())
            <div class="alert-err">
                {{ $errors->first() }}
            </div>
        @endif
 
        <form action="{{ route('login.process') }}" method="POST">
            @csrf
 
            <div class="form-group">
                <label class="form-label">Email</label>
                <input
                    type="email"
                    name="email"
                    class="form-control"
                    placeholder="email@contoh.com"
                    value="{{ old('email') }}"
                    required
                >
            </div>
 
            <div class="form-group">
                <label class="form-label">Password</label>
                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Masukkan password"
                    required
                >
            </div>
 
            <button type="submit" class="btn-submit">
                Masuk →
            </button>
 
        </form>
 
    </div>
 
    <div class="login-footer">
        © {{ date('Y') }} Keuangan Pribadi
    </div>
 
</div>
 
</body>
</html>