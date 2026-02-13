@extends('layouts.admin')

@section('title', 'Edit Event')
@section('page-title', 'Edit Event')

@section('content')
<div class="container-fluid">
    <div class="modern-card">
        <div class="modern-card-header">
            <h3 class="modern-card-title">Edit Event</h3>
        </div>
        <div class="modern-card-body">
            <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label">Event Category (Required)</label>
                    <select name="category" class="form-select" required>
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}" {{ $event->category == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Current Image</label>
                    @if($event->image)
                        <div class="mb-2">
                            <img src="{{ asset($event->image) }}" alt="Event Image" style="width: 200px; border-radius: 5px;">
                        </div>
                    @endif
                    <input type="file" name="image" class="form-control">
                    <small class="text-muted">Leave blank to keep current image.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $event->title) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $event->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Order</label>
                    <input type="number" name="order" class="form-control" value="{{ old('order', $event->order) }}">
                </div>

                <button type="submit" class="btn-modern btn-modern-primary">Update Event</button>
            </form>
        </div>
    </div>
</div>
@endsection
