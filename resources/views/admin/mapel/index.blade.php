@extends('admin.dashboard')

@section('title', 'Data Mata Pelajaran')

@section('content')

<style>
    .custom-card {
        border-radius: 12px !important;
        overflow: hidden !important;
        border: none !important;
    }
    .custom-table {
        margin-bottom: 0 !important;
    }
    .custom-table thead th {
        border-top: none !important;
        border-bottom: 2px solid #e3e6f0 !important;
        letter-spacing: 0.05em;
    }
    .custom-table tbody tr:last-child td {
        border-bottom: none !important;
    }
    .custom-table tbody tr:hover {
        background-color: rgba(78, 115, 223, 0.04) !important;
        transition: background-color 0.2s ease;
    }

    /* Custom Compact Pagination Styling */
    .custom-pagination-container {
        padding: 1rem 1.5rem;
        background-color: #fff;
        border-top: 1px solid #e3e6f0;
    }
    .compact-pagination .pagination {
        margin-bottom: 0 !important;
        gap: 4px;
    }
    .compact-pagination .page-item .page-link {
        border-radius: 6px !important;
        border: 1px solid #e3e6f0 !important;
        color: #4e73df !important;
        font-weight: 600;
        padding: 0.4rem 0.85rem;
        transition: all 0.2s ease-in-out;
    }
    .compact-pagination .page-item.active .page-link {
        background-color: #4e73df !important;
        border-color: #4e73df !important;
        color: #fff !important;
        box-shadow: 0 2px 4px rgba(78, 115, 223, 0.25);
    }
    .compact-pagination .page-item .page-link:hover {
        background-color: #eaecf4 !important;
        border-color: #dddfeb !important;
    }
    .compact-pagination .page-item.disabled .page-link {
        color: #858796 !important;
        background-color: #f8f9fc !important;
        border-color: #e3e6f0 !important;
    }
</style>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Mata Pelajaran</h1>
        <button class="btn btn-primary btn-icon-split shadow-sm" data-toggle="modal" data-target="#modalTambah">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Mata Pelajaran</span>
        </button>
    </div>

    <!-- Flash Message / Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Card Filter & Search -->
    <div class="card shadow-sm custom-card mb-4">
        <div class="card-body p-3 bg-light">
            <form action="{{ route('mapel.index') }}" method="GET">
                <div class="row align-items-center">
                    <!-- Search Input -->
                    <div class="col-md-5 mb-2 mb-md-0">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-right-0"><i class="fas fa-search text-muted"></i></span>
                            </div>
                            <input type="text" name="search" class="form-control border-left-0" placeholder="Cari nama mata pelajaran..." value="{{ request('search') }}">
                        </div>
                    </div>

                    <!-- Per Page Dropdown & Action Buttons -->
                    <div class="col-md-7 d-flex justify-content-md-end align-items-center flex-wrap">
                        <!-- Select Per Page -->
                        <div class="d-flex align-items-center mr-3 mb-2 mb-md-0">
                            <label for="per_page" class="mr-2 mb-0 font-weight-bold text-muted small">Tampilkan:</label>
                            <select name="per_page" id="per_page" class="custom-select custom-select-sm" style="width: auto;" onchange="this.form.submit()">
                                <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page', 50) == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                <option value="250" {{ request('per_page') == 250 ? 'selected' : '' }}>250</option>
                            </select>
                        </div>

                        <!-- Filter Button -->
                        <button type="submit" class="btn btn-secondary mr-2">
                            <i class="fas fa-filter fa-sm"></i> Filter
                        </button>

                        <!-- Reset Button -->
                        @if(request('search') || (request('per_page') && request('per_page') != 50))
                            <a href="{{ route('mapel.index') }}" class="btn btn-outline-danger">
                                <i class="fas fa-undo fa-sm"></i> Reset
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Mata Pelajaran -->
    <div class="card shadow-sm custom-card mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle custom-table" id="mapelTable">
                    <thead class="bg-light text-muted text-uppercase small">
                        <tr>
                            <th width="10%" class="py-3 px-4 text-center">No</th>
                            <th class="py-3 px-4">Nama Pelajaran</th>
                            <th width="20%" class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-dark">
                        @forelse($mataPelajaran as $key => $item)
                            <tr>
                                <td class="py-3 px-4 text-center">
                                    {{ method_exists($mataPelajaran, 'currentPage') ? ($mataPelajaran->currentPage()-1) * $mataPelajaran->perPage() + $loop->iteration : $loop->iteration }}
                                </td>
                                <td class="py-3 px-4 font-weight-bold text-primary">{{ $item->nama_pelajaran }}</td>
                                <td class="py-3 px-4 text-center">
                                    <!-- Tombol Edit -->
                                    <button class="btn btn-sm btn-outline-warning border-0 mr-1"
                                            data-toggle="modal"
                                            data-target="#modalEdit{{ $item->id }}"
                                            title="Edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>

                                    <!-- Tombol Hapus -->
                                    <button class="btn btn-sm btn-outline-danger border-0"
                                            data-toggle="modal"
                                            data-target="#modalHapus{{ $item->id }}"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">Data mata pelajaran tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Compact Pagination Footer -->
            @if(method_exists($mataPelajaran, 'hasPages') && $mataPelajaran->hasPages())
                <div class="custom-pagination-container d-flex flex-column flex-sm-row align-items-center justify-content-between">
                    <small class="text-muted font-weight-bold mb-2 mb-sm-0">
                        Showing {{ $mataPelajaran->firstItem() ?? 0 }} to {{ $mataPelajaran->lastItem() ?? 0 }} of {{ $mataPelajaran->total() }} entries
                    </small>

                    @php
                        $currentPage = $mataPelajaran->currentPage();
                        $lastPage = $mataPelajaran->lastPage();
                        $startPage = max(1, $currentPage - 1);
                        $endPage = min($lastPage, $currentPage + 1);
                    @endphp

                    <div class="compact-pagination">
                        <ul class="pagination">
                            {{-- Previous Page Link --}}
                            @if ($mataPelajaran->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $mataPelajaran->previousPageUrl() }}" rel="prev">&lsaquo;</a></li>
                            @endif

                            {{-- First Page --}}
                            @if ($startPage > 1)
                                <li class="page-item"><a class="page-link" href="{{ $mataPelajaran->appends(request()->query())->url(1) }}">1</a></li>
                                @if ($startPage > 2)
                                    <li class="page-item disabled"><span class="page-link">&hellip;</span></li>
                                @endif
                            @endif

                            {{-- Active Range --}}
                            @for ($page = $startPage; $page <= $endPage; $page++)
                                @if ($page == $currentPage)
                                    <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $mataPelajaran->appends(request()->query())->url($page) }}">{{ $page }}</a></li>
                                @endif
                            @endfor

                            {{-- Last Page --}}
                            @if ($endPage < $lastPage)
                                @if ($endPage < $lastPage - 1)
                                    <li class="page-item disabled"><span class="page-link">&hellip;</span></li>
                                @endif
                                <li class="page-item"><a class="page-link" href="{{ $mataPelajaran->appends(request()->query())->url($lastPage) }}">{{ $lastPage }}</a></li>
                            @endif

                            {{-- Next Page Link --}}
                            @if ($mataPelajaran->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $mataPelajaran->nextPageUrl() }}" rel="next">&rsaquo;</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
                            @endif
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- MODAL TAMBAH DATA -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-card shadow-lg">
            <form action="{{ route('mapel.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold" id="modalTambahLabel">Tambah Mata Pelajaran</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label for="nama_pelajaran" class="font-weight-bold small text-uppercase text-muted">Nama Pelajaran</label>
                        <input type="text" class="form-control" id="nama_pelajaran" name="nama_pelajaran" placeholder="Masukkan nama mata pelajaran..." required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary px-4">Save Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL EDIT & HAPUS (LOOPING DATA) -->
@foreach($mataPelajaran as $item)
    <!-- MODAL EDIT DATA -->
    <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" aria-labelledby="modalEditLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content custom-card shadow-lg">
                <form action="{{ route('mapel.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title font-weight-bold" id="modalEditLabel{{ $item->id }}">Edit Mata Pelajaran</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4 text-left">
                        <div class="form-group mb-3">
                            <label for="nama_pelajaran_{{ $item->id }}" class="font-weight-bold small text-uppercase text-muted">Nama Pelajaran</label>
                            <input type="text" class="form-control" id="nama_pelajaran_{{ $item->id }}" name="nama_pelajaran" value="{{ $item->nama_pelajaran }}" required>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning px-4 text-white">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL HAPUS DATA -->
    <div class="modal fade" id="modalHapus{{ $item->id }}" tabindex="-1" aria-labelledby="modalHapusLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content custom-card shadow-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title font-weight-bold" id="modalHapusLabel{{ $item->id }}">Konfirmasi Hapus</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    Apakah Anda yakin ingin menghapus mata pelajaran <strong>{{ $item->nama_pelajaran }}</strong>?
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <form action="{{ route('mapel.destroy', $item->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection
