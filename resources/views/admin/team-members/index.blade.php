@extends('layouts.admin')

@section('title', 'Manage Team Members')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 text-gray-800">Our Master Chefs</h2>
        <a href="{{ route('admin.team-members.create') }}" class="btn btn-primary shadow-sm"><i class="fa fa-plus-circle"></i> Add New Chef</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="dashboard-widget">
        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th style="width: 80px;">Image</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teamMembers as $member)
                    <tr>
                        <td>
                            @if($member->image)
                                @if(Str::startsWith($member->image, ['http://', 'https://']))
                                    <img src="{{ $member->image }}" alt="{{ $member->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                @else
                                    <img src="{{ asset('assets/images/team/' . $member->image) }}" alt="{{ $member->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                @endif
                            @else
                                <img src="https://via.placeholder.com/50" alt="Placeholder" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                            @endif
                        </td>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->role }}</td>
                        <td>
                            <a href="{{ route('admin.team-members.edit', $member->id) }}" class="btn btn-sm btn-outline-primary"><i class="fa fa-pencil"></i></a>
                            <form action="{{ route('admin.team-members.destroy', $member->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to remove this member?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">No team members found. Add one to get started!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
