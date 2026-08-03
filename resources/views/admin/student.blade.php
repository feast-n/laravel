@extends('layouts.admin_template')

@section('title', $title ?? 'Student Management')

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
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Student Management</h1>
        <button class="btn btn-primary btn-icon-split shadow-sm" data-toggle="modal" data-target="#AddPart">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Data Student</span>
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Card Filter & Search -->
    <div class="card shadow-sm custom-card mb-4">
        <div class="card-body p-3 bg-light">
            <form action="{{ url('admin/student') }}" method="GET">
                <div class="row align-items-center">
                    <div class="col-md-5 mb-2 mb-md-0">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-right-0"><i class="fas fa-search text-muted"></i></span>
                            </div>
                            <input type="text" name="search" class="form-control border-left-0" placeholder="Cari nama, email, telepon, atau alamat..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-7 d-flex justify-content-md-end align-items-center">
                        <!-- Dropdown Options for Per Page (5, 10, 25, 50, 100, 250) -->
                        <div class="d-flex align-items-center mr-3">
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

                        <button type="submit" class="btn btn-secondary mr-2">
                            <i class="fas fa-filter fa-sm"></i> Filter
                        </button>
                        @if(request('search') || request('per_page'))
                            <a href="{{ url('admin/student') }}" class="btn btn-outline-danger">
                                <i class="fas fa-undo fa-sm"></i> Reset
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Student -->
    <div class="card shadow-sm custom-card mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle custom-table" id="student">
                    <thead class="bg-light text-muted text-uppercase small">
                        <tr>
                            <th class="py-3 px-4">No</th>
                            <th class="py-3 px-4">Name</th>
                            <th class="py-3 px-4">Email</th>
                            <th class="py-3 px-4">Phone</th>
                            <th class="py-3 px-4">Address</th>
                            <th class="py-3 px-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-dark">
                        @forelse ($students as $item)
                            <tr>
                                <td class="py-3 px-4">{{ ($students->currentPage()-1) * $students->perPage() + $loop->iteration }}</td>
                                <td class="py-3 px-4 font-weight-bold text-primary">{{ $item->name }}</td>
                                <td class="py-3 px-4">{{ $item->email }}</td>
                                <td class="py-3 px-4">
                                    <span class="badge badge-light border text-dark px-2 py-1">{{ $item->phone }}</span>
                                </td>
                                <td class="py-3 px-4 text-muted">{{ $item->address }}</td>
                                <td class="py-3 px-4 text-center">
                                    <a class="btn btn-sm btn-outline-warning border-0 mr-1" data-toggle="modal" data-target="#EditPart{{ $item->id }}" title="Edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a class="btn btn-sm btn-outline-danger border-0" href="{{ url('admin/student/hapus/' . $item->id ) }}" onclick="return confirm('Data akan dihapus?')" title="Hapus">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="EditPart{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content custom-card shadow-lg">
                                        <form action="{{ url('admin/student/update/' . $item->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-header bg-warning text-white">
                                                <h5 class="modal-title font-weight-bold" id="editModalLabel{{ $item->id }}">Edit Data Student</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body p-4 text-left">
                                                <div class="form-group mb-3">
                                                    <label for="name_{{ $item->id }}" class="font-weight-bold small text-uppercase text-muted">Name</label>
                                                    <input type="text" class="form-control" id="name_{{ $item->id }}" name="name" value="{{ $item->name }}" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="email_{{ $item->id }}" class="font-weight-bold small text-uppercase text-muted">Email</label>
                                                    <input type="email" class="form-control" id="email_{{ $item->id }}" name="email" value="{{ $item->email }}" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="phone_{{ $item->id }}" class="font-weight-bold small text-uppercase text-muted">Phone</label>
                                                    <input type="text" class="form-control" id="phone_{{ $item->id }}" name="phone" value="{{ $item->phone }}" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="address_{{ $item->id }}" class="font-weight-bold small text-uppercase text-muted">Address</label>
                                                    <textarea class="form-control" id="address_{{ $item->id }}" name="address" rows="3" required>{{ $item->address }}</textarea>
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
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Data student tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Compact Pagination Footer with Query Preserved -->
            <div class="custom-pagination-container d-flex flex-column flex-sm-row align-items-center justify-content-between">
                <small class="text-muted font-weight-bold mb-2 mb-sm-0">
                    Showing {{ $students->firstItem() ?? 0 }} to {{ $students->lastItem() ?? 0 }} of {{ $students->total() }} entries
                </small>

                @if ($students->hasPages())
                    @php
                        $currentPage = $students->currentPage();
                        $lastPage = $students->lastPage();

                        $startPage = max(1, $currentPage - 1);
                        $endPage = min($lastPage, $currentPage + 1);
                    @endphp

                    <div class="compact-pagination">
                        <ul class="pagination">
                            {{-- Previous Page Link --}}
                            @if ($students->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $students->appends(request()->query())->previousPageUrl() }}" rel="prev">&lsaquo;</a></li>
                            @endif

                            {{-- First Page --}}
                            @if ($startPage > 1)
                                <li class="page-item"><a class="page-link" href="{{ $students->appends(request()->query())->url(1) }}">1</a></li>
                                @if ($startPage > 2)
                                    <li class="page-item disabled"><span class="page-link">&hellip;</span></li>
                                @endif
                            @endif

                            {{-- Active Range --}}
                            @for ($page = $startPage; $page <= $endPage; $page++)
                                @if ($page == $currentPage)
                                    <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $students->appends(request()->query())->url($page) }}">{{ $page }}</a></li>
                                @endif
                            @endfor

                            {{-- Last Page --}}
                            @if ($endPage < $lastPage)
                                @if ($endPage < $lastPage - 1)
                                    <li class="page-item disabled"><span class="page-link">&hellip;</span></li>
                                @endif
                                <li class="page-item"><a class="page-link" href="{{ $students->appends(request()->query())->url($lastPage) }}">{{ $lastPage }}</a></li>
                            @endif

                            {{-- Next Page Link --}}
                            @if ($students->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $students->appends(request()->query())->nextPageUrl() }}" rel="next">&rsaquo;</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
                            @endif
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="AddPart" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content custom-card shadow-lg">
                <form action="{{ url('admin/student/simpan') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Tambah Data Student</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="form-group mb-3">
                            <label for="name" class="font-weight-bold small text-uppercase text-muted">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama lengkap..." required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email" class="font-weight-bold small text-uppercase text-muted">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="contoh@email.com" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone" class="font-weight-bold small text-uppercase text-muted">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="08123456789" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="address" class="font-weight-bold small text-uppercase text-muted">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" placeholder="Alamat lengkap..." required></textarea>
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
</div>

@endsection
