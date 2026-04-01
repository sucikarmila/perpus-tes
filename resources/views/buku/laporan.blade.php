@extends('layouts.app')

@section('content')
<div class="container-fluid py-2">
    <div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
        <div>
            <h3 class="fw-bold text-dark mb-1">Laporan Aktivitas</h3>
            <p class="text-muted small mb-0">Arsip riwayat peminjaman dan pengembalian buku perpustakaan.</p>
        </div>
        <button onclick="window.print()" class="btn btn-primary rounded-pill px-4 shadow-sm fw-600">
            <i class="fas fa-print me-2"></i> Cetak Laporan
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4 d-print-none">
        <div class="card-body p-4">
            <form action="{{ url('/laporan') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted text-uppercase">Mulai Tanggal</label>
                    <input type="date" name="start_date" class="form-control custom-input" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted text-uppercase">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="form-control custom-input" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1 rounded-3 fw-600 py-2">
                            <i class="fas fa-filter me-1"></i> Filter Data
                        </button>
                        <a href="{{ url('/laporan') }}" class="btn btn-light border flex-grow-1 rounded-3 fw-600 py-2 text-muted">
                            <i class="fas fa-undo me-1"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="d-none d-print-block">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-uppercase mb-1" style="letter-spacing: 3px; font-size: 26px; color: #000;">Laporan Aktivitas Perpustakaan</h2>
            <h4 class="fw-600 mb-2" style="font-size: 18px; color: #2563eb;">E-PERPUS DIGITAL LIBRARY</h4>
            <p class="mb-0 small text-muted">Jl. Perpustakaan No. 123, Kota Malang | Telp: (021) 12345678 | Website: www.eperpus.com</p>
            <div class="mt-3" style="border-top: 3px solid #000; border-bottom: 1px solid #000; height: 5px;"></div>
        </div>
        <div class="d-flex justify-content-between mb-4">
            <p class="small mb-0">Periode: <strong>{{ request('start_date') ?? 'Awal' }}</strong> s/d <strong>{{ request('end_date') ?? 'Sekarang' }}</strong></p>
            <p class="small mb-0">Dicetak pada: <strong>{{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') }}</strong></p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden card-print animate__animated animate__fadeIn">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0" id="reportTable">
                <thead class="bg-light-table">
                    <tr>
                        <th class="text-center py-3 text-secondary small fw-bold" width="5%">NO</th>
                        <th class="py-3 text-secondary small fw-bold">PEMINJAM</th>
                        <th class="py-3 text-secondary small fw-bold">INFORMASI BUKU</th>
                        <th class="py-3 text-secondary small fw-bold text-center">PINJAM</th>
                        <th class="py-3 text-secondary small fw-bold text-center">KEMBALI</th>
                        <th class="py-3 text-secondary small fw-bold text-center">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporan as $index => $p)
                    <tr>
                        <td class="text-center small fw-600 text-muted">{{ $index + 1 }}</td>
                        <td class="ps-3">
                            <div class="fw-bold text-dark">{{ $p->user->Username }}</div>
                            <small class="text-muted" style="font-size: 11px;">{{ $p->user->Email }}</small>
                        </td>
                        <td class="ps-3">
                            <div class="fw-600 text-dark">{{ $p->buku->Judul }}</div>
                            <small class="text-muted" style="font-size: 11px;">ISBN: {{ $p->buku->Penerbit }} ({{ $p->buku->TahunTerbit }})</small>
                        </td>
                        <td class="text-center small">
                            <span class="text-dark">{{ date('d/m/Y', strtotime($p->TanggalPeminjaman)) }}</span>
                        </td>
                        <td class="text-center small">
                            <span class="{{ $p->TanggalPengembalian ? 'text-dark' : 'text-danger fw-bold' }}">
                                {{ $p->TanggalPengembalian ? date('d/m/Y', strtotime($p->TanggalPengembalian)) : 'Belum Kembali' }}
                            </span>
                        </td>
                        <td class="text-center">
                            @php
                                $status = strtolower($p->StatusPeminjaman);
                                $badgeClass = 'bg-soft-secondary text-secondary';
                                if($status == 'dikembalikan' || $status == 'kembali') $badgeClass = 'bg-soft-success text-success';
                                if($status == 'dipinjam') $badgeClass = 'bg-soft-danger text-danger';
                                if($status == 'menunggu persetujuan') $badgeClass = 'bg-soft-warning text-warning';
                            @endphp
                            
                            <span class="d-print-none badge {{ $badgeClass }} px-3 py-2 rounded-pill fw-bold small">
                                {{ ucfirst($p->StatusPeminjaman) }}
                            </span>
                            <span class="d-none d-print-block fw-bold {{ str_contains($status, 'kembali') ? 'text-success' : 'text-dark' }}">
                                {{ ucfirst($p->StatusPeminjaman) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Data tidak ditemukan untuk periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-none d-print-block mt-5 pt-4">
        <div class="row">
            <div class="col-8">
            </div>
            <div class="col-4 text-center">
                <p class="mb-5 text-dark">Malang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br> <strong>Kepala Unit Perpustakaan</strong></p>
                <br><br>
                <p class="mb-0 fw-bold text-dark text-decoration-underline">( ____________________ )</p>
                <p class="small text-muted">NIP. 19820301 200501 1 002</p>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-600 { font-weight: 600; }
    .bg-light-table { background-color: #f8fafc; }
    
     .custom-input {
        background: #f8fafc;
        border: 2px solid #f1f5f9;
        border-radius: 12px;
        padding: 10px 15px;
        font-size: 0.9rem;
        transition: 0.2s;
    }
    .custom-input:focus {
        background: #fff;
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }

     .bg-soft-success { background-color: #f0fdf4; color: #16a34a; }
    .bg-soft-danger { background-color: #fff1f2; color: #e11d48; }
    .bg-soft-warning { background-color: #fffbeb; color: #d97706; }
    .bg-soft-secondary { background-color: #f1f5f9; color: #475569; }

    @media print {
        @page {
            size: A4;
            margin: 1.5cm; 
        }
        
        body {
            background-color: #fff !important;
            font-family: "Times New Roman", Times, serif;
            color: #000 !important;
        }

        .container-fluid { padding: 0 !important; }
        
        .table {
            width: 100% !important;
            border-collapse: collapse !important;
        }

        .table th, .table td {
            border: 1px solid #dee2e6 !important;
            padding: 10px !important;
            color: #000 !important;
        }
        
        .table thead th {
            background-color: #f2f2f2 !important;
            -webkit-print-color-adjust: exact;
        }

        .card-print { 
            border: none !important; 
            box-shadow: none !important; 
        }
        
        .d-print-none { display: none !important; }
        .d-print-block { display: block !important; }
        
         .text-success { color: #16a34a !important; }
        .text-danger { color: #e11d48 !important; }
        .text-primary { color: #2563eb !important; }
    }
</style>
@endsection