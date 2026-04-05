<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Instansi | Ciptatech</title>
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
            padding: 40px 0;
        }

        .register-container {
            width: 100%;
            max-width: 500px;
            padding: 20px;
        }

        .register-card {
            background: #ffffff;
            border: none;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04);
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .register-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), #4cc9f0);
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

        .btn-register {
            background: var(--primary);
            color: white;
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
        }

        .btn-register:hover {
            background: #3751d7;
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(67, 97, 238, 0.3);
            color: white;
        }

        .back-link {
            text-align: center;
            margin-top: 24px;
        }

        .back-link a {
            color: #64748b;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .back-link a:hover {
            color: var(--primary);
        }
    </style>
</head>
<body>

<div class="register-container">
    <div class="register-card">
        <h4 class="text-center fw-bold mb-1">Daftar Instansi Baru</h4>
        <p class="text-center text-muted small mb-4">Buat tim dan mulai kelola laporan dengan Ciptatech</p>

        @if($errors->any())
            <div class="alert alert-danger border-0 small rounded-3 mb-4">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.superadmin.post') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Instansi / Perusahaan</label>
                <input type="text" name="organization_name" class="form-control" placeholder="Contoh: PT Teknologi Maju" value="{{ old('organization_name') }}" required>
            </div>

            <hr class="my-4 opacity-25">

            <div class="mb-3">
                <label class="form-label">Nama Lengkap Superadmin</label>
                <input type="text" name="name" class="form-control" placeholder="Nama Anda" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="email@instansi.com" value="{{ old('email') }}" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn btn-register w-100 mt-3">
                Daftar & Buat Tim <i class="fas fa-rocket ms-2"></i>
            </button>
        </form>
    </div>

    <div class="back-link">
        <a href="{{ route('login') }}">Sudah punya akun? <b>Login di sini</b></a>
    </div>
</div>

</body>
</html>
