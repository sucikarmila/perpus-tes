@extends('layouts.app')

@section('content')
<div class="container-fluid py-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Kelola Katalog Buku</h3>
            <p class="text-muted small mb-0">Manajemen inventaris, stok, dan klasifikasi buku perpustakaan.</p>
        </div>
        <button class="btn btn-primary rounded-pill px-4 shadow-sm fw-600" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="fas fa-plus-circle me-2"></i>Tambah Buku
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden animate__animated animate__fadeIn">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light-table">
                        <tr>
                            <th class="px-4 py-3 text-secondary small fw-bold" width="8%">COVER</th>
                            <th class="py-3 text-secondary small fw-bold" width="30%">INFORMASI BUKU</th>
                            <th class="py-3 text-secondary small fw-bold">PENULIS</th>
                            <th class="py-3 text-secondary small fw-bold">KATEGORI</th>
                            <th class="py-3 text-secondary small fw-bold text-center">STOK</th>
                            <th class="py-3 text-secondary small fw-bold text-center" width="15%">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($buku as $b)
                        <tr>
                            <td class="px-4">
                                @if($b->Gambar)
                                    <img src="{{ asset('storage/'.$b->Gambar) }}" class="rounded-3 shadow-sm img-cover-table">
                                @else
                                    <div class="no-image-placeholder rounded-3">
                                        <i class="fas fa-book opacity-25"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <span class="fw-bold text-dark d-block mb-1">{{ $b->Judul }}</span>
                                <p class="text-muted small mb-0 lh-sm text-truncate" style="max-width: 250px;">
                                    {{ $b->Deskripsi ?? 'Tidak ada deskripsi.' }}
                                </p>
                            </td>
                            <td><span class="text-dark fw-500 small">{{ $b->Penulis }}</span></td>
                            <td>
                                <span class="badge rounded-pill bg-soft-primary text-primary px-3">
                                    {{ $b->kategori->NamaKategori ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($b->Stok > 5)
                                    <span class="badge bg-soft-success text-success border-0 px-3">{{ $b->Stok }} Unit</span>
                                @elseif($b->Stok > 0)
                                    <span class="badge bg-soft-warning text-warning border-0 px-3">{{ $b->Stok }} Tipis</span>
                                @else
                                    <span class="badge bg-soft-danger text-danger border-0 px-3">Habis</span>
                                @endif
                            </td> 
                            <td class="text-center px-4">
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn-action-round edit" data-bs-toggle="modal" data-bs-target="#editBuku{{ $b->BukuID }}" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <form action="{{ route('buku.destroy', $b->BukuID) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-action-round delete" onclick="confirmDelete(this)" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
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
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-dark"><i class="fas fa-plus-circle me-2 text-primary"></i>Tambah Buku Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-md-7">
                        <label class="form-label small fw-bold text-muted text-uppercase">Judul Buku</label>
                        <input type="text" name="Judul" class="form-control custom-input" placeholder="Masukkan judul lengkap" required>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small fw-bold text-muted text-uppercase">Penulis</label>
                        <input type="text" name="Penulis" class="form-control custom-input" placeholder="Nama penulis" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted text-uppercase">Penerbit</label>
                        <input type="text" name="Penerbit" class="form-control custom-input" placeholder="Nama penerbit" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Tahun</label>
                        <input type="number" name="TahunTerbit" class="form-control custom-input" placeholder="2024" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Stok</label>
                        <input type="number" name="Stok" class="form-control custom-input" required min="0" placeholder="0">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-muted text-uppercase">Kategori</label>
                        <select name="KategoriID" class="form-select custom-input" required>
                            <option value="" selected disabled>Pilih Kategori...</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->KategoriID }}">{{ $k->NamaKategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-muted text-uppercase">Deskripsi / Sinopsis</label>
                        <textarea name="Deskripsi" class="form-control custom-input" rows="3" placeholder="Tuliskan gambaran singkat buku..."></textarea>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-muted text-uppercase">Gambar Cover</label>
                        <input type="file" name="Gambar" class="form-control custom-input">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pb-4 px-4">
                <button type="button" class="btn btn-light rounded-pill px-4 fw-600" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm fw-600">Simpan Buku</button>
            </div>
        </form>
    </div>
</div>

@foreach($buku as $b)
<div class="modal fade" id="editBuku{{ $b->BukuID }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form action="{{ route('buku.update', $b->BukuID) }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            @method('PUT')
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-dark"><i class="fas fa-edit me-2 text-primary"></i>Edit Informasi Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-md-7">
                        <label class="form-label small fw-bold text-muted text-uppercase">Judul Buku</label>
                        <input type="text" name="Judul" value="{{ $b->Judul }}" class="form-control custom-input" required>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small fw-bold text-muted text-uppercase">Penulis</label>
                        <input type="text" name="Penulis" value="{{ $b->Penulis }}" class="form-control custom-input" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted text-uppercase">Penerbit</label>
                        <input type="text" name="Penerbit" value="{{ $b->Penerbit }}" class="form-control custom-input" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Tahun</label>
                        <input type="number" name="TahunTerbit" value="{{ $b->TahunTerbit }}" class="form-control custom-input" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Stok</label>
                        <input type="number" name="Stok" value="{{ $b->Stok }}" class="form-control custom-input" required min="0">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-muted text-uppercase">Kategori</label>
                        <select name="KategoriID" class="form-select custom-input" required>
                            @foreach($kategori as $k)
                                <option value="{{ $k->KategoriID }}" {{ $b->KategoriID == $k->KategoriID ? 'selected' : '' }}>
                                    {{ $k->NamaKategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-muted text-uppercase">Deskripsi</label>
                        <textarea name="Deskripsi" class="form-control custom-input" rows="3">{{ $b->Deskripsi }}</textarea>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-muted text-uppercase">Ganti Cover</label>
                        <input type="file" name="Gambar" class="form-control custom-input">
                        <small class="text-info">*Biarkan kosong jika tidak ingin mengubah gambar.</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pb-4 px-4">
                <button type="button" class="btn btn-light rounded-pill px-4 fw-600" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-600 shadow-sm">Update Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<style>
    .fw-600 { font-weight: 600; }
    .fw-500 { font-weight: 500; }
    .bg-light-table { background-color: #f8fafc; }

     .img-cover-table {
        width: 45px;
        height: 60px;
        object-fit: cover;
    }
    .no-image-placeholder {
        width: 45px;
        height: 60px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px dashed #cbd5e1;
    }

     .bg-soft-primary { background-color: #eff6ff; }
    .bg-soft-success { background-color: #f0fdf4; }
    .bg-soft-warning { background-color: #fffbeb; }
    .bg-soft-danger { background-color: #fff1f2; }

    .btn-action-round {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.2s;
    }
    .btn-action-round.edit { background: #f1f5f9; color: #64748b; }
    .btn-action-round.edit:hover { background: #2563eb; color: #fff; }
    .btn-action-round.delete { background: #fff1f2; color: #e11d48; }
    .btn-action-round.delete:hover { background: #e11d48; color: #fff; }

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
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.confirmDelete = function(button) {
        Swal.fire({
            title: 'Hapus buku ini?',
            text: "Data ulasan dan peminjaman terkait akan ikut terhapus secara permanen.",
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
            showConfirmButton: false,
            timer: 2000,
            customClass: {
                popup: 'rounded-4 shadow-lg'
            }
        });
    @endif
</script>
@endpush
@endsection