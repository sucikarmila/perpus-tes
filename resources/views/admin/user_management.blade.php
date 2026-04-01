@extends('layouts.app')

@section('content')
<div class="container-fluid py-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Kelola User & Petugas</h3>
            <p class="text-muted small mb-0">Kelola hak akses kontrol, admin, dan petugas perpustakaan.</p>
        </div>
        <button class="btn btn-primary rounded-pill shadow-sm px-4 fw-600" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="fas fa-user-plus me-2"></i> Tambah Akun
        </button>
    </div>

    @if(session('error'))
    <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 animate__animated animate__shakeX" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-triangle me-3 fs-4"></i>
            <div>
                <span class="fw-bold">Akses Ditolak!</span> {{ session('error') }}
            </div>
        </div>
    </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden animate__animated animate__fadeIn">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light-table">
                        <tr>
                            <th class="px-4 py-3 text-secondary small fw-bold" width="30%">PENGGUNA</th>
                            <th class="py-3 text-secondary small fw-bold" width="30%">EMAIL ADDRESS</th>
                            <th class="py-3 text-secondary small fw-bold">ROLE AKSES</th>
                            <th class="py-3 text-secondary small fw-bold text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $u)
                        <tr>
                            <td class="px-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-user me-3">
                                        {{ strtoupper(substr($u->Username, 0, 1)) }}
                                    </div>
                                    <div class="fw-bold text-dark">{{ $u->Username }}</div>
                                </div>
                            </td>
                            <td>
                                <span class="text-muted small"><i class="far fa-envelope me-1"></i> {{ $u->Email }}</span>
                            </td>
                            <td>
                                @php
                                    $roleStyle = $u->Role == 'admin' 
                                        ? 'bg-soft-danger text-danger border-danger-subtle' 
                                        : 'bg-soft-success text-success border-success-subtle';
                                @endphp
                                <span class="badge rounded-pill px-3 py-2 border {{ $roleStyle }} fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                    <i class="fas fa-shield-alt me-1"></i> {{ strtoupper($u->Role) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn-action-user edit" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEdit{{ $u->UserID }}"
                                            title="Edit Akun">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    
                                    @if(Auth::user()->UserID != $u->UserID)
                                    <form action="{{ route('user.destroy', $u->UserID) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn-action-user delete" onclick="confirmDeleteUser(this)" title="Hapus Akun">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('user.store') }}" method="POST" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold text-dark mb-0"><i class="fas fa-user-plus text-primary me-2"></i>Tambah Akun Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Username</label>
                    <input type="text" name="Username" class="form-control custom-input" placeholder="Contoh: admin_pus" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Email Address</label>
                    <input type="email" name="Email" class="form-control custom-input" placeholder="nama@email.com" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Password</label>
                    <input type="password" name="Password" class="form-control custom-input" placeholder="Minimal 6 karakter" required>
                </div>
                <div class="mb-2">
                    <label class="form-label small fw-bold text-muted text-uppercase">Role Hak Akses</label>
                    <select name="Role" class="form-select custom-input">
                        <option value="petugas">Petugas Perpustakaan</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill shadow-sm">Daftarkan Akun</button>
            </div>
        </form>
    </div>
</div>

@foreach($users as $u)
<div class="modal fade" id="modalEdit{{ $u->UserID }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('user.update', $u->UserID) }}" method="POST" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            @method('PUT')
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold text-dark mb-0"><i class="fas fa-user-edit text-primary me-2"></i>Perbarui Data Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Username</label>
                    <input type="text" name="Username" class="form-control custom-input" value="{{ $u->Username }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Email Address</label>
                    <input type="email" name="Email" class="form-control custom-input" value="{{ $u->Email }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Ganti Password</label>
                    <input type="password" name="Password" class="form-control custom-input" placeholder="Biarkan kosong jika tidak ingin ganti">
                </div>
                <div class="mb-2">
                    <label class="form-label small fw-bold text-muted text-uppercase">Role Hak Akses</label>
                    <select name="Role" class="form-select custom-input">
                        <option value="petugas" {{ $u->Role == 'petugas' ? 'selected' : '' }}>Petugas Perpustakaan</option>
                        <option value="admin" {{ $u->Role == 'admin' ? 'selected' : '' }}>Administrator</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill shadow-sm">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<style>
    .fw-600 { font-weight: 600; }
    .bg-light-table { background-color: #f8fafc; }
    
     .avatar-user {
        width: 36px;
        height: 36px;
        background: linear-gradient(45deg, #2563eb, #60a5fa);
        color: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.85rem;
        box-shadow: 0 4px 8px rgba(37, 99, 235, 0.15);
    }

     .bg-soft-danger { background-color: #fff1f2; }
    .bg-soft-success { background-color: #f0fdf4; }

     .custom-input {
        background-color: #f8fafc;
        border: 2px solid #f1f5f9;
        border-radius: 12px;
        padding: 10px 15px;
        font-size: 0.9rem;
        transition: 0.2s;
    }
    .custom-input:focus {
        background-color: #fff;
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }

     .btn-action-user {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: 0.2s;
        font-size: 0.85rem;
    }
    .btn-action-user.edit {
        background-color: #eff6ff;
        color: #2563eb;
    }
    .btn-action-user.edit:hover {
        background-color: #2563eb;
        color: white;
        transform: translateY(-2px);
    }
    .btn-action-user.delete {
        background-color: #fff1f2;
        color: #e11d48;
    }
    .btn-action-user.delete:hover {
        background-color: #e11d48;
        color: white;
        transform: translateY(-2px);
    }
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.confirmDeleteUser = function(button) {
        Swal.fire({
            title: 'Hapus Akun Ini?',
            text: "Akun tersebut tidak akan bisa mengakses sistem lagi.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-4 shadow-lg'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 2000,
            showConfirmButton: false,
            customClass: {
                popup: 'rounded-4 shadow-lg'
            }
        });
    @endif
</script>
@endpush
@endsection