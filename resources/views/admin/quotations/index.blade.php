@extends('layouts.admin')

@section('title', 'Quotations')
@section('page-title', 'Quotations')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 text-white">
        <h2 class="section-title text-white">
            <i class="fa fa-file-text"></i> Quotation Management
        </h2>
        <a href="{{ route('admin.quotations.create') }}" class="btn-modern btn-modern-primary">
            <i class="fa fa-plus"></i> Create Quotation
        </a>
    </div>

    <!-- Filters and Search -->
    <div class="modern-card mb-4">
        <div class="modern-card-header p-4">
            <div class="row align-items-center g-3">
                <!-- Search -->
                <div class="col-lg-4 col-md-12">
                    <form action="{{ route('admin.quotations.index') }}" method="GET">
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-white border-end-0"><i class="fa fa-search text-muted"></i></span>
                            <input type="text" 
                                   name="search" 
                                   class="form-control border-start-0" 
                                   placeholder="Search quotations..." 
                                   value="{{ request('search') }}">
                             @if(request('search') || request('status') || request('source'))
                                <a href="{{ route('admin.quotations.index') }}" class="btn btn-white border border-start-0" title="Clear Filters">
                                    <i class="fa fa-times text-danger"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Filters Group -->
                <div class="col-lg-8 col-md-12">
                    <div class="d-flex flex-column flex-md-row justify-content-lg-end gap-3 align-items-md-center">
                        <!-- Source Filter Pills -->
                        <div class="filter-group">
                            <label class="small text-muted fw-bold d-block mb-1 text-uppercase">Source</label>
                            <div class="status-filters">
                                <a href="{{ route('admin.quotations.index', array_merge(request()->except('source', 'page'), ['source' => 'all'])) }}" 
                                   class="filter-pill {{ !request('source') || request('source') == 'all' ? 'active' : '' }}">
                                   All
                                </a>
                                <a href="{{ route('admin.quotations.index', array_merge(request()->except('source', 'page'), ['source' => 'client'])) }}" 
                                   class="filter-pill {{ request('source') == 'client' ? 'active' : '' }}">
                                   <i class="fa fa-users me-1"></i> Client
                                </a>
                                <a href="{{ route('admin.quotations.index', array_merge(request()->except('source', 'page'), ['source' => 'admin'])) }}" 
                                   class="filter-pill {{ request('source') == 'admin' ? 'active' : '' }}">
                                   <i class="fa fa-user-shield me-1"></i> Admin
                                </a>
                            </div>
                        </div>

                        <!-- Status Filter Pills -->
                        <div class="filter-group">
                            <label class="small text-muted fw-bold d-block mb-1 text-uppercase">Status</label>
                            <div class="status-filters">
                                <a href="{{ route('admin.quotations.index', array_merge(request()->except('status', 'page'), ['status' => 'all'])) }}" 
                                   class="filter-pill {{ !request('status') || request('status') == 'all' ? 'active' : '' }}">
                                   All
                                </a>
                                <a href="{{ route('admin.quotations.index', array_merge(request()->except('status', 'page'), ['status' => 'draft'])) }}" 
                                   class="filter-pill {{ request('status') == 'draft' ? 'active' : '' }}">
                                   Draft
                                </a>
                                <a href="{{ route('admin.quotations.index', array_merge(request()->except('status', 'page'), ['status' => 'sent'])) }}" 
                                   class="filter-pill {{ request('status') == 'sent' ? 'active' : '' }}">
                                   Sent
                                </a>
                                <a href="{{ route('admin.quotations.index', array_merge(request()->except('status', 'page'), ['status' => 'accepted'])) }}" 
                                   class="filter-pill {{ request('status') == 'accepted' ? 'active' : '' }}">
                                   Accepted
                                </a>
                                <a href="{{ route('admin.quotations.index', array_merge(request()->except('status', 'page'), ['status' => 'rejected'])) }}" 
                                   class="filter-pill {{ request('status') == 'rejected' ? 'active' : '' }}">
                                   Rejected
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="modern-card">
        <div class="modern-card-body p-0">
            @if($quotations->count() > 0)
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th width="5%">S.No</th>
                                <th width="10%">Date</th>
                                <th width="15%">Quotation #</th>
                                <th width="18%">Customer</th>
                                <th width="12%">Event</th>
                                <th width="10%" class="text-end">Amount</th>
                                <th width="10%" class="text-center">Status</th>
                                <th width="15%" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quotations as $quotation)
                            <tr>
                                <td>
                                    <span class="text-muted fw-bold">{{ $loop->iteration + ($quotations->currentPage() - 1) * $quotations->perPage() }}</span>
                                </td>
                                <td>
                                    <span class="text-muted small">
                                        {{ $quotation->created_at->format('M d, Y') }}<br>
                                        {{ $quotation->created_at->format('h:i A') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">{{ $quotation->quotation_number }}</span><br>
                                    @if($quotation->booking_id)
                                        <span class="badge bg-success-soft text-success small" style="font-size: 0.7rem;">
                                            <i class="fa fa-users me-1"></i> Client (Book #{{ $quotation->booking_id }})
                                        </span>
                                    @else
                                        <span class="badge bg-primary-soft text-primary small" style="font-size: 0.7rem;">
                                            <i class="fa fa-user-shield me-1"></i> Admin Created
                                        </span>
                                    @endif
                                </td>
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
                                            <small class="text-muted"><i class="fa fa-calendar-o me-1"></i>{{ $quotation->event_date->format('M d, Y') }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-end">
                                    <span class="fw-bold text-success">₹{{ number_format($quotation->total, 2) }}</span>
                                </td>
                                <td class="text-center">
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
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.quotations.show', $quotation) }}" class="btn-icon btn-icon-primary" title="View Details">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.quotations.edit', $quotation) }}" class="btn-icon btn-icon-warning" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.quotations.download-pdf', $quotation) }}" class="btn-icon btn-icon-danger" title="PDF">
                                            <i class="fa fa-file-pdf-o"></i>
                                        </a>
                                        <form action="{{ route('admin.quotations.destroy', $quotation) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon btn-icon-danger" onclick="return confirm('Delete Quotation?')" title="Delete">
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
                    <i class="fa fa-file-text-o fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted">No Quotations Found</h4>
                    @if(request('search') || request('status') || request('source'))
                        <a href="{{ route('admin.quotations.index') }}" class="btn-modern btn-modern-primary mt-3">
                            <i class="fa fa-refresh"></i> Clear Filters
                        </a>
                    @endif
                </div>
            @endif
        </div>

        @if($quotations->hasPages())
            <div class="modern-card-footer px-4 py-3 border-top">
                {{ $quotations->links() }}
            </div>
        @endif
    </div>
</div>

<style>
/* Filter Pills */
.status-filters {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.filter-pill {
    padding: 0.4rem 1rem;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 500;
    text-decoration: none;
    color: #6b7280;
    background-color: #f3f4f6;
    transition: all 0.2s;
    border: 1px solid transparent;
}

.filter-pill:hover {
    background-color: #e5e7eb;
    color: #374151;
}

.filter-pill.active {
    background-color: #1B4D3E; /* Primary Green */
    color: white;
    box-shadow: 0 2px 4px rgba(27, 77, 62, 0.2);
}

.bg-success-soft { background-color: #dcfce7; }
.bg-primary-soft { background-color: #dbeafe; }

/* Action Buttons */
.btn-icon {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    border: none;
    background: #f3f4f6;
    color: #6b7280;
    transition: all 0.2s;
    text-decoration: none;
}

.btn-icon:hover { color: white; transform: translateY(-2px); }
.btn-icon-primary:hover { background: #1B4D3E; }
.btn-icon-warning:hover { background: #f59e0b; }
.btn-icon-danger:hover { background: #ef4444; }

.modern-table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.05em;
    background: #f9fafb;
    padding: 1rem;
}
.modern-table td { padding: 1rem; vertical-align: middle; }
</style>
@endsection
