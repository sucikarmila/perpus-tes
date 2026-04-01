<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-PERPUS | Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-blue: #2563eb;
            --dark-navy: #0f172a;
            --bg-light: #f8fafc;
            --danger-red: #dc3545;
            --sidebar-width: 260px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-light);
            margin: 0;
            display: flex;
        }

        /* Sidebar Style */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: #ffffff;
            border-right: 1px solid #e2e8f0;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            padding: 1.5rem;
            z-index: 1000;
        }

        .sidebar-brand {
            font-weight: 800;
            font-size: 1.25rem;
            color: var(--dark-navy);
            text-decoration: none;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
        }

        .nav-item {
            margin-bottom: 5px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: #64748b !important;
            text-decoration: none;
            font-weight: 500;
            border-radius: 12px;
            transition: all 0.2s;
        }

        .nav-link i {
            width: 20px;
            text-align: center;
        }

        .nav-link:hover, .nav-link.active {
            background-color: #f1f5f9;
            color: var(--primary-blue) !important;
        }

         .sidebar-footer {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }

        .btn-logout {
            width: 100%;
            background-color: var(--danger-red);
            color: #fff !important;
            border: none;
            padding: 12px;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            background-color: #bb2d3b;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.2);
        }

         .main-content {
    margin-left: var(--sidebar-width);
    flex-grow: 1;
    padding: 40px;
    min-height: 100vh;
    transition: all 0.3s ease;
}

 .main-content.no-sidebar {
    margin-left: 0 !important;
    padding: 0;  
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f1f5f9;  
}
.nav-link.active {
    background-color: #f1f5f9;
    color: var(--primary-blue) !important;
    font-weight: 700 !important;  
    border-right: 4px solid var(--primary-blue);
}

        .badge-notif {
            font-size: 0.7rem;
            padding: 0.4em 0.6em;
        }

         @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
                transition: 0.3s;
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
        }
        .nav-link.active {
        background-color: #f1f5f9;
        color: var(--primary-blue) !important;
        font-weight: 700 !important;  
        box-shadow: inset 4px 0 0 var(--primary-blue);  
    }

    .nav-link.active i {
        color: var(--primary-blue);
    }
    </style>
</head>
<body>
     @auth
        <aside class="sidebar">
            <a href="#" class="sidebar-brand">
                <i class="fas fa-book-open text-primary"></i> DIGITAL PERPUS
            </a>

            <ul class="nav-menu">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}" href="/dashboard">
                        <i class="fas fa-th-large"></i> Dashboard
                    </a>
                </li>
                
                @if(Auth::user()->Role == 'peminjam')
                     <li class="nav-item">
                        <a class="nav-link {{ request()->is('pinjam-buku*') ? 'active' : '' }}" href="/pinjam-buku"><i class="fas fa-book"></i> Pinjam Buku</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('koleksi*') ? 'active' : '' }}" href="/koleksi">
                            <span><i class="fas fa-bookmark"></i> Koleksi</span>
                            @if(isset($jumlahKoleksi) && $jumlahKoleksi > 0)
                                <span class="badge rounded-pill bg-danger badge-notif">{{ $jumlahKoleksi }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('riwayat*') ? 'active' : '' }}" href="/riwayat"><i class="fas fa-history"></i> Riwayat</a>
                    </li>
                @else
                     <li class="nav-item">
                        <a class="nav-link {{ request()->is('kategori*') ? 'active' : '' }}" href="/kategori"><i class="fas fa-tags"></i> Kategori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('buku*') ? 'active' : '' }}" href="/buku"><i class="fas fa-layer-group"></i> Pendataan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('konfirmasi*') || request()->routeIs('admin.konfirmasi') ? 'active' : '' }}" href="{{ route('admin.konfirmasi') }}">
                            <span><i class="fas fa-check-circle"></i> Konfirmasi</span>
                            @php
                                $notifKonfirmasi = \App\Models\Peminjaman::whereIn('StatusPeminjaman', ['Menunggu Persetujuan', 'Menunggu Konfirmasi Kembali'])->count();
                            @endphp
                            @if($notifKonfirmasi > 0)
                                <span class="badge rounded-pill bg-danger badge-notif">{{ $notifKonfirmasi }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}" href="/laporan"><i class="fas fa-file-alt"></i> Laporan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('user-management*') ? 'active' : '' }}" href="/user-management"><i class="fas fa-users-cog"></i> User</a>
                    </li>
                @endif
            </ul>

            <div class="sidebar-footer">
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-logout w-100">
                        <i class="fas fa-sign-out-alt"></i> KELUAR
                    </button>
                </form>
            </div>
        </aside>
    @endauth

     <main class="main-content {{ !Auth::check() ? 'no-sidebar' : '' }}">
        @yield('content')
    </main>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    @stack('scripts')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>