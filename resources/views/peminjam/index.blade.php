@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex align-items-center justify-content-between mb-5">
        <div>
            <h2 class="fw-800 text-dark mb-1 font-syne">Daftar Buku</h2>
            <p class="text-muted small mb-0">Temukan buku Digital dalam satu genggamanmu.</p>
        </div>
    </div>

    <div class="row g-4">
        @foreach($buku as $b)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card book-card h-100 border-0 shadow-sm">
                    <div class="position-relative overflow-hidden img-container">
                        @if($b->Gambar)
                            <img src="{{ asset('storage/' . $b->Gambar) }}" class="card-img-top book-cover" alt="{{ $b->Judul }}">
                        @else
                            <div class="bg-light d-flex flex-column align-items-center justify-content-center text-muted" style="height: 280px;">
                                <i class="fas fa-image fa-3x mb-2 opacity-25"></i>
                                <small>Tidak ada cover</small>
                            </div>
                        @endif

                        <div class="status-badge">
                            @if($b->Stok > 0)
                                <span class="badge rounded-pill bg-success shadow">Tersedia: {{ $b->Stok }}</span>
                            @else
                                <span class="badge rounded-pill bg-danger shadow">Habis</span>
                            @endif
                        </div>
                    </div>

                    <div class="card-body d-flex flex-column p-3">
                        <h6 class="card-title fw-bold text-dark mb-1 text-truncate">{{ $b->Judul }}</h6>
                        <p class="text-muted extra-small mb-2"><i class="fas fa-pen-nib me-1"></i> {{ $b->Penulis ?? 'Penulis Anonim' }}</p>

                        <div class="review-preview mb-3">
                            @php $avgRating = $b->ulasan->avg('Rating') ?? 0; @endphp
                            <div class="d-flex align-items-center mb-2">
                                <div class="text-warning small me-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="{{ $i <= $avgRating ? 'fas' : 'far' }} fa-star"></i>
                                    @endfor
                                </div>
                                <span class="extra-small text-muted">({{ $b->ulasan->count() }})</span>
                            </div>
                            
                            @if($b->ulasan->count() > 0)
                                <a href="javascript:void(0)" class="text-primary fw-bold extra-small text-decoration-none" 
                                   data-bs-toggle="modal" data-bs-target="#modalUlasan{{ $b->BukuID }}">
                                   Lihat semua ulasan...
                                </a>
                            @endif
                        </div>

                        <div class="mt-auto">
                             <form action="{{ route('koleksi.tambah') }}" method="POST" class="mb-2">
                                @csrf
                                <input type="hidden" name="BukuID" value="{{ $b->BukuID }}">
                                <button type="submit" class="btn btn-outline-danger w-100 rounded-pill btn-sm fw-bold shadow-sm">
                                    <i class="far fa-heart me-1"></i> Simpan ke Koleksi
                                </button>
                            </form>

                            @if($b->Stok > 0)
                                <a href="{{ route('pinjam.form', $b->BukuID) }}" class="btn btn-primary w-100 rounded-pill btn-sm fw-bold py-2 shadow-sm">
                                    Ajukan Pinjaman
                                </a>
                            @else
                                <button class="btn btn-light w-100 rounded-pill btn-sm fw-bold py-2 text-muted border" disabled>Stok Kosong</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

 @foreach($buku as $b)
    <div class="modal fade" id="modalUlasan{{ $b->BukuID }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Ulasan: {{ $b->Judul }}</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    @forelse($b->ulasan as $u)
                        <div class="mb-4">
                            <div class="d-flex p-3 bg-light rounded-4">
                                <div class="ms-3 w-100">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="fw-bold mb-0 small">{{ $u->user->Username ?? 'User' }}</h6>
                                        <span class="text-warning extra-small">{{ str_repeat('⭐', $u->Rating) }}</span>
                                    </div>
                                    <p class="text-muted small my-2 lh-base">{{ $u->Ulasan }}</p>
                                    @if($u->BalasanAdmin)
                                        <div class="mt-2 p-2 border-start border-primary border-3 bg-white rounded shadow-sm">
                                            <small class="fw-bold d-block text-primary" style="font-size: 0.7rem;">Balasan Admin:</small>
                                            <p class="small mb-0 text-dark fst-italic">{{ $u->BalasanAdmin }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">Belum ada ulasan untuk buku ini.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection