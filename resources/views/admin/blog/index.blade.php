@extends('layouts.admin_template')

@section('title', $title ?? 'Blog Management')

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
        font-size: 0.75rem;
        text-transform: uppercase;
        color: #858796;
    }
    .custom-table tbody td {
        vertical-align: middle !important;
    }
    .custom-table tbody tr:last-child td {
        border-bottom: none !important;
    }
    .custom-table tbody tr:hover {
        background-color: rgba(78, 115, 223, 0.04) !important;
        transition: background-color 0.2s ease;
    }
    .badge-pill-custom {
        font-weight: 600;
        padding: 0.35em 0.8em;
        border-radius: 50rem;
    }
    .img-preview-table {
        width: 60px;
        height: 40px;
        object-fit: cover;
        border-radius: 6px;
    }
</style>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">{{ $title ?? 'Blog Management' }}</h1>
        <button class="btn btn-primary btn-icon-split shadow-sm" data-toggle="modal" data-target="#AddBlogModal">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Data Blog</span>
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

    <div class="card shadow-sm custom-card mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle custom-table mb-0" id="blog-table">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 px-3 text-center" style="width: 5%;">NO</th>
                            <th class="py-3 px-3 text-center" style="width: 8%;">IMAGE</th>
                            <th class="py-3 px-3" style="width: 20%;">TITLE</th>
                            <th class="py-3 px-3" style="width: 18%;">SUB CONTENT</th>
                            <th class="py-3 px-3" style="width: 20%;">CONTENT</th>
                            <th class="py-3 px-3 text-center text-nowrap" style="width: 11%;">DATE</th>
                            <th class="py-3 px-3 text-center" style="width: 8%;">STATUS</th>
                            <th class="py-3 px-3 text-center text-nowrap" style="width: 10%;">ACTION</th>
                        </tr>
                    </thead>
                    <tbody class="text-dark">
                        @forelse ($blogs as $item)
                            <tr>
                                <td class="py-3 px-3 text-center text-muted font-weight-bold">{{ $loop->iteration }}</td>
                                <td class="py-3 px-3 text-center">
                                    @if($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" class="img-preview-table shadow-sm border" alt="Blog Image">
                                    @else
                                        <span class="badge badge-light border text-muted">No Image</span>
                                    @endif
                                </td>
                                <td class="py-3 px-3 font-weight-bold text-primary">{{ $item->title }}</td>
                                <td class="py-3 px-3 text-muted">{{ Str::limit($item->sub_content, 35, '...') }}</td>
                                <td class="py-3 px-3 text-muted">{{ Str::limit($item->content, 45, '...') }}</td>
                                <td class="py-3 px-3 text-center text-nowrap text-muted small">
                                    <i class="far fa-calendar-alt mr-1 text-gray-400"></i>{{ \Carbon\Carbon::parse($item->date)->format('d M Y') }}
                                </td>
                                <td class="py-3 px-3 text-center">
                                    @if($item->is_active)
                                        <span class="badge badge-success badge-pill-custom">Active</span>
                                    @else
                                        <span class="badge badge-secondary badge-pill-custom">Inactive</span>
                                    @endif
                                </td>
                                <td class="py-3 px-3 text-center text-nowrap">
                                    <div class="d-inline-flex align-items-center">
                                        <button class="btn btn-sm btn-outline-warning border-0 mr-1" data-toggle="modal" data-target="#EditBlogModal{{ $item->id }}" title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>

                                        <form action="{{ route('blog.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Data akan dihapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger border-0" title="Hapus">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">Belum ada data blog.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Blog -->
<div class="modal fade" id="AddBlogModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content custom-card shadow-lg">
            <form action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold" id="addModalLabel">Tambah Data Blog</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label for="title" class="font-weight-bold small text-uppercase text-muted">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Masukkan judul blog..." required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="sub_content" class="font-weight-bold small text-uppercase text-muted">Sub Content</label>
                        <input type="text" class="form-control" id="sub_content" name="sub_content" placeholder="Ringkasan singkat...">
                    </div>
                    <div class="form-group mb-3">
                        <label for="content" class="font-weight-bold small text-uppercase text-muted">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="4" placeholder="Isi konten artikel blog..." required></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="image" class="font-weight-bold small text-uppercase text-muted">Blog Image</label>
                        <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                        <small class="form-text text-muted">Format: JPG, PNG, WEBP (Max 2MB)</small>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6 mb-3">
                            <label for="date" class="font-weight-bold small text-uppercase text-muted">Date</label>
                            <input type="date" class="form-control" id="date" name="date" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label for="is_active" class="font-weight-bold small text-uppercase text-muted">Status</label>
                            <select class="form-control" id="is_active" name="is_active">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
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

<!-- Modal Edit Blog -->
@foreach ($blogs as $item)
    <div class="modal fade" id="EditBlogModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content custom-card shadow-lg">
                <form action="{{ route('blog.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title font-weight-bold" id="editModalLabel{{ $item->id }}">Edit Data Blog</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4 text-left">
                        <div class="form-group mb-3">
                            <label for="title_{{ $item->id }}" class="font-weight-bold small text-uppercase text-muted">Title</label>
                            <input type="text" class="form-control" id="title_{{ $item->id }}" name="title" value="{{ $item->title }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="sub_content_{{ $item->id }}" class="font-weight-bold small text-uppercase text-muted">Sub Content</label>
                            <input type="text" class="form-control" id="sub_content_{{ $item->id }}" name="sub_content" value="{{ $item->sub_content }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="content_{{ $item->id }}" class="font-weight-bold small text-uppercase text-muted">Content</label>
                            <textarea class="form-control" id="content_{{ $item->id }}" name="content" rows="4" required>{{ $item->content }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="image_{{ $item->id }}" class="font-weight-bold small text-uppercase text-muted">Change Image</label>
                            @if($item->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/blogs/' . $item->image) }}" class="rounded border" style="max-height: 80px; width: 120px; object-fit: cover;" alt="Current Image">
                                </div>
                            @endif
                            <input type="file" class="form-control-file" id="image_{{ $item->id }}" name="image" accept="image/*">
                            <small class="form-text text-muted">Leave empty if you don't want to change the image.</small>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 mb-3">
                                <label for="date_{{ $item->id }}" class="font-weight-bold small text-uppercase text-muted">Date</label>
                                <input type="date" class="form-control" id="date_{{ $item->id }}" name="date" value="{{ $item->date }}" required>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="is_active_{{ $item->id }}" class="font-weight-bold small text-uppercase text-muted">Status</label>
                                <select class="form-control" id="is_active_{{ $item->id }}" name="is_active">
                                    <option value="1" {{ $item->is_active ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$item->is_active ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
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
@endforeach

@endsection
