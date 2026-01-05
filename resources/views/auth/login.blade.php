<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Sistem</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #2c2c2cff, #252525ff);
            overflow: hidden;
            font-family: 'Segoe UI', sans-serif;
        }

        .bubbles {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .bubbles span {
            position: absolute;
            bottom: -100px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            animation: rise 20s infinite ease-in;
        }

        @keyframes rise {
            0% {
                transform: translateY(0) scale(0.8);
                opacity: 0;
            }
            50% {
                opacity: 0.5;
            }
            100% {
                transform: translateY(-120vh) scale(1.2);
                opacity: 0;
            }
        }

        /* Card */
        .login-card {
            position: relative;
            z-index: 1;
            border: none;
            border-radius: 18px;
            backdrop-filter: blur(12px);
            background: rgba(255,255,255,0.9);
        }

        .login-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #020202ff, #282828ff);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: -48px auto 16px;
            font-size: 24px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #6d28d9;
        }

        .btn-login {
            background: linear-gradient(135deg, #2a2a2aff, #000000ff);
            border: none;
        }

        .btn-login:hover {
            opacity: 0.9;
        }

        /* Responsive tweaks */
        @media (max-width: 576px) {
            .login-card {
                margin: 0 12px;
            }
        }
    </style>
</head>

<body>
<div class="bubbles">
    <span style="width:40px;height:40px;left:10%;animation-duration:18s;"></span>
    <span style="width:60px;height:60px;left:25%;animation-duration:22s;"></span>
    <span style="width:30px;height:30px;left:40%;animation-duration:16s;"></span>
    <span style="width:70px;height:70px;left:55%;animation-duration:25s;"></span>
    <span style="width:50px;height:50px;left:70%;animation-duration:20s;"></span>
    <span style="width:35px;height:35px;left:85%;animation-duration:19s;"></span>
</div>

<div class="container">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-12 col-sm-10 col-md-6 col-lg-4">

            <div class="card shadow login-card">
                <div class="card-body p-4">

                    <div class="login-icon shadow">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>

                    <h5 class="text-center fw-bold mb-1">Login Ciptatech</h5>
                    <p class="text-center text-muted small mb-4">
                        Masuk ke akun anda
                    </p>

                    @error('email')
                        <div class="alert alert-danger small">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            {{ $message }}
                        </div>
                    @enderror

                    <form method="POST" action="/login">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="email@example.com" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        </div>

                        <div class="form-check mb-4">
                            <input type="checkbox" class="form-check-input" name="remember">
                            <label class="form-check-label small">Remember me</label>
                        </div>

                        <button class="btn btn-login w-100 py-2 fw-semibold text-white">
                            <i class="fa-solid fa-right-to-bracket me-1"></i>
                            Login
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
