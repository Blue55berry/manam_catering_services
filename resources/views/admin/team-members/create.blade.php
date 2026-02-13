@extends('layouts.admin')

@section('title', 'Add New Chef')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 text-gray-800">Add New Chef</h2>
        <a href="{{ route('admin.team-members.index') }}" class="btn btn-secondary shadow-sm">Back to List</a>
    </div>

    <div class="dashboard-widget">
        <form action="{{ route('admin.team-members.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" required placeholder="e.g. Sanjeev Kapoor">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Role / Designation</label>
                    <input type="text" name="role" class="form-control" required placeholder="e.g. Senior Master Chef">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Profile Image</label>
                <input type="file" name="image" class="form-control" accept="image/*" required>
            </div>

            <h5 class="mt-4 mb-3 text-muted">Social Media Links (Optional)</h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label"><i class="fa fa-facebook-square text-primary"></i> Facebook URL</label>
                    <input type="url" name="facebook_url" class="form-control" placeholder="https://facebook.com/username">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label"><i class="fa fa-twitter-square text-info"></i> Twitter URL</label>
                    <input type="url" name="twitter_url" class="form-control" placeholder="https://twitter.com/username">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label"><i class="fa fa-instagram text-danger"></i> Instagram URL</label>
                    <input type="url" name="instagram_url" class="form-control" placeholder="https://instagram.com/username">
                </div>
            </div>

            <button type="submit" class="btn btn-primary px-4">Create Member</button>
        </form>
    </div>
</div>
@endsection
