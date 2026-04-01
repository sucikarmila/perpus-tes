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
        background: radial-gradient(circle at top left, #e2e8f0, #f8fafc);
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
        max-width: 1100px;
        display: flex;
        flex-direction: row-reverse; 
        border-radius: 30px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
    }

    .auth-visual {
        flex: 1;
        background-image: url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da?q=80&w=1000&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
        position: relative;
        padding: 60px;
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: right;
    }

    .auth-visual::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(to left, var(--dark-slate) 20%, transparent 100%);
    }

    .visual-content {
        position: relative;
        z-index: 1;
    }

    .auth-form {
        flex: 1.2;
        padding: 50px 60px;
        background: white;
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
        padding: 12px 16px;
        border: 2px solid #f1f5f9;
        border-radius: 12px;
        background: #f8fafc;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        margin-bottom: 18px;
    }

    .form-control-custom:focus {
        outline: none;
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.08);
    }

    .btn-register {
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

    .btn-register:hover {
        background: var(--primary);
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(13, 110, 253, 0.2);
    }

    @media (max-width: 991px) {
        .auth-visual { display: none; }
        .auth-card { max-width: 550px; }
        .auth-form { padding: 40px; }
    }
</style>

<div class="auth-container">
    <div class="auth-card animate__animated animate__fadeInUp">
        
        <div class="auth-visual">
            <div class="visual-content">
                <h1 class="fw-bold mb-3">Mulai Petualangan <br> Literasimu.</h1>
                <p class="text-white-50">Bergabunglah sekarang untuk mendapatkan akses ke koleksi buku digital kami.</p>
                <div class="mt-4">
                    <span class="badge border border-light rounded-pill px-3 py-2">E-Perpus Group</span>
                </div>
            </div>
        </div>

        <div class="auth-form">
            <div class="mb-4">
                <h2 class="fw-bold text-dark mb-1">Daftar Akun</h2>
                <p class="text-muted small">Lengkapi data diri Anda di bawah ini</p>
            </div>

            <form action="/register" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <label class="input-label">Username</label>
                        <input type="text" name="Username" class="form-control-custom" placeholder="suci_12" required autofocus>
                    </div>
                    <div class="col-md-6">
                        <label class="input-label">Nama Lengkap</label>
                        <input type="text" name="NamaLengkap" class="form-control-custom" placeholder="Nama Lengkap" required>
                    </div>
                </div>

                <label class="input-label">Alamat Email</label>
                <input type="email" name="Email" class="form-control-custom" placeholder="suci@gmail.com" required>

                <label class="input-label">Alamat Lengkap</label>
                <textarea name="Alamat" class="form-control-custom" rows="2" placeholder="Masukkan alamat anda..." required></textarea>

                <label class="input-label">Password</label>
                <input type="password" name="Password" class="form-control-custom" placeholder="Masukkan password anda" required>

                <button type="submit" class="btn-register">
                    DAFTAR 
                </button>
            </form>

            <div class="text-center mt-4">
                <p class="small text-muted">Sudah punya akun? 
                    <a href="/" class="fw-bold text-decoration-none text-primary">login</a>
                </p>
            </div>
        </div>

    </div>
</div>
@endsection