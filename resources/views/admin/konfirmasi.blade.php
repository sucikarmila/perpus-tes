@extends('layouts.app')

@section('content')
<div class="container-fluid py-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Konfirmasi Peminjaman</h3>
            <p class="text-muted small mb-0">Kelola persetujuan pinjam dan pengembalian buku dalam satu tempat.</p>
        </div>
        <div class="text-end">
            <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill fw-600">
                <i class="fas fa-bell me-1"></i> {{ $peminjaman->count() }} Permintaan Butuh Tindakan
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 animate__animated animate__fadeInDown">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-3 fa-lg"></i>
                <div>{{ session('success') }}</div>
            </div>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden animate__animated animate__fadeIn">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light-table">
                        <tr>
                            <th class="px-4 py-3 text-secondary small fw-bold">PEMINJAM</th>
                            <th class="py-3 text-secondary small fw-bold">DETAIL BUKU</th>
                            <th class="py-3 text-secondary small fw-bold">TANGGAL PINJAM</th>
                            <th class="py-3 text-secondary small fw-bold text-center">STATUS</th>
                            <th class="py-3 text-secondary small fw-bold text-center">ULASAN</th>
                            <th class="py-3 text-secondary small fw-bold text-center" width="20%">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjaman as $p)
                        <tr>
                            <td class="px-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3">
                                        {{ strtoupper(substr($p->user->Username, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $p->user->Username }}</div>
                                        <small class="text-muted">{{ $p->user->Email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-600 text-primary">{{ $p->buku->Judul }}</div>
                                <small class="text-muted">ID Buku: #{{ $p->BukuID }}</small>
                            </td>
                            <td>
                                <div class="text-dark fw-500 small">
                                    <i class="far fa-calendar-alt me-1 text-muted"></i>
                                    {{ \Carbon\Carbon::parse($p->TanggalPeminjaman)->format('d M Y') }}
                                </div>
                                <small class="text-muted fst-italic small">Sistem Otomatis</small>
                            </td>
                            <td class="text-center">
                                @if($p->StatusPeminjaman == 'Menunggu Persetujuan')
                                    <span class="custom-badge-warning">Butuh Persetujuan</span>
                                @else
                                    <span class="custom-badge-info">Proses Kembali</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-light-primary rounded-pill px-3 fw-600 small" data-bs-toggle="modal" data-bs-target="#modalBalasUlasan{{ $p->BukuID }}">
                                    <i class="fas fa-comments me-1"></i> Ulasan
                                </button>
                            </td>
                            <td class="px-4 text-center">
                                @if($p->StatusPeminjaman == 'Menunggu Persetujuan')
                                    <div class="d-flex justify-content-center gap-2">
                                        <form action="/setujui-pinjam/{{$p->PeminjamanID}}" method="POST">
                                            @csrf
                                            <button class="btn-action approve shadow-sm" title="Setujui">
                                                <i class="fas fa-check me-1"></i> SETUJUI
                                            </button>
                                        </form>

                                        <form action="/tolak-pinjam/{{$p->PeminjamanID}}" method="POST" id="tolakForm{{$p->PeminjamanID}}">
                                            @csrf
                                            <button type="button" class="btn-action delete shadow-sm" onclick="confirmTolak('{{$p->PeminjamanID}}')" title="Tolak">
                                                <i class="fas fa-times me-1"></i> TOLAK
                                            </button>
                                        </form>
                                    </div>
                                @elseif($p->StatusPeminjaman == 'Menunggu Konfirmasi Kembali')
                                    <form action="/setujui-kembali/{{$p->PeminjamanID}}" method="POST">
                                        @csrf
                                        <button class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm fw-bold w-100 py-2">
                                            <i class="fas fa-file-import me-1"></i> Konfirmasi Terima
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="opacity-25 mb-3">
                                    <i class="fas fa-clipboard-check fa-4x text-muted"></i>
                                </div>
                                <h5 class="text-muted fw-normal">Semua permintaan telah diproses</h5>
                                <p class="text-muted small">Belum ada antrean peminjaman baru saat ini.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach($peminjaman as $p)
<div class="modal fade" id="modalBalasUlasan{{ $p->BukuID }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header border-0 bg-light px-4 py-3">
                <h5 class="modal-title fw-bold text-dark small text-uppercase tracking-wider">
                    <i class="fas fa-star text-warning me-2"></i>Ulasan Buku
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" style="max-height: 450px; overflow-y: auto;">
                <div class="mb-4 text-center">
                    <h6 class="fw-bold mb-1">{{ $p->buku->Judul }}</h6>
                    <p class="text-muted small">{{ $p->buku->Penulis }}</p>
                </div>

                @forelse($p->buku->ulasan as $u)
                    <div class="mb-3 p-3 rounded-4 border shadow-sm {{ $u->BalasanAdmin ? 'bg-white' : 'bg-light-soft' }}">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold text-primary small">{{ $u->user->Username }}</span>
                            <div class="text-warning small">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="{{ $i <= $u->Rating ? 'fas' : 'far' }} fa-star fa-xs"></i>
                                @endfor
                            </div>
                        </div>
                        <p class="text-dark small mb-2 lh-base">"{{ $u->Ulasan }}"</p>
                        
                        @if($u->BalasanAdmin)
                            <div class="ms-3 p-2 border-start border-primary border-3 bg-soft-primary rounded-3 mt-2">
                                <small class="fw-bold d-block text-primary" style="font-size: 0.7rem;">
                                    <i class="fas fa-reply me-1"></i>BALASAN ADMIN:
                                </small>
                                <p class="small mb-0 text-dark fst-italic">{{ $u->BalasanAdmin }}</p>
                            </div>
                        @else
                            <form action="{{ route('admin.balas.ulasan', $u->UlasanID) }}" method="POST" class="mt-3">
                                @csrf
                                <div class="input-group input-group-sm">
                                    <input type="text" name="BalasanAdmin" class="form-control border-primary-subtle bg-white" placeholder="Tulis balasan..." required>
                                    <button class="btn btn-primary" type="submit">Kirim</button>
                                </div>
                            </form>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-4">
                        <i class="fas fa-comment-slash fa-3x text-light mb-3"></i>
                        <p class="text-muted small">Belum ada ulasan untuk buku ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endforeach

<style>
    .fw-600 { font-weight: 600; }
    .fw-500 { font-weight: 500; }
    .bg-light-table { background-color: #f8fafc; }
    .bg-light-soft { background-color: #f1f5f9; }

    .avatar-circle {
        width: 38px;
        height: 38px;
        background: linear-gradient(135deg, #2563eb, #3b82f6);
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.9rem;
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2);
    }

    .custom-badge-warning {
        background-color: #fffbeb;
        color: #d97706;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.7rem;
        border: 1px solid #fde68a;
        text-transform: uppercase;
    }
    .custom-badge-info {
        background-color: #eff6ff;
        color: #2563eb;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.7rem;
        border: 1px solid #dbeafe;
        text-transform: uppercase;
    }

    .btn-light-primary {
        background-color: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
        transition: 0.2s;
    }
    .btn-light-primary:hover {
        background-color: #2563eb;
        color: white;
        border-color: #2563eb;
    }

    .btn-action {
        padding: 8px 14px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.65rem;
        letter-spacing: 0.5px;
        transition: 0.2s;
        border: none;
    }

    .btn-action.approve {
        background-color: #f0fdf4;
        color: #16a34a;
        border: 1px solid #bbf7d0;
    }
    .btn-action.approve:hover {
        background-color: #16a34a;
        color: white;
        transform: translateY(-2px);
    }

    .btn-action.delete {
        background-color: #fff1f2;
        color: #e11d48;
        border: 1px solid #fecdd3;
    }
    .btn-action.delete:hover {
        background-color: #e11d48;
        color: white;
        transform: translateY(-2px);
    }

    .modal-body::-webkit-scrollbar { width: 6px; }
    .modal-body::-webkit-scrollbar-track { background: #f1f1f1; }
    .modal-body::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmTolak(id) {
        Swal.fire({
            title: 'Tolak Peminjaman?',
            text: "Permintaan peminjaman ini akan dibatalkan secara permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Tolak!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-4 shadow-lg'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('tolakForm' + id).submit();
            }
        })
    }
</script>
@endsection