<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Ciptatech</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #4361ee;
            --dark: #0f172a;
            --light-bg: #f8fafc;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--light-bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-card {
            background: #ffffff;
            border: none;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04);
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), #4cc9f0);
        }

        .brand-logo {
            width: 60px;
            height: 60px;
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin: 0 auto 24px;
        }

        .form-label {
            font-weight: 600;
            color: #475569;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .form-control {
            padding: 12px 16px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
        }

        .input-group-text {
            background-color: #f8fafc;
            border-color: #e2e8f0;
            border-radius: 12px;
            cursor: pointer;
            color: #64748b;
        }

        .btn-login {
            background: var(--primary);
            color: white;
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
        }

        .btn-login:hover {
            background: #3751d7;
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(67, 97, 238, 0.3);
            color: white;
        }

        .back-to-landing {
            text-align: center;
            margin-top: 24px;
        }

        .back-to-landing a {
            color: #64748b;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .back-to-landing a:hover {
            color: var(--primary);
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-card">
        
        <h4 class="text-center fw-bold mb-1">Selamat Datang</h4>
        <p class="text-center text-muted small mb-4">Silakan masuk ke akun Ciptatech Anda</p>

        @if($errors->any())
            <div class="alert alert-danger border-0 small rounded-3 mb-4">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text rounded-start-3 border-end-0"><i class="fas fa-envelope small"></i></span>
                    <input type="email" name="email" class="form-control border-start-0" placeholder="nama@email.com" required autofocus>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text rounded-start-3 border-end-0"><i class="fas fa-lock small"></i></span>
                    <input type="password" name="password" id="passwordInput" class="form-control border-start-0 border-end-0" placeholder="••••••••" required>
                    <span class="input-group-text rounded-end-3" id="togglePassword">
                        <i class="fas fa-eye-slash small"></i>
                    </span>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label text-muted small" for="remember">Ingat Saya</label>
                </div>
            </div>

            <button type="submit" class="btn btn-login w-100 mb-3">
                Login <i class="fas fa-sign-in-alt ms-2"></i>
            </button>
        </form>
        <div class="mt-4 text-center">
        <p class="small text-muted mb-1">Butuh akun untuk Tim Anda?</p>
        <a href="{{ route('register.superadmin') }}" class="text-primary fw-bold text-decoration-none small">Daftar Di Sini</a>
    </div>
    <div class="back-to-landing">
        <a href="{{ url('/') }}"><i class="fas fa-arrow-left me-1 small"></i> Kembali </a>
    </div>
    </div>
</div>

<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('passwordInput');
        const icon = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    });
</script>

</body>
</html>
