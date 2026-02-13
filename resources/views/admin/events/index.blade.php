@extends('layouts.admin')

@section('title', 'Manage Events')
@section('page-title', 'Manage Events')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">
            <i class="fa fa-calendar"></i> Manage Events
        </h2>
        <a href="{{ route('admin.events.create') }}" class="btn-modern btn-modern-primary">
            <i class="fa fa-plus"></i> Add New Event
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="modern-card">
        <div class="modern-card-body">
            @if($events->count() > 0)
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                                <tr>
                                    <td>{{ $event->order }}</td>
                                    <td>
                                        @if($event->image)
                                            <img src="{{ asset($event->image) }}" alt="Event" style="height: 50px; border-radius: 5px;">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>
                                    <td>{{ $event->title ?? 'N/A' }}</td>
                                    <td><span class="badge-modern badge-info">{{ ucfirst($event->category) }}</span></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.events.edit', $event) }}" class="btn-modern btn-modern-primary btn-sm" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-modern btn-sm" style="background: #ef4444; color: white;" 
                                                        onclick="return confirm('Are you sure you want to delete this event?')" title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <p class="text-muted">No events found.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
