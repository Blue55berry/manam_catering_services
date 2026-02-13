@extends('layouts.admin')

@section('title', 'Add Slider')
@section('page-title', 'Add Slider')

@section('content')
<div class="container-fluid">
    <div class="modern-card">
        <div class="modern-card-header">
            <h3 class="modern-card-title">Add New Slider</h3>
        </div>
        <div class="modern-card-body">
            <form action="{{ route('admin.hero-banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
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
                    <label class="form-label">Slider Image (Required)</label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" required accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Subtitle</label>
                    <input type="text" name="subtitle" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Button Text 1</label>
                        <input type="text" name="button_text_1" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Button Link 1</label>
                        <input type="text" name="button_link_1" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Button Text 2</label>
                        <input type="text" name="button_text_2" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Button Link 2</label>
                        <input type="text" name="button_link_2" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Order</label>
                    <input type="number" name="order" class="form-control" value="0">
                </div>

                <button type="submit" class="btn-modern btn-modern-primary">Save Slider</button>
            </form>
        </div>
    </div>
</div>
@endsection
