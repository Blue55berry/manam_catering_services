@extends('layouts.admin')

@section('title', 'Edit Menu Category')
@section('page-title', 'Edit Menu Category')

@section('content')
<div class="container-fluid">
    <div class="modern-card">
        <div class="modern-card-header">
            <h3 class="modern-card-title">Edit Category</h3>
        </div>
        <div class="modern-card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.menu-categories.update', $menu_category) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label">Category Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $menu_category->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Order</label>
                    <input type="number" name="order" class="form-control" value="{{ old('order', $menu_category->order) }}">
                </div>

                <button type="submit" class="btn-modern btn-modern-primary">Update Category</button>
                <a href="{{ route('admin.menu-items.index') }}" class="btn-modern btn-modern-secondary ms-2">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
