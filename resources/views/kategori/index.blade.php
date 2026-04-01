@extends('layouts.app')

@section('content')
<div class="container-fluid py-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Kelola Kategori</h3>
            <p class="text-muted small mb-0">Organisir kategori buku untuk mempermudah pencarian koleksi.</p>
        </div>
        <button class="btn btn-primary rounded-pill px-4 shadow-sm fw-600" data-bs-toggle="modal" data-bs-target="#addKategori">
            <i class="fas fa-plus-circle me-2"></i>Tambah Kategori
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden animate__animated animate__fadeIn">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light-table">
                        <tr>
                            <th class="px-4 py-3 text-secondary small fw-bold" width="8%">ID</th>
                            <th class="py-3 text-secondary small fw-bold" width="22%">NAMA KATEGORI</th>
                            <th class="py-3 text-secondary small fw-bold">KOLEKSI BUKU</th>
                            <th class="py-3 text-secondary small fw-bold text-center" width="15%">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategori as $k)
                        <tr>
                            <td class="px-4 text-muted fw-500">#{{ $k->KategoriID }}</td>
                            <td>
                                <span class="custom-badge-category">
                                    {{ $k->NamaKategori }}
                                </span>
                            </td>
                            <td>
                                @if($k->buku->count() > 0)
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($k->buku as $buku)
                                            <button type="button" 
                                                    class="btn-book-tag" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#detailBuku{{ $buku->BukuID }}">
                                                <i class="fas fa-book-open me-1 opacity-50"></i> {{ $buku->Judul }}
                                            </button>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted fst-italic small opacity-50">Belum ada koleksi</span>
                                @endif
                            </td>
                            <td class="text-center px-4">
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn-action-round edit" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editKategori{{ $k->KategoriID }}"
                                            title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <form action="/kategori/{{ $k->KategoriID }}" method="POST" id="deleteForm{{ $k->KategoriID }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-action-round delete" onclick="confirmDelete('{{ $k->KategoriID }}')" title="Hapus">
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

<div class="modal fade" id="addKategori" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="/kategori" method="POST" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-dark">Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4">
                <div class="mb-2">
                    <label class="form-label small fw-bold text-muted text-uppercase">Nama Kategori</label>
                    <input type="text" name="NamaKategori" class="form-control custom-input" placeholder="Contoh: Sains & Teknologi" required>
                </div>
            </div>
            <div class="modal-footer border-0 pb-4 px-4">
                <button type="button" class="btn btn-light rounded-pill px-4 fw-600" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm fw-600">Simpan</button>
            </div>
        </form>
    </div>
</div>

@foreach($kategori as $k)
    <div class="modal fade" id="editKategori{{ $k->KategoriID }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="/kategori/{{ $k->KategoriID }}" method="POST" class="modal-content border-0 shadow-lg rounded-4">
                @csrf
                @method('PUT')
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold text-dark">Ubah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4">
                    <div class="mb-2">
                        <label class="form-label small fw-bold text-muted text-uppercase">Nama Kategori</label>
                        <input type="text" name="NamaKategori" class="form-control custom-input" value="{{ $k->NamaKategori }}" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-600" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-600">Update</button>
                </div>
            </form>
        </div>
    </div>

    @foreach($k->buku as $buku)
    <div class="modal fade" id="detailBuku{{ $buku->BukuID }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-body p-0">
                    <div class="row g-0">
                        <div class="col-md-5 bg-light-soft d-flex align-items-center justify-content-center p-5 border-end">
                            @if($buku->Gambar)
                                <img src="{{ asset('storage/'.$buku->Gambar) }}" class="img-fluid rounded-3 shadow-lg" style="max-height: 300px; object-fit: cover;">
                            @else
                                <div class="text-center text-muted opacity-25">
                                    <i class="fas fa-book-open fa-5x mb-3"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-7 p-5">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-soft-primary text-primary rounded-pill px-3">{{ $k->NamaKategori }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <h3 class="fw-bold text-dark mb-1">{{ $buku->Judul }}</h3>
                            <p class="text-primary fw-600 mb-4">{{ $buku->Penulis }}</p>
                            
                            <div class="row g-3 mb-4">
                                <div class="col-6">
                                    <small class="text-muted d-block">Penerbit</small>
                                    <span class="fw-600 text-dark">{{ $buku->Penerbit }}</span>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Tahun</small>
                                    <span class="fw-600 text-dark">{{ $buku->TahunTerbit }}</span>
                                </div>
                            </div>

                            <label class="small fw-bold text-muted text-uppercase mb-2 d-block">Deskripsi</label>
                            <div class="p-3 bg-light rounded-3">
                                <p class="text-muted small mb-0" style="line-height: 1.6;">
                                    {{ $buku->Deskripsi ?? 'Tidak ada deskripsi untuk buku ini.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endforeach

<style>
    .fw-600 { font-weight: 600; }
    .bg-light-table { background-color: #f8fafc; }
    .bg-light-soft { background-color: #f1f5f9; }

     .custom-badge-category {
        background-color: #eff6ff;
        color: #2563eb;
        padding: 6px 14px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.8rem;
        border: 1px solid #dbeafe;
    }

     .btn-book-tag {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 5px 12px;
        font-size: 0.7rem;
        font-weight: 600;
        color: #64748b;
        transition: 0.2s;
    }
    .btn-book-tag:hover {
        background: #f1f5f9;
        color: #2563eb;
        border-color: #2563eb;
    }

     .btn-action-round {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.2s;
        font-size: 0.85rem;
    }
    .btn-action-round.edit { background: #f1f5f9; color: #64748b; }
    .btn-action-round.edit:hover { background: #2563eb; color: #fff; }
    .btn-action-round.delete { background: #fff1f2; color: #e11d48; }
    .btn-action-round.delete:hover { background: #e11d48; color: #fff; }

     .custom-input {
        background: #f8fafc;
        border: 2px solid #f1f5f9;
        border-radius: 12px;
        padding: 12px;
        font-size: 0.95rem;
        transition: 0.2s;
    }
    .custom-input:focus {
        background: #fff;
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }

    .bg-soft-primary { background-color: #eff6ff; }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Kategori?',
            text: "Buku di dalam kategori ini mungkin akan terpengaruh.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-4 shadow-lg'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm' + id).submit();
            }
        })
    }
</script>
@endsection