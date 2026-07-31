@extends('layouts.admin_template')

@section('title', $title ?? 'User Management')

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
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">User Management</h1>
        <button class="btn btn-primary btn-icon-split shadow-sm" data-toggle="modal" data-target="#AddUserModal">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah User Baru</span>
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
            <form action="{{ route('usermg.index') }}" method="GET">
                <div class="row align-items-center">
                    <div class="col-md-4 mb-2 mb-md-0">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-right-0"><i class="fas fa-search text-muted"></i></span>
                            </div>
                            <input type="text" name="search" class="form-control border-left-0" placeholder="Cari nama atau email..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3 mb-2 mb-md-0">
                        <select name="role" class="form-control" onchange="this.form.submit()">
                            <option value="all" {{ request('role') == 'all' || !request('role') ? 'selected' : '' }}>-- Semua Role --</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin Only</option>
                            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User Only</option>
                        </select>
                    </div>
                    <div class="col-md-5 d-flex justify-content-md-end">
                        <button type="submit" class="btn btn-secondary mr-2">
                            <i class="fas fa-filter fa-sm"></i> Filter
                        </button>
                        @if(request('search') || (request('role') && request('role') != 'all'))
                            <a href="{{ route('usermg.index') }}" class="btn btn-outline-danger">
                                <i class="fas fa-undo fa-sm"></i> Reset
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Users -->
    <div class="card shadow-sm custom-card mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle custom-table" id="usermg">
                    <thead class="bg-light text-muted text-uppercase small">
                        <tr>
                            <th class="py-3 px-4">No</th>
                            <th class="py-3 px-4">Name</th>
                            <th class="py-3 px-4">Email</th>
                            <th class="py-3 px-4">Role</th>
                            <th class="py-3 px-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-dark">
                        @forelse($users as $key => $user)
                        <tr>
                            <td class="py-3 px-4">{{ ($users->currentPage()-1) * $users->perPage() + $loop->iteration }}</td>
                            <td class="py-3 px-4 font-weight-bold text-primary">{{ $user->name }}</td>
                            <td class="py-3 px-4">{{ $user->email }}</td>
                            <td class="py-3 px-4">
                                <span class="badge badge-{{ $user->role == 'admin' ? 'danger' : 'secondary' }} px-2 py-1">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <a class="btn btn-sm btn-outline-warning border-0 mr-1" data-toggle="modal" data-target="#EditUserModal{{ $user->id }}" title="Edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('usermg.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger border-0" title="Hapus">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit User -->
                        <div class="modal fade" id="EditUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content custom-card shadow-lg">
                                    <form action="{{ route('usermg.update', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header bg-warning text-white">
                                            <h5 class="modal-title font-weight-bold" id="editUserModalLabel{{ $user->id }}">Edit User & Role</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body p-4 text-left">
                                            <div class="form-group mb-3">
                                                <label for="name_{{ $user->id }}" class="font-weight-bold small text-uppercase text-muted">Name</label>
                                                <input type="text" class="form-control" id="name_{{ $user->id }}" name="name" value="{{ $user->name }}" required>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="email_{{ $user->id }}" class="font-weight-bold small text-uppercase text-muted">Email</label>
                                                <input type="email" class="form-control" id="email_{{ $user->id }}" name="email" value="{{ $user->email }}" required>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="password_{{ $user->id }}" class="font-weight-bold small text-uppercase text-muted">
                                                    Password <small class="text-muted font-italic">(Kosongkan jika tidak ubah)</small>
                                                </label>
                                                <input type="password" class="form-control" id="password_{{ $user->id }}" name="password" placeholder="Isi hanya jika ingin mengganti password">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="role_{{ $user->id }}" class="font-weight-bold small text-uppercase text-muted">Role</label>
                                                <select class="form-control" id="role_{{ $user->id }}" name="role" required>
                                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-warning px-4 text-white">Update User</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Data user tidak ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Compact Pagination Footer dengan Query String Preserved -->
            <div class="custom-pagination-container d-flex flex-column flex-sm-row align-items-center justify-content-between">
                <small class="text-muted font-weight-bold mb-2 mb-sm-0">
                    Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} entries
                </small>

                @if ($users->hasPages())
                    @php
                        $currentPage = $users->currentPage();
                        $lastPage = $users->lastPage();

                        $startPage = max(1, $currentPage - 1);
                        $endPage = min($lastPage, $currentPage + 1);
                    @endphp

                    <div class="compact-pagination">
                        <ul class="pagination">
                            {{-- Previous Page Link --}}
                            @if ($users->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $users->previousPageUrl() }}" rel="prev">&lsaquo;</a></li>
                            @endif

                            {{-- First Page --}}
                            @if ($startPage > 1)
                                <li class="page-item"><a class="page-link" href="{{ $users->appends(request()->query())->url(1) }}">1</a></li>
                                @if ($startPage > 2)
                                    <li class="page-item disabled"><span class="page-link">&hellip;</span></li>
                                @endif
                            @endif

                            {{-- Active Range --}}
                            @for ($page = $startPage; $page <= $endPage; $page++)
                                @if ($page == $currentPage)
                                    <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $users->appends(request()->query())->url($page) }}">{{ $page }}</a></li>
                                @endif
                            @endfor

                            {{-- Last Page --}}
                            @if ($endPage < $lastPage)
                                @if ($endPage < $lastPage - 1)
                                    <li class="page-item disabled"><span class="page-link">&hellip;</span></li>
                                @endif
                                <li class="page-item"><a class="page-link" href="{{ $users->appends(request()->query())->url($lastPage) }}">{{ $lastPage }}</a></li>
                            @endif

                            {{-- Next Page Link --}}
                            @if ($users->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $users->nextPageUrl() }}" rel="next">&rsaquo;</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
                            @endif
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Tambah User -->
    <div class="modal fade" id="AddUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content custom-card shadow-lg">
                <form action="{{ route('usermg.store') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title font-weight-bold" id="addUserModalLabel">Tambah Data User</h5>
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
                            <label for="password" class="font-weight-bold small text-uppercase text-muted">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 8 karakter..." required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="role" class="font-weight-bold small text-uppercase text-muted">Role</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
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
