@extends('layouts.admin')

@section('title', 'Customer Enquiries')
@section('page-title', 'Enquiries')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-0"><i class="fa fa-envelope"></i> Customer Enquiries</h2>
        <span class="badge-modern badge-info fs-6">{{ $contacts->count() }} Total</span>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fa fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="modern-card bg-info text-white" style="background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);">
                <div class="modern-card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-1 text-white-50">New Enquiries</h5>
                            <h2 class="mb-0 text-white">{{ $contacts->where('is_read', false)->count() }}</h2>
                        </div>
                        <i class="fa fa-envelope-open fa-3x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="modern-card bg-success text-white" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                <div class="modern-card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-1 text-white-50">Read Enquiries</h5>
                            <h2 class="mb-0 text-white">{{ $contacts->where('is_read', true)->count() }}</h2>
                        </div>
                        <i class="fa fa-check-circle fa-3x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enquiries Table -->
    <div class="modern-card">
        <div class="modern-card-header py-3">
            <h5 class="modern-card-title mb-0"><i class="fa fa-list"></i> All Enquiries</h5>
        </div>
        <div class="modern-card-body">
            @if($contacts->count() > 0)
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th width="5%">Status</th>
                                <th width="15%">Name</th>
                                <th width="15%">Email</th>
                                <th width="12%">Phone</th>
                                <th width="20%">Subject</th>
                                <th width="18%">Date</th>
                                <th width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contacts as $contact)
                            <tr class="{{ !$contact->is_read ? 'fw-bold' : '' }}" style="{{ !$contact->is_read ? 'background-color: #f0fdf4;' : '' }}">
                                <td>
                                    @if($contact->is_read)
                                        <span class="badge-modern badge-success"><i class="fa fa-check"></i></span>
                                    @else
                                        <span class="badge-modern badge-warning"><i class="fa fa-envelope"></i></span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-dark">{{ $contact->name }}</span>
                                    @if(!$contact->is_read)
                                        <span class="badge-modern badge-danger ms-1" style="font-size: 0.7em;">New</span>
                                    @endif
                                </td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ $contact->phone }}</td>
                                <td>{{ Str::limit($contact->subject ?? 'No Subject', 30) }}</td>
                                <td>
                                    <span class="text-muted small">
                                        <i class="fa fa-calendar me-1"></i>
                                        {{ $contact->created_at->format('d M Y, h:i A') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.contacts.show', $contact) }}" 
                                           class="btn-modern btn-modern-primary btn-sm" title="View Details">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        @if(!$contact->is_read)
                                            <form action="{{ route('admin.contacts.mark-read', $contact) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn-modern btn-sm" style="background: #10b981; color: white;" 
                                                        title="Mark as Read">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fa fa-inbox fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">No enquiries yet</h5>
                    <p class="text-muted">Customer enquiries will appear here when submitted from the contact form.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
