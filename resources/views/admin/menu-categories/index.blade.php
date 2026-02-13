@extends('layouts.admin')

@section('title', 'Manage Menu Categories')

@section('content')
<div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800"><i class="fa fa-folder"></i> Menu Categories</h2>
        <a href="{{ route('admin.menu-categories.create') }}" class="btn-modern btn-modern-primary shadow-sm">
            <i class="fa fa-plus-circle me-2"></i> Add New Category
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fa fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="modern-card-header">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon-box bg-light text-primary">
                        <i class="fa fa-list-ol fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">Category List</h5>
                        <small class="text-muted">Manage food categories</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            @if($categories->count() > 0)
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th width="10%">Order</th>
                                <th width="40%">Name</th>
                                <th width="20%">Status</th>
                                <th width="20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td><span class="fw-bold text-muted">#{{ $category->order }}</span></td>
                                <td><span class="fw-bold text-dark">{{ $category->name }}</span></td>
                                <td>
                                    @if($category->is_active)
                                        <span class="badge-modern badge-success">Active</span>
                                    @else
                                        <span class="badge-modern badge-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.menu-categories.edit', $category) }}" class="btn-icon btn-icon-warning" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.menu-categories.destroy', $category) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon btn-icon-danger" onclick="return confirm('Delete {{ $category->name }}?')" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light" style="width: 80px; height: 80px;">
                            <i class="fa fa-folder-open fa-2x text-muted"></i>
                        </div>
                    </div>
                    <h4 class="text-muted">No Categories Found</h4>
                    <p class="text-muted mb-4">Create your first food category to get started.</p>
                    <a href="{{ route('admin.menu-categories.create') }}" class="btn-modern btn-modern-primary">
                        <i class="fa fa-plus"></i> Create Category
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
