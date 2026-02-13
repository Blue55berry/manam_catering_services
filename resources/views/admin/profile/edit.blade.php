@extends('layouts.admin')

@section('title', 'Edit Profile')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Admin Profile</h6>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $admin->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                    <a href="{{ route('admin.profile.change-password') }}" class="btn btn-secondary">Change Password</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
