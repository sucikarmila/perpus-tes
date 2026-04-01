@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <div class="bg-white p-4 p-lg-5 shadow-sm animate__animated animate__fadeInUp" style="border-radius: 25px;">
                
                <div class="text-center mb-5">
                    <div class="position-relative d-inline-block mb-3">
                        @if($buku->Gambar)
                            <img src="{{ asset('storage/'.$buku->Gambar) }}" class="rounded-3 shadow-sm" style="width: 100px; height: 140px; object-fit: cover;" alt="{{ $buku->Judul }}">
                        @else
                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center mx-auto" style="width: 100px; height: 140px;">
                                <i class="fas fa-book fa-3x text-muted opacity-25"></i>
                            </div>
                        @endif
                    </div>
                    <h3 class="fw-800 text-dark mb-1">{{ $buku->Judul }}</h3>
                    <p class="text-muted small">Karya: <span class="fw-bold">{{ $buku->Penulis }}</span></p>
                    <hr class="mx-auto w-25 opacity-10">
                </div>

                <form action="{{ route('pinjam.proses') }}" method="POST" id="formPinjam">
                    @csrf
                    <input type="hidden" name="BukuID" value="{{ $buku->BukuID }}">
                    
                    <div class="alert alert-primary border-0 rounded-4 p-3 mb-4 d-flex align-items-center">
                        <i class="fas fa-info-circle fa-lg me-3"></i>
                        <div class="small">
                            <div class="fw-bold">Ketentuan Perpustakaan:</div>
                            Denda keterlambatan sebesar <span class="fw-bold text-danger">Rp 1.000/hari</span>.
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark small text-uppercase">Durasi Peminjaman</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 rounded-start-pill px-3">
                                <i class="fas fa-calendar-alt text-primary"></i>
                            </span>
                            <select name="lama_pinjam" id="lama_pinjam" class="form-select bg-light border-start-0 rounded-end-pill py-2 fw-semibold" required>
                                <option value="3">3 Hari (Kilat)</option>
                                <option value="7" selected>7 Hari (Normal)</option>
                                <option value="14">14 Hari (Lama)</option>
                            </select>
                        </div>
                        <div class="form-text mt-2 ms-2 fs-xs italic text-muted">
                            <i class="fas fa-magic me-1"></i> Sistem akan menghitung tanggal kembali secara otomatis.
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-5">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold py-3 shadow-sm btn-confirm" id="btnSubmit">
                            Konfirmasi Peminjaman
                        </button>
                        <a href="/pinjam-buku" class="btn btn-link text-muted fw-bold text-decoration-none small mt-1">
                            Batal
                        </a>
                    </div>
                </form>
            </div>

            

        </div>
    </div>
</div>

<style>
    body { background-color: #f8fafc; }
    .fw-800 { font-weight: 800; }
    .fs-xs { font-size: 0.7rem; }
    
     .form-select:focus, .form-control:focus {
        border-color: #0d6efd;
        box-shadow: none;
    }

    .input-group-text {
        border-color: #dee2e6;
    }

     .btn-confirm {
        background: linear-gradient(135deg, #0d6efd 0%, #0062cc 100%);
        border: none;
        transition: all 0.3s ease;
    }

    .btn-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(13, 110, 253, 0.2) !important;
    }

    .rounded-pill { border-radius: 50px !important; }
</style>

@push('scripts')
<script>
    document.getElementById('formPinjam').onsubmit = function() {
        const btn = document.getElementById('btnSubmit');
        btn.classList.add('disabled');
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses...';
    };
</script>
@endpush
@endsection