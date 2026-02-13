@extends('layouts.admin')

@section('title', 'Edit Chef Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 text-gray-800">Edit Chef: {{ $team_member->name }}</h2>
        <a href="{{ route('admin.team-members.index') }}" class="btn btn-secondary shadow-sm">Back to List</a>
    </div>

    <div class="dashboard-widget">
        <form action="{{ route('admin.team-members.update', $team_member->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" required value="{{ old('name', $team_member->name) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Role / Designation</label>
                    <input type="text" name="role" class="form-control" required value="{{ old('role', $team_member->role) }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Profile Image</label>
                <div class="d-flex align-items-center mb-2">
                    @if($team_member->image)
                        @if(Str::startsWith($team_member->image, ['http://', 'https://']))
                            <img src="{{ $team_member->image }}" alt="Current" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                        @else
                            <img src="{{ asset('assets/images/team/' . $team_member->image) }}" alt="Current" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                        @endif
                    @else
                        <span class="text-muted me-3">No image uploaded</span>
                    @endif
                </div>
                <input type="file" name="image" class="form-control" accept="image/*">
                <small class="text-muted">Leave empty to keep current image</small>
            </div>

            <h5 class="mt-4 mb-3 text-muted">Social Media Links (Optional)</h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label"><i class="fa fa-facebook-square text-primary"></i> Facebook URL</label>
                    <input type="url" name="facebook_url" class="form-control" value="{{ old('facebook_url', $team_member->facebook_url) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label"><i class="fa fa-twitter-square text-info"></i> Twitter URL</label>
                    <input type="url" name="twitter_url" class="form-control" value="{{ old('twitter_url', $team_member->twitter_url) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label"><i class="fa fa-instagram text-danger"></i> Instagram URL</label>
                    <input type="url" name="instagram_url" class="form-control" value="{{ old('instagram_url', $team_member->instagram_url) }}">
                </div>
            </div>

            <button type="submit" class="btn btn-primary px-4">Update Details</button>
        </form>
    </div>
</div>
@endsection
