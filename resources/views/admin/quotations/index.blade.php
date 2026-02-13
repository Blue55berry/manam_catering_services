@extends('layouts.admin')

@section('title', 'Quotations')
@section('page-title', 'Quotations')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">
            <i class="fa fa-file-text"></i> Create Quotations
        </h2>
        <a href="{{ route('admin.quotations.create') }}" class="btn-modern btn-modern-primary">
            <i class="fa fa-plus"></i> Create Quotation
        </a>
    </div>

    <!-- Search Bar -->
    <div class="modern-card mb-4">
        <form action="{{ route('admin.quotations.index') }}" method="GET" class="row g-3">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Search by quotation number, customer name, email, or event type..." 
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn-modern btn-modern-primary w-100">
                    <i class="fa fa-search"></i> Search
                </button>
                @if(request('search'))
                <a href="{{ route('admin.quotations.index') }}" class="btn-modern w-100 mt-2" style="background: #6b7280; color: white;">
                    <i class="fa fa-times"></i> Clear
                </a>
                @endif
            </div>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($quotations->count() > 0)
        <div class="modern-card">
            <div class="modern-card-body">
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Date</th>
                                <th>Quotation #</th>
                                <th>Customer</th>
                                <th>Event</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quotations as $quotation)
                            <tr>
                                <td><span class="fw-bold text-muted">{{ $loop->iteration + ($quotations->currentPage() - 1) * $quotations->perPage() }}</span></td>
                                <td>
                                    <span class="text-muted small">
                                        <i class="fa fa-calendar-alt me-1"></i>
                                        {{ $quotation->created_at->format('d M Y') }}
                                    </span>
                                </td>
                                <td class="fw-bold text-dark">{{ $quotation->quotation_number }}</td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-dark">{{ $quotation->customer_name }}</span>
                                        <small class="text-muted">{{ $quotation->customer_email }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span>{{ $quotation->event_type ?? 'N/A' }}</span>
                                        @if($quotation->event_date)
                                            <small class="text-muted">{{ $quotation->event_date->format('d M Y') }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td class="fw-bold text-success">₹{{ number_format($quotation->total, 2) }}</td>
                                <td>
                                    @if($quotation->status === 'sent')
                                        <span class="badge-modern badge-info">Sent</span>
                                    @elseif($quotation->status === 'accepted')
                                        <span class="badge-modern badge-success">Accepted</span>
                                    @elseif($quotation->status === 'rejected')
                                        <span class="badge-modern badge-danger">Rejected</span>
                                    @else
                                        <span class="badge-modern badge-secondary">Draft</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.quotations.show', $quotation) }}" class="btn-modern btn-modern-primary btn-sm" title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.quotations.edit', $quotation) }}" class="btn-modern btn-sm" style="background: #f59e0b; color: white;" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.quotations.download-pdf', $quotation) }}" class="btn-modern btn-sm" style="background: #ef4444; color: white;" title="PDF">
                                            <i class="fa fa-file-pdf-o"></i>
                                        </a>
                                        <form action="{{ route('admin.quotations.destroy', $quotation) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-modern btn-sm" style="background: #ef4444; color: white;" 
                                                    onclick="return confirm('Delete this quotation?')" title="Delete">
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
            </div>
        </div>

        @if($quotations->hasPages())
            <div class="mt-4">
                {{ $quotations->links() }}
            </div>
        @endif
    @else
        <div class="modern-card text-center py-5">
            <i class="fa fa-file-text" style="font-size: 4rem; color: #d1d5db; margin-bottom: 1rem;"></i>
            <h4 class="text-muted mb-3">No Quotations Found</h4>
            <p class="text-muted mb-4">Quotations will be automatically created when customers submit event bookings.</p>
            <a href="{{ route('admin.quotations.create') }}" class="btn-modern btn-modern-primary">
                <i class="fa fa-plus"></i> Create Manual Quotation
            </a>
        </div>
    @endif
</div>
@endsection
