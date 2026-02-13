@extends('layouts.admin')

@section('title', 'Manage Sliders')
@section('page-title', 'Manage Sliders')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">
            <i class="fa fa-images"></i> Manage Sliders
        </h2>
        <a href="{{ route('admin.hero-banners.create') }}" class="btn-modern btn-modern-primary">
            <i class="fa fa-plus"></i> Add New Slider
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="modern-card">
        <div class="modern-card-body">
            @if($banners->count() > 0)
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($banners as $banner)
                                <tr>
                                    <td>{{ $banner->order }}</td>
                                    <td>
                                        @if($banner->image)
                                            <img src="{{ asset($banner->image) }}?v={{ time() }}" alt="Slider" style="height: 50px; border-radius: 5px;">
                                        @else
                                            <span class="text-muted">No image</span>
                                        @endif
                                    </td>
                                    <td>{{ $banner->title ?? 'N/A' }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.hero-banners.edit', $banner) }}" class="btn-modern btn-modern-primary btn-sm" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.hero-banners.destroy', $banner) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-modern btn-sm" style="background: #ef4444; color: white;" 
                                                        onclick="return confirm('Are you sure you want to delete this slider?')" title="Delete">
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
                    <p class="text-muted">No sliders found.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
