@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    :root {
        --primary: #0d6efd;
        --dark-slate: #0f172a;
    }

    nav, footer, .navbar { display: none !important; }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: radial-gradient(circle at top right, #e2e8f0, #f8fafc);
        min-height: 100vh;
        margin: 0;
    }

    .auth-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
    }

    .auth-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        width: 100%;
        max-width: 1000px; 
        display: flex;
        border-radius: 30px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
    }

    .auth-visual {
        flex: 1;
        background-image: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=1000&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
        position: relative;
        padding: 60px;
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .auth-visual::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(to right, var(--dark-slate) 20%, transparent 100%);
    }

    .visual-content {
        position: relative;
        z-index: 1;
    }

    .auth-form {
        flex: 1.1;
        padding: 60px;
        background: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .input-label {
        font-size: 0.8rem;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 6px;
        display: block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control-custom {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #f1f5f9;
        border-radius: 12px;
        background: #f8fafc;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        margin-bottom: 20px;
    }

    .form-control-custom:focus {
        outline: none;
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.08);
    }

    .btn-login {
        width: 100%;
        padding: 16px;
        border: none;
        border-radius: 12px;
        background: var(--dark-slate);
        color: white;
        font-weight: 700;
        font-size: 1rem;
        transition: all 0.3s ease;
        margin-top: 10px;
    }

    .btn-login:hover {
        background: var(--primary);
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(13, 110, 253, 0.2);
    }

    .alert-custom {
        border-radius: 15px;
        border: none;
        background-color: #fee2e2;
        color: #b91c1c;
        font-size: 0.85rem;
        padding: 12px 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    @media (max-width: 991px) {
        .auth-visual { display: none; }
        .auth-card { max-width: 500px; }
        .auth-form { padding: 40px; }
    }
</style>

<div class="auth-container">
    <div class="auth-card animate__animated animate__fadeIn">
        
        <div class="auth-visual">
            <div class="visual-content">
                <h1 class="fw-bold mb-3">Selamat Datang <br> Kembali.</h1>
                <p class="text-white-50">Lanjutkan perjalanan literasimu dan kelola koleksi buku favoritmu dengan mudah.</p>
                <div class="mt-4">
                    <span class="badge border border-light rounded-pill px-3 py-2">E-Perpus Dashboard</span>
                </div>
            </div>
        </div>

        <div class="auth-form">
            <div class="mb-4">
                <h2 class="fw-bold text-dark mb-1">Masuk Akun</h2>
                <p class="text-muted small">Silahkan masukkan Anda untuk mengakses sistem</p>
            </div>

            @if($errors->has('loginError'))
                <div class="alert alert-danger alert-custom mb-4 animate__animated animate__shakeX">
                    <i class="bi bi-exclamation-circle-fill"></i> {{ $errors->first('loginError') }}
                </div>
            @endif

            <form action="/login" method="POST">
                @csrf
                
                <label class="input-label">Username</label>
                <input type="text" name="Username" class="form-control-custom" placeholder="Masukkan username Anda" required autofocus>

                <label class="input-label">Password</label>
                <input type="password" name="Password" class="form-control-custom" placeholder="Masukkan password Anda" required>

                <button type="submit" class="btn-login">
                    LOGIN <i class="bi bi-arrow-right-short ms-2 fs-5"></i>
                </button>
            </form>

            <div class="text-center mt-5">
                <p class="small text-muted">Belum memiliki akun? 
                    <a href="/register" class="fw-bold text-decoration-none text-primary">Daftar</a>
                </p>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 3000, showConfirmButton: false });
    @endif

    @if(session('success_admin'))
        Swal.fire({ title: 'Mode Admin', text: "{{ session('success_admin') }}", icon: 'info', confirmButtonColor: '#0f172a' });
    @endif
</script>
@endpush
@endsection