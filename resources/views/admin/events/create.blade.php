@extends('layouts.admin')

@section('title', 'Add Event')
@section('page-title', 'Add Event')

@section('content')
<div class="container-fluid">
    <div class="modern-card">
        <div class="modern-card-header">
            <h3 class="modern-card-title">Add New Event</h3>
        </div>
        <div class="modern-card-body">
            <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Event Category (Required)</label>
                    <select name="category" class="form-select" required>
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Event Image (Required)</label>
                    <input type="file" name="image" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Order</label>
                    <input type="number" name="order" class="form-control" value="0">
                </div>

                <button type="submit" class="btn-modern btn-modern-primary">Save Event</button>
            </form>
        </div>
    </div>
</div>
@endsection
