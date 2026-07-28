@extends('layouts.admin_template')

@section('title', $title ?? 'Contact Management')

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
</style>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">{{ $title ?? 'Contact Management' }}</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow-sm custom-card mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle custom-table" id="contacts-table">
                    <thead class="bg-light text-muted text-uppercase small">
                        <tr>
                            <th class="py-3 px-4">No</th>
                            <th class="py-3 px-4">Name</th>
                            <th class="py-3 px-4">Email</th>
                            <th class="py-3 px-4">Subject</th>
                            <th class="py-3 px-4">Message</th>
                            <th class="py-3 px-4">Created At</th>
                            <th class="py-3 px-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-dark">
                        @forelse ($contacts as $item)
                            <tr>
                                <td class="py-3 px-4 text-muted">{{ $loop->iteration }}</td>
                                <td class="py-3 px-4 font-weight-bold text-primary">{{ $item->name }}</td>
                                <td class="py-3 px-4">{{ $item->email }}</td>
                                <td class="py-3 px-4">
                                    <span class="badge badge-light border text-dark px-2 py-1">{{ $item->subject }}</span>
                                </td>
                                <td class="py-3 px-4 text-muted">{{ $item->message }}</td>
                                <td class="py-3 px-4 text-muted small">
                                    {{ $item->created_at ? $item->created_at->format('d M Y H:i') : '-' }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <form action="{{ route('contact.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Data akan dihapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger border-0" title="Hapus">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Belum ada data contact.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
