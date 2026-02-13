@extends('layouts.admin')

@section('title', 'Blog Management')
@section('page-title', 'Blog Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-0"><i class="fa fa-newspaper-o"></i> Blog Management</h2>
        <a href="{{ route('admin.blogs.create') }}" class="btn-modern btn-modern-primary">
            <i class="fa fa-plus"></i> Create New Blog
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fa fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="modern-card">
        <div class="modern-card-body">
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th width="80">S.No</th>
                            <th>Title</th>
                            <th width="150">Published Date</th>
                            <th width="200">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($blogs as $blog)
                            <tr>
                                <td>
                                    <span class="fw-bold text-muted">{{ $loop->iteration }}</span>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">{{ $blog->title }}</span>
                                    <div class="text-muted small mt-1">{{ Str::limit($blog->excerpt ?? '', 60) }}</div>
                                </td>
                                <td>
                                    <span class="text-muted small">
                                        <i class="fa fa-calendar-alt me-1"></i>
                                        {{ $blog->published_at ? $blog->published_at->format('d M Y') : '-' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn-modern btn-modern-primary btn-sm" title="Edit">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-modern btn-sm" style="background: #ef4444; color: white;" 
                                                    onclick="return confirm('Are you sure you want to delete this blog?')" title="Delete">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <i class="fa fa-newspaper-o fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">No blogs found. Create your first blog post!</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($blogs->hasPages())
                <div class="mt-4">
                    {{ $blogs->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
