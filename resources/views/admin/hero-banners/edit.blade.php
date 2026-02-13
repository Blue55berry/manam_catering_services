@extends('layouts.admin')

@section('title', 'Edit Slider')
@section('page-title', 'Edit Slider')

@section('content')
<div class="container-fluid">
    <div class="modern-card">
        <div class="modern-card-header">
            <h3 class="modern-card-title">Edit Slider</h3>
        </div>
        <div class="modern-card-body">
            <form action="{{ route('admin.hero-banners.update', $heroBanner) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="mb-3">
                    <label class="form-label">Current Image</label>
                    @if($heroBanner->image)
                        <div class="mb-2">
                            <img src="{{ asset($heroBanner->image) }}?v={{ time() }}" alt="Slider Image" style="width: 200px; border-radius: 5px;">
                        </div>
                    @endif
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    <small class="text-muted">Leave blank to keep current image.</small>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $heroBanner->title) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Subtitle</label>
                    <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $heroBanner->subtitle) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $heroBanner->description) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Button Text 1</label>
                        <input type="text" name="button_text_1" class="form-control" value="{{ old('button_text_1', $heroBanner->button_text_1) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Button Link 1</label>
                        <input type="text" name="button_link_1" class="form-control" value="{{ old('button_link_1', $heroBanner->button_link_1) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Button Text 2</label>
                        <input type="text" name="button_text_2" class="form-control" value="{{ old('button_text_2', $heroBanner->button_text_2) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Button Link 2</label>
                        <input type="text" name="button_link_2" class="form-control" value="{{ old('button_link_2', $heroBanner->button_link_2) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Order</label>
                    <input type="number" name="order" class="form-control" value="{{ old('order', $heroBanner->order) }}">
                </div>

                <button type="submit" class="btn-modern btn-modern-primary">Update Slider</button>
            </form>
        </div>
    </div>
</div>
@endsection
