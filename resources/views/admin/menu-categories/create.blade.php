@extends('layouts.admin')

@section('title', 'Add Menu Category')
@section('page-title', 'Add Menu Category')

@section('content')
<div class="container-fluid">
    <div class="modern-card">
        <div class="modern-card-header">
            <h3 class="modern-card-title">Add New Category</h3>
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
            <form action="{{ route('admin.menu-categories.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Category Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Order</label>
                    <input type="number" name="order" class="form-control" value="0">
                </div>

                <button type="submit" class="btn-modern btn-modern-primary">Save Category</button>
                <a href="{{ route('admin.menu-items.index') }}" class="btn-modern btn-modern-secondary ms-2">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
