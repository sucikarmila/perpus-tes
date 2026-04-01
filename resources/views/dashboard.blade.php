@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<div class="container py-4">
    <div class="mb-5 animate__animated animate__fadeIn">
        <h4 class="fw-bold text-dark mb-1">Halo, {{ Auth::user()->NamaLengkap }}</h4>
        <p class="text-muted small">Selamat datang di panel kendali {{ strtoupper(Auth::user()->Role) }}.</p>
    </div>

    <div class="row g-3">
        @if(Auth::user()->Role == 'admin' || Auth::user()->Role == 'petugas')
            <div class="col-6 col-md-3">
                <a href="/kategori" class="menu-link">
                    <div class="simple-card">
                        <i class="fas fa-tags mb-3 text-primary"></i>
                        <h6>Kategori</h6>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="/buku" class="menu-link">
                    <div class="simple-card">
                        <i class="fas fa-book mb-3 text-info"></i>
                        <h6>Data Buku</h6>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="/laporan" class="menu-link">
                    <div class="simple-card">
                        <i class="fas fa-file-alt mb-3 text-success"></i>
                        <h6>Laporan</h6>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="/user-management" class="menu-link">
                    <div class="simple-card">
                        <i class="fas fa-users mb-3 text-dark"></i>
                        <h6>Pengguna</h6>
                    </div>
                </a>
            </div>
        @else
            <div class="col-12 col-md-4">
                <a href="/pinjam-buku" class="menu-link">
                    <div class="simple-card py-5">
                        <i class="fas fa-search mb-3 text-primary"></i>
                        <h5>Cari Buku</h5>
                        <p class="text-muted small mb-0">Eksplorasi koleksi digital</p>
                    </div>
                </a>
            </div>
            <div class="col-12 col-md-4">
                <a href="/riwayat" class="menu-link">
                    <div class="simple-card py-5">
                        <i class="fas fa-clock-history mb-3 text-warning"></i>
                        <h5>Riwayat</h5>
                        <p class="text-muted small mb-0">Status peminjaman Anda</p>
                    </div>
                </a>
            </div>
            <div class="col-12 col-md-4">
                <a href="/koleksi" class="menu-link">
                    <div class="simple-card py-5">
                        <i class="fas fa-bookmark mb-3 text-danger"></i>
                        <h5>Koleksi</h5>
                        <p class="text-muted small mb-0">Buku yang disimpan</p>
                    </div>
                </a>
            </div>
        @endif
    </div>
</div>

<style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #fcfcfc;
    }

    .menu-link {
        text-decoration: none;
        color: inherit;
    }

     .simple-card {
        background: #ffffff;
        border: 1px solid #f0f0f0;
        border-radius: 20px;
        padding: 30px 20px;
        text-align: center;
        transition: all 0.2s ease;
        height: 100%;
    }

    .simple-card i {
        font-size: 1.8rem;
        display: block;
    }

    .simple-card h6, .simple-card h5 {
        font-weight: 600;
        margin-bottom: 0;
    }

     .simple-card:hover {
        background: #fafafa;
        border-color: #e0e0e0;
        transform: translateY(-4px);
    }

     @media (max-width: 576px) {
        .simple-card {
            padding: 20px 10px;
        }
        .simple-card i {
            font-size: 1.5rem;
        }
    }
</style>
@endsection